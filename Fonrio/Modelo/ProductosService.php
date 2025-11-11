<?php
class ProductosService {
    private $apiUrlGet    = "http://localhost:8080/Productos";   
    private $apiUrlPost   = "http://localhost:8080/RegistroP";  
    private $apiUrlPut    = "http://localhost:8080/ActualizaProd"; 
    private $apiUrlDelete = "http://localhost:8080/EliminarPro";   

    private $jwtToken = "eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJhZG1pbiIsImlhdCI6MTc1OTQ0MTU2OSwiZXhwIjoxNzU5NDQ1MTY5fQ.nUHy5ontSShI2Ao5lhH1BgEYK4srhfiDrQKyziLp0D0";

    
    public function obtenerProductos() {

        $headers = [
    "Authorization: Bearer " . $this->jwtToken
];

    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => implode("\r\n", $headers)
        ]
    ]);

        $respuesta = @file_get_contents($this->apiUrlGet, false, $context);
        if ($respuesta === false) return false;
        return json_decode($respuesta, true);
    }

    
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
        'Content-Type: application/json',
        'Authorization: Bearer ' . $this->jwtToken
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

    
    public function actualizarProducto($ID_Producto, $data) {
        $url = $this->apiUrlPut . "/" . rawurlencode($ID_Producto);
        $data_json = json_encode($data, JSON_UNESCAPED_UNICODE);

        $proceso = curl_init($url);
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $this->jwtToken
        ]);
;

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

    
    public function eliminarProducto($ID_Producto) {
        $url = $this->apiUrlDelete . "/" . rawurlencode($ID_Producto);

        $proceso = curl_init($url);
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $this->jwtToken
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
}