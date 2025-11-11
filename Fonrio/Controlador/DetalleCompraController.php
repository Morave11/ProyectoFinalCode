<?php
require_once __DIR__ . '/../Modelo/DetalleCompraService.php';

class DetalleCompraController {
    private $detalleCompraService;

    public function __construct() {
        $this->detalleCompraService = new DetalleCompraService();
    }

    public function manejarPeticiondetallecompra() {
        $mensaje = "";
        $detallesCompra = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $method        = strtoupper(trim($_POST["_method"] ?? "POST"));
            $idEntrada     = trim($_POST["ID_Entrada"]     ?? '');
            $idProveedor   = trim($_POST["ID_Proveedor"]   ?? '');
            $cantidad      = trim($_POST["Cantidad"]       ?? '');
            $fechaEntrada  = trim($_POST["Fecha_Entrada"]  ?? '');

            
            if ($method === "POST") {
                $res = $this->detalleCompraService->agregarDetalleC($idEntrada, $idProveedor, $cantidad, $fechaEntrada);
                $mensaje = ($res["success"] ?? false)
                    ? "<p style='color:green;'>Detalle de compra agregado correctamente.</p>"
                    : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al agregar")."</p>";

            
            } elseif ($method === "PUT") {
                if ($idEntrada === "" || $idProveedor === "") {
                    $mensaje = "<p style='color:red;'>Debes enviar ID_Entrada e ID_Proveedor para actualizar.</p>";
                } else {
                    $data = array_filter([
                        "Cantidad"      => $cantidad,
                        "Fecha_Entrada" => $fechaEntrada
                    ], function($v) {
                        return !($v === "" || $v === null);
                    });

                    if (empty($data)) {
                        $mensaje = "<p style='color:red;'>No hay campos para actualizar.</p>";
                    } else {
                        $res = $this->detalleCompraService->actualizarDetalleC($idEntrada, $idProveedor, $data);
                        $mensaje = ($res["success"] ?? false)
                            ? "<p style='color:green;'>Detalle de compra actualizado correctamente.</p>"
                            : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al actualizar")." (HTTP ".htmlspecialchars((string)($res["http_code"] ?? "N/A")).")</p>";
                    }
                }

            
            } elseif ($method === "DELETE") {
                if ($idEntrada === "" || $idProveedor === "") {
                    $mensaje = "<p style='color:red;'>Debes enviar ID_Entrada e ID_Proveedor para eliminar.</p>";
                } else {
                    $res = $this->detalleCompraService->eliminarDetalleC($idEntrada, $idProveedor);
                    $mensaje = ($res["success"] ?? false)
                        ? "<p style='color:green;'>Detalle de compra eliminado correctamente.</p>"
                        : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al eliminar")." (HTTP ".htmlspecialchars((string)($res["http_code"] ?? "N/A")).")</p>";
                }
            }
        }

        
        $detallesCompra = $this->detalleCompraService->obtenerDetalleC() ?? [];

        
        include __DIR__ . "/../vista/detallecompra.php";
    }
}

