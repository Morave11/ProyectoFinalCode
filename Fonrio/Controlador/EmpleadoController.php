<?php
require_once __DIR__ . '/../Modelo/EmpleadoService.php';


class EmpleadoController {
    private $empleadoService;

    public function __construct() {
        $this->empleadoService = new EmpleadoService();
    }

    public function manejarPeticion() {
        $mensaje  = "";
        $empleado = [];

       
       
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $method                = strtoupper(trim($_POST["_method"] ?? "POST"));
            $Documento_Empleado    = trim($_POST["Documento_Empleado"]  ?? "");
            $Tipo_Documento        = trim($_POST["Tipo_Documento"]     ?? "");
            $Nombre_Usuario        = trim($_POST["Nombre_Usuario"]   ?? "");
            $Apellido_Usuario      = trim($_POST["Apellido_Usuario"]           ?? "");
            $Edad                  = trim($_POST["Edad"]   ?? "");
            $Correo_Electronico    = trim($_POST["Correo_Electronico"]             ?? "");
            $Telefono              = trim($_POST["Telefono"]   ?? "");
            $Genero                = trim($_POST["Genero"]           ?? "");
            $ID_Estado             = trim($_POST["ID_Estado"]   ?? "");
            $ID_Rol                = trim($_POST["ID_Rol"]             ?? "");
            $Fotos                 = trim($_POST["Fotos"]          ?? "");

            if ($method === "PUT") {
                if ($Documento_Empleado === "") {
                    $mensaje = "<p style='color:red;'>Debes enviar el Documento_Cliente para actualizar.</p>";
                } else {
                    $data =[
                    "Tipo_Documento"       => $Tipo_Documento,  
                    "Nombre_Usuario"        => $Nombre_Usuario,
                    "Apellido_Usuario"      => $Apellido_Usuario,
                    "Edad"                  => $Edad,
                    "Correo_Electronico"    => $Correo_Electronico,
                    "Telefono"              => $Telefono,
                    "Genero"                => $Genero,
                    "ID_Estado"             => $ID_Estado,
                    "ID_Rol"                => $ID_Rol,
                    "Fotos"                 => $Fotos,
   
                    ];

                    if (empty($data)) {
                        $mensaje = "<p style='color:red;'>No hay campos para actualizar.</p>";
                    } else {
                        $res = $this->empleadoService->actualizarEmpleado($Documento_Empleado, $data);
                        $mensaje = ($res["success"] ?? false)
                            ? "<p style='color:green;'>Empleado actualizado correctamente.</p>"
                            : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al actualizar")." (HTTP ".htmlspecialchars((string)($res["http_code"] ?? "N/A")).")</p>";
                    }
                }

            } elseif ($method === "DELETE") {
                if ($Documento_Empleado === "") {
                    $mensaje = "<p style='color:red;'>Debes enviar el Documento_Empleado para eliminar.</p>";
                } else {
                    $res = $this->empleadoService->eliminarEmpleado($Documento_Empleado);
                    $mensaje = ($res["success"] ?? false)
                        ? "<p style='color:green;'>empleado eliminado correctamente.</p>"
                        : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al eliminar")." (HTTP ".htmlspecialchars((string)($res["http_code"] ?? "N/A")).")</p>";
                }

            } else { 
                if ($Documento_Empleado === "" || $Nombre_Usuario === "") {
                    $mensaje = "<p style='color:red;'>El Documento_Empleado y el Nombre_Cliente no pueden estar vacíos.</p>";
                } else {
                    $res = $this->empleadoService->agregarEmpleado(
                        $Documento_Empleado,$Tipo_Documento,$Nombre_Usuario,$Apellido_Usuario,$Edad,$Correo_Electronico,$Telefono,$Genero,$ID_Estado,$ID_Rol,$Fotos
                    );
                    $mensaje = ($res["success"] ?? false)
                        ? "<p style='color:green;'>empleado agregado correctamente.</p>"
                        : "<p style='color:red;'>".htmlspecialchars($res["error"] ?? "Error al crear")."</p>";
                }
            }
        }

        $empleado = $this->empleadoService->obtenerEmpleados() ?: [];
        require_once __DIR__ . '/../Vista/indexEm.php';

    }
}