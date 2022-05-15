<?php

/**
 * 記事がないことを伝えるファイル
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace layout;

/**
 * 記事がないことを伝える
 *
 * @param bool $is_btn
 * @return void
 */
function nopost(bool $is_btn = false): void
{
?>

  <div class="nopost">
    <p class="nopost__text">記事がありません。</p>
    <?php if ($is_btn) : ?>
      <p class="nopost__btn"><a href="<?php the_url('mypage/post/create'); ?>" class="btn btn--accent">記事を作成する</a></p>
    <?php endif; ?>
  </div>

<?php
}
?>
