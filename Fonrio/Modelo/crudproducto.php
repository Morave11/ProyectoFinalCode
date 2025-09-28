<?php
class ProductosService {

    private $apiUrlGet    = "http://localhost:8080/Productos";        // Obtener productos
    private $apiUrlPost   = "http://localhost:8080/RegistroP";       // Agregar producto
    private $apiUrlPut    = "http://localhost:8080/ActualizaProd";   // Actualizar producto
    private $apiUrlDelete = "http://localhost:8080/EliminarPro";    // Eliminar producto

    // Obtener todos los productos
    public function obtenerProductos() {
        $respuesta = @file_get_contents($this->apiUrlGet);
        if ($respuesta === false) return false;
        return json_decode($respuesta, true);
    }

    // Agregar un nuevo producto
    public function agregarProducto(
        $ID_Producto,
        $Nombre_Producto,
        $Descripcion,
        $Precio_Venta,
        $Stock_Minimo,
        $ID_Categoria,
        $ID_Estado,
        $ID_Gama,
        $Fotos
    ) {
        $data_json = json_encode([
            "ID_Producto"     => $ID_Producto,
            "Nombre_Producto" => $Nombre_Producto,
            "Descripcion"     => $Descripcion,
            "Precio_Venta"    => $Precio_Venta,
            "Stock_Minimo"    => $Stock_Minimo,
            "ID_Categoria"    => $ID_Categoria,
            "ID_Estado"       => $ID_Estado,
            "ID_Gama"         => $ID_Gama,
            "Fotos"           => $Fotos
        ], JSON_UNESCAPED_UNICODE);

        $proceso = curl_init($this->apiUrlPost);
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $respuesta = curl_exec($proceso);
        $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

        if (curl_errno($proceso)) {
            $error = curl_error($proceso);
            curl_close($proceso);
            return ["success" => false, "error" => $error];
        }

        curl_close($proceso);

        return ($http_code >= 200 && $http_code < 300)
            ? ["success" => true, "response" => $respuesta]
            : ["success" => false, "error" => "HTTP $http_code", "response" => $respuesta];
    }

    // Actualizar un producto
    public function actualizarProducto($ID_Producto, $data) {
        $url = $this->apiUrlPut . "/" . rawurlencode($ID_Producto);
        $data_json = json_encode($data, JSON_UNESCAPED_UNICODE);

        $proceso = curl_init($url);
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $respuesta = curl_exec($proceso);
        $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

        if (curl_errno($proceso)) {
            $error = curl_error($proceso);
            curl_close($proceso);
            return ["success" => false, "error" => $error];
        }

        curl_close($proceso);

        return [
            "success"   => ($http_code >= 200 && $http_code < 300),
            "http_code" => $http_code,
            "response"  => $respuesta
        ];
    }

    // Eliminar un producto
    public function eliminarProducto($id) {
    $url = $this->apiUrlDelete . '/' . urlencode($id);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code === 200) {
        return ["success" => true];
    } else {
        return ["success" => false, "error" => $response, "http_code" => $http_code];
    }
}

}
?>
