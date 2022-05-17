<?php

/**
 * 記事削除のコントローラー
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace controller\mypage\post\delete;

use db\PostQuery;
use db\CategoryRelationshipQuery;
use db\DB;
use lib\Auth;
use lib\Msg;
use model\CategoryRelationshipModel;
use model\PostModel;
use model\UserModel;
use Throwable;

/**
 * 記事の削除処理
 *
 * @return mixed
 */
function post(): mixed
{
  Auth::requireLogin();

  /** @var \model\PostModel */
  $post = new PostModel();

  /** @var int */
  $post->id = (int) get_param('id', null, false);

  /** @var \model\PostModel */
  $delete_post = new PostModel();

  /** @var int */
  $delete_post->id = (int) get_param('id', null);

  /** @var \model\CategoryRelationshipModel */
  $category_relationship = new CategoryRelationshipModel();

  /** @var int */
  $category_relationship->post_id = $delete_post->id;

  /** @var object */
  $user = UserModel::getSession();

  Auth::requirePostPermission($post->id, $delete_post->id, $user);

  try {
    /** @var \db\DB */
    $db = new DB();

    $db->begin();

    /** @var bool $is_success 成否判定 */
    // カテゴリーリレーションの削除処理
    $is_success = CategoryRelationshipQuery::delete($delete_post);

    if ($is_success) {
      // 記事の削除処理
      $is_success = PostQuery::delete($delete_post);
    }
  } catch (Throwable $e) {
    Msg::push(Msg::DEBUG, $e->getMessage());
    $is_success = false;
  } finally {
    if ($is_success) {
      $db->commit();

      Msg::push(Msg::INFO, '記事を削除しました。');

      redirect('mypage/post/archive');
    } else {
      $db->rollback();

      Msg::push(Msg::DEBUG, '記事の削除に失敗しました。');

      redirect(GO_REFERER);
    }
  }
}
