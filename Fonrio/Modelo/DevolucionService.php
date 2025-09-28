<?php
class DevolucionService {

    private $apiUrlGet    = "http://localhost:8080/Devoluciones";      
    private $apiUrlPost   = "http://localhost:8080/AgregarDevolucion";    
    private $apiUrlPut    = "http://localhost:8080/ActualizarD";  
    private $apiUrlDelete = "http://localhost:8080/EliminarDev";     

    public function obtenerDevoluciones() {
        $respuesta = @file_get_contents($this->apiUrlGet);
        if ($respuesta === false) return false;
        return json_decode($respuesta, true);
    }

    public function agregarDevolucion($ID_Devolucion, $Fecha_Devolucion, $Motivo) {
        $data_json = json_encode([
            "ID_Devolucion"   => $ID_Devolucion,
            "Fecha_Devolucion"=> $Fecha_Devolucion,
            "Motivo"          => $Motivo
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

    public function actualizarDevolucion($ID_Devolucion, $data) {
        $url = $this->apiUrlPut . "/" . rawurlencode($ID_Devolucion);
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

    public function eliminarDevolucion($ID_Devolucion) {
        $url = $this->apiUrlDelete . "/" . rawurlencode($ID_Devolucion);

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
