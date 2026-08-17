<?php

$host = "127.0.0.1";
$port = "3307";
$databaseName = "joy_crm";
$username = "root";
$password = "";

try {
    $connection = new PDO(
        "mysql:host=$host;port=$port;dbname=$databaseName;charset=utf8mb4",
        $username,
        $password
    );

    $connection->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );
} catch (PDOException $error) {
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed"
    ]);

    exit;
}