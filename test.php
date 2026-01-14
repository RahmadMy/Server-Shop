<?php
if (defined('PDO::ATTR_DRIVER_NAME')) {
    $drivers = PDO::getAvailableDrivers();
    if (in_array('mysql', $drivers)) {
        echo "PDO MySQL aktif ✅";
    } else {
        echo "PDO aktif tapi MySQL driver tidak ditemukan ❌";
    }
} else {
    echo "PDO tidak aktif ❌";
}
?>
