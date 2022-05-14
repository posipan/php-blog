<?php

/**
 * 作成者記事一覧ページのコントローラー
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace controller\author;

use db\CategoryQuery;
use db\PostQuery;

/**
 * 作成者記事一覧ページを表示
 *
 * @return void
 */
function get(): void
{
  /** @var string */
  $author_name = get_param('name', null, false);
  // var_dump($author_name);

  if (empty($author_name)) {
    redirect(GO_HOME);
  }

  /** @var int */
  $total = PostQuery::countAllPublishedPosts('author', $author_name);

  /** @var float */
  $pages = ceil($total / MAX_VIEW);

  /** @var int */
  $start = (int) get_param('page', 1, false);

  /** @var array|false */
  $posts = PostQuery::fetchAuthorAllPublishedPosts($author_name, $start, MAX_VIEW);

  /** @var array|false */
  $all_categories = CategoryQuery::fetchAllCategories();

  \view\author\index($posts, $all_categories, $author_name, $start, $pages);
}
