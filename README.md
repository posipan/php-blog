# PHP製ブログ

## 概要
* 登録したユーザーがMarkDown形式の記事を投稿できるブログシステム


## 仕様
* 記事はタイトル、カテゴリー、サムネイル画像、MarkDown形式の本文、公開または下書きのステータス設定ができる。
* ユーザーは情報の変更や削除が可能。ユーザーを削除した場合、ユーザーに紐づいた記事は全て削除される。

## 制作の目的

* PHPやMySQLの基礎固め
* CRUD機能の作成、セッションを使ったログイン処理、パスワード処理、画像投稿、複数カテゴリーのタグ付けなどシステム開発の基本を体感できると考えたため

## 環境構築
1. Docker For Macのインストール
2. docker-compose up -d
3. PHPコンテナにログインしてcomposer install
4. MySQLコンテナにログインして初期データをインポート

### Docker
### Composerのインストール
PHPコンテナにログイン
```
docker exec -it blog_php_1 /bin/bash
```

PHPコンテナで以下を実行
```
composer install 
```
### DB関連
* MySQLを使用
* DBの情報はディレクトリ直下の/.envファイルに記述
* MySQLのログファイル /db_data/*.log

####  初期データのインポート
① /data/blog.sqlをMySQLコンテナの/tmp/ディレクトリにコピーする

```
docker cp data/blog.sql blog_mysql_1:/tmp
```

② MySQLコンテナへログインする

```
docker exec -it blog_mysql_1 /bin/bash
```

③ インポートを実行
```
mysql -u root -p < /tmp/blog.sql
```

#### Docker環境でMySQLのログを確認する

MySQLコンテナにログイン後、以下のようにgeneral_logの位置を確認
```
show variables like 'general_log%';
```

上記コマンド実行後、general_logがOFFになっていたら、以下のコマンドんでONにする。
```
set global general_log = on;
```

### TypeScript
### Sass

package.jsonとgulpfile.jsがあるディレクトリで以下のコマンドを実行

```
$ npm install
$ npm start
```
