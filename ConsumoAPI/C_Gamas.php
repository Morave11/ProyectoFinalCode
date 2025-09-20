<?php
$url = "http://localhost:8080/Gamas";

$consumo = file_get_contents($url);

if ($consumo === false) {
    die("Error al consumir el servicio.");
}

$Gamas = json_decode($consumo);

foreach ($Gamas  as $Gama) {
    echo $Gama . "\n";
}
