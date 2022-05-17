<?php

/**
 * DB関連クラス
 *
 * DB接続、各種テーブルのレコードの登録・更新・取得の実行、トランザクションの実行などを行う。
 *
 * @author Posipan
 */

declare(strict_types=1);

namespace db;

use PDO;

class PDOSingleton {
  private static $singleton;

  private function __construct($dsn, $user, $password)
  {
    $this->conn = new PDO($dsn, $user, $password);
    $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  }

  public static function getInstance($dsn ,$user, $password) {
    if (!isset(self::$singleton)) {
      $instance = new PDOSingleton($dsn ,$user, $password);
      self::$singleton = $instance->conn;
    }

    return self::$singleton;
  }
}

class DB
{
  /** @var \PDO */
  private \PDO $conn;

  /** @var bool */
  private $sqlResult;

  /** @var string */
  public const CLS = 'cls';

  /**
   * DB接続コンストラクター関数
   *
   * @return void
   */
  public function __construct()
  {
    /** @var string */
    $host = $_ENV['DB_HOST'];

    /** @var string */
    $port = $_ENV['DB_PORT'];

    /** @var string */
    $dbname = $_ENV['MYSQL_DATABASE'];

    /** @var string */
    $user = $_ENV['MYSQL_USER'];

    /** @var string */
    $password = $_ENV['MYSQL_PASSWORD'];

    /** @var string */
    $dsn = "mysql:host={$host};port={$port};dbname={$dbname};";

    $this->conn = PDOSingleton::getInstance($dsn, $user, $password);
  }

  /**
   * 該当レコードを全て取得
   *
   * @param string $sql SQL文
   * @param array $params プリペアドステートメントのパラメータ
   * @param string $type クエリを実行した際に返り値をクラスオブジェクト形式で返すか否かの判定
   * @param string $cls クラスオブジェクト
   * @return array|object|false
   */
  public function select(string $sql = '', array $params = [], string $type = '', string $cls = ''): array|false
  {
    /** @var \PDOStatement|false */
    $stmt = $this->executeSql($sql, $params);
    if ($type === static::CLS) {
      return $stmt->fetchAll(PDO::FETCH_CLASS, $cls);
    } else {
      return $stmt->fetchAll();
    }
  }

  /**
   * 該当レコードの先頭のみを取得
   *
   * @param string $sql SQL文
   * @param array $params プリペアドステートメントのパラメータ
   * @param string $type クエリを実行した際に返り値をクラスオブジェクト形式で返すか否かの判定
   * @param string $cls クラスオブジェクト
   * @return array|object|false
   */
  public function selectOne(string $sql = '', array $params = [], string $type = '', string $cls = ''): object|array|false
  {
    /** @var array|object|false */
    $result = $this->select($sql, $params, $type, $cls);

    return count($result) > 0 ? $result[0] : false;
  }

  /**
   * SQLを実行
   *
   * @param string $sql SQL文
   * @param array $params プリペアドステートメントのパラメータ
   * @return \PDOStatement|false
   */
  private function executeSql(string $sql = '', array $params = []): \PDOStatement|false
  {
    /** @var \PDOStatement|false */
    $stmt = $this->conn->prepare($sql);

    // SQLの実行、このexecuteはPHP標準の関数
    $this->sqlResult = $stmt->execute($params);

    return $stmt;
  }

  /**
   * SQLの実行結果を返す
   *
   * SQLの実行はこの関数を使用すること
   *
   * @param string $sql SQL文
   * @param array $params プリペアドステートメントのパラメータ
   * @return bool
   */
  public function execute(string $sql = '', array $params = []): bool
  {
    // SQLの実行
    $this->executeSql($sql, $params);

    return $this->sqlResult;
  }

  /**
   * トランザクション処理を開始
   *
   * @return void
   */
  public function begin(): void
  {
    $this->conn->beginTransaction();
  }

  /**
   * トランザクション処理をコミット
   *
   * @return void
   */
  public function commit(): void
  {
    $this->conn->commit();
  }

  /**
   * トランザクション処理をロールバック
   *
   * @return void
   */
  public function rollback(): void
  {
    $this->conn->rollback();
  }
}
