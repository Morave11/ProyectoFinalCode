<?php
require_once __DIR__ . '/../Modelo/ProveedorService.php';

class ProveedorController {
    private $proveedorService;

    public function __construct() {
        $this->proveedorService = new ProveedorService();
    }

    public function manejarPeticionProveedor() {
        $mensaje    = "";
        $proveedores = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $method             = strtoupper(trim($_POST["_method"] ?? "POST"));

            
            $ID_Proveedor       = trim($_POST["ID_Proveedor"]       ?? "");
            $Nombre_Proveedor   = trim($_POST["Nombre_Proveedor"]   ?? "");
            $Correo_Electronico = trim($_POST["Correo_Electronico"] ?? "");
            $Telefono           = trim($_POST["Telefono"]           ?? "");
            $ID_Estado          = trim($_POST["ID_Estado"]          ?? "");

            if ($method === "PUT") {
                if ($ID_Proveedor === "") {
                    $mensaje = "<p style='color:red;'>Debes enviar el ID_Proveedor para actualizar.</p>";
                } else {
                    
                    $data = [
                        "Nombre_Proveedor"   => $Nombre_Proveedor,
                        "Correo_Electronico" => $Correo_Electronico,
                        "Telefono"           => $Telefono,
                        "ID_Estado"          => $ID_Estado
                    ];

                    if (empty($data)) {
                        $mensaje = "<p style='color:red;'>No hay campos para actualizar.</p>";
                    } else {
                        $res = $this->proveedorService->actualizarProveedor($ID_Proveedor, $data);
                        $mensaje = ($res["success"] ?? false)
                            ? "<p style='color:green;'>Proveedor actualizado correctamente.</p>"
                            : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al actualizar")."</p>";
                    }
                }

            } elseif ($method === "DELETE") {
                if ($ID_Proveedor === "") {
                    $mensaje = "<p style='color:red;'>Debes enviar el ID_Proveedor para eliminar.</p>";
                } else {
                    $res = $this->proveedorService->eliminarProveedor($ID_Proveedor);
                    $mensaje = ($res["success"] ?? false)
                        ? "<p style='color:green;'>Proveedor eliminado correctamente.</p>"
                        : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al eliminar")."</p>";
                }

            } else { 
                if ($ID_Proveedor === "" || $Nombre_Proveedor === "" || $Correo_Electronico === "" || $Telefono === "" || $ID_Estado === "") {
                    $mensaje = "<p style='color:red;'>Todos los campos son obligatorios: ID_Proveedor, Nombre_Proveedor, Correo_Electronico, Telefono e ID_Estado.</p>";
                } else {
                    $res = $this->proveedorService->agregarProveedor(
                        $ID_Proveedor,
                        $Nombre_Proveedor,
                        $Correo_Electronico,
                        $Telefono,
                        $ID_Estado
                    );
                    $mensaje = ($res["success"] ?? false)
                        ? "<p style='color:green;'>Proveedor registrado correctamente.</p>"
                        : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al crear")."</p>";
                }
            }
        }

        // Listado para la vista
        $proveedores = $this->proveedorService->obtenerProveedores() ?: [];

        // Render de la vista (ajusta el nombre del archivo si es distinto)
        require_once __DIR__ . '/../Vista/proveedor.php';
    }
}
