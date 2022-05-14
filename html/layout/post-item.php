<?php

/**
 * 記事アイテムファイル
 *
 * @access public
 * @author Posipan
 */

declare(strict_types=1);

namespace layout;

/**
 * 記事アイテムを出力
 *
 * @param object $post 記事情報
 * @param array $all_categories 全てのカテゴリー
 * @param (string|\Closure)[] $urls 各種URL
 * @return void
 */
function post_item(object $post, array $all_categories, array $urls): void
{
  /** @var array */
  $post->selected_categories = str_to_array($post->selected_categories);
?>

  <article class="post-item box">
    <div class="post-item__image">
      <a href="<?php echo $urls['post']; ?>">
        <?php if (is_valid_image($post->image)) : ?>
          <img src="<?php echo BASE_STORAGE_PATH; ?>images/<?php echo escape($post->image); ?>" alt="">
        <?php else : ?>
          <img src="<?php echo BASE_IMAGE_PATH; ?>noimage.png" class="post-item__noimage" alt="">
        <?php endif; ?>
      </a>
    </div>

    <div class="post-item__desc">
      <p class="post-item__category">
        <?php
        /** @var int $category_id */
        foreach ($post->selected_categories as $category_id) :
          /** @var string */
          $slug = $all_categories[$category_id - 1]->slug;

          /** @var string */
          $name = $all_categories[$category_id - 1]->name;
        ?>
          <a href="<?php echo $urls['category']($slug); ?>" class="tag tag--<?php echo $slug; ?>"><?php echo escape($name); ?></a>
        <?php endforeach; ?>
      </p>

      <h2 class="post-item__title"><a href="<?php echo $urls['post']; ?>"><?php echo escape($post->title); ?></a></h2>

      <div class="post-item__footer">
        <p class="time"><?php echo format_date($post->update_at) ?></p>
        <p class="author">
          <span class="icon"><i class="fa-solid fa-user"></i></span>
          <a href="<?php echo $urls['author']; ?>"><?php echo escape($post->author_name); ?></a>
        </p>
      </div>
    </div>
  </article>

<?php
}
?>
