<?php

/**
 * カテゴリークラス
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace db;

use model\CategoryModel;

class CategoryQuery
{
  /**
   * 全てのカテゴリーを取得
   *
   * @return array|object|false
   */
  public static function fetchAllCategories(): array|object|false
  {
    /** @var \db\DB */
    $db = new DB();

    /** @var string */
    $sql = "SELECT * FROM `categories`;";

    return $db->select($sql, [], DB::CLS, CategoryModel::class);
  }
}
