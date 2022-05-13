<?php

/**
 * 記事編集ページのコントローラー
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace controller\mypage\post\edit;

use db\PostQuery;
use db\CategoryQuery;
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

  /** @var array|false */
  $all_categories = CategoryQuery::fetchAllCategories();

  if (!empty($post)) {
    \view\mypage\post\edit\index($post, $all_categories, $post->selected_categories);
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

  /** @var int[] */
  $post->selected_categories = array_map('intval', str_to_array($fetchedPost->selected_categories));

  \view\mypage\post\edit\index($fetchedPost, $all_categories, $post->selected_categories);
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

    /** @var \model\CategoryRelationshipModel */
    $category_relationship = new CategoryRelationshipModel();

    /** @var int */
    $category_relationship->post_id = $update_post->id;

    /** @var string|array|null */
    $update_post->selected_categories = get_param('categories', null);

    if (!empty($update_post->selected_categories)) {
      /** @var int[] */
      $update_post->selected_categories = array_map('intval', $update_post->selected_categories);
    }

    /** @var object */
    $user = UserModel::getSession();

    Auth::requirePostPermission($post->id, $update_post->id, $user);

    try {
      /** @var \db\DB */
      $db = new DB();

      $db->begin();

      if (!($update_post->isValidCategories($update_post->selected_categories))) {
        return false;
      }

      /** @var bool $is_success 成否判定 */
      // カテゴリーリレーションの削除処理
      $is_success = CategoryRelationshipQuery::delete($update_post);

      if ($is_success) {
        foreach ($update_post->selected_categories as $category_id) {
          /** @var int category_id */

          // カテゴリーリレーションの登録処理
          $is_success = CategoryRelationshipQuery::insert($update_post->id, $category_id);
        }
      }

      if ($is_success) {
        // 記事の更新処理
        $is_success = PostQuery::update($update_post);
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
        PostModel::setSession($post);

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
