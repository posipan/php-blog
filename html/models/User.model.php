<?php

/**
 * ユーザーモデルクラスファイル
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace model;

use lib\Msg;

/**
 * ユーザーモデルクラス
 *
 * @access public
 * @author Posipan
 */
class UserModel extends AbstractModel
{
  /** @var int */
  public int $id;

  /** @var string */
  public string $name;

  /** @var string */
  public string $email;

  /** @var string */
  public string $password;

  /** @var string */
  public string $password_confirm;

  /**
   * @var int ユーザー名の最大入力文字数
   * @access private
   */
  private const MAX_NAME_LEN = 15;

  /**
   * @var int パスワードの最短入力文字数
   * @access private
   */
  private const MIN_PASSWORD_LEN = 8;

  /** @var mixed ユーザーセッション情報のキー */
  protected static mixed $SESSION_NAME = '_user';

  /**
   * ユーザーIDのバリデーション（dynamic）
   *
   * @return bool
   */
  public function isValidId(): bool
  {
    return static::validateId($this->id);
  }

  /**
   * ユーザーIDのバリデーション（static）
   *
   * @param int $val ユーザーID
   * @return bool $result
   */
  public static function validateId(int $val): bool
  {
    $result = true;

    if (empty($val)) {
      Msg::push(Msg::ERROR, 'IDが不正です。');

      $result = false;
    }

    return $result;
  }

  /**
   * ユーザー名のバリデーション（dynamic）
   *
   * @return bool
   */
  public function isValidName(): bool
  {
    return static::validateName($this->name);
  }

  /**
   * ユーザー名のバリデーション（static）
   *
   * @param string $val ユーザー名
   * @return bool $result
   */
  public static function validateName(string $val): bool
  {
    $result = true;

    if (empty($val)) {
      Msg::push(Msg::ERROR, 'ユーザー名を入力してください。');

      $result = false;
    } else {
      if (mb_strlen($val) > static::MAX_NAME_LEN) {
        Msg::push(Msg::ERROR, 'ユーザー名は15文字以下で入力してください。');

        $result = false;
      }
    }

    return $result;
  }

  /**
   * メールアドレスのバリデーション（dynamic）
   *
   * @return bool
   */
  public function isValidEmail(): bool
  {
    return static::validateEmail($this->email);
  }

  /**
   * メールアドレスのバリデーション（static）
   *
   * @param string $val メールアドレス
   * @return bool $result
   */
  public static function validateEmail(string $val): bool
  {
    $result = true;

    if (empty($val)) {
      Msg::push(Msg::ERROR, 'メールアドレスを入力してください。');

      $result = false;
    } else {
      if (!filter_var($val, FILTER_VALIDATE_EMAIL)) {
        Msg::push(Msg::ERROR, 'メールアドレスの形式が無効です。');

        $result = false;
      }
    }

    return $result;
  }

  /**
   * パスワードのバリデーション（dynamic）
   *
   * @return bool
   */
  public function isValidPassword(): bool
  {
    return static::validatePassword($this->password);
  }

  /**
   * パスワードのバリデーション（static）
   *
   * @param string $val パスワード
   * @return bool $result
   */
  public static function validatePassword(string $val): bool
  {
    $result = true;

    if (empty($val)) {
      Msg::push(Msg::ERROR, 'パスワードを入力してください。');

      $result = false;
    } else {
      if (strlen($val) < static::MIN_PASSWORD_LEN) {
        Msg::push(Msg::ERROR, 'パスワードは8文字以上でで入力してください。');

        $result = false;
      }

      if (!is_alphanumeric_char($val)) {
        Msg::push(Msg::ERROR, 'パスワードは半角英数字で入力してください。');

        $result = false;
      }
    }

    return $result;
  }
}
