<?php
$url = "http://localhost:8080/Devoluciones";

$consumo = file_get_contents($url);

if ($consumo === false) {
    die("Error al consumir el servicio.");
}

$Devoluciones = json_decode($consumo);

foreach ($Devoluciones as $Devolucion) {
    echo $Devolucion . "\n";
}
?>

// pa que corra C:\xampp\php\php.exe C_devoluciones.php
