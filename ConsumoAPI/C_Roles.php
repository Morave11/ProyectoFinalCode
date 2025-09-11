<?php

$url = "http://localhost:8080/Roles";

$consumo = file_get_contents($url);

if ($consumo === false) {
    die("Error al consumir el servicio.");
}

$Roles = json_decode($consumo);

foreach ($Roles as $Rol) {
    echo $Rol . "\n";
}
