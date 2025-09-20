<?php
$url = "http://localhost:8080/Contrasenas";

$consumo = file_get_contents($url);

if ($consumo === false) {
    die("Error al consumir el servicio.");
}

$DetallesC = json_decode($consumo);

foreach ($DetallesC as $DetalleC) {
    echo $DetalleC . "\n";
}

