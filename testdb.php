<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");

$conn = mysqli_connect(
  getenv("MYSQLHOST"),
  getenv("MYSQLUSER"),
  getenv("MYSQLPASSWORD"),
  getenv("MYSQLDATABASE"),
  getenv("MYSQLPORT")
);

if (!$conn) {
  http_response_code(500);
  echo json_encode([
    "status" => false,
    "error" => mysqli_connect_error(),
    "host" => getenv("MYSQLHOST"),
    "db" => getenv("MYSQLDATABASE")
  ]);
  exit;
}

echo json_encode(["status" => "DB CONNECTED"]);
