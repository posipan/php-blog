import '../sass/style.scss';
import {
  userValidate,
  loginValidate,
  $registerForm,
  $loginForm,
  $userEditForm,
  postValidate,
  $postCreateForm,
  $postEditForm,
} from './validate';
import { showMessage } from './msg';
import { setPreview } from './img';
import { menu } from './menu';

menu();
showMessage('.msg--info');
setPreview();

// ユーザー登録
userValidate($registerForm);

// ログイン
loginValidate($loginForm);

// ユーザー編集
userValidate($userEditForm);

// 記事作成
postValidate($postCreateForm);

// 記事編集
postValidate($postEditForm);
