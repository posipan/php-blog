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

  <div class="register">
    <form action="<?php echo CURRENT_URI; ?>" method="POST" class="form box">
      <div class="form__control">
        <label for="name" class="form__label">ユーザー名</label>
        <p class="form__content">
          <input type="text" name="name" id="name" placeholder="POSIPAN" />
        </p>
      </div>

      <div class="form__control">
        <label for="email" class="form__label">メールアドレス</label>
        <p class="form__content">
          <input type="email" name="email" id="email" placeholder="example@example.com" />
        </p>
      </div>

      <div class="form__control">
        <label for="password" class="form__label">パスワード</label>
        <p class="form__content">
          <input type="password" name="password" id="password" />
        </p>
      </div>

      <div class="form__control">
        <label for="password-confirm" class="form__label">パスワード確認</label>
        <p class="form__content">
          <input type="password" name="password-confirm" id="password-confirm" />
        </p>

        <!-- <p class="form__error">パスワードは8文字以上入力してください。</p> -->
      </div>

      <div class="form__btn">
        <button type="submit" class="btn btn--accent">登録</button>
      </div>
    </form>

    <p class="register__link"><a href="<?php the_url('login'); ?>">ログインはこちら</a></p>
  </div>

<?php
}
?>
