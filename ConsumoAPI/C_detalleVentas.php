<?php
include "./Config/config.php";

echo " DETALLES DE VENTAS \n";
echo "1) Buscar por ID de Venta\n";
echo "2) Buscar por ID de Producto\n";
echo "3) Mostrar todas\n";
echo "4) Agregar detalle de venta\n";
echo "5) Actualizar detalle de venta\n";
echo "6) Eliminar detalle de venta\n";

$opcion = readline("Elige una opción: ");

$consumo = file_get_contents($urlGetDV);
if ($consumo === false) {
    die("Error al consumir el servicio.\n");
}

$detalless = json_decode($consumo);

$detalles = [];
foreach ($detalless as $linea) {
    $partes = explode(" | ", $linea);
    $detalles[] = [
        "cantidad"  => $partes[0],
        "fechaSalida"     => $partes[1],
        "idProducto"    => $partes[2],
        "idVenta" => $partes[3]
    ];
}

switch ($opcion) {
    case "1":
        $idVentaBuscada = readline("Ingresa el ID_Venta: ");
        foreach ($detalles as $d) {
            if ($d["idVenta"] === $idVentaBuscada) {
                echo "Producto: {$d['idProducto']} | Venta: {$d['idVenta']} | Cantidad: {$d['cantidad']} | Fecha_Salida: {$d['fechaSalida']}\n";
            }
        }
        break;

    case "2":
        $idProductoBuscado = readline("Ingresa el ID_Producto: ");
        foreach ($detalles as $d) {
            if ($d["idProducto"] === $idProductoBuscado) {
                echo "Producto: {$d['idProducto']} | Venta: {$d['idVenta']} | Cantidad: {$d['cantidad']} | Fecha_Salida: {$d['fechaSalida']}\n";
            }
        }
        break;

    case "3":
        foreach ($detalles as $d) {
            echo "Producto: {$d['idProducto']} | Venta: {$d['idVenta']} | Cantidad: {$d['cantidad']} | Fecha_Salida: {$d['fechaSalida']}\n";
        }
        break;

    case "4":
        $idProducto = readline("ID_Producto: ");
        $idVenta    = readline("ID_Venta: ");
        $cantidad   = readline("Cantidad: ");
        $fecha      = readline("Fecha de salida (YYYY-MM-DD): ");

        $data = json_encode([
            "ID_Producto"  => $idProducto,
            "ID_Venta"     => $idVenta,
            "Cantidad"     => $cantidad,
            "Fecha_Salida" => $fecha
        ], JSON_UNESCAPED_UNICODE);

        $proceso = curl_init($urlPostDV);
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($proceso, CURLOPT_POSTFIELDS, $data);
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);

        $respuesta = curl_exec($proceso);
        curl_close($proceso);

        echo "Respuesta del servidor: " . $respuesta . "\n";
        break;

    case "5":
        $idProducto = readline("ID_Producto a actualizar: ");
        $idVenta    = readline("ID_Venta a actualizar: ");
        $cantidad   = readline("Nueva cantidad: ");
        $fecha      = readline("Nueva fecha de salida (YYYY-MM-DD): ");

        $urlPut = $urlPutDV . "/" . rawurlencode($idProducto) . "/" . rawurlencode($idVenta);

        $data = json_encode([
            "Cantidad"     => $cantidad,
            "Fecha_Salida" => $fecha
        ], JSON_UNESCAPED_UNICODE);

        $proceso = curl_init($urlPut);
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($proceso, CURLOPT_POSTFIELDS, $data);
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);

        $respuesta = curl_exec($proceso);
        curl_close($proceso);

        echo "Respuesta del servidor: " . $respuesta . "\n";
        break;

    case "6":
    $idProducto = readline("ID_Producto a eliminar: ");
    $idVenta    = readline("ID_Venta a eliminar: ");

    $urlDelete = $urlDeleteDV . "/" . rawurlencode($idProducto) . "/" . rawurlencode($idVenta);

    $proceso = curl_init($urlDelete);
    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);

    $respuesta = curl_exec($proceso);
    curl_close($proceso);

    echo "Respuesta del servidor: " . $respuesta . "\n";
    break;
}
