<?php
include "./Config/config.php";


$consumo = file_get_contents($urlcompras);


if ($consumo === FALSE) {
    die("Error al consumir el servicio.");
}


$compras = json_decode($consumo, true);


$encontrado = false;
foreach ($compras as $compra) {
      echo $compra . "\n";
}


echo "\n--- MENÚ  ---\n";
echo "1. Registrar compra\n";
echo "2. Actualizar compra\n";
echo "3. Eliminar compra\n";


$opcion = readline("Seleccione una opción: ");


switch ($opcion) {
// Metodo POST
    case "1":
        $id_entrada = readline("Ingresa el ID de la entrada: ");
        $precio_compra = readline("Ingresa el precio de compra: ");
        $id_producto = readline("Ingresa el ID del producto: ");
        $documento_empleado = readline("Ingresa el documento del empleado: ");


        $datos = json_encode([
            "ID_Entrada" => $id_entrada,
            "Precio_Compra" => $precio_compra,
            "ID_Producto" => $id_producto,
            "Documento_Empleado" => $documento_empleado
        ], JSON_UNESCAPED_UNICODE);


        $proceso = curl_init($urlpostcompras);
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($proceso, CURLOPT_POSTFIELDS, $datos);
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);


        $respuestapet = curl_exec($proceso);
        $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);


        if (curl_errno($proceso)) {
            die("Error en la petición POST: " . curl_error($proceso) . "\n");
        }


        curl_close($proceso);


        if ($http_code === 200) {
            echo "Compra registrada correctamente (200)\n";
        } else {
            echo "Error al registrar la compra. Código HTTP: $http_code\n";
        }
        break;


// METODO PUT
    case "2":
        $id_entrada = readline("Ingresa el ID de la entrada que desea actualizar: ");
        $precio_compra = readline("Nuevo precio de compra: ");
        $id_producto = readline("Nuevo ID del producto: ");
        $documento_empleado = readline("Nuevo documento del empleado: ");


        $datos = json_encode([
            "ID_Entrada" => $id_entrada,
            "Precio_Compra" => $precio_compra,
            "ID_Producto" => $id_producto,
            "Documento_Empleado" => $documento_empleado
        ], JSON_UNESCAPED_UNICODE);


        $urlputCompras = $urlputcompras . "/" . rawurlencode($id_entrada);
        $proceso = curl_init($urlputCompras);


        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($proceso, CURLOPT_POSTFIELDS, $datos);
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);


        $respuestapet = curl_exec($proceso);
        $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);


        if (curl_errno($proceso)) {
            die("Error en la petición PUT: " . curl_error($proceso) . "\n");
        }


        curl_close($proceso);


        if ($http_code === 200) {
            echo "Compra actualizada correctamente (200)\n";
        } else {
            echo "Error al actualizar la compra. Código HTTP: $http_code\n";
        }
        break;


// METODO DELETE
    case "3":
        $id_entrada = readline("Ingresa el ID de la entrada que desea eliminar: ");


        $urlDeleteCom = $urldeletecompras . "/" . rawurlencode($id_entrada);
        $proceso = curl_init($urlDeleteCom);


        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);


        $respuestapet = curl_exec($proceso);
        $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);


        if (curl_errno($proceso)) {
            die("Error en la petición DELETE: " . curl_error($proceso) . "\n");
        }


        curl_close($proceso);


        if ($http_code === 200) {
            echo "Compra eliminada correctamente (200)\n";
        } else {
            echo "Error al eliminar la compra. Código HTTP: $http_code\n";
        }
        break;
}
?>

