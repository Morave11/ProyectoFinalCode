<?php
class DetalleCompraService {
    
    private $apiUrlGet    = "http://localhost:8080/DetalleC";         
    private $apiUrlPost   = "http://localhost:8080/AgregarDetalleC";   
    private $apiUrlPut    = "http://localhost:8080/ActualizarDetalleC"; 
    private $apiUrlDelete = "http://localhost:8080/EliminarDetC";      

    
    public function obtenerDetalleC() {
        $respuesta = @file_get_contents($this->apiUrlGet);
        if ($respuesta === false) return false;
        return json_decode($respuesta, true);
    }

    
    public function agregarDetalleC($ID_Entrada, $ID_Proveedor, $Cantidad, $Fecha_Entrada) {
        $data_json = json_encode([
            "ID_Entrada"    => $ID_Entrada,
            "ID_Proveedor"  => $ID_Proveedor,
            "Cantidad"      => $Cantidad,
            "Fecha_Entrada" => $Fecha_Entrada
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

        return [
            "success" => ($http_code >= 200 && $http_code < 300),
            "http_code" => $http_code,
            "response" => $respuesta
        ];
    }

    
    public function actualizarDetalleC($ID_Entrada, $ID_Proveedor, $data) {
        $url = $this->apiUrlPut . '/' . rawurlencode($ID_Entrada) . '/' . rawurlencode($ID_Proveedor);
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

        return [
            "success" => ($http_code >= 200 && $http_code < 300),
            "http_code" => $http_code,
            "response" => $respuesta
        ];
    }

    
    public function eliminarDetalleC($ID_Entrada, $ID_Proveedor) {
        $url = $this->apiUrlDelete . '/' . rawurlencode($ID_Entrada) . '/' . rawurlencode($ID_Proveedor);

        $proceso = curl_init($url);
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "DELETE");
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

        return [
            "success"  => ($http_code >= 200 && $http_code < 300),
            "http_code"=> $http_code,
            "response" => $respuesta
        ];
    }
}

