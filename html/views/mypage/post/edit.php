<?php

/**
 * 記事編集ページ
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace view\mypage\post\edit;

use model\PostModel;

/**
 * 記事編集ページを出力
 *
 * @param array|object|false $post 現行記事の情報
 * @param array $all_categories 全てのカテゴリー
 * @param string|array|null $selected_categories 選択したカテゴリー
 * @return void
 */
function index(array|object|false $post, array $all_categories, string|array|null $selected_categories): void
{
?>
  <h1 class="page-title">記事を編集する</h1>

  <div class="box box--post">
    <form action="<?php echo CURRENT_URI; ?>" method="POST" enctype="multipart/form-data" class="form form--post" id="form--post">
      <input type="hidden" name="id" value="<?php echo $post->id; ?>">

      <div class="form__control">
        <p class="form__label">タイトル</p>
        <p class="form__content">
          <input type="text" name="title" value="<?php echo $post->title; ?>" placeholder="ブログタイトル" />
        </p>
      </div>

      <div class="form__control">
        <p class="form__label">カテゴリー</p>
        <div class="form__content form__content--category">
          <?php
          foreach ($all_categories as $category) :
          ?>
            <div class="form__checkbox">
              <input type="checkbox" name="categories[]" value="<?php echo $category->id; ?>" class="category__<?php echo $category->slug; ?>" id="category__<?php echo $category->slug; ?>"
              <?php
              if (!empty($selected_categories)) {
                foreach ($selected_categories as $select_category_id) {
                  if ($category->id === $select_category_id) {
                    echo 'checked';
                  }
                }
              }
              ?>
              />
              <label for="category__<?php echo $category->slug; ?>">
                <?php echo $category->name; ?>
              </label>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="form__control">
        <p class="form__label">サムネイル</p>
        <div class="form__content">
          <div class="form__imagePreview" id="form__imagePreview">
            <span class="deleteImage" id="deleteImage">削除</span>
            <img src="<?php if (is_valid_image($post->image)) { echo BASE_STORAGE_PATH . 'images/' . $post->image; } ?>" id="imagePreview" class="imagePreview <?php  if (is_valid_image($post->image)) { echo 'active'; } ?>" alt="">
            <input type="hidden" name="image" id="hiddenImage" value="<?php if(is_valid_image($post->image)) { echo $post->image; } ?>">
          </div>

          <div class="form__image" id="form__image">
            <label for="uploadImage" class="form__imageLabel">
              <input type="file" accept="image/*" name="uploadImage" id="uploadImage" />
              <a>サムネイルを設定する</a>
            </label>
          </div>
        </div>
      </div>

      <div class="form__control">
        <p class="form__label">本文</p>
        <p class="form__content">
          <textarea name="content" rows="20"><?php echo $post->content; ?></textarea>
        </p>
      </div>

      <div class="form__control">
        <p class="form__label">ステータス</p>
        <p class="form__content form__select">
          <select name="status">
            <option value="1" <?php echo $post->status ? 'selected': ''; ?>>公開</option>
            <option value="0" <?php echo $post->status ? '': 'selected'; ?>>下書き</option>
          </select>
        </p>
      </div>

      <div class="form__btn">
        <a class="btn btn--cancel" id="cancel" onclick="return confirm('この記事の編集をキャンセルしますか？');" href="<?php the_url('mypage/post/archive'); ?>">キャンセル</a>
        <button type="submit" name="dispatch" value="<?php echo PostModel::$UPDATE; ?>" class="btn btn--accent">更新する</button>
      </div>

      <p class="form__delete"><button type="submit" name="dispatch" value="<?php echo PostModel::$DELETE; ?>" onclick="return confirm('この記事を削除しますか？');">この記事を削除する</button></p>
    </form>
  </div>
<?php
}
?>
