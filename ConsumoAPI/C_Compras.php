<?php
$url = "http://localhost:8080/Compras";

$consumo = file_get_contents($url);

if ($consumo === FALSE) {
    die("Error al consumir el servicio.");
}

$compras = json_decode($consumo);

foreach ($compras as $compra) {
    echo $compra . "\n";
}
?>