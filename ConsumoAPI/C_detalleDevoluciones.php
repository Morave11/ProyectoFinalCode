<?php
$url = "http://localhost:8080/DetalleD";

$consumo = file_get_contents($url);
if ($consumo === false) {
    die("Error al consumir el servicio.");
}

$detalles = json_decode($consumo);

foreach ($detalles as $linea) {
    $partes = explode("________", $linea);

    $idDevolucion = $partes[0];
    $cantidad = $partes[1];
    $idVenta = $partes[2];

    
    if ($idVenta === "23") {
        echo "Devolución: $idDevolucion | Cantidad: $cantidad | Venta: $idVenta\n";
    }

   
    if ($cantidad >= 2) {
        echo "Devolución $idDevolucion tiene cantidad mayor o igual a 2\n";
    }

    
    if ($idDevolucion === "DEV001") {
        echo "Encontrada DEV001 (venta $idVenta, cant $cantidad)\n";
    }

}
