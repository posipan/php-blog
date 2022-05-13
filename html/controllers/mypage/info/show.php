<?php

/**
 * ユーザー情報確認ページのコントローラー
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace controller\mypage\info\show;

use lib\Auth;
use model\UserModel;

/**
 * ユーザー情報確認ページを表示
 *
 * @return void
 */
function get(): void
{
  Auth::requireLogin();

  /** @var object */
  $user = UserModel::getSession();

  \view\mypage\info\show\index($user);
}
