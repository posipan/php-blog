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

/** @var string cssフォルダのパス */
define('BASE_CSS_PATH', BASE_CONTEXT_PATH . 'assets/css/');

/** @var string jsフォルダのパス */
define('BASE_JS_PATH', BASE_CONTEXT_PATH . 'assets/js/');

/** @var string storageフォルダのパス */
define('BASE_STORAGE_PATH', BASE_CONTEXT_PATH . 'storage/');

/** @var string 現在いるディレクトリのフルパス */
define('BASE_SOURCE_PATH', __DIR__ . '/');

/** @var string ホームページのURL */
define('GO_HOME', 'home');

/** @var string アクセス元のURL */
define('GO_REFERER', 'referer');

/** @var int 1ページあたりの記事の表示数 */
define('MAX_VIEW', 3);

/** @var bool デバッグメッセージの表示 */
define('DEBUG', true);
