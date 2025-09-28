<?php  
require_once __DIR__ . '/../Modelo/DevolucionService.php';

class DevolucionController {
    private $devolucionService;

    public function __construct() {
        $this->devolucionService = new DevolucionService();
    }

    public function manejarPeticionDevoluciones() {
        $mensaje = "";
        $devoluciones = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $method = strtoupper(trim($_POST["_method"] ?? "POST"));
            $ID_Devolucion    = trim($_POST["ID_Devolucion"]    ?? '');
            $Fecha_Devolucion = trim($_POST["Fecha_Devolucion"] ?? '');
            $Motivo           = trim($_POST["Motivo"]           ?? '');

            if ($method === "PUT") {
                if ($ID_Devolucion === "") {
                    $mensaje = "<p style='color:red;'>Debes enviar ID_Devolucion para actualizar.</p>";
                } else {
                    $data = array_filter([
                        "Fecha_Devolucion" => $Fecha_Devolucion,
                        "Motivo"           => $Motivo
                    ], function($v) { return !($v === "" || $v === null); });

                    if (empty($data)) {
                        $mensaje = "<p style='color:red;'>No hay campos para actualizar.</p>";
                    } else {
                        $res = $this->devolucionService->actualizarDevolucion($ID_Devolucion, $data);
                        $mensaje = ($res["success"] ?? false)
                            ? "<p style='color:green;'>Devolución actualizada correctamente.</p>"
                            : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al actualizar")." (HTTP ".htmlspecialchars((string)($res["http_code"] ?? "N/A")).")</p>";
                    }
                }

            } elseif ($method === "DELETE") {
                if ($ID_Devolucion === "") {
                    $mensaje = "<p style='color:red;'>Debes enviar ID_Devolucion para eliminar.</p>";
                } else {
                    $res = $this->devolucionService->eliminarDevolucion($ID_Devolucion);
                    $mensaje = ($res["success"] ?? false)
                        ? "<p style='color:green;'>Devolución eliminada correctamente.</p>"
                        : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al eliminar")." (HTTP ".htmlspecialchars((string)($res["http_code"] ?? "N/A")).")</p>";
                }

            } else { // POST
                if ($ID_Devolucion === '' || $Fecha_Devolucion === '' || $Motivo === '') {
                    $mensaje = "<p style='color:red;'>Todos los campos son obligatorios.</p>";
                } else {
                    $res = $this->devolucionService->agregarDevolucion($ID_Devolucion, $Fecha_Devolucion, $Motivo);
                    $mensaje = ($res["success"] ?? false)
                        ? "<p style='color:green;'>Devolución agregada correctamente.</p>"
                        : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al agregar")." (HTTP ".htmlspecialchars((string)($res["http_code"] ?? "N/A")).")</p>";
                }
            }
        }

        $devoluciones = $this->devolucionService->obtenerDevoluciones() ?: [];
        require_once __DIR__ . '/../Vista/indexDevolu.php';
    }
}
