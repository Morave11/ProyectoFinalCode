<?php
class DetaDevolucionService {

    private $apiUrlGet    = "http://localhost:8080/DetalleD";      
    private $apiUrlPost   = "http://localhost:8080/AgregarDetalleD";    
    private $apiUrlPut    = "http://localhost:8080/ActualizarDetalleD";  
    private $apiUrlDelete = "http://localhost:8080/EliminarDetD";     

    // Obtener todos los registros
    public function obtenerEmpleados() {
        $respuesta = @file_get_contents($this->apiUrlGet);
        if ($respuesta === false) return false;
        return json_decode($respuesta, true);
    }

    // Agregar un registro
    public function agregarEmpleado($ID_DetalleDev, $ID_Devolucion, $Cantidad_Devuelta, $ID_Venta) {
        $data_json = json_encode([
            "ID_DetalleDev"      => $ID_DetalleDev,
            "ID_Devolucion"      => $ID_Devolucion,
            "Cantidad_Devuelta"  => $Cantidad_Devuelta,
            "ID_Venta"           => $ID_Venta,
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

    // Actualizar un registro
    public function actualizarEmpleado($ID_Devolucion, $ID_Venta, $data) {
        $url = $this->apiUrlPut . "/" . rawurlencode($ID_Devolucion) . "/" . rawurlencode($ID_Venta);
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

    // Eliminar un registro
    public function eliminarEmpleado($ID_Devolucion, $ID_Venta) {
        $url = $this->apiUrlDelete . "/" . rawurlencode($ID_Devolucion) . "/" . rawurlencode($ID_Venta);

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