<?php
require_once __DIR__ . '/../Modelo/VentaService.php';

class VentaController {
    private $ventasService;

    public function __construct() {
        $this->ventasService = new VentaService();
    }

    public function manejarPeticionVenta() {
        $mensaje = "";
        $ventas  = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $method            = strtoupper(trim($_POST["_method"] ?? "POST"));
            $ID_Venta          = trim($_POST["ID_Venta"] ?? "");
            $Documento_Cliente = trim($_POST["Documento_Cliente"] ?? "");
            $Documento_Empleado= trim($_POST["Documento_Empleado"] ?? "");


            if ($method === "PUT") {
                if ($ID_Venta === "") {
                    $mensaje = "<p style='color:red;'>Debes enviar el ID_Venta para actualizar.</p>";
                } else {
                    $data = array_filter([
                        "Documento_Cliente" => $Documento_Cliente,
                        "Documento_Empleado"=> $Documento_Empleado
                    ], function($v) { return !($v === "" || $v === null); });

                    if (empty($data)) {
                        $mensaje = "<p style='color:red;'>No hay campos para actualizar.</p>";
                    } else {
                        $res = $this->ventasService->actualizarVenta($ID_Venta, $data);
                        $mensaje = ($res["success"] ?? false)
                            ? "<p style='color:green;'>Venta actualizada correctamente.</p>"
                            : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al actualizar")."</p>";
                    }
                }
            } 
            
            elseif ($method === "DELETE") {
                if ($ID_Venta === "") {
                    $mensaje = "<p style='color:red;'>Debes enviar el ID_Venta para eliminar.</p>";
                } else {
                    $res = $this->ventasService->eliminarVenta($ID_Venta);
                    $mensaje = ($res["success"] ?? false)
                        ? "<p style='color:green;'>Venta eliminada correctamente.</p>"
                        : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al eliminar")."</p>";
                }
            } else {
                if ($ID_Venta === "" || $Documento_Cliente === "" || $Documento_Empleado === "") {
                    $mensaje = "<p style='color:red;'>Todos los campos son obligatorios.</p>";
                } else {
                    $res = $this->ventasService->agregarVenta($ID_Venta, $Documento_Cliente, $Documento_Empleado);
                    $mensaje = ($res["success"] ?? false)
                        ? "<p style='color:green;'>Venta registrada correctamente.</p>"
                        : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al crear")."</p>";
                }
            }
        }

        $ventas = $this->ventasService->obtenerVentas() ?: [];
        require_once __DIR__ . '/../Vista/indexv.php';
    }
}
