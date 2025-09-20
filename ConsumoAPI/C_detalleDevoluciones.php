<?php
include "./Config/config.php";

echo " Bienvenido a detalle de Devoluciones \n";
echo "1) Buscar por ID de Venta\n";
echo "2) Buscar por ID de Devolución\n";
echo "3) Mostrar todas\n";
echo "4) Agregar detalle de devolución\n";
echo "5) Actualizar detalle de devolución\n";
echo "6) Eliminar detalle de devolución\n";

$opcion = readline("Elige una opción: ");

$consumo = file_get_contents($urlD);

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

    case "4":
        $idDevolucion = readline("ID_Devolucion: ");
        $idVenta = readline("ID_Venta: ");
        $cantidad = readline("Cantidad devuelta: ");

        $data = json_encode([
            "ID_Devolucion"    => $idDevolucion,
            "ID_Venta"         => $idVenta,
            "Cantidad_Devuelta"=> $cantidad
        ], JSON_UNESCAPED_UNICODE);

        $proceso = curl_init($urlpostD);
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($proceso, CURLOPT_POSTFIELDS, $data);
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
        ]);

        $respuesta = curl_exec($proceso);
        curl_close($proceso);

        echo "Respuesta del servidor: " . $respuesta . "\n";
        break;

    case "5":
        $idDevolucion = readline("ID_Devolucion a actualizar: ");
        $idVenta = readline("ID_Venta a actualizar: ");
        $cantidad = readline("Nueva cantidad devuelta: ");

        $urlPut = $urlputD . "/" . rawurlencode($idDevolucion) . "/" . rawurlencode($idVenta);

        $data = json_encode([
            "Cantidad_Devuelta" => $cantidad
        ], JSON_UNESCAPED_UNICODE);

        $proceso = curl_init($urlPut);
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($proceso, CURLOPT_POSTFIELDS, $data);
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
        ]);

        $respuesta = curl_exec($proceso);
        curl_close($proceso);

        echo "Respuesta del servidor: " . $respuesta . "\n";
        break;

        case "6":
    $idDevolucion = readline("ID_Devolucion a eliminar: ");
    $idVenta = readline("ID_Venta a eliminar: ");

$urldelete = $urldeleteD . "/" . rawurlencode($idDevolucion) . "/" . rawurlencode($idVenta);

    $proceso = curl_init($urldelete);
    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);

    $respuesta = curl_exec($proceso);
    curl_close($proceso);

    echo "Respuesta del servidor: " . $respuesta . "\n";
    break;
}
