<?php
$url = "http://localhost:8080/Compras";

$consumo = file_get_contents($url);

if ($consumo === FALSE) {
    die("Error al consumir el servicio.");
}

$compras = json_decode($consumo);

foreach ($compras as $compra) {
    echo $compra . "\n";
}

// Metodo POST 
$respuesta = readline("¿Deseas agregar una nueva compra?, s para sí, n para no: \n");

if ($respuesta === "s") {
    $id_entrada = readline("Ingresa el ID de la entrada: \n");
    $precio_compra = readline("Ingresa el precio de compra: \n");
    $id_producto = readline("Ingresa el ID del producto: \n");
    $documento_empleado = readline("Ingresa el documento del empleado: \n");
} 

    $datos = array(
        "ID_Entrada" => $id_entrada,
        "Precio_Compra" => $precio_compra,
        "ID_Producto" => $id_producto,
        "Documento_Empleado" => $documento_empleado
    );

    $data_json = json_encode($datos);
    $urlpost = "http://localhost:8080/ComprasR";

    $proceso = curl_init($urlpost);

    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($proceso, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_json)
    ]);

    $respuestapet = curl_exec($proceso);
    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

    if (curl_errno($proceso)) {
        die("Error en la petición POST: " . curl_error($proceso) . "\n");
    }

    curl_close($proceso);

    if ($http_code === 200) {
        echo "Compra guardada correctamente (200)\n";
    } else {
        echo "Error en el servidor, respuesta: $http_code\n";
    }
?>