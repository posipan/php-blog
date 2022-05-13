<?php

/**
 * 記事作成ページのコントローラー
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace controller\mypage\post\create;

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
 * 記事作成ページを表示
 *
 * @return void
 */
function get(): void
{
  Auth::requireLogin();

  /** @var object 記事の作成に失敗した場合、直前の入力内容を取得 */
  $post = PostModel::getSessionAndFlush();

  // 初回アクセス時
  if (empty($post)) {
    /** @var \model\PostModel */
    $post = new PostModel();

    /** @var string */
    $post->title = '';

    /** @var string|null */
    $post->image = '';

    /** @var string */
    $post->content = '';

    /** @var int */
    $post->status = PostModel::$PUBLISH;

    /** @var string */
    $post->selected_categories = '';
  }

  /** @var array|false */
  $all_categories = CategoryQuery::fetchAllCategories();

  \view\mypage\post\create\index($post, $all_categories, $post->selected_categories);
}

/**
 * 記事の作成処理
 *
 * @return mixed
 */
function post(): mixed
{
  Auth::requireLogin();

  /** @var \model\PostModel */
  $post = new PostModel();

  /** @var string */
  $post->title = get_param('title', null);

  /** @var string */
  $post->image = get_param('image', null);

  /** @var string */
  $post->content = get_param('content', null);

  /** @var int */
  $post->status = (int) get_param('status', null);

  /** @var string|array|null */
  $post->selected_categories = get_param('categories', null);

  /** @var \model\CategoryRelationshipModel */
  $category_relationship = new CategoryRelationshipModel();

  if (!empty($post->selected_categories)) {
    /** @var int[] */
    $post->selected_categories = array_map('intval', $post->selected_categories);
  }

  /** @var object */
  $user = UserModel::getSession();

  try {
    /** @var \db\DB */
    $db = new DB();

    $db->begin();

    /** @var bool $is_success 成否判定 */
    // 記事の登録
    $is_success = PostQuery::insert($post, $user);

    if ($is_success) {
      /** @var int 作成した記事のIDを取得 */
      $category_relationship->post_id = PostQuery::getLastId();

      if (!empty($category_relationship->post_id)) {
        $is_success = true;
      } else {
        $is_success = false;
      }
    }

    if ($is_success) {
      // カテゴリーリレーションの登録処理
      foreach ($post->selected_categories as $category_id) {
        /** @var int category_id */
        CategoryRelationshipQuery::insert($category_relationship->post_id, $category_id);
      }
    } else {
      $is_success = false;
    }
  } catch (Throwable $e) {
    Msg::push(Msg::DEBUG, $e->getMessage());

    $is_success = false;
  } finally {
    if ($is_success) {
      $db->commit();

      Msg::push(Msg::INFO, '記事を保存しました。');

      redirect('mypage/post/archive');
    } else {
      $db->rollback();

      Msg::push(Msg::ERROR, '記事の保存に失敗しました。');

      // 入力内容をセッションに保存
      PostModel::setSession($post);

      redirect(GO_REFERER);
    }
  }
}
