<?php

/**
 * ログインページのコントローラー
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace controller\login;

use lib\Auth;
use lib\Msg;
use model\UserModel;

/**
 * ログインページを表示
 *
 * @return void
 */
function get(): void
{
  \view\login\index();
}

/**
 * ログイン処理
 *
 * @return void
 */
function post()
{
  /** @var string */
  $email = get_param('email', null);

  /** @var string */
  $password = get_param('password', null);

  if (Auth::login($email, $password)) {
    /** @var object */
    $user = UserModel::getSession();

    Msg::push(Msg::INFO, "ようこそ、{$user->name} さん！");
    redirect(GO_HOME);
  } else {
    redirect(GO_REFERER);
  }
}
