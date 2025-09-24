<?php
class ClienteService {
    // Ajusta los endpoints a lo que expone tu API
    private $apiUrlGet    = "http://localhost:8080/Detalles";        // GET lista
    private $apiUrlPost   = "http://localhost:8080/RegistraC";       // POST crear
    private $apiUrlPut    = "http://localhost:8080/ActualizarC";    // PUT actualizar
    private $apiUrlDelete = "http://localhost:8080/EliminarC";     // DELETE eliminar

    // Obtener todos los clientes
    public function obtenerClientes() {
        $respuesta = @file_get_contents($this->apiUrlGet);
        if ($respuesta === false) return false;
        return json_decode($respuesta, true);
    }

    // Agregar un cliente
    public function agregarCliente(
        $Documento_Cliente,
        $Nombre_Cliente,
        $Apellido_Cliente,
        $Telefono,
        $Fecha_Nacimiento,
        $Genero,
        $ID_Estado
    ) {
        $data_json = json_encode([
            "Documento_Cliente" => $Documento_Cliente,
            "Nombre_Cliente"    => $Nombre_Cliente,
            "Apellido_Cliente"  => $Apellido_Cliente,
            "Telefono"          => $Telefono,
            "Fecha_Nacimiento"  => $Fecha_Nacimiento,
            "Genero"            => $Genero,
            "ID_Estado"         => $ID_Estado
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

    // Actualizar un cliente
    public function actualizarCliente($Documento_Cliente, $data) {
        $url = $this->apiUrlPut . "/" . rawurlencode($Documento_Cliente);
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

    // Eliminar un cliente
    public function eliminarCliente($Documento_Cliente) {
        $url = $this->apiUrlDelete . "/" . rawurlencode($Documento_Cliente);

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