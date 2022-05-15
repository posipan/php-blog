<?php

/**
 * ユーザー情報確認ページ
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace view\mypage\info\show;

/**
 * ユーザー情報確認ページを出力
 *
 * @param object $user ユーザー情報
 * @return void
 */
function index($user): void
{
?>

  <h1 class="page-title">ユーザー情報確認</h1>

  <div class="form box">
    <div class="form__control">
      <p class="form__label">ユーザー名</p>
      <div class="form__content">
        <input type="text" name="name" value="<?php echo escape($user->name); ?>" disabled />
      </div>
    </div>

    <div class="form__control">
      <p class="form__label">メールアドレス</p>
      <div class="form__content">
        <input type="email" name="email" value="<?php echo escape($user->email); ?>" disabled />
      </div>
    </div>

    <div class="form__control">
      <p class="form__label">パスワード</p>
      <div class="form__content">
        <input type="password" name="password" value="********" disabled />
      </div>
    </div>

    <div class="form__btn">
      <a href="<?php the_url('mypage/info/edit'); ?>" class="btn btn--accent">編集する</a>
    </div>
  </div>
<?php
}
?>
