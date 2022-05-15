<?php

/**
 * 作成者記事一覧ページ
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace view\author;

use db\CategoryQuery;

/**
 * 作成者の記事一覧を出力
 *
 * @param array|object|false $posts 作成者の公開記事情報
 * @param int $start 現在のページ番号
 * @param float $pages ページ数
 * @param string $author_name 作成者名
 * @return void
 */
function index(array|object|false $posts, int $start, float $pages, string $author_name): void
{
?>

  <h1 class="page-title">「<?php echo $author_name; ?>」さんの記事</h1>

  <div class="archive">
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

    <?php \layout\pagination($start, $pages, $urls['author'] . '&page='); ?>
  </div>

<?php
}
?>
