<?php
$url = "http://localhost:8080/Ventas";

$consumo = file_get_contents($url);

if ($consumo === FALSE) {
    die("Error al consumir el servicio.");
}

$Ventas = json_decode($consumo);

foreach ($Ventas  as $Venta) {
    echo $Venta . "\n";
}
?>

// pa que corra C:\xampp\php\php.exe C_ventas.php
