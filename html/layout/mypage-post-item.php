<?php

/**
 * マイポストアイテム
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace layout;

/**
 * マイポストアイテムを出力
 *
 * @param object $post 記事
 * @param array $all_categories 全てのカテゴリー
 * @param (string|\Closure)[] $urls 各種URL
 * @return void
 */
function mypage_post_item(object $post, array $all_categories, array $urls): void
{
  /** @var array */
  $post->selected_categories = str_to_array($post->selected_categories);

  /** @var string */
  $status_label = $post->status ? '公開済み' : '下書き';

  /** @var string */
  $status_style = $post->status ? 'publish' : 'draft';
?>

  <article class="post-item box">
    <div class="post-item__image">
      <a href="<?php echo $urls['edit']; ?>">
        <?php if (is_valid_image($post->image)) : ?>
          <img src="<?php echo BASE_STORAGE_PATH; ?>images/<?php echo escape($post->image); ?>" alt="">
        <?php else : ?>
          <img src="<?php echo BASE_IMAGE_PATH; ?>noimage.png" class="post-item__noimage" alt="">
        <?php endif; ?>
      </a>

      <span class="post-item__status post-item__status--<?php echo $status_style; ?>"><?php echo $status_label; ?></span>
    </div>

    <div class="post-item__desc">
      <p class="post-item__category">
        <?php
        foreach ($post->selected_categories as $category_id) :
          $slug = $all_categories[$category_id - 1]->slug;
          $name = $all_categories[$category_id - 1]->name;
        ?>
          <a class="tag tag--<?php echo $slug; ?>"><?php echo escape($name); ?></a>
        <?php endforeach; ?>
      </p>

      <h2 class="post-item__title">
        <a href="<?php echo $urls['edit']; ?>"><?php echo escape($post->title); ?></a>
      </h2>

      <div class="post-item__footer">
        <p class="time"><?php echo format_date($post->update_at) ?></p>
      </div>
    </div>
  </article>

<?php
}
?>
