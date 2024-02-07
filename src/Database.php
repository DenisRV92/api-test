<?php

namespace Src;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;

    private $host = 'localhost';
    private $dbname = 'test';
    private $username = 'postgres';
    private $password = '';
    private $conn;

    /**
     * Подключаемся к бд
     * @return void
     */
    public function connect()
    {
        try {
            $this->conn = new PDO("pgsql:host=" . $this->host . ";dbname=" . $this->dbname, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    /**
     * Получаем данные по ключу
     * @param $key
     * @return void
     */
    public function getRecordsByKey($key)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM score WHERE key = ?");
            $stmt->execute([$key]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    /**
     * Глобальный instance
     * @return Database|null
     */
    public static function getInstance(): ?Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
            self::$instance->connect();
        }

        return self::$instance;
    }

}

