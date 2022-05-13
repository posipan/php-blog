<?php

/**
 * カテゴリーリレーションクラス
 *
 * @access public
 * @author Posipan
 */

declare(strict_types=1);

namespace db;

class CategoryRelationshipQuery
{
  /**
   * カテゴリーリレーションの追加
   *
   * @return bool
   */
  public static function insert(int $post_id, int $category_id): bool
  {
    // TODO: ログインユーザーのバリデートチェック

    /** @var \db\DB */
    $db = new DB();

    /** @var string */
    $sql = 'INSERT INTO `category_relationships` (post_id, category_id) VALUES (:post_id, :category_id);';

    return $db->execute($sql, [
      ':post_id' => $post_id,
      ':category_id' => $category_id,
    ]);
  }

  /**
   * カテゴリーリレーションの削除
   *
   * @param object $post
   * @return bool
   */
  public static function delete(object $post): bool
  {
    /** @var \db\DB */
    $db = new DB();

    /** @var string */
    $sql = 'DELETE FROM `category_relationships` WHERE post_id = :post_id';

    return $db->execute($sql, [
      ':post_id' => $post->id,
    ]);
  }
}
