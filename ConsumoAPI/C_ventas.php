<?php
$url = "http://localhost:8080/Ventas";

$consumo = file_get_contents($url);
if ($consumo === false) {
    die("Error al consumir el servicio.");
}

$ventas = json_decode($consumo);

foreach ($ventas as $linea) {
    $partes = explode(" | ", $linea);

    $ID_Venta = $partes[0];
    $Documento_Cliente = $partes[1];
    $Documento_Empleado = $partes[2];

    if ($ID_Venta === "12") {
        echo "Venta: $ID_Venta | $Documento_Cliente | $Documento_Empleado\n";
    }

    if ($Documento_Empleado === "1032939708") {
        echo "Venta hecha por empleado 1032939708: $ID_Venta\n";
    }

    if ($ID_Venta === "23") {
        echo "Venta encontrada ID=23, Cliente=$Documento_Cliente\n";
    }
}


// pa que corra C:\xampp\php\php.exe C_ventas.php
