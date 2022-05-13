<?php

/**
 * ユーザー情報操作クラスファイル
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace db;

use model\UserModel;

/**
 * ユーザー情報操作クラス
 *
 * @access public
 * @author Posipan
 */
class UserQuery
{
  /**
   * ユーザー名によるユーザー情報の取得を定義
   *
   * @param string $name ユーザー名
   * @return object|false
   */
  public static function fetchByName(string $name): object|false
  {
    /** @var \db\DB */
    $db = new DB();

    /** @var string */
    $sql = "SELECT * FROM `users` WHERE `name` = :name;";

    return $db->selectOne($sql, [
      ':name' => $name,
    ], DB::CLS, UserModel::class);
  }

  /**
   * メールアドレスによるユーザー情報の取得を定義
   *
   * @param string $email メールアドレス
   * @return object|false
   */
  public static function fetchByEmail(string $email): object|false
  {
    /** @var \db\DB */
    $db = new DB();

    /** @var string */
    $sql = "SELECT * FROM `users` WHERE `email` = :email;";

    return $db->selectOne($sql, [
      ':email' => $email,
    ], DB::CLS, UserModel::class);
  }

  /**
   * ユーザー情報の登録処理を定義
   *
   * @param string $name ユーザー名
   * @param string $email メールアドレス
   * @param string $password パスワード
   * @return bool
   */
  public static function insert(string $name, string $email, string $password): bool
  {
    /** @var \db\DB */
    $db = new DB();

    /** @var string */
    $sql = "INSERT INTO `users` (`name`, `email`, `password`) VALUES (:name, :email, :password)";

    // パスワードのハッシュ化
    $password = password_hash($password, PASSWORD_DEFAULT);

    return $db->execute($sql, [
      ':name' => $name,
      ':email' => $email,
      ':password' => $password,
    ]);
  }

  /**
   * ユーザー情報の更新処理を定義
   *
   * @param object $user 更新するユーザー情報
   * @return bool
   */
  public static function update(object $user): bool
  {
    /** @var \db\DB */
    $db = new DB();

    /** @var string */
    $sql = "UPDATE `users` set `name` = :name, `email` = :email, `password` = :password WHERE `id` = :id;";

    // パスワードのハッシュ化
    $password = password_hash($user->password, PASSWORD_DEFAULT);

    return $db->execute($sql, [
      ':id' => $user->id,
      ':name' => $user->name,
      ':email' => $user->email,
      ':password' => $password,
    ]);
  }

  /**
   * ユーザー情報の編集権限の確認処理を定義
   *
   * ユーザー情報の編集フォーム内の<input type="hidden"〜>に設定されているIDとログインユーザーIDを比較
   * 一致すれば編集権限のあるユーザーと判定
   *
   * @param int $user_id セッションに保存されているユーザーID
   * @param int $target_user_id POSTリクエストで送信したユーザーID
   * @return bool
   */
  public static function isOwnUser(int $user_id, int $target_user_id): bool
  {
    // バリデーション
    if (!UserModel::validateId($user_id)) {
      return false;
    } else if ($user_id !== $target_user_id) {
      return false;
    }

    /** @var \db\DB */
    $db = new DB();

    /** @var string */
    $sql = "SELECT count(*) as count FROM `users` WHERE `id` = :id";

    /** @var object|false $result */
    $result = $db->selectOne($sql, [
      ':id' => $user_id,
    ]);

    if (!empty($result) && $result['count'] != 0) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * ユーザーの削除処理を定義
   *
   * @param object $user ユーザー情報
   * @return bool
   */
  public static function delete(object $user): bool
  {
    /** @var \db\DB */
    $db = new DB();

    /** @var string */
    $sql = "DELETE FROM `users` WHERE `id` = :id;";

    return $db->execute($sql, [
      ':id' => $user->id,
    ]);
  }
}
