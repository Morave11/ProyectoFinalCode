<?php

include "./Config/config.php";

$consumo = file_get_contents($urlcliente);

if ($consumo === FALSE) {
    die("Error al consumir el servicio.\n");
}

$clientes = json_decode($consumo);


foreach ($clientes as $cliente) {
   echo $cliente ."\n";
    }

echo "\n=== MENÚ DE OPCIONES ===\n";
echo "1. Registrar cliente\n";
echo "2. Actualizar cliente\n";
echo "3. Eliminar cliente\n";

$opcion = readline("Seleccione una opción: ");

switch ($opcion) {
 case "1":
//Metodo post
    
    $Nombre_Cliente = readline("Ingrese su nombre ". "\n");
    $Apellido_Cliente = readline("Ingresa su apellido ". "\n");
    $Documento_Cliente=readline("Ingresa su documento ". "\n");
    $Telefono = readline("Ingresa su Telefono ". "\n");
    $Fecha_Nacimiento = readline("Ingresa su Fecha_Nacimiento ". "\n");
    $Genero=readline("Ingresa su Genero ". "\n");
    $ID_Estado=readline("Ingresa su estado ". "\n");

    
    $data = json_encode([
        "Documento_Cliente"=> $Documento_Cliente,
        "Nombre_Cliente" => $Nombre_Cliente,
        "Apellido_Cliente" => $Apellido_Cliente,
         "Telefono"=> $Telefono,
        "Fecha_Nacimiento" => $Fecha_Nacimiento,
        "Genero" => $Genero,
        "ID_Estado" => $ID_Estado], JSON_UNESCAPED_UNICODE);

    $proceso = curl_init($urlpostcliente);
    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($proceso, CURLOPT_POSTFIELDS, $data);
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($proceso, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
    ));

    $respuestapet= curl_exec($proceso);
    $http_code= curl_getinfo($proceso, CURLINFO_HTTP_CODE);

    if(curl_errno($proceso)){
        die("Error en la petición POST"."\n");
    }
    curl_close($proceso);

    if($http_code === 200){
        echo "cliente agregado exitosamente". "\n";
    }
    else{
        echo "Error al agregar el cliente. Código HTTP: $http_code" . "\n";
    
    }
    break; 

case "2":   
//metodo put

    $Documento_Cliente=readline("Ingresa el documento del cliente a actualizar ". "\n");
    $Nombre_Cliente = readline("Ingrese el nombre que desea actualizar". "\n");
    $Apellido_Cliente = readline("Ingrese el apellido que desea actualizar". "\n");
    $Telefono = readline("Ingresa el nuevo Telefono ". "\n");
    $Fecha_Nacimiento = readline("Ingresa la Fecha_Nacimiento ". "\n");
    $Genero=readline("Ingresa el Genero ". "\n");
    $ID_Estado=readline("Ingresa su estado ". "\n");

    
    $data = json_encode([
        "Documento_Cliente"=> $Documento_Cliente,
        "Nombre_Cliente" => $Nombre_Cliente,
        "Apellido_Cliente" => $Apellido_Cliente,
         "Telefono"=> $Telefono,
        "Fecha_Nacimiento" => $Fecha_Nacimiento,
        "Genero" => $Genero,
        "ID_Estado" => $ID_Estado], JSON_UNESCAPED_UNICODE);

    $urlPutConDocemp = $urlputcli . "/" . rawurlencode($Documento_Cliente);

    $proceso = curl_init($urlPutConDocemp);
    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($proceso, CURLOPT_POSTFIELDS, $data);
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($proceso, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
    ));

    $respuestapet= curl_exec($proceso);
    $http_code= curl_getinfo($proceso, CURLINFO_HTTP_CODE);

    if(curl_errno($proceso)){
        die("Error en la petición PUT"."\n");
    }
    curl_close($proceso);

    if($http_code === 200){
        echo "cliente actualizado exitosamente". "\n";
    }
    else{
        echo "Error al actualizar el cliente. Código HTTP: $http_code" . "\n";
    
    }
    break; 

case "3":
    
//Metodo Delete

    $Documento_Cliente = readline("Ingresa el documento del cliente a eliminar: " . "\n");

    $urlDeleteConDocli = $urlDeletcli . "/" . rawurlencode($Documento_Cliente);

    $proceso = curl_init($urlDeleteConDocli);
    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);

    $respuestapet = curl_exec($proceso);
    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

    if (curl_errno($proceso)) {
        die("Error en la petición DELETE" . "\n");
    }
    curl_close($proceso);

    if ($http_code === 200) {
        echo "Cliente eliminado exitosamente" . "\n";
    } else {
        echo "Error al eliminar el cliente. Código HTTP: $http_code" . "\n";
    }
    break;

default:
    echo "Opción no válida\n";
    break;
}
?>
