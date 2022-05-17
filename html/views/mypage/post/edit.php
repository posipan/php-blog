<?php

/**
 * 記事編集ページ
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace view\mypage\post\edit;

use db\CategoryQuery;
use model\PostModel;

/**
 * 記事編集ページを出力
 *
 * @param array|object|false $post 現行記事の情報
 * @return void
 */
function index(array|object|false $post): void
{
  /** @var array|false */
  $all_categories = CategoryQuery::fetchAllCategories();
?>
  <h1 class="page-title">記事を編集する</h1>

  <div class="box box--post">
    <form action="<?php echo CURRENT_URI; ?>" method="POST" enctype="multipart/form-data" class="form form--post form--post" id="form--post-edit">
      <input type="hidden" name="id" value="<?php echo $post->id; ?>">

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
            <label for="upload-image" class="form__imageLabel">
              <input type="file" accept="image/*" name="upload-image" id="upload-image" />
              <a>サムネイルを設定する</a>
            </label>
          </div>
        </div>
      </div>

      <div class="form__control">
        <p class="form__label">本文<span class="required">※</span></p>
        <div class="form__content">
          <textarea name="content" rows="20" id="content"><?php echo $post->content; ?></textarea>
          <p class="form__error"></p>
        </div>
      </div>

      <div class="form__control">
        <p class="form__label">ステータス<span class="required">※</span></p>
        <p class="form__content form__select">
          <select name="status">
            <option value="1" <?php echo $post->status ? 'selected': ''; ?>>公開</option>
            <option value="0" <?php echo $post->status ? '': 'selected'; ?>>下書き</option>
          </select>
        </p>
      </div>

      <div class="form__btn">
        <button type="submit" name="dispatch" value="<?php echo PostModel::$UPDATE; ?>" id="btn--post-update" class="btn btn--accent">更新する</button>
        <a class="btn btn--cancel" id="cancel" onclick="return confirm('この記事の編集をキャンセルしますか？');" href="<?php the_url('mypage/post/archive'); ?>">キャンセル</a>
      </div>

      <div class="form__delete">
        <button type="submit" name="dispatch" id="btn--post-delete" value="<?php echo PostModel::$DELETE; ?>" onclick="return confirm('この記事を削除しますか？');">この記事を削除する</button>
      </div>
    </form>
  </div>
<?php
}
?>
