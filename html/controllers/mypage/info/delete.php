<?php

/**
 * ユーザー情報削除のコントローラー
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace controller\mypage\info\delete;

use db\CategoryRelationshipQuery;
use db\DB;
use db\PostQuery;
use db\UserQuery;
use lib\Auth;
use lib\Msg;
use model\UserModel;
use Throwable;

/**
 * ユーザー情報の削除処理
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

      Msg::push(Msg::ERROR, 'ユーザーの削除に失敗しました。' . '<br>' . 'もう一度やりなおしてください。');

      redirect(GO_REFERER);
    }
  }
}
