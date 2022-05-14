<?php

/**
 * マイポストページのコントローラー
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace controller\mypage\post\archive;

use db\CategoryQuery;
use db\PostQuery;
use lib\Auth;
use model\UserModel;

/**
 * マイポストページを表示
 *
 * @return void
 */
function get(): void
{
  Auth::requireLogin();

  /** @var object */
  $user = UserModel::getSession();

  /** @var int */
  $total = PostQuery::countAllPublishedPosts('mypage', $user->id);

  /** @var float */
  $pages = ceil($total / MAX_VIEW);

  /** @var int */
  $start = (int) get_param('page', 1, false);

  /** @var array|object|false */
  $posts = PostQuery::fetchMyAllPosts($start, MAX_VIEW, $user);

  if (count($posts) > 0) {
    \view\mypage\post\archive\index($posts, $start, $pages);
  } else {
    \view\mypage\post\archive\nopost();
  }
}
