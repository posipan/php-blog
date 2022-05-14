<?php

/**
 * エントリーポイントファイル
 *
 * ヘッダーやフッターの出力、ルーディングの実行を行っている。
 *
 * @author Posipan
 */

declare(strict_types=1);

use function lib\route;

// Config
require_once './config.php';

// Autoload
require './vendor/autoload.php';

// Dotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Library
require_once BASE_SOURCE_PATH . 'libs/Helper.php';
require_once BASE_SOURCE_PATH . 'libs/Auth.php';

// Model
require_once BASE_SOURCE_PATH . 'models/Abstract.model.php';
require_once BASE_SOURCE_PATH . 'models/User.model.php';
require_once BASE_SOURCE_PATH . 'models/Post.model.php';
require_once BASE_SOURCE_PATH . 'models/CategoryRelationship.model.php';
require_once BASE_SOURCE_PATH . 'models/Category.model.php';

// Message
require_once BASE_SOURCE_PATH . 'libs/Message.php';

// Router
require_once BASE_SOURCE_PATH . 'libs/Router.php';

// DB
require_once BASE_SOURCE_PATH . 'db/DB.php';
require_once BASE_SOURCE_PATH . 'db/User.query.php';
require_once BASE_SOURCE_PATH . 'db/Post.query.php';
require_once BASE_SOURCE_PATH . 'db/CategoryRelationship.query.php';
require_once BASE_SOURCE_PATH . 'db/Category.query.php';

// Layout
require_once BASE_SOURCE_PATH . 'layout/header.php';
require_once BASE_SOURCE_PATH . 'layout/footer.php';
require_once BASE_SOURCE_PATH . 'layout/post-item.php';
require_once BASE_SOURCE_PATH . 'layout/mypage-post-item.php';
require_once BASE_SOURCE_PATH . 'layout/pagination.php';

// View
require_once BASE_SOURCE_PATH . 'views/login.php';
require_once BASE_SOURCE_PATH . 'views/register.php';
require_once BASE_SOURCE_PATH . 'views/home.php';
require_once BASE_SOURCE_PATH . 'views/author.php';
require_once BASE_SOURCE_PATH . 'views/category.php';
require_once BASE_SOURCE_PATH . 'views/post.php';
require_once BASE_SOURCE_PATH . 'views/mypage/post/archive.php';
require_once BASE_SOURCE_PATH . 'views/mypage/post/create.php';
require_once BASE_SOURCE_PATH . 'views/mypage/post/edit.php';
require_once BASE_SOURCE_PATH . 'views/mypage/info/show.php';
require_once BASE_SOURCE_PATH . 'views/mypage/info/edit.php';

// セッション処理の開始
session_start();

try {
  // ヘッダー
  \layout\header();

  // 現在のURIからコントローラーの向き先とメソッドを選択している
  /** @var array|string|int|null|false */
  $url = parse_url(CURRENT_URI);

  /** @var string|string[]|null */
  $rpath = preg_replace('/\\' . BASE_CONTEXT_PATH . '/', '', $url['path'], 1);

  /** @var string */
  $method = strtolower($_SERVER['REQUEST_METHOD']);
  route($rpath, $method);

  // フッター
  \layout\footer();

} catch (Throwable $e) {
  die('<h1 style="margin-top: 4.8rem; font-size: 2rem; font-weight: bold; text-align: center;">時間を置いてから再度アクセスしてください。</h1>');
}
