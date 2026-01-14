<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

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

// Cek email sudah terdaftar atau belum
$checkQuery = "SELECT id FROM users WHERE email = ?";
$checkStmt = $conn->prepare($checkQuery);
$checkStmt->bind_param("s", $email);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    echo json_encode([
        "status" => false,
        "message" => "Email sudah terdaftar"
    ]);
    exit;
}

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Simpan ke database
$query = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $name, $email, $hashedPassword);

if ($stmt->execute()) {
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
