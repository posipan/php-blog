<?php

/**
 * ユーザー登録ページ
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace view\register;

/**
 * ユーザー登録ページを出力
 *
 * @return void
 */
function index(): void
{
?>

  <h1 class="page-title">ユーザー登録</h1>

  <div class="register auth">
    <form action="<?php echo CURRENT_URI; ?>" method="POST" class="form box form--validate" novalidate>
      <div class="form__control">
        <p class="form__label">ユーザー名<span class="required">※</span></p>
        <div class="form__content">
          <input type="text" name="name" placeholder="Posipan" class="validate" required minlength="1" maxlength="15" />
          <p class="form__error"></p>
        </div>
      </div>

      <div class="form__control">
        <p class="form__label">メールアドレス<span class="required">※</span></p>
        <div class="form__content">
          <input type="email" name="email" placeholder="example@example.com" class="validate validate--email" required pattern="^[a-zA-Z0-9.!#$&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)+$" />
          <p class="form__error"></p>
        </div>
      </div>

      <div class="form__control">
        <p class="form__label">パスワード<span class="required">※</span></p>
        <div class="form__content">
          <input type="password" name="password" class="validate validate--password" required minlength="8" pattern="[a-zA-Z0-9]+" />
          <p class="form__error"></p>
        </div>
      </div>

      <div class="form__control">
        <p class="form__label">パスワード確認<span class="required">※</span></p>
        <div class="form__content">
          <input type="password" name="password-confirm" class="validate validate--password-confirm" />
          <p class="form__error"></p>
        </div>
      </div>

      <div class="form__btn">
        <button type="submit" class="btn btn--accent">登録する</button>
      </div>
    </form>

    <p class="auth__link"><a href="<?php the_url('login'); ?>">ログインはこちら</a></p>
  </div>

<?php
}
?>
