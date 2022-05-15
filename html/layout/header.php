<?php

/**
 * ヘッダー
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace layout;

use lib\Auth;
use lib\Msg;
use model\UserModel;

/**
 * ヘッダーを出力
 *
 * @return void
 */
function header(): void
{
?>

  <!DOCTYPE html>
  <html lang="ja">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:site_name" content="" />
    <meta property="og:description" content="" />
    <meta property="og:title" content="" />
    <meta property="og:image" content="" />
    <meta property="og:url" content="" />
    <meta property="og:type" content="" />

    <meta name="twitter:card" content="" />
    <meta name="twitter:site" content="" />
    <meta name="twitter:title" content="" />
    <meta name="twitter:description" content="" />
    <meta name="twitter:image" content="" />

    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo BASE_IMAGE_PATH; ?>favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo BASE_IMAGE_PATH; ?>favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo BASE_IMAGE_PATH; ?>favicons/favicon-16x16.png">
    <link rel="manifest" href="<?php echo BASE_IMAGE_PATH; ?>favicons/site.webmanifest">
    <link rel="mask-icon" href="<?php echo BASE_IMAGE_PATH; ?>favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossOrigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/fontawesome.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/solid.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="<?php echo BASE_CSS_PATH; ?>style.css">
    <title>ブログ</title>
  </head>

  <body>
    <header class="header">
      <div class="header__inner">
        <div class="header__logo">
          <a href="<?php the_url('/'); ?>">
            <img src="<?php echo BASE_IMAGE_PATH; ?>logo.svg" alt="">
          </a>
        </div>
        <nav class="header__nav">
          <?php
          if (Auth::isLogin()) :
            /** @var object $user */
            $user = UserModel::getSession();
          ?>
            <ul class="mypage">
              <li class="mypage__item">
                <a class="mypage__name" id="mypage__name">
                  <span class="icon"><i class="fa-solid fa-user"></i></span>
                  <?php echo escape($user->name); ?>
                </a>
                <div class="mypage__menu">
                  <ul>
                    <li><a href="<?php the_url('mypage/post/archive'); ?>">マイポスト一覧</a></li>
                    <li><a href="<?php the_url('mypage/info/show'); ?>">ユーザー情報</a></li>
                    <li><a href="<?php the_url('logout'); ?>">ログアウト</a></li>
                    <li class="mypage__create"><a href="<?php the_url('mypage/post/create'); ?>" class="btn btn--accent">記事を作成する</a></li>
                  </ul>
                </div>
              </li>
            </ul>
          <?php else : ?>
            <ul class="guest">
              <li><a href="<?php the_url('login'); ?>">ログイン</a></li>
              <li><a href="<?php the_url('register'); ?>">ユーザー登録</a></li>
            </ul>
          <?php endif; ?>
          </ul>
        </nav>
      </div>
    </header>
    <main>

      <div class="container">
        <?php Msg::flush(); ?>

      <?php
    }
      ?>
