<?php

/**
 * ホームページのコントローラーファイル
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace controller\home;

use db\CategoryQuery;
use db\PostQuery;

/**
 * ホームページを表示
 *
 * @return void
 */
function get(): void
{
  /** @var int */
  $total = PostQuery::countAllPublishedPosts();

  /** @var float */
  $pages = ceil($total / MAX_VIEW);

  /** @var int */
  $start = (int) get_param('page', 1, false);

  /** @var array|object|false */
  $posts = PostQuery::fetchAllPublishedPosts($start, MAX_VIEW);

  /** @var array|false */
  $all_categories = CategoryQuery::fetchAllCategories();

  \view\home\index($posts, $all_categories, $start, $pages);
}
