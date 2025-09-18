<?php
$nombre = readline("Por favor, ingresa el nombre del cliente: ");

$url = "http://localhost:8080/Detalles";
$urlpost ="http://localhost:8080/RegistraC";
$urlput ="http://localhost:8080/ActualizarC";
$urlDelet ="http://localhost:8080/EliminarC";

$consumo = file_get_contents($url);

if ($consumo === FALSE) {
    die("Error al consumir el servicio.\n");
}

$clientes = json_decode($consumo);

$encontrado = false;
foreach ($clientes as $cliente) {
    
    $campos = explode("________", $cliente);

    
    if (stripos($campos[1], $nombre) !== false) {
        $encontrado = true;

        echo "------------------------\n";
        echo "Documento_Cliente: " . $campos[0] . "\n";
        echo "Nombre_Cliente: " . $campos[1] . "\n";
        echo "Apellido_Cliente: " . $campos[2] . "\n";
        echo "Teléfono: " . $campos[3] . "\n";
        echo "Fecha de nacimiento: " . $campos[4] . "\n";
        echo "Género: " . $campos[5] . "\n";
        echo "ID_Estado: " . $campos[6] . "\n";
    }
}

if (!$encontrado) {
    echo "Cliente no encontrado.\n";
}



//Metodo post

$respuesta= readline("¿Deseas agregar un nuevo cliente?, s para si, n para no: ". "\n");

if($respuesta === "s"){
    
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

    $proceso = curl_init($urlpost);
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
}





//metodo put
$respuestaup= readline("¿Deseas actualizar un cliente?, s para si, n para no: ". "\n");
if($respuestaup === "s"){
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


       
        
    $urlPutConDoc = $urlput . "/" . rawurlencode($Documento_Cliente);

    $proceso = curl_init($urlPutConDoc);
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
}



//Metodo Delete


$respuestadel = readline("¿Deseas eliminar un cliente?, s para si, n para no: " . "\n");

if ($respuestadel === "s") {
    $Documento_Cliente = readline("Ingresa el documento del cliente a eliminar: " . "\n");

 
    $urlDeleteConDoc = $urlDelet . "/" . rawurlencode($Documento_Cliente);

    $proceso = curl_init($urlDeleteConDoc);
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
}

?>