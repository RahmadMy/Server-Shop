<?php
$conn = mysqli_connect(
  getenv("MYSQLHOST"),
  getenv("MYSQLUSER"),
  getenv("MYSQLPASSWORD"),
  getenv("MYSQLDATABASE"),
  getenv("MYSQLPORT")
);

if (!$conn) {
  die(json_encode(["error" => "DB connection failed"]));
}
