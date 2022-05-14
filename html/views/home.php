<?php

/**
 * ホームページファイル
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace view\home;

use db\CategoryQuery;

/**
 * ホームページを出力
 *
 * @param array|object|false $posts 公開記事情報
 * @param int $start 開始位置
 * @param int $max 最大取得数
 * @return void
 */
function index(array|object|false $posts, int $start, float $pages): void
{
?>

  <div class="archive">
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
  <?php /*
  <div class="pagination">
    <ul class="pagination__list">
    <?php for ($i = 1; $i <= $pages; $i++) : ?>
      <?php if ($i === $start) : ?>
        <li class="pagination__item pagination__item--current">
          <a><?php echo $start; ?></a>
        </li>
      <?php else : ?>
        <li class="pagination__item">
          <a href="<?php echo get_url('/?page=' . $i) ?>"><?php echo $i; ?></a>
        </li>
      <?php endif; ?>
    <?php endfor; ?>
    </ul>
  </div>
  */ ?>

<?php
\layout\pagination($start, $pages, '/?page=');
}

?>
