<?php
class ProveedorService {

    
    private $apiUrlGet    = "http://localhost:8080/Proveedor";
    private $apiUrlPost   = "http://localhost:8080/ProveeReg";
    private $apiUrlPut    = "http://localhost:8080/ActualizaProv";
    private $apiUrlDelete = "http://localhost:8080/EliminarProve";

    public function obtenerProveedores() {
        $ch = curl_init($this->apiUrlGet);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $resp = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err  = curl_errno($ch) ? curl_error($ch) : null;
        curl_close($ch);

        if ($err || $code < 200 || $code >= 300 || !$resp) {
            return [];
        }

        $json = json_decode($resp, true);


       
        if (is_array($json) && isset($json[0]) && is_string($json[0])) {
            $out = [];
            foreach ($json as $linea) {
                $p = explode('________', (string)$linea);
                $out[] = [
                    'ID_Proveedor'       => $p[0] ?? '',
                    'Nombre_Proveedor'   => $p[1] ?? '',
                    'Correo_Electronico' => $p[2] ?? '',
                    'Telefono'           => $p[3] ?? '',
                    'ID_Estado'          => $p[4] ?? '',
                ];
            }
            return $out;
        }

        return [];
    }

    public function agregarProveedor($ID_Proveedor, $Nombre_Proveedor, $Correo_Electronico, $Telefono, $ID_Estado) {
        $data_json = json_encode([
            "ID_Proveedor"       => $ID_Proveedor,
            "Nombre_Proveedor"   => $Nombre_Proveedor,
            "Correo_Electronico" => $Correo_Electronico,
            "Telefono"           => $Telefono,
            "ID_Estado"          => $ID_Estado
        ], JSON_UNESCAPED_UNICODE);

        $ch = curl_init($this->apiUrlPost);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        $resp = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            return ["success" => false, "error" => $error];
        }

        curl_close($ch);
        return ($code >= 200 && $code < 300)
            ? ["success" => true, "response" => $resp]
            : ["success" => false, "error" => "HTTP $code", "response" => $resp];
    }

    public function actualizarProveedor($ID_Proveedor, $data) {
        $url = $this->apiUrlPut . "/" . rawurlencode($ID_Proveedor);
        $data_json = json_encode($data, JSON_UNESCAPED_UNICODE);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        $resp = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            return ["success" => false, "error" => $error];
        }

        curl_close($ch);
        return [
            "success"   => ($code >= 200 && $code < 300),
            "http_code" => $code,
            "response"  => $resp
        ];
    }

    public function eliminarProveedor($ID_Proveedor) {
        $url = $this->apiUrlDelete . "/" . rawurlencode($ID_Proveedor);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $resp = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            return ["success" => false, "error" => $error];
        }

        curl_close($ch);
        return [
            "success"   => ($code >= 200 && $code < 300),
            "http_code" => $code,
            "response"  => $resp
        ];
    }
}
