<?php

/**
 * マイポストページ
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace view\mypage\post\archive;

use db\CategoryQuery;

/**
 * マイポストページを表示
 *
 * @param array|object|false $posts ユーザーの記事情報
 * @param int $start 開始位置
 * @param int $max 最大取得数
 * @return void
 */
function index(array|object|false $posts, int $start, float $pages): void
{
  $all_categories = CategoryQuery::fetchAllCategories();
?>

  <h1 class="page-title">マイポスト</h1>

  <div class="user-post">
    <p class="user-post__create"><a href="<?php the_url('mypage/post/create'); ?>" class="btn btn--accent">記事を作成する</a></p>

    <div class="archive">
      <?php
      /** @var object $post */
      foreach ($posts as $post) {
        /** @var string[] */
        $urls = [
          'edit' => get_url('mypage/post/edit?id=' . $post->id),
        ];
        \layout\mypage_post_item($post, $all_categories, $urls);
      }
      ?>
    </div>
    <?php \layout\pagination($start, $pages, '/mypage/post/archive?page='); ?>

    <div class="post__footer">
      <a href="<?php the_url('/'); ?>" class="btn btn--secondary">記事一覧に戻る</a>
    </div>
  </div>

<?php
}

function nopost()
{
?>
  <div class="nopost">
    <p class="nopost__text">記事がありません。</p>
    <p class="nopost__btn"><a href="<?php the_url('mypage/post/create'); ?>" class="btn btn--accent">記事を作成する</a></p>

  </div>

<?php
}
?>
