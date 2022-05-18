/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./html/assets/sass/style.scss":
/*!*************************************!*\
  !*** ./html/assets/sass/style.scss ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./html/assets/ts/img.ts":
/*!*******************************!*\
  !*** ./html/assets/ts/img.ts ***!
  \*******************************/
/***/ ((__unused_webpack_module, exports) => {


/**
 * Thumbnail Image
 */
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.setPreview = void 0;
var setPreview = function () {
    var $preview = document.getElementById('preview');
    if (!$preview) {
        return;
    }
    var isImage = function (fileName) {
        var image = fileName.substring(fileName.lastIndexOf('.'));
        if (image.match(/\.(jpg|jpeg|png|gif|svg)$/i)) {
            return true;
        }
        return false;
    };
    var isBase64Image = function (fileName) {
        if (fileName.match(/^(data:image)?/i)) {
            return true;
        }
        return false;
    };
    var initPreview = function () {
        var $formImage = document.getElementById('form__image');
        var $formPreview = document.getElementById('form__preview');
        var $deleteBtn = document.getElementById('delete-image');
        var $hiddenImage = document.getElementById('hidden-image');
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
        }
        else {
            $formPreview.style.display = 'none';
            $formImage.style.display = 'block';
        }
    };
    var createPreview = function (elem) {
        var fileReader = new FileReader();
        var file = elem.files[0];
        fileReader.onload = function () {
            $preview.src = fileReader.result;
        };
        fileReader.readAsDataURL(file);
        $preview.classList.add('active');
        initPreview();
    };
    if (document.querySelector('.form--post')) {
        initPreview();
        var uploadImage = document.getElementById('upload-image');
        uploadImage.addEventListener('change', function () {
            createPreview(this);
        });
    }
};
exports.setPreview = setPreview;


/***/ }),

/***/ "./html/assets/ts/menu.ts":
/*!********************************!*\
  !*** ./html/assets/ts/menu.ts ***!
  \********************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {


Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.menu = void 0;
var var_1 = __webpack_require__(/*! ./var */ "./html/assets/ts/var.ts");
var menu = function () {
    var $mypageName = document.getElementById('mypage__name');
    if ($mypageName !== null) {
        $mypageName.addEventListener('click', function (e) {
            e.preventDefault();
            var nextElem = this.nextElementSibling;
            if (window.innerWidth <= var_1.breakPoint) {
                nextElem.classList.toggle('active');
            }
            else {
                return false;
            }
        });
    }
};
exports.menu = menu;


/***/ }),

/***/ "./html/assets/ts/msg.ts":
/*!*******************************!*\
  !*** ./html/assets/ts/msg.ts ***!
  \*******************************/
/***/ ((__unused_webpack_module, exports) => {


Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.showMessage = void 0;
var showMessage = function (elem) {
    var time = 4000;
    var $msgElm = document.querySelector(elem);
    if ($msgElm) {
        $msgElm.classList.add('active');
        setTimeout(function () {
            $msgElm.classList.remove('active');
        }, time);
    }
};
exports.showMessage = showMessage;


/***/ }),

/***/ "./html/assets/ts/validate.ts":
/*!************************************!*\
  !*** ./html/assets/ts/validate.ts ***!
  \************************************/
/***/ ((__unused_webpack_module, exports) => {


Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.postValidate = exports.loginValidate = exports.userValidate = exports.$postEditForm = exports.$postCreateForm = exports.$userEditForm = exports.$loginForm = exports.$registerForm = void 0;
/**
 * 変数
 */
// 要素
var $username = document.getElementById('name');
var $email = document.getElementById('email');
var $password = document.getElementById('password');
var $confirmPassword = document.getElementById('confirm-password');
var $postTitle = document.getElementById('title');
var $postContent = document.getElementById('content');
// フォーム
exports.$registerForm = document.getElementById('form--register');
exports.$loginForm = document.getElementById('form--login');
exports.$userEditForm = document.getElementById('form--user-edit');
exports.$postCreateForm = document.getElementById('form--post-create');
exports.$postEditForm = document.getElementById('form--post-edit');
/**
 * バリデーション関数
 */
// 必須項目判定
var isRequired = function (val) { return (val === '' ? false : true); };
// 長さ範囲判定
var isBetween = function (len, min, max) { return (len < min || len > max ? false : true); };
// メールアドレス形式判定
var isEmailValid = function (val) {
    var reg = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
    return reg.test(val);
};
// パスワード形式判定
var isPassword = function (pwd) {
    // const reg = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
    var reg = new RegExp('^(?=.*[a-z])(?=.*[0-9])(?=.{8,})');
    return reg.test(pwd);
};
/**
 * サクセス & エラー
 */
// サクセス
var showSuccess = function ($input) {
    $input.classList.remove('validate-error');
    $input.classList.add('validate-success');
    var $error = $input.nextElementSibling;
    $error.textContent = '';
};
// エラー
var showError = function ($input, msg) {
    $input.classList.remove('validate-success');
    $input.classList.add('validate-error');
    var $error = $input.nextElementSibling;
    $error.textContent = msg;
};
/**
 * 各項目チェック
 */
// ユーザー名チェック
var checkUsername = function () {
    var valid = false;
    var min = 1, max = 15;
    var usernameVal = $username.value.trim();
    if (!isRequired(usernameVal)) {
        showError($username, 'ユーザー名を入力してください。');
    }
    else if (!isBetween(usernameVal.length, min, max)) {
        showError($username, "\u30E6\u30FC\u30B6\u30FC\u540D\u306F".concat(min, "\u4EE5\u4E0A\u3001").concat(max, "\u4EE5\u4E0B\u3067\u5165\u529B\u3057\u3066\u304F\u3060\u3055\u3044\u3002"));
    }
    else {
        showSuccess($username);
        valid = true;
    }
    return valid;
};
// メールアドレスチェック
var checkEmail = function () {
    var valid = false;
    var emailVal = $email.value.trim();
    if (!isRequired(emailVal)) {
        showError($email, 'メールアドレスを入力してください。');
    }
    else if (!isEmailValid(emailVal)) {
        showError($email, 'メールアドレス形式で入力してください。');
    }
    else {
        showSuccess($email);
        valid = true;
    }
    return valid;
};
// パスワードチェック
var checkPassword = function () {
    var valid = false;
    var passwordVal = $password.value.trim();
    if (!isRequired(passwordVal)) {
        showError($password, 'パスワードを入力してください。');
    }
    else if (!isPassword(passwordVal)) {
        showError($password, 'パスワードは半角英字と半角数字をそれぞれ1文字以上使い、合計8文字以上で入力してください。');
    }
    else {
        showSuccess($password);
        valid = true;
    }
    return valid;
};
// パスワード一致確認
var checkConfirmPassword = function () {
    var valid = false;
    var confirmPasswordVal = $confirmPassword.value.trim();
    var passwordVal = $password.value.trim();
    if (!isRequired(confirmPasswordVal)) {
        showError($confirmPassword, 'パスワードを入力してください。');
    }
    else if (passwordVal !== confirmPasswordVal) {
        showError($confirmPassword, 'パスワードが一致しません。');
    }
    else {
        showSuccess($confirmPassword);
        valid = true;
    }
    return valid;
};
// 記事タイトルチェック
var checkPostTitle = function () {
    var valid = false;
    var min = 1, max = 80;
    var postTitleVal = $postTitle.value.trim();
    if (!isRequired(postTitleVal)) {
        showError($postTitle, 'タイトルを入力してください。');
    }
    else if (!isBetween(postTitleVal.length, min, max)) {
        showError($postTitle, "\u30BF\u30A4\u30C8\u30EB\u306F".concat(min, "\u4EE5\u4E0A\u3001").concat(max, "\u4EE5\u4E0B\u3067\u5165\u529B\u3057\u3066\u304F\u3060\u3055\u3044\u3002"));
    }
    else {
        showSuccess($postTitle);
        valid = true;
    }
    return valid;
};
// 記事タイトルチェック
var checkPostContent = function () {
    var valid = false;
    var postContentVal = $postContent.value.trim();
    if (!isRequired(postContentVal)) {
        showError($postContent, '本文を入力してください。');
    }
    else {
        showSuccess($postContent);
        valid = true;
    }
    return valid;
};
/**
 * バリデーション
 */
var userValidate = function ($form) {
    if ($form) {
        $form.addEventListener('submit', function (e) {
            var isUsernameValid = checkUsername(), isEmailValid = checkEmail(), isPasswordValid = checkPassword(), isConfirmPasswordValid = checkConfirmPassword();
            var isFormValid = isUsernameValid && isEmailValid && isPasswordValid && isConfirmPasswordValid;
            if (isFormValid) {
                console.log('valid');
                return true;
            }
            else {
                e.preventDefault();
                console.log('invalid');
                return false;
            }
        });
    }
};
exports.userValidate = userValidate;
// ログイン
var loginValidate = function ($form) {
    if ($form) {
        $form.addEventListener('submit', function (e) {
            var isEmailValid = checkEmail(), isPasswordValid = checkPassword();
            var isFormValid = isEmailValid && isPasswordValid;
            if (isFormValid) {
                return true;
            }
            else {
                e.preventDefault();
                return false;
            }
        });
    }
};
exports.loginValidate = loginValidate;
// 記事
var postValidate = function ($form) {
    if ($form) {
        $form.addEventListener('submit', function (e) {
            var isPostTitleValid = checkPostTitle(), isPostContentValid = checkPostContent();
            var isFormValid = isPostTitleValid && isPostContentValid;
            if (isFormValid) {
                return true;
            }
            else {
                e.preventDefault();
                return false;
            }
        });
    }
};
exports.postValidate = postValidate;


/***/ }),

/***/ "./html/assets/ts/var.ts":
/*!*******************************!*\
  !*** ./html/assets/ts/var.ts ***!
  \*******************************/
/***/ ((__unused_webpack_module, exports) => {


Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.breakPoint = void 0;
exports.breakPoint = 749;


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
var exports = __webpack_exports__;
/*!*******************************!*\
  !*** ./html/assets/ts/app.ts ***!
  \*******************************/

Object.defineProperty(exports, "__esModule", ({ value: true }));
__webpack_require__(/*! ../sass/style.scss */ "./html/assets/sass/style.scss");
var validate_1 = __webpack_require__(/*! ./validate */ "./html/assets/ts/validate.ts");
var msg_1 = __webpack_require__(/*! ./msg */ "./html/assets/ts/msg.ts");
var img_1 = __webpack_require__(/*! ./img */ "./html/assets/ts/img.ts");
var menu_1 = __webpack_require__(/*! ./menu */ "./html/assets/ts/menu.ts");
(0, menu_1.menu)();
(0, msg_1.showMessage)('.msg--info');
(0, img_1.setPreview)();
// ユーザー登録
(0, validate_1.userValidate)(validate_1.$registerForm);
// ログイン
(0, validate_1.loginValidate)(validate_1.$loginForm);
// ユーザー編集
(0, validate_1.userValidate)(validate_1.$userEditForm);
// 記事作成
(0, validate_1.postValidate)(validate_1.$postCreateForm);
// 記事編集
(0, validate_1.postValidate)(validate_1.$postEditForm);

})();

/******/ })()
;
//# sourceMappingURL=bundle.js.map