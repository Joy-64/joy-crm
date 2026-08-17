<?php

session_start();

header("Content-Type: application/json");

if (!isset($_SESSION["admin_id"])) {
    http_response_code(401);

    echo json_encode([
        "success" => false,
        "message" => "Unauthorized"
    ]);

    exit;
}

require_once __DIR__ . "/../config/database.php";

$sql = "
    SELECT
        id,
        name,
        business_name,
        contact,
        service,
        message,
        status,
        created_at
    FROM inquiries
    ORDER BY created_at DESC
";

$statement = $connection->prepare($sql);

$statement->execute();

$inquiries = $statement->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "success" => true,
    "data" => $inquiries
]);