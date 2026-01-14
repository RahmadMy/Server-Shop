<?php
header('Content-Type: application/json');

// Ambil environment variable dari Railway
$host = getenv('MYSQLHOST') ?: 'localhost';
$db   = getenv('MYSQLDATABASE') ?: 'test';
$port = getenv('MYSQLPORT') ?: 3306;
$user = getenv('MYSQLUSER') ?: 'root';
$pass = getenv('MYSQLPASSWORD') ?: '';

$response = [];

try {
    // Buat koneksi PDO MySQL
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;port=$port;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    $response['status'] = "success";
    $response['message'] = "PDO MySQL aktif dan koneksi berhasil ✅";

    // Tampilkan driver PDO aktif
    $response['pdo_drivers'] = PDO::getAvailableDrivers();

} catch (PDOException $e) {
    http_response_code(500);
    $response['status'] = "error";
    $response['message'] = $e->getMessage();
}

echo json_encode($response, JSON_PRETTY_PRINT);
