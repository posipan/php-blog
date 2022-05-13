<?php

/**
 * 記事詳細ページのコントローラー
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace controller\post;

use db\CategoryQuery;
use db\PostQuery;
use lib\Msg;
use model\PostModel;

/**
 * 記事詳細ページを表示
 *
 * @return void
 */
function get(): void
{
  /** @var \model\PostModel */
  $post = new PostModel();

  /** @var int */
  $post->id = (int) get_param('id', null, false);

  /** @var array|false */
  $all_categories = CategoryQuery::fetchAllCategories();

  /** @var object|false */
  $fetchedPost = PostQuery::fetchPost($post);

  /** @var array */
  $post->selected_categories = str_to_array($fetchedPost->selected_categories);

  if (!$fetchedPost) {
    Msg::push(Msg::DEBUG, '記事が見つかりません。');
    redirect('404');
  }

  \view\post\index($fetchedPost, $all_categories);
}
