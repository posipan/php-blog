<?php

/**
 * 認証クラスファイル
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace lib;

use db\PostQuery;
use db\UserQuery;
use model\UserModel;
use Throwable;

/**
 * 認証クラス
 *
 * ユーザーのログイン・登録処理
 * ログイン・編集権限判定の定義など
 *
 * @access public
 * @author Posipan
 */
class Auth
{
  /** @var int get関数内のID比較を行う関数で使用する */
  public static int $DEFAULT_TARGET_ID = 0;

  /**
   * ログイン処理を定義
   *
   * @param string $email メールアドレス
   * @param string $password パスワード
   * @return bool $is_success
   */
  public static function login(string $email, string $password): bool
  {
    try {
      // バリデーション
      if (!(UserModel::validateEmail($email)
        * UserModel::validatePassword($password)
      )) {
        return false;
      }

      $is_success = false;

      /** @var object|false */
      $user = UserQuery::fetchByEmail($email);

      if (!empty($user)) {
        if (password_verify($password, $user->password)) {
          $is_success = true;

          UserModel::setSession($user);
        } else {
          Msg::push(Msg::DEBUG, 'メールアドレスまたはパスワードに誤りがあります。');
        }
      } else {
        Msg::push(Msg::DEBUG, 'メールアドレスまたはパスワードに誤りがあります。');
      }
    } catch (Throwable $e) {
      $is_success = false;

      Msg::push(Msg::DEBUG, $e->getMessage());
      Msg::push(Msg::ERROR, 'ログイン処理でエラーが発生しました。' . '<br>' . '再度ログインを実行してください。');
    }

    return $is_success;
  }

  /**
   * ユーザー登録処理を定義
   *
   * @param object $user 登録するユーザー情報
   * @return bool $is_success
   */
  public static function regist(object $user): bool
  {
    try {
      // バリデーション
      if (!($user->isValidName()
        * $user->isValidEmail()
        * $user->isValidPassword())) {
        return false;
      }

      $is_success = false;

      if (!empty(UserQuery::fetchByName($user->name))) {
        Msg::push(Msg::DEBUG, 'すでに登録されているユーザー名です。');
        return false;
      }

      if (!empty(UserQuery::fetchByEmail($user->email))) {
        Msg::push(Msg::DEBUG, 'すでに登録されているメールアドレスです。');
        return false;
      }

      if ($user->password !== $user->password_confirm) {
        Msg::push(Msg::DEBUG, 'パスワードが一致しません。');
        return false;
      }

      $is_success = UserQuery::insert($user->name, $user->email, $user->password);
    } catch (Throwable $e) {
      $is_success = false;

      Msg::push(Msg::DEBUG, $e->getMessage());
      Msg::push(Msg::ERROR, 'ユーザー登録処理でエラーが発生しました。' . '<br>' . 'もう1度と試してください。');
    }

    return $is_success;
  }

  /**
   * ユーザー情報の更新処理を定義
   *
   * @param object $user 更新前のユーザー情報
   * @param object $update_user 更新中のユーザー情報
   * @return bool $is_success
   */
  public static function update(object $user, object $update_user): bool
  {
    try {
      // バリデーション
      if (!($update_user->isValidName()
        * $update_user->isValidEmail()
        * $update_user->isValidPassword())) {
        return false;
      }

      $is_success = false;

      // 登録済みチェック
      $fetchedUpdateUserByName = UserQuery::fetchByName($update_user->name);
      $fetchedUpdateUserByEmail = UserQuery::fetchByEmail($update_user->email);

      // ユーザー名のチェック
      if (
        !empty($fetchedUpdateUserByName)
        && ($user->name !== $fetchedUpdateUserByName->name)
      ) {
        Msg::push(Msg::DEBUG, 'すでに登録されているユーザー名です。');

        return false;
      }

      // メールアドレスのチェック
      if (
        !empty($fetchedUpdateUserByEmail)
        && ($user->email !== $fetchedUpdateUserByEmail->email)
      ) {
        Msg::push(Msg::DEBUG, 'すでに登録されているメールアドレスです。');

        return false;
      }

      if ($update_user->password !== $update_user->password_confirm) {
        Msg::push(Msg::DEBUG, 'パスワードが一致しません。');

        return false;
      }

      // ユーザー情報の更新を実行
      $is_success = UserQuery::update($update_user);
    } catch (Throwable $e) {
      Msg::push(Msg::DEBUG, $e->getMessage());
      $is_success = false;
    }

    return $is_success;
  }

  /**
   * ログイン状態の判定を定義
   *
   * 出力要素の出し分けに使用
   *
   * @return bool
   */
  public static function isLogin(): bool
  {
    try {
      /** @var object */
      $user = UserModel::getSession();
    } catch (Throwable $e) {
      UserModel::clearSession();
      Msg::push(Msg::DEBUG, $e->getMessage());

      return false;
    }

    if (!empty($user)) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * ログアウト処理を定義
   *
   * @return bool
   */
  public static function logout(): bool
  {
    try {
      UserModel::clearSession();
    } catch (Throwable $e) {
      Msg::push(Msg::DEBUG, $e->getMessage());
      return false;
    }

    return true;
  }

  /**
   * ログイン必須処理を定義
   *
   * @return void
   */
  public static function requireLogin(): void
  {
    if (!static::isLogin()) {
      Msg::push(Msg::ERROR, 'ログインしてください。');

      redirect('login');
    }
  }

  /**
   * 記事編集権限の確認を定義
   *
   * @param int $post_id GETで受け取った記事ID
   * @param int $target_post_id POSTで受け取った記事ID
   * @return bool
   */
  public static function hasPostPermission(int $post_id, int $target_post_id, object $user): bool
  {
    return PostQuery::isOwnPost($post_id, $target_post_id, $user);
  }

  /**
   * 記事編集権限の必須処理を定義
   *
   * @param int $post_id GETで受け取った記事ID
   * @param int $target_post_id POSTで受け取った記事ID
   * @param object $user ユーザー情報
   * @return void
   */
  public static function requirePostPermission(int $post_id, int $target_post_id, object $user): void
  {
    if (!static::hasPostPermission($post_id, $target_post_id, $user)) {
      Msg::push(Msg::ERROR, '記事の編集権限がありません。' . '<br>' . 'ログインしてください。');

      redirect('login');
    }
  }

  /**
   * ユーザー情報の編集権限の確認を定義
   *
   * @param int $user_id GETで受け取ったユーザーID
   * @param int $target_user_id POSTで受け取ったユーザーID
   * @return bool
   */
  public static function hasUserInfoPermission(int $user_id, int $target_user_id): bool
  {
    return UserQuery::isOwnUser($user_id, $target_user_id);
  }

  /**
   * ユーザー情報の編集権限の必須処理を定義
   *
   * フォームから渡ってきたユーザーIDとセッションのユーザーIDを比較
   *
   * @param int $user_id GETで受け取ったユーザーID
   * @param int $target_user_id POSTで受け取ったユーザーID
   * @return void
   */
  public static function requireUserInfoPermission(int $user_id, int $target_user_id): void
  {
    if (!static::hasUserInfoPermission($user_id, $target_user_id)) {
      Msg::push(Msg::ERROR, 'ユーザー情報の編集権限がありません。' . '<br>' . 'ログインしてください。');
      redirect('login');
    }
  }
}
