<?php

/**
 * 抽象クラスファイル
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace model;

use Error;

/**
 * セッション情報を扱う親クラス
 *
 * セッション情報を設定・取得・削除する
 *
 * @access public
 * @author Posipan
 */
abstract class AbstractModel
{
  /**
   * @var mixed セッション情報のキー
   * @access protected
   */
  protected static mixed $SESSION_NAME = null;

  /** @var string $PUT 更新ボタンの値 */
  public static string $UPDATE = 'update';

  /** @var string $DELETE 削除ボタンの値 */
  public static string $DELETE = 'delete';

  /** @var int 公開 */
  public static int $PUBLISH = 1;

  /**
   * @var int 下書き
   */
  public static int $DRAFT = 0;

  /**
   * セッション情報の設定
   *
   * @param mixed $val
   * @return void
   */
  public static function setSession($val): void
  {
    if (empty(static::$SESSION_NAME)) {
      throw new Error('$SESSION_NAMEを設定してください。');
    }
    $_SESSION[static::$SESSION_NAME] = $val;
  }

  /**
   * セッション情報の取得
   *
   * @return mixed
   */
  public static function getSession(): mixed
  {
    return $_SESSION[static::$SESSION_NAME] ?? null;
  }

  /**
   * セッション情報の削除
   *
   * @return void
   */
  public static function clearSession(): void
  {
    static::setSession(null);
  }

  /**
   * セッション情報の取得と削除
   *
   * @return mixed
   */
  public static function getSessionAndFlush(): mixed
  {
    try {
      return static::getSession();
    } finally {
      static::clearSession();
    }
  }
}
