<?php
include "./Config/config.php";

class ProductosService{
    private $apiURL = "http://localhost:8080/Productos";
    public function obtenerProductos(){
        $respuesta = @file_get_contents ($this->apiURL);
        if ($respuesta === false) return false; 
        return json_decode ($respuesta, true);
    }

    public function AgregarProductos ($ID_Producto){
        $data_json = json_encode(["ID_Producto" => $ID_Producto]);

        $proceso = curl_init($this -> apiURL);
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_json)
        ]);

    $respuestapet = curl_exec($proceso);
    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

    if(curl_errno($proceso)) {
        $error = curl_error($proceso);
        curl_close($proceso);
        return ["success" => false, "error" => $error];
    }

    curl_close($proceso);

    if ($http_code === 200){
        echo "Producto actualizado exitosamente: $respuestapet\n";
    } else {
        echo "Error al actualizar el producto. Código HTTP: $http_code \n";
        echo "Respuesta: $respuestapet\n";
}
    }
}



//cositas 


if ($consumo === false) {
    die("Error al consumir el servicio.");
}

$productos = json_decode($consumo);

foreach ($productos as $lista) {
    echo $lista . "\n";
}

$respuesta = readline("¿Desea registrar un nuevo producto? (s/n): ");
if($respuesta === 's'){
    $ID_Producto = readline("Ingrese el ID del producto: ");
    $Nombre_Producto = readline("Ingrese el nombre del producto: ");
    $Descripcion = readline("Ingrese la descripción: ");
    $Precio_Venta = readline("Ingrese el precio de venta: ");
    $Stock_Minimo = readline("Ingrese el stock mínimo: ");
    $ID_Categoria = readline("Ingrese el ID de la categoría: ");
    $ID_Estado = readline("Ingrese el ID del estado: ");
    $ID_Gama = readline("Ingrese el ID de la gama: ");

    $data = array(
        "ID_Producto" => $ID_Producto,
        "Nombre_Producto" => $Nombre_Producto,
        "Descripcion" => $Descripcion,
        "Precio_Venta" => $Precio_Venta,
        "Stock_Minimo" => $Stock_Minimo,
        "ID_Categoria" => $ID_Categoria,
        "ID_Estado" => $ID_Estado,
        "ID_Gama" => $ID_Gama
    );
    $data_json = json_encode($data);

    

    $respuestapeticion = curl_exec($proceso);
    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);
    curl_close($proceso);

    if ($http_code === 200){
        echo "Producto registrado exitosamente: $respuestapeticion\n";
    } else {
        echo "Error al registrar el producto. Código HTTP: $http_code\n";
        echo "Respuesta: $respuestapeticion\n";
    }
}

$respuestaPut = readline("¿Desea actualizar un producto existente? (s/n): ");
if($respuestaPut === 's'){
    $ID_Producto = readline("Ingrese el ID del producto a actualizar: ");
    $Nombre_Producto = readline("Ingrese el nuevo nombre del producto: ");
    $Descripcion = readline("Ingrese la nueva descripción: ");
    $Precio_Venta = readline("Ingrese el nuevo precio de venta: ");
    $Stock_Minimo = readline("Ingrese el nuevo stock mínimo: ");
    $ID_Categoria = readline("Ingrese el nuevo ID de la categoría: ");
    $ID_Estado = readline("Ingrese el nuevo ID del estado: ");
    $ID_Gama = readline("Ingrese el nuevo ID de la gama: ");

    $urlPut = $urlPutPro . "/" . rawurlencode($ID_Producto);

    $dataPut = array(
        "Nombre_Producto" => $Nombre_Producto,
        "Descripcion" => $Descripcion,
        "Precio_Venta" => $Precio_Venta,
        "Stock_Minimo" => $Stock_Minimo,
        "ID_Categoria" => $ID_Categoria,
        "ID_Estado" => $ID_Estado,
        "ID_Gama" => $ID_Gama
    );
    $data_jsonPut = json_encode($dataPut);

    $procesoPut = curl_init($urlPut);
    curl_setopt($procesoPut, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($procesoPut, CURLOPT_POSTFIELDS, $data_jsonPut);
    curl_setopt($procesoPut, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($procesoPut, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_jsonPut)
    ));

    $respuestaPut = curl_exec($procesoPut);
    $http_codePut = curl_getinfo($procesoPut, CURLINFO_HTTP_CODE);
    curl_close($procesoPut);

    if ($http_codePut === 200){
        echo "Producto actualizado exitosamente: $respuestaPut\n";
    } else {
        echo "Error al actualizar el producto. Código HTTP: $http_codePut\n";
        echo "Respuesta: $respuestaPut\n";
    }
}

$respuestaDel = readline("¿Desea eliminar un producto? (s/n): ");
if($respuestaDel === 's'){
    $ID_Producto = readline("Ingrese el ID del producto a eliminar: ");

    $urlDelete = $urlDeletePro . "/" . rawurlencode($ID_Producto);

    $procesoDel = curl_init($urlDelete);
    curl_setopt($procesoDel, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($procesoDel, CURLOPT_RETURNTRANSFER, true);

    $respuestaDel = curl_exec($procesoDel);
    $http_codeDel = curl_getinfo($procesoDel, CURLINFO_HTTP_CODE);
    curl_close($procesoDel);

    if ($http_codeDel === 200){
        echo "Producto eliminado exitosamente: $respuestaDel\n";
    } else {
        echo "Error al eliminar el producto. Código HTTP: $http_codeDel\n";
        echo "Respuesta: $respuestaDel\n";
    }
}

// pa que corra C:\xampp\php\php.exe C_Productos.php