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
  </footer>

  <script src="<?php echo BASE_JS_PATH; ?>script.js"></script>
  </body>

  </html>

<?php
}
?>
