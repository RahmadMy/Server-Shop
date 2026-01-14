<?php
if (function_exists('mysqli_connect')) {
    echo "MySQLi aktif ✅";
} else {
    echo "MySQLi tidak aktif ❌";
}

// Opsional: info PHP lengkap
phpinfo();
?>
