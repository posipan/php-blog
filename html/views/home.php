<?php

/**
 * ホームページファイル
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace view\home;

/**
 * ホームページを出力
 *
 * @param array|object|false $posts 公開記事情報
 * @param array $all_categories 全てのカテゴリー
 * @param (string|\Closure)[] $url 各種URL
 * @return void
 */
function index(array|object|false $posts, array $all_categories, int $start, float $pages): void
{
?>

  <div class="archive">
    <?php
    /** @var object $post */
    foreach ($posts as $post) {
      $urls = [
        'post' => get_url('/post?id=' . $post->id),
        'author' => get_url('author?name=' . $post->author_name . '&page=1'),
        'category' => function (string $slug): string {
          return get_url('category?slug=' . $slug . '&page=1');
        },
      ];

      \layout\post_item($post, $all_categories, $urls);
    }
    ?>
  </div>
  <div class="pagination">
    <?php for ($i = 1; $i <= $pages; $i++) : ?>
      <?php if ($i === $start) : ?>
        <span><?php echo $start; ?></span>
      <?php else : ?>
        <a href="<?php echo get_url('/?page=' . $i) ?>"><?php echo $i; ?></a>
      <?php endif; ?>
    <?php endfor; ?>
  </div>

<?php
}
?>
