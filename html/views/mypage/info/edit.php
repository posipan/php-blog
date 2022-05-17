<?php

/**
 * ユーザー情報編集ページ
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace view\mypage\info\edit;

use model\UserModel;

/**
 * ユーザー情報編集ページを出力
 *
 * @param object $user ユーザー情報
 * @return void
 */
function index($user): void
{
?>

  <h1 class="page-title">ユーザー情報の編集</h1>

  <div class="user-edit">
    <form action="<?php echo CURRENT_URI; ?>" method="POST" class="form box form--auth" id="form--user-edit">
      <input type="hidden" name="id" value="<?php echo $user->id; ?>">

      <div class="form__control">
        <p class="form__label">ユーザー名<span class="required">※</span></p>
        <div class="form__content">
          <input type="text" name="name" id="name" value="<?php echo $user->name; ?>" />
          <p class="form__error"></p>
        </div>
      </div>

      <div class="form__control">
        <p class="form__label">メールアドレス<span class="required">※</span></p>
        <div class="form__content">
          <input type="email" name="email" id="email" value="<?php echo $user->email; ?>" />
          <p class="form__error"></p>
        </div>
      </div>

      <div class="form__control">
        <p class="form__label">パスワード<span class="required">※</span></p>
        <div class="form__content">
          <input type="password" name="password" id="password" value="" />
          <p class="form__error"></p>
        </div>
      </div>

      <div class="form__control">
        <p class="form__label">パスワードの確認<span class="required">※</span></p>
        <div class="form__content">
          <input type="password" name="confirm-password" id="confirm-password" value="" />
          <p class="form__error"></p>
        </div>
      </div>

      <div class="form__btn">
        <button type="submit" name="dispatch" value="<?php echo UserModel::$UPDATE; ?>" id="btn--user-update" class="btn btn--accent">更新する</button>
        <a class="btn btn--cancel" id="cancel" onclick="return confirm('この記事の編集をキャンセルしますか？');" href="<?php the_url('mypage/info/show'); ?>">キャンセル</a>
      </div>

      <div class="form__delete">
        <button type="submit" name="dispatch" id="btn--user-delete" value="<?php echo UserModel::$DELETE; ?>" onclick="return confirm('これまで作成した記事も全て削除されます。ユーザーを削除しますか？');">ユーザーを削除する</button>
      </div>
    </form>
  </div>

<?php
}
?>
