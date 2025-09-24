<?php
class VentaService {

    private $apiUrlGet    = "http://localhost:8080/Ventas";            
    private $apiUrlPost   = "http://localhost:8080/VentaRegistro";      
    private $apiUrlPut    = "http://localhost:8080/VentaActualizar";    
    private $apiUrlDelete = "http://localhost:8080/VentaEliminar";      


    public function obtenerVentas() {
        $respuesta = @file_get_contents($this->apiUrlGet);
        if ($respuesta === false) return false;
        return json_decode($respuesta, true);
    }


    public function agregarVenta($ID_Venta, $Documento_Cliente, $Documento_Empleado) {
        $data_json = json_encode([
            "ID_Venta"          => $ID_Venta,
            "Documento_Cliente" => $Documento_Cliente,
            "Documento_Empleado"=> $Documento_Empleado
        ], JSON_UNESCAPED_UNICODE);

        $proceso = curl_init($this->apiUrlPost);
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

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


    public function actualizarVenta($ID_Venta, $data) {
        $url = $this->apiUrlPut . "/" . rawurlencode($ID_Venta);
        $data_json = json_encode($data, JSON_UNESCAPED_UNICODE);

        $proceso = curl_init($url);
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

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


    public function eliminarVenta($ID_Venta) {
        $url = $this->apiUrlDelete . "/" . rawurlencode($ID_Venta);

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
            "success"   => ($http_code >= 200 && $http_code < 300),
            "http_code" => $http_code,
            "response"  => $respuesta
        ];
    }
}
