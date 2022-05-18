<?php

/**
 * ヘルパー関数ファイル
 *
 * @author Posipan
 */

declare(strict_types=1);

/**
 * $_POSTまたは＄＿GETの値を取得
 *
 * @param string $key
 * @param string|int|array|object|null $default_val
 * @param bool $is_post
 * @return string|int|array|object
 */
function get_param(string $key, string|int|array|object|null $default_val, bool $is_post = true): string|int|array|object
{
  /** @var array */
  $method_ary = $is_post ? $_POST : $_GET;

  return $method_ary[$key] ?? $default_val;
}

/**
 * リダイレクトを実行
 *
 * @param string $path
 * @return void
 */
function redirect(string $path): void
{
  if ($path === GO_HOME) {
    $path = get_url('');
  } else if ($path === GO_REFERER) {
    $path = $_SERVER['HTTP_REFERER'];
  } else {
    $path = get_url($path);
  }

  header("Location: {$path}");

  die();
}

/**
 * URLを出力
 *
 * @param string $path
 * @return void
 */
function the_url(string $path): void
{
  echo get_url($path);
}

/**
 * URLを取得
 *
 * @param string $path
 * @return string
 */
function get_url(string $path): string
{
  return BASE_CONTEXT_PATH . trim($path, '/');
}

/**
 * 半角英数字チェック
 *
 * @param string $val
 * @return int|false
 */
function is_alphanumeric_char(string $val): int|false
{
  return preg_match("/^[a-zA-Z0-9]+$/", $val);
}

/**
 * 画像かを判定
 *
 * @param string $image
 * @return bool
 */
function is_image($image): bool
{
  if (preg_match("/.*?\.jpg|.*?\.png||.*?\.gif.*?\.jpeg/i", $image)) {
    return true;
  } else {
    return false;
  }
}

/**
 * 存在する画像かを判定
 *
 * @param string $image
 * @return bool
 */
function is_valid_image($image): bool
{
  $image_path = BASE_SOURCE_PATH . 'storage/' . $image;
  if (!empty($image) && is_image($image) && file_exists($image_path)) {
    return true;
  } else {
    return false;
  }
}

/**
 * カンマ区切り文字列を数値配列に変換
 *
 * @param string $str
 * @param bool $is_int
 * @return array $ary
 */
function str_to_array(string $str, bool $is_int = true): array
{
  $ary = explode(',', $str);
  if ($is_int) {
    $ary = array_map('intval', $ary);
  }

  return $ary;
}

/**
 * HTMLエスケープ処理
 *
 * @param string $val
 * @return string
 */
function escape(string $val): string
{
  return htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
}

/**
 * 日付への変換とフォーマット調整
 *
 * @param string $val
 * @return string $to_formatted_date
 */
function format_date(string $val): string
{
  $to_date =  new DateTime($val);
  $to_formatted_date = $to_date->format("Y年m月d日");
  return $to_formatted_date;
}

/**
 * storageディレクトリがなかったら作成する
 *
 * @return void
 */
function mkdir_storage(): void
{
  /** @var string */
  $storage_dir = BASE_SOURCE_PATH . 'storage';

  if (!file_exists($storage_dir)) {
    if (mkdir($storage_dir, 0777)) {
      chmod($storage_dir, 0777);
    }
  }
}
