<?php  
require_once __DIR__ . '/../Modelo/ComprasService.php';

class ComprasController {
    private $comprasService;

    
    public function __construct() {
        
        $this->comprasService = new ComprasService();
    }

    public function manejarPeticioncompras() {
        $mensaje = "";
        $compras = [];

       
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $method = strtoupper(trim($_POST["_method"] ?? "POST"));
            $idEntrada          = trim($_POST["ID_Entrada"]         ?? '');
            $precioCompra      = trim($_POST["Precio_Compra"]      ?? '');
            $idProducto        = trim($_POST["ID_Producto"]        ?? '');
            $documentoEmpleado = trim($_POST["Documento_Empleado"] ?? '');

            if ($method === "PUT") {
                if ($idEntrada=== "") {
                    $mensaje = "<p style='color:red;'>Debes enviar el ID_Entrada para actualizar.</p>";
                } else {
                    $data = array_filter([
                        "Precio_Compra"      => $precioCompra,
                        "ID_Producto"        => $idProducto,
                        "Documento_Empleado" => $documentoEmpleado
                    ], function($v) {
    return !($v === "" || $v === null);
});
                    if (empty($data)) {
                        $mensaje = "<p style='color:red;'>No hay campos para actualizar.</p>";
                    } else {
                        $res = $this->comprasService->actualizarCompra($idEntrada, $data);
                        $mensaje = ($res["success"] ?? false)
                            ? "<p style='color:green;'>Compra actualizada correctamente.</p>"
                            : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al actualizar")." (HTTP ".htmlspecialchars((string)($res["http_code"] ?? "N/A")).")</p>";
                    }
                }

            } elseif ($method === "DELETE") { // Delete
                if ($idEntrada === "") {
                    $mensaje = "<p style='color:red;'>Debes enviar el ID_Entrada para eliminar.</p>";
                } else {
                    $res = $this->comprasService->eliminarCompra($idEntrada);
                    $mensaje = ($res["success"] ?? false)
                        ? "<p style='color:green;'>Compra eliminada correctamente.</p>"
                        : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al eliminar")." (HTTP ".htmlspecialchars((string)($res["http_code"] ?? "N/A")).")</p>";
                }
            } else { // POST (crear)
                if ($idEntrada === '' || $precioCompra === '' || $idProducto === '' || $documentoEmpleado === ''    ) {
                    $mensaje = "<p style='color:red;'>Todos los campos son obligatorios.</p>";
                } else {
                    $res = $this->comprasService->agregarCompra(
                        $idEntrada,
                        $precioCompra,
                        $idProducto,
                        $documentoEmpleado
                );
                $mensaje = ($res["success"] ?? false)
                    ? "<p style='color:green;'>Compra agregada correctamente.</p>"
                    : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al agregar")." (HTTP ".htmlspecialchars((string)($res["http_code"] ?? "N/A")).")</p>";
            }
        }
        }

        $compras = $this->comprasService->obtenerCompras() ?: [];
        require_once __DIR__ . '/../Vista/compras.php';
    }
}   