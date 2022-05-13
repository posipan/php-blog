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

  /** @var array|false */
  $posts = PostQuery::fetchAuthorAllPublishedPosts($author_name);

  /** @var array|false */
  $all_categories = CategoryQuery::fetchAllCategories();

  \view\author\index($posts, $all_categories, $author_name);
}
