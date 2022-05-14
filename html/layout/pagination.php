<?php

/**
 * ページネーション
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace layout;

/**
 * ページネーションを出力
 *
 * @param int $start
 * @param int $pages
 * @param string $url
 * @return void
 */
function pagination(int $start, int $pages, string $url): void
{
?>

  <div class="pagination">
    <ul class="pagination__list">
      <?php for ($i = 1; $i <= $pages; $i++) : ?>
        <?php if ($i === $start) : ?>
          <li class="pagination__item pagination__item--current">
            <a><?php echo $start; ?></a>
          </li>
        <?php else : ?>
          <li class="pagination__item">
            <a href="<?php echo get_url($url . $i) ?>"><?php echo $i; ?></a>
          </li>
        <?php endif; ?>
      <?php endfor; ?>
    </ul>
  </div>

<?php
}
?>
