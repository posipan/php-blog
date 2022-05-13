<?php

/**
 * カテゴリーモデルクラスファイル
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace model;

/**
 * カテゴリーモデルクラス
 *
 * @access public
 * @author Posipan
 */

class CategoryModel extends AbstractModel
{
  /** @var int */
  public int $id;

  /** @var string */
  public string $name;

  /** @var string */
  public string $slug;
}
