<?php
try {
    $conn = new PDO(
        "mysql:host=" . getenv("MYSQLHOST") .
        ";dbname=" . getenv("MYSQLDATABASE") .
        ";port=" . getenv("MYSQLPORT") .
        ";charset=utf8mb4",
        getenv("MYSQLUSER"),
        getenv("MYSQLPASSWORD"),
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "status" => false,
        "error" => $e->getMessage()
    ]);
    exit;
}
