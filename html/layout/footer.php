<?php

/**
 * フッター
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace layout;

/**
 * フッターを出力
 *
 * @return void
 */
function footer(): void
{
?>

  </div>
  </main>
  <footer class="footer">
    <p>&copy; <?php echo date("Y"); ?> POSIPAN</p>
    <div id="output"></div>
  </footer>

  <script src="<?php echo BASE_DIST_PATH; ?>bundle.js"></script>
  </body>

  </html>

<?php
}
?>
