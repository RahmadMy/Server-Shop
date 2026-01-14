<?php
$host = "sql200.infinityfree.com";
$user = "if0_40901151";
$pass = "e38y1qR3Jv1";
$db   = "if0_40901151_myonlineshopdatabase";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
