<?php
require_once __DIR__ . '/../Modelo/ClienteService.php';


class ClienteController {
    private $clientesService;

    public function __construct() {
        $this->clientesService = new ClienteService();
    }

    public function manejarPeticion() {
        $mensaje  = "";
        $clientes = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $method             = strtoupper(trim($_POST["_method"] ?? "POST"));
            $Documento_Cliente  = trim($_POST["Documento_Cliente"]  ?? "");
            $Nombre_Cliente     = trim($_POST["Nombre_Cliente"]     ?? "");
            $Apellido_Cliente   = trim($_POST["Apellido_Cliente"]   ?? "");
            $Telefono           = trim($_POST["Telefono"]           ?? "");
            $Fecha_Nacimiento   = trim($_POST["Fecha_Nacimiento"]   ?? "");
            $Genero             = trim($_POST["Genero"]             ?? "");
            $ID_Estado          = trim($_POST["ID_Estado"]          ?? "");

            if ($method === "PUT") {
                if ($Documento_Cliente === "") {
                    $mensaje = "<p style='color:red;'>Debes enviar el Documento_Cliente para actualizar.</p>";
                } else {
                    $data = [
                        "Nombre_Cliente"   => $Nombre_Cliente,
                        "Apellido_Cliente" => $Apellido_Cliente,
                        "Telefono"         => $Telefono,
                        "Fecha_Nacimiento" => $Fecha_Nacimiento,
                        "Genero"           => $Genero,
                        "ID_Estado"        => $ID_Estado,
                    ];

                    if (empty($data)) {
                        $mensaje = "<p style='color:red;'>No hay campos para actualizar.</p>";
                    } else {
                        $res = $this->clientesService->actualizarCliente($Documento_Cliente, $data);
                        $mensaje = ($res["success"] ?? false)
                            ? "<p style='color:green;'>Cliente actualizado correctamente.</p>"
                            : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al actualizar")." (HTTP ".htmlspecialchars((string)($res["http_code"] ?? "N/A")).")</p>";
                    }
                }

            } elseif ($method === "DELETE") {
                if ($Documento_Cliente === "") {
                    $mensaje = "<p style='color:red;'>Debes enviar el Documento_Cliente para eliminar.</p>";
                } else {
                    $res = $this->clientesService->eliminarCliente($Documento_Cliente);
                    $mensaje = ($res["success"] ?? false)
                        ? "<p style='color:green;'>Cliente eliminado correctamente.</p>"
                        : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al eliminar")." (HTTP ".htmlspecialchars((string)($res["http_code"] ?? "N/A")).")</p>";
                }

            } else { 
                if ($Documento_Cliente === "" || $Nombre_Cliente === "") {
                    $mensaje = "<p style='color:red;'>El Documento_Empleado y el Nombre_Usuario no pueden estar vacíos.</p>";
                } else {
                    $res = $this->clientesService->agregarCliente(
                        $Documento_Cliente, $Nombre_Cliente, $Apellido_Cliente,
                        $Telefono, $Fecha_Nacimiento, $Genero, $ID_Estado
                    );
                    $mensaje = ($res["success"] ?? false)
                        ? "<p style='color:green;'>Cliente agregado correctamente.</p>"
                        : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al crear")."</p>";
                }
            }
        }

        $clientes = $this->clientesService->obtenerClientes() ?: [];
        require_once __DIR__ . '/../Vista/indexc.php';

    }
}