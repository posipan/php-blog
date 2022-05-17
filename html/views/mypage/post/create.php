<?php

/**
 * 記事作成ページファイル
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace view\mypage\post\create;

use db\CategoryQuery;

/**
 * 記事作成ページを出力
 *
 * @param array|object|false $post 作成に失敗した記事の情報
 * @return void
 */
function index(array|object|false $post): void
{
  /** @var array|false */
  $all_categories = CategoryQuery::fetchAllCategories();
?>
  <h1 class="page-title">記事を作成する</h1>

  <div class="post box">
    <form action="<?php echo CURRENT_URI; ?>" method="POST" enctype="multipart/form-data" class="form form--post" id="form--post-create">
      <div class="form__control">
        <p class="form__label">タイトル<span class="required">※</span></p>
        <div class="form__content">
          <input type="text" name="title" id="title" value="<?php echo $post->title; ?>" placeholder="ブログタイトル" />
          <p class="form__error"></p>
        </div>
      </div>

      <div class="form__control">
        <p class="form__label">カテゴリー</p>
        <div class="form__content form__content--category">
          <?php
          foreach ($all_categories as $category) :
          ?>
            <div class="form__radio">
              <input type="radio" name="category" value="<?php echo $category->id; ?>" id="category__<?php echo $category->slug; ?>"
              <?php
              if (!empty($post->selected_category_id)) {
                if ($category->id === $post->selected_category_id) {
                  echo 'checked';
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
        <p class="form__label">サムネイル画像</p>
        <div class="form__content">
          <div class="form__preview" id="form__preview">
            <span class="delete-image" id="delete-image">削除</span>

            <img src="<?php if (is_valid_image($post->image)) { echo BASE_STORAGE_PATH . 'images/' . $post->image; } ?>" id="preview" class="preview <?php  if (is_valid_image($post->image)) { echo 'active'; } ?>" alt="">

            <input type="hidden" name="image" id="hidden-image" value="<?php if(is_valid_image($post->image)) { echo $post->image; } ?>">
          </div>

          <div class="form__image" id="form__image">
            <label for="upload-image">
              <input type="file" accept="image/*" name="upload-image" id="upload-image" />
              <a>サムネイルを設定する</a>
            </label>
          </div>
        </div>
      </div>

      <div class="form__control">
        <p class="form__label">本文<span class="required">※</span></p>
        <div class="form__content">
          <textarea name="content" id="content" rows="20"><?php echo $post->content; ?></textarea>
          <p class="form__error"></p>
        </div>
      </div>

      <div class="form__control">
        <p class="form__label">ステータス<span class="required">※</span></p>
        <div class="form__content form__select">
          <select name="status">
            <option value="1" <?php echo $post->status ? 'selected': ''; ?>>公開</option>
            <option value="0" <?php echo $post->status ? '': 'selected'; ?>>下書き</option>
          </select>
        </div>
      </div>

      <div class="form__btn">
        <button type="submit" id="btn--post-create" class="btn btn--accent">作成する</button>
        <a class="btn btn--cancel" id="cancel" onclick="return confirm('この記事の作成をキャンセルしますか？');" href="<?php the_url('mypage/post/archive'); ?>">キャンセル</a>
      </div>

    </form>
  </div>
<?php
}
?>
