<?php
$urlGet = "http://localhost:8080/Ventas";
$urlPost = "http://localhost:8080/VentaRegistro";

$consumo = file_get_contents($urlGet);
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

//POST
$respuesta = readline("¿Desea registrar una nueva venta? (s/n): ");

if($respuesta === 's'){
    $ID_Venta = readline("Ingrese el ID de la venta: ");
    $Documento_Cliente = readline("Ingrese el documento del cliente: ");
    $Documento_Empleado = readline("Ingrese el documento del empleado: ");

$data = array(
        "ID_Venta" => $ID_Venta,
        "Documento_Cliente" => $Documento_Cliente,
        "Documento_Empleado" => $Documento_Empleado
    );
    $data_json = json_encode($data);

    $proceso = curl_init($urlPost);

    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($proceso, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_json)
    ));

    $respuestapeticion = curl_exec($proceso);

    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

    if (curl_errno ($proceso)) {
        die("Error en la petición POST" . curl_error($proceso) ."\n");
    }

    curl_close($proceso);


    if ($http_code === 200){
        echo "Venta registrada exitosamente.\n";
    } else {
        echo "Error al registrar la venta. Código HTTP: $http_code\n";
    }
}

// pa que corra C:\xampp\php\php.exe C_ventas.php
