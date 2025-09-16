<?php

$nombre = readline("Por favor, ingresa el nombre del empleado: ");


$url = "http://localhost:8080/Empleados";
$urlpost = "http://localhost:8080/EmpleadoRegistro";

$consumo = file_get_contents($url);

if ($consumo === FALSE) {
    die("Error al consumir el servicio.");
}

$Empleados = json_decode($consumo);

$encontrado = false;
foreach ($Empleados as $Empleado) 
    
    $campos = explode("________", $Empleado);

    

    if (stripos($campos[1], $nombre) !== false) {
        $encontrado = true;

        echo "------------------------\n";
        echo "Documento_Empleado: " . $campos[0] . "\n";
        echo "Tipo_Documento: " . $campos[1] . "\n";
        echo "Nombre_Usuario: " . $campos[2] . "\n";
        echo "Apellido_Usuario: " . $campos[3] . "\n";
        echo "Edad: " . $campos[4] . "\n";
        echo "Correo_electronico: " . $campos[5] . "\n";
        echo "Telefono: " . $campos[6] . "\n";
        echo "Genero". $campos[7] . "\n";
        echo "ID_Estado". $campos[8] . "\n";
        echo "ID_Rol". $campos[9] . "\n";
        echo "Fotos". $campos[10] . "\n";
    }

if (!$encontrado) {
    echo "Empleado no encontrado.\n";
}


//Metodo post


$respuesta= readline("¿Deseas agregar un nuevo Empleado?, s para si, n para no: ". "\n");

if($respuesta === "s"){

    $Documento_Empleado= readline("Ingresa su documento  ". "\n");
    $Tipo_Documento= readline("Ingresa el tipo  documento  ". "\n");
    $Nombre_Usuario= readline("Ingresa su nombre  ". "\n");
    $Apellido_Usuario= readline("Ingresa su apellido  ". "\n");
    $Edad= readline("Ingresa su edad  ". "\n");
    $Correo_electronico= readline("Ingresa  su correo electronico  ". "\n"); 
    $Telefono= readline("Ingresa su Telefono  ". "\n");
    $Genero= readline("Ingresa su Genero  ". "\n");
    $ID_Estado= readline("Ingresa el estado   ". "\n");
    $ID_Rol= readline("Ingresa su rol  ". "\n");
    $Fotos= readline("Ingresa su Foto  ". "\n");

    $data = json_encode([
       "Documento_Empleado"=> $Documento_Empleado,
       "Tipo_Documento"=> $Tipo_Documento,
       "Nombre_Usuario"=> $Nombre_Usuario,
       "Apellido_Usuario"=> $Apellido_Usuario,
       "Edad"=> $Edad,
       "Correo_electronico"=> $Correo_electronico,
       "Telefono"=> $Telefono,
       "Genero"=> $Genero,
       "ID_Estado"=> $ID_Estado,
       "ID_Rol"=> $ID_Rol,
       "Fotos"=> $Fotos], JSON_UNESCAPED_UNICODE);

       
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
?>
