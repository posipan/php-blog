<?php

/**
 * 記事編集ページのコントローラー
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace controller\mypage\post\edit;

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
 * 記事編集ページを表示
 *
 * @return void
 */
function get(): void
{
  Auth::requireLogin();

  /** @var object 記事の編集に失敗した場合、直前の入力内容を取得 */
  $post = PostModel::getSessionAndFlush();

  if (!empty($post)) {
    \view\mypage\post\edit\index($post);
    return;
  }

  /** @var \model\PostModel */
  $post = new PostModel();

  /** @var int */
  $post->id = (int) get_param('id', null, false);

  /** @var object */
  $user = UserModel::getSession();

  Auth::requirePostPermission($post->id, Auth::$DEFAULT_TARGET_ID, $user);

  /** @var object|false */
  $fetchedPost = PostQuery::fetchPost($post);

  \view\mypage\post\edit\index($fetchedPost);
}

/**
 * 記事の更新または削除処理
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

  /** @var string 更新または削除 */
  $dispatch = get_param('dispatch', null);

  if ($dispatch === PostModel::$UPDATE) {
    /**
     * 更新処理
     */

    /** @var \model\PostModel  */
    $update_post = new PostModel();

    /** @var int */
    $update_post->id = (int) get_param('id', null);

    /** @var string */
    $update_post->title = get_param('title', null);

    /** @var string|null */
    $update_post->image = get_param('image', null);

    /** @var string */
    $update_post->content = get_param('content', null);

    /** @var int */
    $update_post->status = (int) get_param('status', null);

    /** @var int */
    $update_post->selected_category_id = (int) get_param('category', null);

    /** @var \model\CategoryRelationshipModel */
    $category_relationship = new CategoryRelationshipModel();

    /** @var int */
    $category_relationship->post_id = $update_post->id;

    /** @var object */
    $user = UserModel::getSession();

    Auth::requirePostPermission($post->id, $update_post->id, $user);

    try {
      /** @var \db\DB */
      $db = new DB();

      $db->begin();

      if (!($update_post->isValidCategory($update_post->selected_category_id))) {
        return false;
      }

      /** @var bool $is_success 成否判定 */
      // カテゴリーリレーションの削除処理
      $is_success = CategoryRelationshipQuery::delete($update_post);

      if ($is_success) {
          // カテゴリーリレーションの登録処理
          $is_success = CategoryRelationshipQuery::insert($update_post, $category_relationship);
      } else {
        $is_success = false;
      }

      if ($is_success) {
        // 記事の更新処理
        $is_success = PostQuery::update($update_post);
      } else {
        $is_success = false;
      }

    } catch (Throwable $e) {
      Msg::push(Msg::DEBUG, $e->getMessage());

      $is_success = false;
    } finally {
      if ($is_success) {
        $db->commit();

        Msg::push(Msg::INFO, '記事を更新しました。');

        redirect('mypage/post/archive');
      } else {
        $db->rollback();

        Msg::push(Msg::ERROR, '記事の更新に失敗しました。');

        // 入力内容をセッションに保存
        PostModel::setSession($update_post);

        redirect(GO_REFERER);
      }
    }
  } else if ($dispatch === PostModel::$DELETE) {
    /**
     * 削除処理
     */

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

        Msg::push(Msg::ERROR, '記事の削除に失敗しました。');

        redirect(GO_REFERER);
      }
    }
  } else {
    return false;
  }
}
