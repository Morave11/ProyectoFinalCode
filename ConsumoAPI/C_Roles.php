<?php

$urlpost = "http://localhost:8080/RolesR";
$url = "http://localhost:8080/Roles";

$consumo = file_get_contents($url);

if ($consumo === false) {
    die("Error al consumir el servicio.");
}

$Roles = json_decode($consumo);

foreach ($Roles as $Rol) {
    echo $Rol . "\n";
}

//Metodo post

$respuesta= readline("¿Deseas agregar un nuevo rol?, s para si, n para no: ");

if($respuesta === "s"){
    
    $id = readline("Ingresa el ID del nuevo rol (ej: ROL003): ". "\n");
    $nombre = readline("Ingresa el nombre del nuevo rol: ". "\n");

    
    $data = json_encode([
        "ID_Rol" => $id,
        "Nombre" => $nombre
    ], JSON_UNESCAPED_UNICODE);

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
        echo "Rol agregado exitosamente". "\n";
    }
    else{
        echo "Error al agregar el rol. Código HTTP: $http_code" . "\n";
    
}
}
