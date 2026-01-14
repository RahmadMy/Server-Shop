<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Include dbconnect.php → pastikan $pdo tersedia
include "dbconnect.php";

try {
    // Query dengan PDO
    $stmt = $pdo->query("SELECT id, name, price, description, promo, images, category, vendors, stock FROM product_items");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => true,
        "data" => $products
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "status" => false,
        "message" => "Query gagal",
        "error" => $e->getMessage()
    ]);
}
