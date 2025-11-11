<?php
require_once __DIR__ . '/../Modelo/crudproducto.php';

class crudProductoController {
    private $productosService;

    public function __construct() {
        $this->productosService = new ProductosService();
    }

    public function manejarPeticion() {
        $mensaje   = "";
        $productos = [];

        $method = $_SERVER["REQUEST_METHOD"] === "POST"
            ? strtoupper(trim($_POST["_method"] ?? "POST"))
            : $_SERVER["REQUEST_METHOD"];

        $ID_Producto     = trim($_POST["ID_Producto"] ?? "");
        $Nombre_Producto = trim($_POST["Nombre_Producto"] ?? "");
        $Descripcion     = trim($_POST["Descripcion"] ?? "");
        $Precio_Venta    = trim($_POST["Precio_Venta"] ?? "");
        $Stock_Minimo    = trim($_POST["Stock_Minimo"] ?? "");
        $ID_Categoria    = trim($_POST["ID_Categoria"] ?? "");
        $ID_Estado       = trim($_POST["ID_Estado"] ?? "");
        $ID_Gama         = trim($_POST["ID_Gama"] ?? "");
        $Fotos           = trim($_POST["Fotos"] ?? "");

        if ($method === "PUT") {
            if ($ID_Producto === "") {
                $mensaje = "<p style='color:red;'>Debes enviar el ID_Producto para actualizar.</p>";
            } else {
                $data = array_filter([
                    "Nombre_Producto" => $Nombre_Producto,
                    "Descripcion"     => $Descripcion,
                    "Precio_Venta"    => $Precio_Venta,
                    "Stock_Minimo"    => $Stock_Minimo,
                    "ID_Categoria"    => $ID_Categoria,
                    "ID_Estado"       => $ID_Estado,
                    "ID_Gama"         => $ID_Gama,
                    "Fotos"           => $Fotos
                ], fn($v) => $v !== "");

                if (empty($data)) {
                    $mensaje = "<p style='color:red;'>No hay campos para actualizar.</p>";
                } else {
                    $res = $this->productosService->actualizarProducto($ID_Producto, $data);
                    $mensaje = ($res["success"] ?? false)
                        ? "<p style='color:green;'>Producto actualizado correctamente.</p>"
                        : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al actualizar")." (HTTP ".htmlspecialchars((string)($res["http_code"] ?? "N/A")).")</p>";
                }
            }

        } elseif ($method === "DELETE") {
            if ($ID_Producto === "") {
                $mensaje = "<p style='color:red;'>Debes enviar el ID del producto para eliminar.</p>";
            } else {
                $res = $this->productosService->eliminarProducto($ID_Producto);
                $mensaje = ($res["success"] ?? false)
                    ? "<p style='color:green;'>Producto eliminado correctamente.</p>"
                    : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al eliminar")."</p>";
            }

        } else { 
            if ($ID_Producto === "" || $Nombre_Producto === "") {
            } else {
                $res = $this->productosService->agregarProducto(
                    $ID_Producto,
                    $Nombre_Producto,
                    $Descripcion,
                    $Precio_Venta,
                    $Stock_Minimo,
                    $ID_Categoria,
                    $ID_Estado,
                    $ID_Gama,
                    $Fotos
                );
                $mensaje = ($res["success"] ?? false)
                    ? "<p style='color:green;'>Producto agregado correctamente.</p>"
                    : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al agregar")."</p>";
            }
        }

        $productos = $this->productosService->obtenerProductos() ?: [];
        require_once __DIR__ . '/../Vista/productos.php';
    }
}
?>
