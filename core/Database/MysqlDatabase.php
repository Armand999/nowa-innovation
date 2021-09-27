<?php

namespace Core\Database;

use \pdo;

class MysqlDatabase
{

    private $host;
    private $dbname;
    private $dbuser;
    private $dbpass;
    private $pdo;
    public static $dbInstance;

    /**
     * Singleton Database Instance
     *
     * @return void
     */
    public static function dbInstance()
    {
        if (empty(self::$dbInstance)) {
            return self::$dbInstance = new MysqlDatabase();
        }
        return self::$dbInstance;
    }

    public function __construct($host = 'localhost', $dbname = 'nowa', $dbuser = 'root', $dbpass = '')
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->dbuser = $dbuser;
        $this->dbpass = $dbpass;
    }

    /**
     * get PDO
     *
     * @param object $pdo
     * @return $this->pdo
     */
    private function getPdo()
    {
        if (empty($this->pdo)) {
            $this->pdo = new pdo("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", "$this->dbuser", "$this->dbpass", [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        }
        return $this->pdo;
    }

    /**
     * To make query with PDO
     *
     * @param string $statement
     * @return []
     */
    public function query($statement, $className = '', $one = false)
    {
        $query = $this->getPdo()->query($statement);

        if (
            strpos($statement, 'UPDATE') === 0 || strpos($statement, 'INSERT') === 0 || strpos($statement, 'DELETE') === 0
        ) {
            return $query;
        }

        $query->setFetchMode(PDO::FETCH_CLASS, $className);

        if ($one) {
            $datas = $query->fetch();
        } else {
            $datas = $query->fetchAll();
        }

        return $datas;
    }

    /**
     * To make prepared query
     *
     * @param string $statement
     * @param array $attributes
     * @return []
     */
    public function prepare($statement, $attributes = [], $className = null, $one = false)
    {
        $query = $this->getPdo()->prepare($statement);
        $res = $query->execute($attributes);
        
        if (
            strpos($statement, 'UPDATE') === 0 || strpos($statement, 'INSERT') === 0 || strpos($statement, 'DELETE') === 0
        ) {
            return $res;
        }

        $query->setFetchMode(PDO::FETCH_CLASS, $className);

        if ($one) {
            $datas = $query->fetch();
        } else {
            $datas = $query->fetchAll();
        }

        return $datas;
    }

    public function getLastInsertID()
    {
        return $this->getPdo()->lastInsertId();
    }
}
