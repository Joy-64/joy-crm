<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../config/database.php";

echo json_encode([
    "success" => true,
    "message" => "Database connected successfully"
]);