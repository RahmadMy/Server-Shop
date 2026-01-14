<?php
header("Content-Type: application/json");

try {
    $pdo = new PDO(
        "mysql:host=" . getenv("MYSQLHOST") .
        ";dbname=" . getenv("MYSQLDATABASE") .
        ";port=" . getenv("MYSQLPORT") .
        ";charset=utf8mb4",
        getenv("MYSQLUSER"),
        getenv("MYSQLPASSWORD"),
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );

    echo json_encode([
        "status" => "PDO CONNECTED"
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "ERROR",
        "message" => $e->getMessage()
    ]);
}
