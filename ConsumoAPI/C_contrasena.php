<?php
$url = "http://localhost:8080/Contrasenas";

$consumo = file_get_contents($url);

if ($consumo === FALSE) {
    die("Error al consumir el servicio.");
}

$Contrasenas = json_decode($consumo);

foreach ($Contrasenas as $Contrasena) {
    echo $Contrasena . "\n";
}
?>

// pa que corra C:\xampp\php\php.exe C_contrasenas.php
