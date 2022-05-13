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

  <div class="register">
    <form action="<?php echo CURRENT_URI; ?>" method="POST" class="form box">
      <div class="form__control">
        <label for="email" class="form__label">メールアドレス</label>
        <div class="form__content">
          <input type="email" name="email" id="email" placeholder="example@example.com" />
        </div>
      </div>

      <div class="form__control">
        <label for="password" class="form__label">パスワード</label>
        <div class="form__content">
          <input type="password" name="password" id="password" />
        </div>
      </div>

      <div class="form__btn">
        <button type="submit" class="btn btn--accent">ログイン</button>
      </div>
    </form>

    <p class="register__link"><a href="<?php the_url('register'); ?>">ユーザー登録はこちら</a></p>
  </div>

<?php
}
?>
