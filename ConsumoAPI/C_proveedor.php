<?php
$url = "http://localhost:8080/Proveedor";

$consumo = file_get_contents($url);

if ($consumo === FALSE) {
    die("Error al consumir el servicio.");
}

$Proveedores = json_decode($consumo);

foreach ($Proveedores  as $Proveedor) {
    echo $Proveedor . "\n";
}
?>