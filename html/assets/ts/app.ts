import '../sass/style.scss';
import {
  userValidate,
  loginValidate,
  $registerBtn,
  $registerForm,
  $loginBtn,
  $loginForm,
  $userEditForm,
  $userUpdateBtn,
  $userDeleteBtn,
  postValidate,
  $createPostBtn,
  $updatePostBtn,
  $deletePostBtn,
  $postCreateForm,
  $postEditForm,
} from './validate';
import { showMessage } from './msg';
import { initPreview, createPreview } from './img';
import { menu } from './menu';

menu();
// showMessage('.msg');

// ユーザー登録
userValidate($registerBtn, $registerForm);

// ログイン
loginValidate($loginBtn, $loginForm);

// ユーザー編集
userValidate($userUpdateBtn, $userEditForm);

// ユーザー削除
userValidate($userDeleteBtn, $userEditForm);

// 記事作成
postValidate($createPostBtn, $postCreateForm);

// 記事編集
postValidate($updatePostBtn, $postEditForm);

// 記事削除
postValidate($deletePostBtn, $postEditForm);

if (document.querySelector('.form--post')) {
  initPreview();

  const uploadImage = document.getElementById('upload-image') as HTMLInputElement;
  uploadImage.addEventListener('change', function () {
    createPreview(this);
  });
}
