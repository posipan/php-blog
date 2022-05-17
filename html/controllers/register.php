<?php

/**
 * ユーザー登録ページのコントローラー
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace controller\register;

use lib\Auth;
use lib\Msg;
use model\UserModel;

/**
 * ユーザー登録ページを表示
 *
 * @return void
 */
function get(): void
{
  if (!Auth::isLogin()) {
    \view\register\index();
  } else {
    redirect(GO_HOME);
  }
}

/**
 * ユーザー登録処理
 *
 * @return void
 */
function post()
{
  /** @var \model\UserModel */
  $user = new UserModel();

  /** @var string */
  $user->name = get_param('name', null);

  /** @var string */
  $user->email = get_param('email', null);

  /** @var string */
  $user->password = get_param('password', null);

  /** @var string */
  $user->confirm_password = get_param('confirm-password', null);

  if (Auth::regist($user)) {
    Msg::push(Msg::INFO, '登録しました！' . '<br>' . 'ログインしてください。');
    redirect('login');
  } else {
    redirect(GO_REFERER);
  }
}
