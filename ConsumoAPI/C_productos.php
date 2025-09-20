<?php
$url = "http://localhost:8080/Productos";

$consumo = file_get_contents($url);

if ($consumo === false) {
    die("Error al consumir el servicio.");
}

$Productos = json_decode($consumo);

foreach ($Productos  as $Producto) {
    echo $Producto . "\n";
}
