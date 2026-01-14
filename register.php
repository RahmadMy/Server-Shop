<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Include koneksi PDO
include "dbconnect.php";

// Ambil data JSON dari Flutter / Postman
$input = json_decode(file_get_contents("php://input"), true);

$name     = $input['name'] ?? '';
$email    = $input['email'] ?? '';
$password = $input['password'] ?? '';

// Validasi input
if (empty($name) || empty($email) || empty($password)) {
    echo json_encode([
        "status" => false,
        "message" => "Nama, email, dan password wajib diisi"
    ]);
    exit;
}

try {
    // Cek email sudah terdaftar atau belum
    $checkStmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $checkStmt->bindParam(':email', $email, PDO::PARAM_STR);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        echo json_encode([
            "status" => false,
            "message" => "Email sudah terdaftar"
        ]);
        exit;
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Simpan ke database
    $insertStmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $insertStmt->bindParam(':name', $name, PDO::PARAM_STR);
    $insertStmt->bindParam(':email', $email, PDO::PARAM_STR);
    $insertStmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);

    if ($insertStmt->execute()) {
        echo json_encode([
            "status" => true,
            "message" => "Registrasi berhasil"
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Registrasi gagal"
        ]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "status" => false,
        "message" => "Terjadi kesalahan server",
        "error" => $e->getMessage()
    ]);
}
