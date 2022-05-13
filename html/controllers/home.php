<?php

/**
 * ホームページのコントローラー
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
  /** @var array|object|false */
  $posts = PostQuery::fetchAllPublishedPosts();

  /** @var array|false */
  $all_categories = CategoryQuery::fetchAllCategories();

  \view\home\index($posts, $all_categories);
}
