<?php

/**
 * ユーザー情報編集ページのコントローラー
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace controller\mypage\info\edit;

use lib\Auth;
use lib\Msg;
use model\UserModel;

/**
 * ユーザー情報編集ページを表示
 *
 * @return void
 */
function get(): void
{
  Auth::requireLogin();

  /** @var object */
  $user = UserModel::getSession();

  \view\mypage\info\edit\index($user);
}

/**
 * ユーザー情報の更新処理
 *
 * @return mixed
 */
function post(): mixed
{
  Auth::requireLogin();

  /** @var object */
  $user = UserModel::getSession();

  /** @var int */
  $user->id = (int) get_param('id', null);

  /** @var \model\UserModel */
  $update_user = new UserModel();

  /** @var int */
  $update_user->id = (int) get_param('id', null);

  /** @var stirng */
  $update_user->name = get_param('name', null);

  /** @var stirng */
  $update_user->email = get_param('email', null);

  /** @var stirng */
  $update_user->password = get_param('password', null);

  /** @var stirng */
  $update_user->confirm_password = get_param('confirm-password', null);

  Auth::requireUserInfoPermission($user->id, $update_user->id);

  if (Auth::update($user, $update_user)) {
    UserModel::clearSession();

    Msg::push(Msg::INFO, 'ユーザー情報を更新しました。' . '<br>' . '再度ログインを行なってください。');

    redirect('login');
  } else {
    Msg::push(Msg::DEBUG, 'ユーザー情報の更新に失敗しました。' . '<br>' . 'もう一度やりなおしてください。');

    redirect(GO_REFERER);
  }
}
