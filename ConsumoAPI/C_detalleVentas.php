<?php

$url = "http://localhost:8080/DetalleVentas";

$consumo = file_get_contents($url);

if ($consumo === false) {
    die("Error al consumir el servicio.");
}

$Detallesventas = json_decode($consumo);

foreach ($Detallesventas as $DetalleV) {
    echo $DetalleV . "\n";
}
