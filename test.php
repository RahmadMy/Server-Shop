<?php
$drivers = PDO::getAvailableDrivers();
echo "Drivers aktif: ";
print_r($drivers);
?>
