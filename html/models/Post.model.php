<?php

/**
 * 記事モデルクラスファイル
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace model;

use lib\Msg;

/**
 * 記事モデルクラス
 *
 * @access public
 * @author Posipan
 */
class PostModel extends AbstractModel
{
  /** @var int */
  public int $id;

  /** @var string */
  public string $title;

  /** @var string|null */
  public string|null $image;

  /** @var string */
  public string $content;

  /** @var int */
  public int $status;

  /** @var int */
  public int $user_id;

  /** @var string */
  public string $author_name;

  /** @var int */
  public int $selected_category_id;

  /**
   * @var string タイトルの最大入力文字数
   * @access private
   */
  private const MAX_TITLE_LEN = 80;

  /** @var mixed 記事セッション情報のキー */
  protected static mixed $SESSION_NAME = '_post';

  /**
   * 記事IDのバリデーション（dynamic）
   *
   * @return bool
   */
  public function isValidId(): bool
  {
    return static::validateId($this->id);
  }

  /**
   * 記事IDのバリデーション（static）
   *
   * @param int $val 記事ID
   * @return bool $result
   */
  public static function validateId(int $val): bool
  {
    $result = true;

    if (empty($val)) {
      $result = false;
    }

    return $result;
  }

  /**
   * タイトルのバリデーション（dynamic）
   *
   * @return bool
   */
  public function isValidTitle(): bool
  {
    return static::validateTitle($this->title);
  }

  /**
   * タイトルのバリデーション（static）
   *
   * @param string $val タイトル
   * @return bool $result
   */
  public static function validateTitle(string $val): bool
  {
    $result = true;

    if (empty($val)) {
      Msg::push(Msg::DEBUG, 'タイトルを入力してください。');

      $result = false;
    } else {
      if (mb_strlen($val) > static::MAX_TITLE_LEN) {
        Msg::push(Msg::DEBUG, 'タイトルは80文字以下で入力してください。');

        $result = false;
      }
    }

    return $result;
  }

  /**
   * カテゴリーのバリデーション（dynamic）
   *
   * @return bool
   */
  public function isValidCategory(): bool
  {
    return static::validateCategory($this->selected_category_id);
  }

  /**
   * カテゴリーのバリデーション（static）
   *
   * @param int $val カテゴリーID
   * @return bool $result
   */
  public static function validateCategory(int $val): bool
  {
    $result = true;

    if (empty($val)) {
      Msg::push(Msg::DEBUG, 'カテゴリーを設定してください。');
      $result = false;
    }

    return $result;
  }

  /**
   * 本文のバリデーション（dynamic）
   *
   * @return bool
   */
  public function isValidContent(): bool
  {
    return static::validateContent($this->content);
  }

  /**
   * 本文のバリデーション（static）
   *
   * @param string $val 本文
   * @return bool $result
   */
  public function validateContent(string $val): bool
  {
    $result = true;

    if (empty($val)) {
      Msg::push(Msg::DEBUG, '本文を入力してください。');
      $result = false;
    }

    return $result;
  }
}
