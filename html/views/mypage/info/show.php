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

  <div class="box">
    <div class="form">
      <div class="form__control">
        <label for="name" class="form__label">ユーザー名</label>
        <p class="form__content">
          <input type="text" name="name" id="name" value="<?php echo escape($user->name); ?>" disabled />
        </p>
      </div>

      <div class="form__control">
        <label for="email" class="form__label">メールアドレス</label>
        <p class="form__content">
          <input type="email" name="email" id="email" value="<?php echo escape($user->email); ?>" disabled />
        </p>
      </div>

      <div class="form__control">
        <label for="password" class="form__label">パスワード</label>
        <p class="form__content">
          <input type="password" name="password" id="password" value="********" disabled />
        </p>
      </div>

      <div class="form__btn">
        <a href="<?php the_url('mypage/info/edit'); ?>" class="btn btn--accent">編集する</a>
      </div>
    </div>
  </div>
<?php
}
?>
