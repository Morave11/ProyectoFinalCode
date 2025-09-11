<?php
$url = "http://localhost:8080/Detallle";

$consumo = file_get_contents($url);

if ($consumo === FALSE) {
    die("Error al consumir el servicio.");
}

$clientes = json_decode($consumo);

foreach ($clientes as $cliente) {
    echo $cliente . "\n";
}
?>