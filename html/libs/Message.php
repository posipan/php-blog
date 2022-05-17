<?php

/**
 * フラッシュメッセージファイル
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace lib;

use model\AbstractModel;
use Throwable;

/**
 * フラッシュメッセージクラス
 *
 * @access public
 * @author Posipan
 */
class Msg extends AbstractModel
{
  /** @var mixed メッセージセッション情報のキー */
  protected static mixed $SESSION_NAME = '_msg';

  /** @var string 処理成功メッセージタイプ */
  public const INFO = 'info';

  /** @var string 処理失敗メッセージタイプ */
  public const ERROR = 'error';

  /** @var string デバッグメッセージタイプ */
  public const DEBUG = 'debug';

  /**
   * フラッシュメッセージをセッション配列に設定
   *
   * @param string $type フラッシュメッセージタイプ
   * @param string $msg フラッシュメッセージ文字列
   * @return void
   */
  public static function push(string $type, string $msg): void
  {
    if (!is_array(static::getSession())) {
      static::init();
    }

    $msgs = static::getSession();
    $msgs[$type][] = $msg;

    static::setSession($msgs);
  }

  /**
   * フラッシュメッセージを表示
   *
   * @return void
   */
  public static function flush(): void
  {
    try {
      /** @var void|array */
      $msgs_with_type = static::getSessionAndFlush() ?? [];

      /** @var array $msgs */
      foreach ($msgs_with_type as $type => $msgs) {
        /** @var string $type */
        if ($type === static::DEBUG && !DEBUG) {
          continue;
        }

        /** @var string */
        if ($type === static::INFO) {
          /** @var string */
          $color = 'msg--info';
        } else if ($type === static::ERROR) {
          $color = 'msg--error';
        } else {
          $color = 'msg--debug';
        }

        /** @var string $msg */
        foreach ($msgs as $msg) {
          echo "<div class='msg $color'>{$msg}</div>";
        }
      }
    } catch (Throwable $e) {
      Msg::push(Msg::DEBUG, $e->getMessage());
    }
  }

  /**
   * フラッシュメッセージセッションを初期化
   *
   * @return void
   */
  private static function init(): void
  {
    static::setSession([
      static::INFO => [],
      static::ERROR => [],
      static::DEBUG => [],
    ]);
  }
}
