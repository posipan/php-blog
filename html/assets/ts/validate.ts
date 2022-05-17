/**
 * 変数
 */
// 要素
const $username = document.getElementById('name') as HTMLInputElement;
const $email = document.getElementById('email') as HTMLInputElement;
const $password = document.getElementById('password') as HTMLInputElement;
const $confirmPassword = document.getElementById('confirm-password') as HTMLInputElement;
const $postTitle = document.getElementById('title') as HTMLInputElement;
const $postContent = document.getElementById('content') as HTMLInputElement;

// ボタン
export const $registerBtn = document.getElementById('btn--register') as HTMLElement;
export const $loginBtn = document.getElementById('btn--login') as HTMLElement;
export const $userUpdateBtn = document.getElementById('btn--user-update') as HTMLElement;
export const $userDeleteBtn = document.getElementById('btn--user-delete') as HTMLElement;

export const $createPostBtn = document.getElementById('btn--post-create') as HTMLElement;
export const $updatePostBtn = document.getElementById('btn--post-update') as HTMLElement;
export const $deletePostBtn = document.getElementById('btn--post-delete') as HTMLElement;

// フォーム
export const $registerForm = document.getElementById('form--register') as HTMLFormElement;
export const $loginForm = document.getElementById('form--login') as HTMLFormElement;
export const $userEditForm = document.getElementById('form--user-edit') as HTMLFormElement;

export const $postCreateForm = document.getElementById('form--post-create') as HTMLFormElement;
export const $postEditForm = document.getElementById('form--post-edit') as HTMLFormElement;


/**
 * バリデーション関数
 */

// 必須項目判定
const isRequired = (val: string): boolean => (val === '' ? false : true);

// 長さ範囲判定
const isBetween = (len: number, min: number, max: number): boolean => (len < min || len > max ? false : true);

// メールアドレス形式判定
const isEmailValid = (val: string): boolean => {
  const reg = new RegExp(
    /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
  );
  return reg.test(val);
};

// パスワード形式判定
const isPassword = (pwd: string): boolean => {
  // const reg = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
  const reg = new RegExp('^(?=.*[a-z])(?=.*[0-9])(?=.{8,})');
  return reg.test(pwd);
};

/**
 * サクセス & エラー
 */
// サクセス
const showSuccess = ($input: HTMLInputElement): void => {
  $input.classList.remove('validate-error');
  $input.classList.add('validate-success');

  const $error = $input.nextElementSibling as HTMLElement;
  $error.textContent = '';
};

// エラー
const showError = ($input: HTMLInputElement, msg: string): void => {
  $input.classList.remove('validate-success');
  $input.classList.add('validate-error');
  const $error = $input.nextElementSibling as HTMLElement;
  $error.textContent = msg;
};

/**
 * 各項目チェック
 */
// ユーザー名チェック
const checkUsername = () => {
  let valid: boolean = false;

  const min: number = 1,
    max: number = 15;

  const usernameVal: string = $username.value.trim();

  if (!isRequired(usernameVal)) {
    showError($username, 'ユーザー名を入力してください。');
  } else if (!isBetween(usernameVal.length, min, max)) {
    showError($username, `ユーザー名は${min}以上、${max}以下で入力してください。`);
  } else {
    showSuccess($username);
    valid = true;
  }

  return valid;
};

// メールアドレスチェック
const checkEmail = () => {
  let valid: boolean = false;

  const emailVal = $email.value.trim();
  if (!isRequired(emailVal)) {
    showError($email, 'メールアドレスを入力してください。');
  } else if (!isEmailValid(emailVal)) {
    showError($email, 'メールアドレス形式で入力してください。');
  } else {
    showSuccess($email);
    valid = true;
  }

  return valid;
};

// パスワードチェック
const checkPassword = () => {
  let valid: boolean = false;

  const passwordVal = $password.value.trim();

  if (!isRequired(passwordVal)) {
    showError($password, 'パスワードを入力してください。');
  } else if (!isPassword(passwordVal)) {
    showError($password, 'パスワードは半角英字と半角数字をそれぞれ1文字以上使い、合計8文字以上で入力してください。');
  } else {
    showSuccess($password);
    valid = true;
  }

  return valid;
};

// パスワード一致確認
const checkConfirmPassword = () => {
  let valid: boolean = false;

  const confirmPasswordVal: string = $confirmPassword.value.trim();
  const passwordVal: string = $password.value.trim();

  if (!isRequired(confirmPasswordVal)) {
    showError($confirmPassword, 'パスワードを入力してください。');
  } else if (passwordVal !== confirmPasswordVal) {
    showError($confirmPassword, 'パスワードが一致しません。');
  } else {
    showSuccess($confirmPassword);
    valid = true;
  }

  return valid;
};

// 記事タイトルチェック
const checkPostTitle = () => {
  let valid = false;

  const min = 1,
    max = 80;

  const postTitleVal: string = $postTitle.value.trim();

  if (!isRequired(postTitleVal)) {
    showError($postTitle, 'タイトルを入力してください。');
  } else if (!isBetween(postTitleVal.length, min, max)) {
    showError($postTitle, `タイトルは${min}以上、${max}以下で入力してください。`);
  } else {
    showSuccess($postTitle);
    valid = true;
  }

  return valid;
};

// 記事タイトルチェック
const checkPostContent = () => {
  let valid = false;

  const postContentVal: string = $postContent.value.trim();

  if (!isRequired(postContentVal)) {
    showError($postContent, '本文を入力してください。');
  } else {
    showSuccess($postContent);
    valid = true;
  }

  return valid;
};

/**
 * バリデーション
 */
export const userValidate = ($btn: HTMLElement, $form: HTMLFormElement) => {
  if ($btn) {
    $btn.addEventListener('click', function (e) {
      e.preventDefault();

      if (this === $userDeleteBtn) {
        $form.submit();
      } else {
        let isUsernameValid = checkUsername(),
          isEmailValid = checkEmail(),
          isPasswordValid = checkPassword(),
          isConfirmPasswordValid = checkConfirmPassword();

        let isFormValid = isUsernameValid && isEmailValid && isPasswordValid && isConfirmPasswordValid;

        if (isFormValid) {
          $form.submit();
        }
      }
    });
  }
};

// ログイン
export const loginValidate = ($btn: HTMLElement, $form: HTMLFormElement) => {
  if ($btn) {
    $btn.addEventListener('click', function (e) {
      e.preventDefault();

      let isEmailValid = checkEmail(),
        isPasswordValid = checkPassword();
      let isFormValid = isEmailValid && isPasswordValid;

      if (isFormValid) {
        $form.submit();
      }
    });
  }
};

// 記事
export const postValidate = ($btn: HTMLElement, $form: HTMLFormElement) => {
  if ($btn) {
    $btn.addEventListener('click', function (e) {
      e.preventDefault();

      if (this === $deletePostBtn) {
        $form.submit();
      } else {
        let isPostTitleValid = checkPostTitle(),
          isPostContentValid = checkPostContent();
        let isFormValid = isPostTitleValid && isPostContentValid;

        if (isFormValid) {
          $form.submit();
        }
      }
    });
  }
};
