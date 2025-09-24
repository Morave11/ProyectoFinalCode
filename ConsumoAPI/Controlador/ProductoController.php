<?php
require_once __DIR__ . '/../Modelo/ProductosService.php';

class ProductoController {
    private $productosService;

    public function __construct() {
        $this->productosService = new ProductosService();
    }

    public function manejarPeticion() {
        $mensaje   = "";
        $productos = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $method = strtoupper(trim($_POST["_method"] ?? "POST"));
            $idProducto  = trim($_POST["ID_Producto"]     ?? "");
            $nombre      = trim($_POST["Nombre_Producto"] ?? "");
            $precio      = trim($_POST["Precio_Venta"]    ?? "");
            $stock       = trim($_POST["Stock_Minimo"]    ?? "");
            $descripcion = trim($_POST["Descripcion"]     ?? "");
            $fotos       = trim($_POST["Fotos"]           ?? "");
            $idCategoria = trim($_POST["ID_Categoria"]    ?? "");
            $idEstado    = trim($_POST["ID_Estado"]       ?? "");
            $idGama      = trim($_POST["ID_Gama"]         ?? "");

            if ($method === "PUT") {
                if ($idProducto === "") {
                    $mensaje = "<p style='color:red;'>Debes enviar el ID_Producto para actualizar.</p>";
                } else {
                    $data = array_filter([
                        "Nombre_Producto" => $nombre,
                        "Precio_Venta"    => $precio,
                        "Stock_Minimo"    => $stock,
                        "Descripcion"     => $descripcion,
                        "Fotos"           => $fotos,
                        "ID_Categoria"    => $idCategoria,
                        "ID_Estado"       => $idEstado,
                        "ID_Gama"         => $idGama,
                    ], function($v) {
    return !($v === "" || $v === null);
});

                    if (empty($data)) {
                        $mensaje = "<p style='color:red;'>No hay campos para actualizar.</p>";
                    } else {
                        $res = $this->productosService->actualizarProducto($idProducto, $data);
                        $mensaje = ($res["success"] ?? false)
                            ? "<p style='color:green;'>Producto actualizado correctamente.</p>"
                            : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al actualizar")." (HTTP ".htmlspecialchars((string)($res["http_code"] ?? "N/A")).")</p>";
                    }
                }

            } elseif ($method === "DELETE") {
                if ($idProducto === "") {
                    $mensaje = "<p style='color:red;'>Debes enviar el ID_Producto para eliminar.</p>";
                } else {
                    $res = $this->productosService->eliminarProducto($idProducto);
                    $mensaje = ($res["success"] ?? false)
                        ? "<p style='color:green;'>Producto eliminado correctamente.</p>"
                        : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al eliminar")." (HTTP ".htmlspecialchars((string)($res["http_code"] ?? "N/A")).")</p>";
                }

            } else { // POST (crear)
                if ($idProducto === "" || $nombre === "") {
                    $mensaje = "<p style='color:red;'>El ID y el Nombre del producto no pueden estar vacíos.</p>";
                } else {
                    $res = $this->productosService->agregarProducto(
                        $idProducto, $nombre, $precio, $stock,
                        $descripcion, $fotos, $idCategoria, $idEstado, $idGama
                    );
                    $mensaje = ($res["success"] ?? false)
                        ? "<p style='color:green;'>Producto agregado correctamente.</p>"
                        : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al crear")."</p>";
                }
            }
        }

        $productos = $this->productosService->obtenerProductos() ?: [];
        require __DIR__ . '/../Vista/indexP.php';
    }
}
