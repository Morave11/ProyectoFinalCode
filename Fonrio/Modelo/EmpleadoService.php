<?php
class EmpleadoService {

    private $apiUrlGet    = "http://localhost:8080/Empleados";      
    private $apiUrlPost   = "http://localhost:8080/EmpleadoRegistro";    
    private $apiUrlPut    = "http://localhost:8080/EmpleadoActualizar";  
    private $apiUrlDelete = "http://localhost:8080/EmpleadoEliminar";     


    public function obtenerEmpleados() {
        $respuesta = @file_get_contents($this->apiUrlGet);
        if ($respuesta === false) return false;
        return json_decode($respuesta, true);
    }

    public function agregarEmpleado(
        $Documento_Empleado,
        $Tipo_Documento,
        $Nombre_Usuario,
        $Apellido_Usuario,
        $Edad,
        $Correo_Electronico,
        $Telefono,
        $Genero,
        $ID_Estado,
        $ID_Rol,
        $Fotos
    ) {
        $data_json = json_encode([
            "Documento_Empleado"  => $Documento_Empleado,
            "Tipo_Documento"      => $Tipo_Documento,
            "Nombre_Usuario"      => $Nombre_Usuario,
            "Apellido_Usuario"    => $Apellido_Usuario,
            "Edad"                => $Edad,
            "Correo_Electronico"  => $Correo_Electronico,
            "Telefono"            => $Telefono,
            "Genero"              => $Genero,
            "ID_Estado"           => $ID_Estado,
            "ID_Rol"              => $ID_Rol,
            "Fotos"               => $Fotos,
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


    public function actualizarEmpleado($Documento_Empleado, $data) {
        $url = $this->apiUrlPut . "/" . rawurlencode($Documento_Empleado);
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


    public function eliminarEmpleado($Documento_Empleado) {
        $url = $this->apiUrlDelete . "/" . rawurlencode($Documento_Empleado);

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