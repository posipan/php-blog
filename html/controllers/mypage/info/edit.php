<?php

/**
 * ユーザー情報編集ページのコントローラー
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace controller\mypage\info\edit;

use db\CategoryRelationshipQuery;
use db\DB;
use db\PostQuery;
use db\UserQuery;
use lib\Auth;
use lib\Msg;
use model\UserModel;
use Throwable;

/**
 * ユーザー情報編集ページを表示
 *
 * @return void
 */
function get(): void
{
  Auth::requireLogin();

  /** @var object */
  $user = UserModel::getSession();

  \view\mypage\info\edit\index($user);
}

/**
 * ユーザー情報の更新または削除処理
 *
 * @return mixed
 */
function post(): mixed
{
  Auth::requireLogin();

  /** @var object */
  $user = UserModel::getSession();

  /** @var int */
  $user->id = (int) get_param('id', null);

  /** @var stirng */
  $dispatch = get_param('dispatch', null);

  if ($dispatch === UserModel::$UPDATE) {
    /**
     * 更新処理
     */

    /** @var \model\UserModel */
    $update_user = new UserModel();

    /** @var int */
    $update_user->id = (int) get_param('id', null);

    /** @var stirng */
    $update_user->name = get_param('name', null);

    /** @var stirng */
    $update_user->email = get_param('email', null);

    /** @var stirng */
    $update_user->password = get_param('password', null);

    /** @var stirng */
    $update_user->confirm_password = get_param('confirm-password', null);

    Auth::requireUserInfoPermission($user->id, $update_user->id);

    if (Auth::update($user, $update_user)) {
      UserModel::clearSession();

      Msg::push(Msg::INFO, 'ユーザー情報を更新しました。' . '<br>' . '再度ログインを行なってください。');

      redirect('login');
    } else {
      Msg::push(Msg::ERROR, 'ユーザー情報の更新に失敗しました。' . '<br>' . 'もう一度やりなおしてください。');

      redirect(GO_REFERER);
    }
  } else if ($dispatch === UserModel::$DELETE) {
    /**
     * 削除処理
     */

    /** @var \model\UserModel */
    $delete_user = new UserModel();

    /** @var int */
    $delete_user->id = (int) get_param('id', null);

    Auth::requireUserInfoPermission($user->id, $delete_user->id);

    try {
      /** @var \db\DB */
      $db = new DB();

      $db->begin();

      /** @var array|false */
      // ユーザーが作成した全ての記事を取得
      $posts = PostQuery::fetchUserAllPost($user);

      if (!empty($posts)) {

        /** @var object $post */
        foreach ($posts as $post) {
          // 記事に設定したカテゴリーを削除
          /** @var bool $is_success 成否判定 */
          $is_success = CategoryRelationshipQuery::delete($post);
        }
      } else {
        // 記事を持たないユーザーの場合
        $is_success = true;
      }

      if ($is_success) {
        // ユーザーが作成した全ての記事を削除
        $is_success = PostQuery::deleteUserAllPost($user);

        // 削除する記事がない場合
        if (!$is_success) {
          $is_success = true;
        }
      } else {
        $is_success = false;
      }

      if ($is_success) {
        // ユーザーを削除
        $is_success = UserQuery::delete($user);
      } else {
        $is_success = false;
      }
    } catch (Throwable $e) {
      Msg::push(Msg::DEBUG, $e->getMessage());

      $is_success = false;
    } finally {
      if ($is_success) {
        $db->commit();

        Msg::push(Msg::INFO, 'ユーザーを削除しました。');

        UserModel::clearSession();

        redirect('register');
      } else {
        $db->rollback();

        Msg::push(Msg::ERROR, 'ユーザーの削除に失敗しました。');

        redirect(GO_REFERER);
      }
    }
  } else {
    return false;
  }
}
