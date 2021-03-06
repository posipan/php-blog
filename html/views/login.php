<?php

/**
 * ログインページ
 *
 * @author Posipan
 */


declare(strict_types=1);

namespace view\login;

/**
 * ログインページを出力
 *
 * @return void
 */
function index(): void
{
?>

  <h1 class="page-title">ログイン</h1>

  <div class="register auth">
    <form action="<?php echo CURRENT_URI; ?>" method="POST" class="form box form--auth" id="form--login" novalidate>
      <div class="form__control">
        <p class="form__label">メールアドレス<span class="required">※</span></p>
        <div class="form__content">
          <input type="email" name="email" id="email" placeholder="example@example.com" />
          <p class="form__error"></p>
        </div>
      </div>

      <div class="form__control">
        <p class="form__label">パスワード<span class="required">※</span></p>
        <div class="form__content">
          <input type="password" name="password" id="password" />
          <p class="form__error"></p>
        </div>
      </div>

      <div class="form__btn">
        <button type="submit" id="btn--login" class="btn btn--accent">ログイン</button>
      </div>
    </form>

    <p class="auth__link"><a href="<?php the_url('register'); ?>">ユーザー登録はこちら</a></p>
  </div>

<?php
}
?>
