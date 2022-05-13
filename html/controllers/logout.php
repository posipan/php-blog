<?php

/**
 * ログアウトのコントローラー
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace controller\logout;

use lib\Auth;
use lib\Msg;


/**
 * ログアウト状態を確認し、ホームページへリダイレクト
 *
 * @return void
 */
function get(): void
{
  if (Auth::logout()) {
    Msg::push(Msg::INFO, 'ログアウトしました。');
  } else {
    Msg::push(Msg::ERROR, 'ログアウトに失敗しました。');
  }

  redirect(GO_HOME);
}
