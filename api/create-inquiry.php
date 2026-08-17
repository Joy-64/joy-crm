<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../config/database.php";

$name = trim($_POST["name"] ?? "");
$businessName = trim($_POST["business_name"] ?? "");
$contact = trim($_POST["contact"] ?? "");
$service = trim($_POST["service"] ?? "");
$message = trim($_POST["message"] ?? "");

if ($name === "" || $contact === "" || $service === "") {
    echo json_encode([
        "success" => false,
        "message" => "Please complete all required fields"
    ]);

    exit;
}

$sql = "
    INSERT INTO inquiries (
        name,
        business_name,
        contact,
        service,
        message
    ) VALUES (
        :name,
        :business_name,
        :contact,
        :service,
        :message
    )
";

$statement = $connection->prepare($sql);

$statement->execute([
    "name" => $name,
    "business_name" => $businessName,
    "contact" => $contact,
    "service" => $service,
    "message" => $message
]);

echo json_encode([
    "success" => true,
    "message" => "Inquiry created successfully",
    "inquiry_id" => $connection->lastInsertId()
]);