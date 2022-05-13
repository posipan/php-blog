<?php

/**
 * 記事詳細ページ
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace view\post;

use DateTime;

/**
 * 記事詳細ページを表示
 *
 * @param object $post 記事の詳細
 * @param array $all_categories 全てのカテゴリー
 * @return void
 */
function index(object $post, array $all_categories): void
{
  /** @var (string|\Closure)[] */
  $urls = [
    'author' => get_url('author?name=' . $post->author_name),
    'category' => function(string $slug): string {
      return get_url('category?slug=' . $slug);
    },
  ];

  /** @var array */
  $post->selected_categories = str_to_array($post->selected_categories);

  /** @var \cebe\markdown\Markdown */
  $parser = new \cebe\markdown\Markdown();

  $post->content = $parser->parse($post->content);
?>

  <article class="box box--post">
    <div class="post__header">
      <p class="post__category">
        <?php
        foreach ($post->selected_categories as $category_id) :
          $slug = $all_categories[$category_id - 1]->slug;
          $name = $all_categories[$category_id - 1]->name;
        ?>
          <a href="<?php echo $urls['category']($slug); ?>" class="tag tag--<?php echo $slug; ?>"><?php echo escape($name); ?></a>
        <?php endforeach; ?>
      </p>

      <h1 class="post__title"><?php echo escape($post->title); ?></h1>
      <p class="post__date">
        <?php echo format_date($post->update_at); ?>
      </p>

      <p class="post__author">
        <span class="icon"><i class="fa-solid fa-user"></i></span>
        <a href="<?php echo $urls['author']; ?>"><?php echo escape($post->author_name); ?></a>
      </p>
    </div>

    <div class="post__image">
      <?php if (is_valid_image($post->image)) : ?>
        <img src="<?php echo BASE_STORAGE_PATH; ?>images/<?php echo escape($post->image); ?>" alt="">
      <?php else : ?>
        <img src="<?php echo BASE_IMAGE_PATH; ?>noimage.png" class="post-item__noimage" alt="">
      <?php endif; ?>
    </div>

    <div class="post__content">
      <?php echo $post->content; ?>
    </div>

    <div class="post__footer">
      <a href="<?php the_url('/'); ?>" class="btn btn--secondary">記事一覧に戻る</a>
    </div>
  </article>

<?php
}
?>
