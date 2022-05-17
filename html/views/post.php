<?php

/**
 * 記事詳細ページ
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace view\post;

use db\CategoryQuery;

/**
 * 記事詳細ページを表示
 *
 * @param object $post 記事の詳細
 * @return void
 */
function index(object $post): void
{
  /** @var array|false */
  $all_categories = CategoryQuery::fetchAllCategories();

  $urls = [
    'author' => get_url('author?name=' . $post->author_name),
    'category' => get_url('category?name=' . $all_categories[$post->selected_category_id - 1]->name),
  ];

  /** @var \cebe\markdown\Markdown */
  $parser = new \cebe\markdown\Markdown();

  $post->content = $parser->parse($post->content);
?>

  <article class="post box">
    <div class="post__header">
      <p class="post__category">
        <?php
        /** @var string */
        $slug = $all_categories[$post->selected_category_id - 1]->slug;

        /** @var string */
        $name = $all_categories[$post->selected_category_id - 1]->name;
        ?>
        <a href="<?php echo $urls['category'] . '&page=1'; ?>" class="tag tag--<?php echo $slug; ?>"><?php echo escape($name); ?></a>
      </p>

      <h1 class="post__title"><?php echo escape($post->title); ?></h1>

      <p class="post__date">
        <?php echo format_date($post->update_at); ?>
      </p>

      <p class="post__author">
        <span class="icon"><i class="fa-solid fa-user"></i></span>
        <a href="<?php echo $urls['author'] . '&page=1'; ?>"><?php echo escape($post->author_name); ?></a>
      </p>
    </div>

    <div class="post__image">
      <?php if (is_valid_image($post->image)) : ?>
        <img src="<?php echo BASE_STORAGE_PATH; ?>images/<?php echo escape($post->image); ?>" alt="">
      <?php else : ?>
        <img src="<?php echo BASE_IMAGE_PATH; ?>noimage.png" class="post-item__noimage" alt="">
      <?php endif; ?>
    </div>

    <div class="post__content markdown-css">
      <?php echo $post->content; ?>
    </div>

    <div class="post__footer">
      <a href="<?php the_url('/'); ?>" class="btn btn--secondary">記事一覧に戻る</a>
    </div>
  </article>

<?php
}
?>
