<?php

/**
 * カテゴリー記事一覧ページのコントローラー
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace controller\category;

use db\PostQuery;

/**
 * カテゴリー記事一覧ページを表示
 *
 * @return void
 */
function get(): void
{
  /** @var string */
  $category_name = get_param('name', null, false);

  if (empty($category_name)) {
    redirect(GO_HOME);
  }

  /** @var int */
  $total = PostQuery::countAllPublishedPosts('category', $category_name);

  /** @var float */
  $pages = ceil($total / MAX_VIEW);

  /** @var int */
  $start = (int) get_param('page', 1, false);

  /** @var array|false */
  $posts = PostQuery::fetchCategoryAllPublishedPosts($start, MAX_VIEW, $category_name);

  \view\category\index($posts, $start, $pages, $category_name);
}
