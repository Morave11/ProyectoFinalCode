<?php
$url = "http://localhost:8080/Empleados";

$consumo = file_get_contents($url);

if ($consumo === FALSE) {
    die("Error al consumir el servicio.");
}

$Empleados = json_decode($consumo);

foreach ($Empleados as $Empleado) {
    echo $Empleado . "\n";
}
?>