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

  <form action="<?php echo CURRENT_URI; ?>" method="POST" class="form box">
    <input type="hidden" name="id" value="<?php echo $user->id; ?>">

    <div class="form__control">
      <p class="form__label">ユーザー名</p>
      <p class="form__content">
        <input type="text" name="name" value="<?php echo $user->name; ?>" />
      </p>
    </div>

    <div class="form__control">
      <p class="form__label">メールアドレス</p>
      <p class="form__content">
        <input type="email" name="email" value="<?php echo $user->email; ?>" />
      </p>
    </div>

    <div class="form__control">
      <p class="form__label">パスワード</p>
      <div class="form__content">
        <input type="password" name="password" value="" />
      </div>
    </div>

    <div class="form__control">
      <p class="form__label">パスワードの確認</p>
      <div class="form__content">
        <input type="password" name="password-confirm" value="" />
      </div>
    </div>

    <div class="form__btn">
      <button type="submit" name="dispatch" value="<?php echo UserModel::$UPDATE; ?>" class="btn btn--accent">更新する</button>
      <a class="btn btn--cancel" id="cancel" onclick="return confirm('この記事の編集をキャンセルしますか？');" href="<?php the_url('mypage/info/show'); ?>">キャンセル</a>
    </div>

    <div class="form__delete">
      <button type="submit" name="dispatch" value="<?php echo UserModel::$DELETE; ?>" onclick="return confirm('これまで作成した記事も全て削除されます。ユーザーを削除しますか？');">ユーザーを削除する</button>
    </div>
  </form>

<?php
}
?>
