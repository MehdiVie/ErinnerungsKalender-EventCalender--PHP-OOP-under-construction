<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);


class Database {
    private $host = "localhost";
    private $dbname = "erinnerungskalender_db";
    private $username = "root";
    private $password = "Mysql@123";
    private static $instance = null;
    public $conn;

    private function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Database connection failed: " . $e->getMessage();
        }
    }

    // Singleton Pattern (nur eine Verbindung)
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->conn;
    }
}
?>
