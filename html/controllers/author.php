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
  $posts = PostQuery::fetchAuthorAllPublishedPosts($start, MAX_VIEW, $author_name);

  \view\author\index($posts, $start, $pages, $author_name);
}
