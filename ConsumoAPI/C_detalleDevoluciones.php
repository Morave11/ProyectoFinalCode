<?php
include "./Config/config.php";

echo " Bienvenido a detalle de Devoluciones \n";
echo "1) Buscar por ID de Venta\n";
echo "2) Buscar por ID de Devolución\n";
echo "3) Mostrar todas\n";

$opcion = readline("Elige una opción: ");

$consumo = file_get_contents($url);

if ($consumo === false) {
    die("Error al consumir el servicio.\n");
}

$detalless = json_decode($consumo);


$detalles = [];
foreach ($detalless as $linea) {
    $partes = explode("________", $linea);
    $detalles[] = [
        "idDevolucion" => $partes[0],
        "cantidad"     => $partes[1],
        "idVenta"      => $partes[2]
    ];
}


switch ($opcion) {
    case "1":
        $venta = readline("Ingresa el ID de Venta: ");
        foreach ($detalles as $d) {
            if ($d["idVenta"] === $venta) {
                echo "ID Devolución: {$d['idDevolucion']} | Cantidad: {$d['cantidad']} | Venta: {$d['idVenta']}\n";
            }
        }
        break;

    case "2":
        $dev = readline("Ingresa el ID de Devolución: ");
        foreach ($detalles as $d) {
            if ($d["idDevolucion"] === $dev) {
                echo "ID Devolución: {$d['idDevolucion']} | Cantidad: {$d['cantidad']} | Venta: {$d['idVenta']}\n";
            }
        }
        break;

    case "3":
        foreach ($detalles as $d) {
            echo "ID Devolución: {$d['idDevolucion']} | Cantidad: {$d['cantidad']} | Venta: {$d['idVenta']}\n";
        }
        break;

    default:
        echo "Opción no válida.\n";
}
