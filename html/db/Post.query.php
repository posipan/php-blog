<?php

/**
 * 記事操作クラスファイル
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace db;

use lib\Auth;
use model\PostModel;

/**
 * 記事操作クラス
 *
 * 記事のCRUD機能
 *
 * @access public
 * @author Posipan
 */
class PostQuery
{
  /**
   * 記事の詳細情報の取得を定義
   *
   * @param object $post 記事の詳細情報
   * @return object|false
   */
  public static function fetchPost(object $post): object|false
  {
    // バリデーション
    if (!$post->isValidId()) {
      return false;
    }

    /** @var \db\DB */
    $db = new DB();

    /** @var string */
    $sql = "SELECT p.*, u.name AS author_name, GROUP_CONCAT(DISTINCT c.id ORDER BY c.id ASC) AS selected_categories
      FROM `posts` p
      INNER JOIN `users` u
        ON p.user_id = u.id
      INNER JOIN `category_relationships` cr
        ON p.id = cr.post_id
      INNER JOIN `categories` c
        ON cr.category_id = c.id
      WHERE p.id = :id
      GROUP BY p.id
      ORDER BY p.id DESC;
    ";

    return $db->selectOne($sql, [
      ':id' => $post->id,
    ], DB::CLS, PostModel::class);
  }

  /**
   * 作成した全ての記事の取得を定義
   *
   * マイポストを表示
   *
   * @param object $user ユーザー情報
   * @return array|object|false
   */
  public static function fetchMyAllPosts(object $user): array|object|false
  {
    // バリデーション
    if (!$user->isValidEmail()) {
      return false;
    }

    /** @var \db\DB */
    $db = new DB();

    /** @var string */
    $sql = "SELECT p.*, GROUP_CONCAT(DISTINCT c.id ORDER BY c.id ASC) AS selected_categories
      FROM `posts` p
      INNER JOIN `category_relationships` cr
        ON p.id = cr.post_id
      INNER JOIN `categories` c
        ON cr.category_id = c.id
      WHERE p.user_id = :user_id
      GROUP BY p.id
      ORDER BY p.update_at DESC;
    ";

    return $db->select($sql, [
      ':user_id' => $user->id,
    ], DB::CLS, PostModel::class);
  }

  /**
   * 記事数の取得を定義
   *
   * @param string $page ページ名
   * @param string $param パラメータ
   * @return int
   */
  public static function countAllPublishedPosts(string $page = '', string $param = ''): int
  {
    /** @var \db\DB */
    $db = new DB();

    if ($page === 'author') {
      /** @var string */
      $sql = "SELECT COUNT(*) AS count
        FROM `posts` p
        INNER JOIN `users` u
          ON p.user_id = u.id
        WHERE p.status = :status
          AND u.name = :author_name;
      ";

      return $db->selectOne($sql, [
        ':status' => PostModel::$PUBLISH,
        ':author_name' => $param,
      ], DB::CLS, PostModel::class)->count;
    } else if ($page === 'category') {
      /** @var string */
      $sql = "SELECT COUNT(*) AS count
        FROM `posts` p
        INNER JOIN `users` u
        ON p.user_id = u.id
        INNER JOIN `category_relationships` cr
          ON p.id = cr.post_id
        INNER JOIN `categories` c
          ON cr.category_id = c.id
        WHERE p.status = :status
          AND c.slug = :category_slug;
      ";

      return $db->selectOne($sql, [
        ':status' => PostModel::$PUBLISH,
        ':category_slug' => $param,
      ], DB::CLS, PostModel::class)->count;
    } else {
      /** @var string */
      $sql = "SELECT COUNT(*) AS count FROM `posts` p WHERE p.status = :status";

      return $db->selectOne($sql, [
        ':status' => PostModel::$PUBLISH,
      ], DB::CLS, PostModel::class)->count;
    }
  }

  /**
   * 全ての公開記事の取得を定義
   *
   * @param int $start 開始位置
   * @param int $max 最大取得数
   * @return array|object|false
   */
  public static function fetchAllPublishedPosts(int $start, int $max): array|object|false
  {
    /** @var \db\DB */
    $db = new DB();

    /** @var string */
    $sql = "SELECT p.*, u.name AS author_name, GROUP_CONCAT(DISTINCT c.id ORDER BY c.id ASC) AS selected_categories
      FROM `posts` p
      INNER JOIN `users` u
        ON p.user_id = u.id
      INNER JOIN `category_relationships` cr
        ON p.id = cr.post_id
      INNER JOIN `categories` c
        ON cr.category_id = c.id
      WHERE p.status = :status
      GROUP BY p.id
      ORDER BY p.update_at DESC
      LIMIT :start, :max;
    ";

    if ($start === 1) {
      return $db->select($sql, [
        ':status' => PostModel::$PUBLISH,
        ':start' => $start - 1,
        ':max' => $max,
      ], DB::CLS, PostModel::class);
    } else {
      return $db->select($sql, [
        ':status' => PostModel::$PUBLISH,
        ':start' => ($start - 1) * MAX_VIEW,
        ':max' => $max,
      ], DB::CLS, PostModel::class);
    }
  }

  /**
   * カテゴリーの公開記事の取得を定義
   *
   * @param string $category_slug カテゴリースラッグ名
   * @param int $start 開始位置
   * @param int $max 最大取得数
   * @return array|object|false
   */
  public static function fetchCategoryAllPublishedPosts(string $category_slug, int $start, int $max): array|object|false
  {
    /** @var \db\DB */
    $db = new DB();

    /** @var string */
    $sql = "SELECT p.*, u.name AS author_name, GROUP_CONCAT(DISTINCT c.id ORDER BY c.id ASC) AS selected_categories
      FROM `posts` p
      INNER JOIN `users` u
        ON p.user_id = u.id
      INNER JOIN `category_relationships` cr
        ON p.id = cr.post_id
      INNER JOIN `categories` c
        ON cr.category_id = c.id
      WHERE p.status = :status
        AND c.slug = :category_slug
      GROUP BY p.id
      ORDER BY p.update_at DESC
      LIMIT :start, :max;
    ";

    if ($start === 1) {
      return $db->select($sql, [
        ':status' => PostModel::$PUBLISH,
        ':category_slug' => $category_slug,
        ':start' => $start - 1,
        ':max' => $max,
      ], DB::CLS, PostModel::class);
    } else {
      return $db->select($sql, [
        ':status' => PostModel::$PUBLISH,
        ':category_slug' => $category_slug,
        ':start' => ($start - 1) * MAX_VIEW,
        ':max' => $max,
      ], DB::CLS, PostModel::class);
    }
  }

  /**
   * 作成者の公開記事の取得を定義
   *
   * @param string $author_name 作成者名
   * @param int $start 開始位置
   * @param int $max 最大取得数
   * @return array|object|false
   */
  public static function fetchAuthorAllPublishedPosts(string $author_name, int $start, int $max): array|object|false
  {
    /** @var \db\DB */
    $db = new DB();

    /** @var string */
    $sql = "SELECT p.*, u.name AS author_name, GROUP_CONCAT(DISTINCT c.id ORDER BY c.id ASC) AS selected_categories
      FROM `posts` p
      INNER JOIN `users` u
        ON p.user_id = u.id
      INNER JOIN `category_relationships` cr
        ON p.id = cr.post_id
      INNER JOIN `categories` c
        ON cr.category_id = c.id
      WHERE p.status = :status
        AND u.name = :author_name
      GROUP BY p.id
      ORDER BY p.update_at DESC
      LIMIT :start, :max;
    ";

    if ($start === 1) {
      return $db->select($sql, [
        ':status' => PostModel::$PUBLISH,
        ':author_name' => $author_name,
        ':start' => $start - 1,
        ':max' => $max,
      ], DB::CLS, PostModel::class);
    } else {
      return $db->select($sql, [
        ':status' => PostModel::$PUBLISH,
        ':author_name' => $author_name,
        ':start' => ($start - 1) * MAX_VIEW,
        ':max' => $max,
      ], DB::CLS, PostModel::class);
    }
  }

  /**
   * ユーザー作成記事の判定を定義
   *
   * @param int $post_id パラメータから取得した記事ID
   * @param int $target_post_id POSTリクエストで送信した記事ID
   * @param object $user ユーザー情報
   * @return bool
   */
  public static function isOwnPost(int $post_id, int $target_post_id, object $user): bool
  {
    // バリデーション
    if (!(PostModel::validateId($post_id)
      * $user->isValidEmail()
    )) {
      return false;
    } else if (($post_id !== $target_post_id) && ($target_post_id !== Auth::$DEFAULT_TARGET_ID)) {
      // アクセス元の記事のIDと更新する記事のIDが不一致かつPOSTリクエスト送信だった場合
      return false;
    }

    /** @var \db\DB */
    $db = new DB();

    /** @var string */
    $sql = "SELECT COUNT(*) AS count FROM `posts` WHERE `id` = :id AND `user_id` = :user_id;";

    /** @var array|object|false */
    $result = $db->selectOne($sql, [
      ':id' => $post_id,
      ':user_id' => $user->id,
    ]);

    if (!empty($result) && $result['count'] != 0) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * アップロード画像の作成を定義
   *
   * @access private
   * @param string $val ファイルのname属性値
   * @return string $image 画像名
   */
  private static function createImage(string $val): string
  {
    $rand = mt_rand();
    $image = uniqid((string) $rand, false);
    $image .= '.' . substr(strrchr($_FILES[$val]['name'], '.'), 1);

    return $image;
  }

  /**
   * 記事の作成処理を定義
   *
   * @param object $post 作成する記事の情報
   * @param object $user ユーザーの情報
   * @return bool $result
   */
  public static function insert(object $post, object $user): bool
  {
    // バリデーション
    if (!($post->isValidTitle($post->title)
      * $post->isValidCategories($post->selected_categories)
      * $post->isValidContent($post->content)
    )) {
      return false;
    }

    /** @var \db\DB */
    $db = new DB();

    /** @var string */
    $image = static::createImage('uploadImage');

    /** @var string */
    $file_name = $_FILES['uploadImage']['name'];

    /** @var string */
    $tmp_name = $_FILES['uploadImage']['tmp_name'];

    /** @var string サムネイル画像名を含む、画像の移動先 */
    $image_path = BASE_SOURCE_PATH . 'storage/images/' . $image;

    /** @var string */
    $sql = 'INSERT INTO `posts` (title, image, content, status, user_id) VALUES (:title, :image, :content, :status, :user_id);';

    if (!empty($file_name)) {
      if (is_image($image_path)) {
        $result = $db->execute($sql, [
          ':title' => $post->title,
          ':image' => $image,
          ':content' => $post->content,
          ':status' => $post->status,
          ':user_id' => $user->id,
        ]);

        // 画像を指定パスに移動
        move_uploaded_file($tmp_name, $image_path);
      }
    } else {
      $result = $db->execute($sql, [
        ':title' => $post->title,
        ':image' => '',
        ':content' => $post->content,
        ':status' => $post->status,
        ':user_id' => $user->id,
      ]);
    }

    return $result;
  }

  /**
   * 新規作成した記事のID取得を定義
   *
   * カテゴリーリレーションテーブルへのレコード登録に必要な記事IDを取得する
   *
   * @return int $result 記事ID
   */
  public static function getLastId(): int
  {
    /** @var \db\DB */
    $db = new DB();

    /** @var string */
    $sql = 'SELECT `id` FROM `posts` ORDER BY `id` DESC LIMIT 1;';

    /** @var int */
    $result = $db->selectOne($sql, [], DB::CLS, PostModel::class)->id;

    return $result;
  }

  /**
   * 記事の更新処理を定義
   *
   * @param object $post 更新する記事の情報
   * @return bool $result
   */
  public static function update(object $post): bool
  {
    // バリデーション
    if (!($post->isValidTitle($post->title)
      * $post->isValidContent($post->content)
    )) {
      return false;
    }

    /** @var \db\DB */
    $db = new DB();

    /** @var string */
    $image = static::createImage('uploadImage');

    /** @var string */
    $file_name = $_FILES['uploadImage']['name'];

    /** @var string */
    $tmp_name = $_FILES['uploadImage']['tmp_name'];

    /** @var string サムネイル画像名を含む、画像の移動先 */
    $image_path = BASE_SOURCE_PATH . 'storage/images/' . $image;

    /** @var string */
    $sql = 'UPDATE `posts` set `title` = :title, `image` = :image, `content` = :content, `status` = :status WHERE id = :id;';

    if (!empty($file_name)) {
      if (is_image($image_path)) {
        $result = $db->execute($sql, [
          ':id' => $post->id,
          ':title' => $post->title,
          ':image' => $image,
          ':content' => $post->content,
          ':status' => $post->status,
        ]);

        // 画像を指定パスに移動
        move_uploaded_file($tmp_name, $image_path);
      }
    } else {
      // 画像を設定していない、または画像を変更しない場合
      if (is_valid_image($post->image) || empty($post->image)) {
        $result = $db->execute($sql, [
          ':id' => $post->id,
          ':title' => $post->title,
          ':image' => $post->image,
          ':content' => $post->content,
          ':status' => $post->status,
        ]);
      }
    }

    return $result;
  }

  /**
   * 記事の削除処理を定義
   *
   * @param object $post 削除する記事の情報
   * @return bool
   */
  public static function delete(object $post): bool
  {
    /** @var \db\DB */
    $db = new DB();

    /** @var string */
    $sql = 'DELETE FROM `posts` WHERE id = :id;';

    return $db->execute($sql, [
      ':id' => $post->id,
    ]);
  }

  /**
   * ユーザーが作成した全ての記事IDの取得を定義
   *
   * @param object $user ユーザー情報
   * @return array|false
   */
  public static function fetchUserAllPost(object $user): array|false
  {
    /** @var \db\DB */
    $db = new DB();

    /** @var string */
    $sql = 'SELECT * FROM `posts` WHERE user_id = :user_id';

    return $db->select($sql, [
      ':user_id' => $user->id,
    ], DB::CLS, PostModel::class);
  }

  /**
   * ユーザー削除に伴う全ての記事の削除処理を定義
   *
   * @param object $user 削除する記事の情報
   * @return bool
   */
  public static function deleteUserAllPost(object $user): bool
  {
    /** @var \db\DB */
    $db = new DB();

    /** @var string */
    $sql = 'DELETE FROM `posts` WHERE user_id = :user_id;';

    return $db->execute($sql, [
      ':user_id' => $user->id,
    ]);
  }
}
