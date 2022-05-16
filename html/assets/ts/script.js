const breakPoint = 749;

function activateSubmitBtn($form) {
  const $submitBtn = $form.querySelector('[type="submit"]');

  if ($form.checkValidity()) {
    $submitBtn.removeAttribute('disabled');
  } else {
    $submitBtn.setAttribute('disabled', true);
  }
}

function validateForm() {
  const $form = document.querySelector('.form--validate');

  if (!$form) {
    return;
  }
  const $inputs = document.querySelectorAll('.validate');

  for (const $input of $inputs) {
    $input.addEventListener('input', function (e) {
      const $target = $input;
      const $error = $target.nextElementSibling;

      if (!$target.checkValidity()) {
        if ($target.validity.valueMissing) {
          $error.textContent = '入力してください！';
        } else if ($target.validity.tooShort) {
          $error.textContent = $target.minLength + '文字以上で入力してください！';
        } else if ($target.validity.tooLong) {
          $error.textContent = $target.maxLength + '文字以下で入力してください！';
        } else if ($target.validity.patternMismatch) {
          if ($target.classList.contains('validate--email')) {
            $error.textContent = '正しいメールアドレス形式で入力してください！';
          } else {
            $error.textContent = '半角英数字で入力してください！';
          }
        } else {
          $error.textContent = '';
        }
      } else {
        if ($target.classList.contains('validate--password-confirm')) {
          const $password = document.querySelector('.validate--password');
          const $passwordConfirm = document.querySelector('.validate--password-confirm');

          if ($password.value !== $passwordConfirm.value) {
            $error.textContent = 'パスワードを一致させてください！';
          } else {
            $error.textContent = '';
          }
        } else {
          $error.textContent = '';
        }
      }

      activateSubmitBtn($form);
    });
  }

  activateSubmitBtn($form);
}
validateForm();
