<?php  
require_once __DIR__ . '/../Modelo/DetaDevolucionService.php';

class DetaDevolucionController {
    private $detaDevolucionService;

    public function __construct() {
        $this->detaDevolucionService = new DetaDevolucionService();
    }

    public function manejarPeticionDevoluciones() {
        $mensaje = "";
        $devoluciones = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $method = strtoupper(trim($_POST["_method"] ?? "POST"));
            $idDetalleDev    = trim($_POST["ID_DetalleDev"]    ?? '');
            $idDevolucion    = trim($_POST["ID_Devolucion"]    ?? '');
            $cantidadDevuelta= trim($_POST["Cantidad_Devuelta"]?? '');
            $idVenta         = trim($_POST["ID_Venta"]         ?? '');

            if ($method === "PUT") {
                if ($idDevolucion === "" || $idVenta === "") {
                    $mensaje = "<p style='color:red;'>Debes enviar ID_Devolucion y ID_Venta para actualizar.</p>";
                } else {
                    $data = array_filter([
                        "ID_DetalleDev"     => $idDetalleDev,
                        "Cantidad_Devuelta" => $cantidadDevuelta,
                        "ID_Venta"          => $idVenta
                    ], function($v) {
                        return !($v === "" || $v === null);
                    });

                    if (empty($data)) {
                        $mensaje = "<p style='color:red;'>No hay campos para actualizar.</p>";
                    } else {
                        $res = $this->detaDevolucionService->actualizarEmpleado($idDevolucion, $idVenta, $data);
                        $mensaje = ($res["success"] ?? false)
                            ? "<p style='color:green;'>Detalle de devolución actualizado correctamente.</p>"
                            : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al actualizar")." (HTTP ".htmlspecialchars((string)($res["http_code"] ?? "N/A")).")</p>";
                    }
                }

            } elseif ($method === "DELETE") {
                if ($idDevolucion === "" || $idVenta === "") {
                    $mensaje = "<p style='color:red;'>Debes enviar ID_Devolucion y ID_Venta para eliminar.</p>";
                } else {
                    $res = $this->detaDevolucionService->eliminarEmpleado($idDevolucion, $idVenta);
                    $mensaje = ($res["success"] ?? false)
                        ? "<p style='color:green;'>Detalle de devolución eliminado correctamente.</p>"
                        : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al eliminar")." (HTTP ".htmlspecialchars((string)($res["http_code"] ?? "N/A")).")</p>";
                }

            } else { 
                if ($idDetalleDev === '' || $idDevolucion === '' || $cantidadDevuelta === '' || $idVenta === '') {
                    $mensaje = "<p style='color:red;'>Todos los campos son obligatorios.</p>";
                } else {
                    $res = $this->detaDevolucionService->agregarEmpleado(
                        $idDetalleDev,
                        $idDevolucion,
                        $cantidadDevuelta,
                        $idVenta
                    );
                    $mensaje = ($res["success"] ?? false)
                        ? "<p style='color:green;'>Detalle de devolución agregado correctamente.</p>"
                        : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al agregar")." (HTTP ".htmlspecialchars((string)($res["http_code"] ?? "N/A")).")</p>";
                }
            }
        }

        $devoluciones = $this->detaDevolucionService->obtenerEmpleados() ?: [];
        require_once __DIR__ . '/../Vista/indexdetaDev.php';
    }
}
