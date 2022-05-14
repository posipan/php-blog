<?php

/**
 * カテゴリー記事一覧ページのコントローラー
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace controller\category;

use db\CategoryQuery;
use db\PostQuery;

/**
 * カテゴリー記事一覧ページを表示
 *
 * @return void
 */
function get(): void
{
  /** @var string */
  $category_slug = get_param('slug', null, false);

  if (empty($category_slug)) {
    redirect(GO_HOME);
  }

  /** @var int */
  $total = PostQuery::countAllPublishedPosts('category', $category_slug);

  /** @var float */
  $pages = ceil($total / MAX_VIEW);

  /** @var int */
  $start = (int) get_param('page', 1, false);

  /** @var array|false */
  $posts = PostQuery::fetchCategoryAllPublishedPosts($category_slug, $start, MAX_VIEW);

  /** @var array|false */
  $all_categories = CategoryQuery::fetchAllCategories();

  \view\category\index($posts, $all_categories, $category_slug, $start, $pages);
}
