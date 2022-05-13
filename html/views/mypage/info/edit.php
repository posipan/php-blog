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

  <div class="box">
    <form action="<?php echo CURRENT_URI; ?>" method="POST" class="form">
      <input type="hidden" name="id" value="<?php echo $user->id; ?>">
      <div class="form__control">
        <label for="name" class="form__label">ユーザー名</label>
        <p class="form__content">
          <input type="text" name="name" id="name" value="<?php echo $user->name; ?>" />
        </p>
      </div>

      <div class="form__control">
        <label for="email" class="form__label">メールアドレス</label>
        <p class="form__content">
          <input type="email" name="email" id="email" value="<?php echo $user->email; ?>" />
        </p>
      </div>

      <div class="form__control">
        <label for="password" class="form__label">パスワード</label>
        <p class="form__content">
          <input type="password" name="password" id="password" value="" />
        </p>
      </div>

      <div class="form__control">
        <label for="password-confirm" class="form__label">パスワードの確認</label>
        <p class="form__content">
          <input type="password" name="password-confirm" id="password-confirm" value="" />
        </p>
      </div>

      <div class="form__btn">
        <a class="btn btn--cancel" id="cancel" onclick="return confirm('この記事の編集をキャンセルしますか？');" href="<?php the_url('mypage/info/show'); ?>">キャンセル</a>
        <button type="submit" name="dispatch" value="<?php echo UserModel::$UPDATE; ?>" class="btn btn--accent">更新する</button>
      </div>

      <p class="form__delete"><button type="submit" name="dispatch" value="<?php echo UserModel::$DELETE; ?>" onclick="return confirm('これまで作成した記事も全て削除されます。ユーザーを削除しますか？');">ユーザーを削除する</button></p>
    </form>
  </div>

<?php
}
?>
