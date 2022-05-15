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

/**
 * Toast
 */
function showToastInfo() {
  const TIME = 4000;
  const $toastElm = document.querySelector('.toast.toast--info');

  if ($toastElm !== null) {
    $toastElm.classList.add('active');
    setTimeout(function () {
      $toastElm.classList.remove('active');
    }, TIME);
  }
}
showToastInfo();

const isImage = (fileName) => {
  fileName = fileName.substring(fileName.lastIndexOf('.'));
  if (fileName.match(/\.(jpg|jpeg|png|gif|svg)$/i)) {
    return true;
  }
  return false;
};

const isBase64Image = (fileName) => {
  if (fileName.match(/^(data:image)?/i)) {
    return true;
  }
  return false;
};

/**
 * Mypage Post
 */
function initPreview() {
  const $preview = document.getElementById('preview');
  const $formImage = document.getElementById('form__image');
  const $formPreview = document.getElementById('form__preview');
  const $deleteBtn = document.getElementById('delete-image');
  const $hiddenImage = document.getElementById('hidden-image');

  $deleteBtn.addEventListener('click', function () {
    $preview.src = '';
    $formPreview.style.display = 'none';
    $formImage.style.display = 'block';
    $preview.classList.remove('active');
    $hiddenImage.value = '';
  });

  if (isImage($preview.src) || (isBase64Image($preview.src) && $preview.classList.contains('active'))) {
    $formPreview.style.display = 'block';
    $formImage.style.display = 'none';
  } else {
    $formPreview.style.display = 'none';
    $formImage.style.display = 'block';
  }
}

function createPreview(elm) {
  const $preview = document.getElementById('preview');
  let fileReader = new FileReader();

  fileReader.onload = function () {
    $preview.src = fileReader.result;
  };
  fileReader.readAsDataURL(elm.files[0]);

  $preview.classList.add('active');
  initPreview();
}

if (document.getElementById('form--post') !== null) {
  initPreview();

  document.getElementById('upload-image').addEventListener('change', function () {
    createPreview(this);
  });
}

/**
 * Hamburger Menu
 */
const $mypageName = document.getElementById('mypage__name');

if ($mypageName !== null) {
  $mypageName.addEventListener('click', function (e) {
    e.preventDefault();
    if (window.innerWidth <= breakPoint) {
      this.nextElementSibling.classList.toggle('active');
    } else {
      return false;
    }
  });
}
