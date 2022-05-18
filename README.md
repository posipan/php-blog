# プレーンPHP製ブログ「The Blog」

https://the-blog.posipan.com/

## 概要
ブログ記事を投稿・閲覧できるシステム

## 使用技術
* PHP 8.1.6
* MySQL 8.0
* TypeScript 4.6.4
* Sass
* Docker

## 機能
### ユーザー関連
* ユーザー登録やログイン機能
* ユーザー情報の更新や削除機能
* ユーザーを削除した場合、作成した記事も削除
* ユーザー名やメールアドレスは一意
* パスワードは半角英数字をそれぞれ1文字以上使い、合計8文字以上で入力しなければならない

### 記事関連
* 登録ユーザーによる記事の作成・編集
  * タイトル
  * カテゴリー
  * サムネイル画像
  * 本文（MarkDown形式）
  * ステータス（公開 or 下書き）
* 記事の削除
* 公開記事の閲覧
* URLパラメータによるカテゴリーや記事作成者での記事一覧の絞り込み
* ページネーション機能(1ページ9記事)

## システム構成図（ERD）
![ERD](/html/assets/images/readme/er.png) 

## 制作の目的
* PHPやMySQLの基礎定着ために作成した。 
* 下記項目のような、システム開発に必要な技術をアウトプットするのに相応しいのがブログシステムであると考えたため。
  * CRUD機能
  * セッション処理（ログイン機能など）
  * パスワードのハッシュ化
  * 画像アップロード
  * カテゴリー付け

## 制作物の参考資料
https://www.udemy.com/course/backend-tutorial/


## 環境構築方法
### Gitリポジトリのクローン
```
git clone https://github.com/posipan/php-blog.git
```

### .envファイルを作成し、DB情報を記述
ルートディレクトリ直下に.envを作成し、以下の内容を貼り付けて書き換える
```
MYSQL_DATABASE=[任意のDB名]
MYSQL_USER=[任意のDBユーザー名]
MYSQL_PASSWORD=[任意のDBパスワード]
MYSQL_ROOT_PASSWORD=[任意のrootユーザーパスワード]

DB_HOST=blog_mysql
DB_PORT=3306
```

### Dockerコンテナの作成と起動
```
docker-compose up -d
```
* ホームページ  
http://localhost:8080/  
※サムネイル画像を表示させたい場合、ユーザー登録&ログイン後に登録しなければならない。

* phpMyAdmin  
http://localhost:4040  
  * サーバ名: blog_mysql
  * ユーザー名: MYSQL_USERの値
  * パスワード: MYSQL_PASSWORDの値

### Composerのインストール
PHPコンテナにログイン
```
docker exec -it blog_php /bin/bash
```

Composerをインストール
```
composer install
```

### nodeパッケージのインストール
ルートディレクトリ直下で以下のコマンドを実行
```
npm install
```

### TypeScriptとSassのコンパイラーを起動
webpackを使用し、TypeScriptとSassのコンパイラーを起動している

コンパイルと監視
```
$ npm run watch
```

本番用ビルドファイルの作成
```
$ npm run build
```

* TypeScriptディレクトリ  
/html/assets/ts/

* Sassディレクトリ  
/html/assets/sass/

* アウトプットディクトリ  
/html/assets/dist/

/html/assets/ts/app.tsがエントリーポイントとなっており、.tsモジュールやstyle.scssを読み込んでいる。


## 画面キャプチャ
記事一覧（ホーム）
![home](/html/assets/images/readme/screenshot/home.png) 

記事一覧（カテゴリー）
![category](/html/assets/images/readme/screenshot/category.png) 

記事一覧（作成者）  
![author](/html/assets/images/readme/screenshot/author.png) 

記事詳細
![post](/html/assets/images/readme/screenshot/post.png) 

ユーザー登録
![register](/html/assets/images/readme/screenshot/register.png)

ログイン
![login](/html/assets/images/readme/screenshot/login.png)

ユーザー記事一覧
![mypost](/html/assets/images/readme/screenshot/mypost.png)

記事登録画面
![post-create](/html/assets/images/readme/screenshot/post-create.png)

記事編集画面
![post-edit](/html/assets/images/readme/screenshot/post-edit.png)

ユーザー情報確認画面
![user-show](/html/assets/images/readme/screenshot/user-show.png)

ユーザー情報編集画面
![user-edit](/html/assets/images/readme/screenshot/user-edit.png)

404
![404](/html/assets/images/readme/screenshot/404.png)

## 備考
* 制作物はあくまで勉強用
* SEO対策はしていない
