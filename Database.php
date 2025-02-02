<?php

class Database
{
    private static ?Database $instance = null;

    // Property with getter method
    private PDO $connection {
        get {
            return $this->connection;
        }
    }
    private string $server = "127.0.0.1:3306";
    private string $username = "root";
    private string $password = "";

    private function __construct()
    {
        try {
            $dsn = "mysql:host=$this->server;dbname=test";
            $this->connection = new PDO($dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function getInstance(): ?Database
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}