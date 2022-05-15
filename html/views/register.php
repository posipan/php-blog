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
    <form action="<?php echo CURRENT_URI; ?>" method="POST" class="form box">
      <div class="form__control">
        <p class="form__label">ユーザー名</p>
        <div class="form__content">
          <input type="text" name="name" placeholder="Posipan" />
        </div>
      </div>

      <div class="form__control">
        <p class="form__label">メールアドレス</p>
        <div class="form__content">
          <input type="email" name="email" placeholder="example@example.com" />
        </div>
      </div>

      <div class="form__control">
        <p class="form__label">パスワード</p>
        <div class="form__content">
          <input type="password" name="password" />
        </div>
      </div>

      <div class="form__control">
        <label for="password-confirm" class="form__label">パスワード確認</label>
        <div class="form__content">
          <input type="password" name="password-confirm" id="password-confirm" />
        </div>
        <!-- <p class="form__error">パスワードは8文字以上入力してください。</p> -->
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
