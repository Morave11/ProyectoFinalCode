<?php
class ComprasService {
    // Ajusta los endpoints a lo que expone tu API
    private $apiUrlGet  = "http://localhost:8082/Compras";          // GET lista
    private $apiUrlPost = "http://localhost:8082/RegistroC";  // POST crear
    private $apiURLPut  = "http://localhost:8082/Compras";
    private $apiUrlDelete = "http://localhost:8082/ComprasE";

    // Obtener todas las compras
    public function obtenerCompras() {
        $respuesta = @file_get_contents($this->apiUrlGet);
        if ($respuesta === false) return false;
        return json_decode($respuesta, true);
    }

    // Agregar una compra
    public function agregarCompra(
        $ID_Entrada,
        $Precio_Compra,
        $ID_Producto,
        $Documento_Empleado
    ) {
        $data_json = json_encode([
            "ID_Entrada"         => $ID_Entrada,
            "Precio_Compra"      => $Precio_Compra,
            "ID_Producto"        => $ID_Producto,
            "Documento_Empleado" => $Documento_Empleado
        ], JSON_UNESCAPED_UNICODE);

        $proceso = curl_init($this->apiUrlPost);
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
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
            return ["success" => true];
        } else {
            return ["success" => false, "error" => "HTTP $http_code"];
        }
    }

    //Actualizar Compra 
    public function actualizarCompra($ID_Entrada, $data) {
        $url = $this->apiUrlPut . '/' . urlencode($ID_Entrada);
        $data_json = json_encode($data, JSON_UNESCAPED_UNICODE);

        $proceso = curl_init($url);
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);

        $respuesta = curl_exec($proceso);
        $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

        if (curl_errno($proceso)) {
            $error = curl_error($proceso);
            curl_close($proceso);
            return ["success" => false, "error" => $error];
        }

        curl_close($proceso);

        if ($http_code === 200) {
            return ["success" => true];
        } else {
            return ["success" => false, "error" => "HTTP $http_code"];
        }
    }

    // Eliminar una compra
    public function eliminarCompra($ID_Entrada) {
        $url = $this->apiUrlDelete . '/' . urlencode($ID_Entrada);
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