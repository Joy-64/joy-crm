<?php

header("Content-Type: application/json");

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