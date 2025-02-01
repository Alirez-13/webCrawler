<?php

$server = "127.0.0.1:3306";
$username = "root";
$password = "";
$dsn = "mysql:host=$server;dbname=test";

// Database using PDO
$connection = new PDO($dsn, $username, $password);

try {

    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully <br>";
    $createDB = "CREATE DATABASE IF NOT EXISTS test";

    $connection->exec($createDB);
    echo "Database created successfully<br>";

    $createTable = "CREATE TABLE IF NOT EXISTS Links (
        URL_ID INT AUTO_INCREMENT PRIMARY KEY,
        URL_Path VARCHAR(500) NOT NULL,
        Word_Counter BIGINT,
        Specific_Words VARCHAR(255),
        Img_Number BIGINT)";

    $connection->exec($createTable);
    echo "Table created successfully<br>";

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
