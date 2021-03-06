<?php

/**
 * カテゴリー記事一覧ページ
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace view\category;

use db\CategoryQuery;

/**
 * カテゴリーの記事一覧を出力
 *
 * @param array|object|false $posts 各カテゴリーの公開記事情報
 * @param int $start 現在のページ番号
 * @param float $pages ページ数
 * @param string $category_name カテゴリー名
 * @return void
 */
function index(array|object|false $posts, int $start, float $pages, string $category_name): void
{
?>

  <h1 class="page-title">「<?php echo $category_name; ?>」の記事</h1>

  <div class="archive">
    <?php if (!empty($posts)) : ?>
      <div class="archive__list">
        <?php
        /** @var array */
        $all_categories = CategoryQuery::fetchAllCategories();

        /** @var object $post */
        foreach ($posts as $post) {
          $urls = [
            'post' => get_url('/post?id=' . $post->id),
            'author' => get_url('author?name=' . $post->author_name),
            'category' => get_url('category?name=' . $all_categories[$post->selected_category_id - 1]->name),
          ];

          \layout\post_item($post, $all_categories, $urls);
        }
        ?>
      </div>

      <?php \layout\pagination($start, $pages, $urls['category'] . '&page='); ?>
    <?php else : ?>
      <?php \layout\nopost(); ?>
    <?php endif; ?>
  </div>

<?php
}
?>
