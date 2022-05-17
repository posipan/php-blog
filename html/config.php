<?php
/**
 * 定数ファイル
 *
 * @author Posipan
 */

/** @var string 現在のURI */
define('CURRENT_URI', $_SERVER['REQUEST_URI']);

/** @var string コンテキストパス */
define('BASE_CONTEXT_PATH', '/');

/** @var string imagesフォルダのパス */
define('BASE_IMAGE_PATH', BASE_CONTEXT_PATH . 'assets/images/');

/** @var string tsやsassのコンパイル先フォルダのパス */
define('BASE_DIST_PATH', BASE_CONTEXT_PATH . 'assets/dist/');

/** @var string storageフォルダのパス */
define('BASE_STORAGE_PATH', BASE_CONTEXT_PATH . 'storage/');

/** @var string 現在いるディレクトリのフルパス */
define('BASE_SOURCE_PATH', __DIR__ . '/');

/** @var string ホームページのURL */
define('GO_HOME', 'home');

/** @var string アクセス元のURL */
define('GO_REFERER', 'referer');

/** @var int 1ページあたりの記事の表示数 */
define('MAX_VIEW', 9);

/** @var bool デバッグメッセージの表示 */
define('DEBUG', false);
