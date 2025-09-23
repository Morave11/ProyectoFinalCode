<?php 
require_once __DIR__ . '/Modelo/ProductosService.php';

class ProductoController {
    private $productosService;
    public function __construct(){
        $this -> productosService = new ProductosService();
}

public function manejarPeticion(){
    $mensaje="";
    if ($_SERVER["REQUEST_METHOD"] === "POST"){

        $nombre = trim ($_POST ["ID_Producto"] ?? '');

        if(!empty ($ID_Producto)){

            $resultado = $this -> productosService -> AgregarProductos($ID_Producto);
            if($resultado ["success"]){
                $mensaje = "<p style = 'color:green;' > Productos agregados correctamente. </p>";
            }
            else {
                $mensaje = "<p style='color:red;'>Error: " . $resultado ["Error"] . "</p>"; 
            }
        } else {
            $mensaje = "<p style = 'color:red;' >El Producto no puede estar vacio. </p>";
        }
    }

    $Productos = $this -> productosService -> obtenerProductos();

    require __DIR__ . '/../Vista/indexP.php';
}
}