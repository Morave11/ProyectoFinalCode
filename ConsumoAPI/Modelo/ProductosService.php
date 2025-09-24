<?php
class ProductosService {
    // Ajusta los endpoints a lo que expone tu API
    private $apiUrlGet    = "http://localhost:8080/Productos";   // GET lista
    private $apiUrlPost   = "http://localhost:8080/RegistroP";  // POST crear
    private $apiUrlPut    = "http://localhost:8080/ActualizaProd"; // PUT actualizar
    private $apiUrlDelete = "http://localhost:8080/EliminarPro";   // DELETE eliminar

    // Obtener todos los productos
    public function obtenerProductos() {
        $respuesta = @file_get_contents($this->apiUrlGet);
        if ($respuesta === false) return false;
        return json_decode($respuesta, true);
    }

    // Agregar un producto
    public function agregarProducto(
        $ID_Producto,
        $Nombre_Producto,
        $Precio_Venta,
        $Stock_Minimo,
        $Descripcion,
        $Fotos,
        $ID_Categoria,
        $ID_Estado,
        $ID_Gama
    ) {
        $data_json = json_encode([
            "ID_Producto"     => $ID_Producto,
            "Nombre_Producto" => $Nombre_Producto,
            "Precio_Venta"    => $Precio_Venta,
            "Stock_Minimo"    => $Stock_Minimo,
            "Descripcion"     => $Descripcion,
            "Fotos"           => $Fotos,
            "ID_Categoria"    => $ID_Categoria,
            "ID_Estado"       => $ID_Estado,
            "ID_Gama"         => $ID_Gama
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

        if ($http_code === 200 || $http_code === 201) {
            return ["success" => true, "response" => $respuesta];
        } else {
            return ["success" => false, "error" => "HTTP $http_code", "response" => $respuesta];
        }
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
            "success"  => ($http_code >= 200 && $http_code < 300),
            "http_code"=> $http_code,
            "response" => $respuesta
        ];
    }

    // Eliminar un producto
    public function eliminarProducto($ID_Producto) {
        $url = $this->apiUrlDelete . "/" . rawurlencode($ID_Producto);

        $proceso = curl_init($url);
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);

        $respuesta = curl_exec($proceso);
        $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

        if (curl_errno($proceso)) {
            $error = curl_error($proceso);
            curl_close($proceso);
            return ["success" => false, "error" => $error];
        }

        curl_close($proceso);

        return [
            "success"  => ($http_code >= 200 && $http_code < 300),
            "http_code"=> $http_code,
            "response" => $respuesta
        ];
    }
}