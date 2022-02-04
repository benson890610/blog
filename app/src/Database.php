<?php 

namespace App;

use \PDO;

class Database {
    
    private string $driver;
    private string $host;
    private string $user;
    private string $password;
    private string $dbname;
    private int    $port;
    private string $charset;

    private \PDO $pdo;
    private \PDOStatement $statement;

    public function __construct(string $host = '', string $user = '', string $pass = '', string $dbname = '', int $port = 0, string $charset = '') {
        if(empty($host) || empty($user) || empty($pass) || empty($dbname)) {
            $this->driver  = (string) $_ENV['DB_DRIVER'];
            $this->host    = (string) $_ENV['DB_HOST'];
            $this->user    = (string) $_ENV['DB_USER'];
            $this->pass    = (string) $_ENV['DB_PASS'];
            $this->dbname  = (string) $_ENV['DB_NAME'];
            $this->port    = (int)    $_ENV['DB_PORT'];
            $this->charset = (string) $_ENV['DB_CHAR'];
        } else {
            $this->host   = (string) $host;
            $this->user   = (string) $user;
            $this->pass   = (string) $pass;
            $this->dbname = (string) $dbname;

            if($port === 0 || empty($charset)) {
                $this->port    = (int)    $_ENV['DB_PORT'];
                $this->charset = (string) $_ENV['DB_CHAR'];
            } else {
                $this->port    = (int)    $port;
                $this->charset = (string) $charset;
            }
        }

        try {
            $dsn = "{$this->driver}:host={$this->host};dbname={$this->dbname};port={$this->port};charset={$this->charset}";

            $this->pdo = new \PDO($dsn, $this->user, $this->pass);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE,            \PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            $this->pdo->setAttribute(\PDO::ATTR_PERSISTENT,         true);
            $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES,   false);

        } catch(\PDOException $e) {
            trigger_error($e->getMessage());
            exit;
        }
    }

    public function begin_transaction() {
        $this->pdo->beginTransaction();
    }

    public function commit() {
        $this->pdo->commit();
    }

    public function rollback() {
        $this->pdo->rollBack();
    }

    public function query_single(string $sql_commad, $fetch_mode = null) {
        if($this->pdo instanceof \PDO) {
            return $this->query($sql_command)->fetch($fetch_mode);
        }

        trigger_error('Database Error: query_single method, pdo attribute is not an instance of \\PDO class');
        exit;
    } 

    public function query_all(string $sql_command, $fetch_mode = null) {
        if($this->pdo instanceof \PDO) {
            return $this->pdo->query($sql_command)->fetchAll();
        }

        trigger_error('Database Error: query_all method, pdo attribute is not an instance of \\PDO class');
        exit;
    }

    public function prepare(string $sql_command) {
        if($this->pdo instanceof \PDO) {
            $this->statement = $this->pdo->prepare($sql_command);
            return true;
        }

        trigger_error('Database Error: prepare method, pdo attribute is not an instance of \\PDO class');
        exit;
    }

    public function execute() {
        if($this->statement instanceof \PDOStatement) {
            $this->statement->execute();
            return true;
        }

        trigger_error('Database Error: execute method, statement attribute is not an instance of \\PDOStatement class');
        exit;
    }

    public function bind($param, $value, $type = null) {
        if(is_null($type)) {
            switch($value) {
                case is_string($value):
                    $type = \PDO::PARAM_STR;
                    break;
                case is_int($value):
                    $type = \PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = \PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = \PDO::PARAM_NULL;
                    break;
                default:
                    $type = \PDO::PARAM_LOB;
            }
        }

        $this->statement->bindValue($param, $value, $type);
    }

    public function single($fetch_mode = null) {
        if($this->statement instanceof \PDOStatement) {
            return $this->statement->fetch($fetch_mode);
        }

        trigger_error('Database Error: statement attribute is not an instance of \\PDOStatement class');
        exit;
    }

    public function all($fetch_mode = null) {
        if($this->statement instanceof \PDOStatement) {
            return $this->statement->fetchAll($fetch_mode);
        }

        trigger_error('Database Error: statement attribute is not an instance of \\PDOStatement class');
        exit;
    }

    public function last_id() {
        if($this->pdo instanceof \PDO) {
            return $this->pdo->lastInsertId();
        }

        trigger_error('Database Error: statement attribute is not an instance of \\PDOStatement class');
        exit;
    }

    public function row_count() {
        if($this->statement instanceof \PDOStatement) {
            return $this->statement->rowCount();
        }

        trigger_error('Database Error: statement attribute is not an instance of \\PDOStatement class');
        exit;
    }
}