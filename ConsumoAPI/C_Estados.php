<?php
$url = "http://localhost:8080/Estado";

$consumo = file_get_contents($url);

if ($consumo === false) {
    die("Error al consumir el servicio.");
}

$Estados = json_decode($consumo);

foreach ($Estados  as $Estado) {
    echo $Estado . "\n";
}
