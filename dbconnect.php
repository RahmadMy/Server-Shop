<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = getenv("MYSQLHOST") ?: 'localhost';
$db   = getenv("MYSQLDATABASE") ?: 'test';
$port = getenv("MYSQLPORT") ?: 3306;
$user = getenv("MYSQLUSER") ?: 'root';
$pass = getenv("MYSQLPASSWORD") ?: '';

try {
    // Buat koneksi PDO
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;port=$port;charset=utf8mb4",
        $user,
        $pass,
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
