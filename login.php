<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Include koneksi PDO
include "dbconnect.php";

// Ambil input JSON
$input = json_decode(file_get_contents("php://input"), true);

// Validasi input
if (!isset($input['email']) || !isset($input['password'])) {
    http_response_code(400);
    echo json_encode([
        "status" => false,
        "message" => "Email dan password wajib diisi"
    ]);
    exit;
}

$email = $input['email'];
$password = $input['password'];

try {
    // Siapkan query PDO dengan prepared statement
    $stmt = $pdo->prepare("SELECT id, name, email, password FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        echo json_encode([
            "status" => true,
            "message" => "Login berhasil",
            "user" => [
                "id" => $user['id'],
                "name" => $user['name'],
                "email" => $user['email']
            ]
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Email atau password salah"
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
