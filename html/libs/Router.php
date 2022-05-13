<?php

/**
 * ルーターファイル
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace lib;

use Throwable;

/**
 * ルーティングの定義
 *
 * @param string $rpath アクセス先のURI
 * @param string $method getまたはpost
 * @author Posipan
 */
function route(string $rpath, string $method) {
  try {
    if ($rpath === '') {
      $rpath = 'home';
    }

    /** @var string */
    $targetFile = BASE_SOURCE_PATH . "controllers/{$rpath}.php";

    if (!file_exists($targetFile)) {
      require_once BASE_SOURCE_PATH . "views/404.php";
      return;
    }

    // コントローラーを経由するため
    $rpath = str_replace('/', '\\', $rpath);
    require_once $targetFile;

    // コントローラー関数の指定と実行
    /** @var string */
    $fn = "\\controller\\{$rpath}\\{$method}";
    $fn();
  } catch (Throwable $e) {
    Msg::push(Msg::DEBUG, $e->getMessage());
    Msg::push(Msg::DEBUG, '何かがおかしいようです。');

    redirect('404');
  }
}
