<?php

/**
 * カテゴリーリレーションモデルクラスファイル
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace model;

/**
 * カテゴリーリレーションモデルクラス
 *
 * @access public
 * @author Posipan
 */
class CategoryRelationshipModel extends AbstractModel
{
  /** @var int */
  public int $id;

  /** @var int */
  public int $post_id;

  /** @var int */
  public int $category_id;
}
