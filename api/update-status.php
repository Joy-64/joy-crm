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

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$status = trim($_POST["status"] ?? "");

$allowedStatuses = [
    "new",
    "contacted",
    "quoted",
    "client",
    "discarded"
];

if (!$id || !in_array($status, $allowedStatuses, true)) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid inquiry data"
    ]);

    exit;
}

$sql = "
    UPDATE inquiries
    SET status = :status
    WHERE id = :id
";

$statement = $connection->prepare($sql);

$statement->execute([
    "status" => $status,
    "id" => $id
]);

echo json_encode([
    "success" => true,
    "message" => "Status updated successfully"
]);