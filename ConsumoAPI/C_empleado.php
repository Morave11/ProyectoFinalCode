
<?php
include "./Config/config.php";

$consumo = file_get_contents($urlemp);

if ($consumo === FALSE) {
    die("Error al consumir el servicio.");
}

$Empleados = json_decode($consumo);


foreach ($Empleados as $Empleado) {
       echo $Empleado ."\n";
  

}

echo "\n=== MENÚ DE OPCIONES ===\n";
echo "1. Registrar  empleado\n";
echo "2. Actualizar  empleado\n";
echo "3. Eliminar  empleado\n";

$opcion = readline("Seleccione una opción: ");

switch ($opcion) {
 case "1":
//Metodo post
    $Documento_Empleado= readline("Ingresa su documento  ". "\n");
    $Tipo_Documento= readline("Ingresa el tipo  documento  ". "\n");
    $Nombre_Usuario= readline("Ingresa su nombre  ". "\n");
    $Apellido_Usuario= readline("Ingresa su apellido  ". "\n");
    $Edad= readline("Ingresa su edad  ". "\n");
    $Correo_Electronico= readline("Ingresa  su correo electronico  ". "\n"); 
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
       "Correo_Electronico"=> $Correo_Electronico,
       "Telefono"=> $Telefono,
       "Genero"=> $Genero,
       "ID_Estado"=> $ID_Estado,
       "ID_Rol"=> $ID_Rol,
       "Fotos"=> $Fotos], JSON_UNESCAPED_UNICODE);

       
    $proceso = curl_init($urlpostemp);
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
        echo "Empleado agregado exitosamente". "\n";
    }
    else{
        echo "Error al agregar el cliente. Código HTTP: $http_code" . "\n";
 }
    break; 

case "2":   
//metodo put


    $Documento_Empleado= readline("Ingresa el documento del empleado que quieres actualizar  ". "\n");
    $Tipo_Documento= readline("Ingresa el tipo  documento  ". "\n");
    $Nombre_Usuario= readline("Ingrese el nombre que desea actualizar  ". "\n");
    $Apellido_Usuario= readline("Ingrese el apellido que desea actualizar  ". "\n");
    $Edad= readline("Ingresa su edad  ". "\n");
    $Correo_Electronico= readline("Ingresa  su nuevo correo electronico  ". "\n"); 
    $Telefono= readline("Ingresa la nueva actualizacion del Telefono  ". "\n");
    $Genero= readline("Ingresa el Genero  ". "\n");
    $ID_Estado= readline("Ingresa el estado   ". "\n");
    $ID_Rol= readline("Ingresa su rol  ". "\n");
    $Fotos= readline("Ingresa su Foto  ". "\n");

    $data = json_encode([
   "Documento_Empleado"=> $Documento_Empleado,
   "Tipo_Documento"=> $Tipo_Documento,
   "Nombre_Usuario"=> $Nombre_Usuario,
   "Apellido_Usuario"=> $Apellido_Usuario,
   "Edad"=> $Edad,
   "Correo_Electronico"=> $Correo_Electronico,
   "Telefono"=> $Telefono,
   "Genero"=> $Genero,
   "ID_Estado"=> $ID_Estado,
   "ID_Rol"=> $ID_Rol,
   "Fotos"=> $Fotos], JSON_UNESCAPED_UNICODE);

        
    $urlPutConDoc = $urlputemp . "/" . rawurlencode($Documento_Empleado);

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
        echo "empleado actualizado exitosamente". "\n";
    }
    else{
        echo "Error al actualizar el empleado. Código HTTP: $http_code" . "\n";
    
 }
    break; 

case "3":
    
//Metodo Delete
$Documento_Empleado= readline("Ingresa el documento del empleado que quiere eliminar  ". "\n");

 $urlDeleteConDoc = $urlDeletemp . "/" . rawurlencode($Documento_Empleado);



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
        echo "empleado eliminado exitosamente" . "\n";
    } else {
        echo "Error al eliminar el empleado. Código HTTP: $http_code" . "\n";
     }
    break;

default:
    echo "Opción no válida\n";
    break;
}
?>