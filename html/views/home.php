<?php

/**
 * ホームページ
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace view\home;

/**
 * ホームページの記事一覧を出力
 *
 * @param array|object|false $posts 公開記事情報
 * @param array $all_categories 全てのカテゴリー
 * @param (string|\Closure)[] $url 各種URL
 * @return void
 */
function index(array|object|false $posts, array $all_categories): void
{
?>

<div class="archive">
<?php
  /** @var object $post */
  foreach ($posts as $post) {
    $urls = [
      'post' => get_url('/post?id=' . $post->id),
      'author' => get_url('author?name=' . $post->author_name),
      'category' => function(string $slug): string {
        return get_url('category?slug=' . $slug);
      },
    ];

    \layout\post_item($post, $all_categories, $urls);
  }
?>
</div>

<?php
}
?>
