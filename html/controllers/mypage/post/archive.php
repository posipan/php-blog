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
use lib\Msg;
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

  /** @var array|object|false */
  $posts = PostQuery::fetchMyAllPosts($user);

  // if ($posts === false) {
  //   Msg::push(Msg::ERROR, 'ログインしてください。');

  //   redirect('login');
  // }

  /** @var array|false */
  $all_categories = CategoryQuery::fetchAllCategories();

  if (count($posts) > 0) {
    \view\mypage\post\archive\index($posts, $all_categories);
  } else {
    \view\mypage\post\archive\nopost();
  }
}
