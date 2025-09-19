<?php
include("../php/conexion.php");
$mensaje = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombres    = trim($_POST["nombres"]);
    $apellidos  = trim($_POST["apellidos"]);
    $tipo_doc   = $_POST["tipodocumento"];
    $num_doc    = trim($_POST["numerodocumento"]);
    $edad       = (int)$_POST["edad"];
    $genero     = ($_POST["sexo"] === "femenino") ? "F" : "M";
    $correo     = trim($_POST["correo"]);
    $telefono   = trim($_POST["telefono"]);
    $rol        = ($_POST["rol"] === "Administrador") ? "ROL001" : "ROL002";
    $estado     = "EST001";


    $foto_nombre = "";
    if(isset($_FILES["fotografia"]) && $_FILES["fotografia"]["error"] == 0){
        $carpeta = "../fotos_empleados/";
        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }
        $foto_nombre = $carpeta . uniqid() . "_" . basename($_FILES["fotografia"]["name"]);
        move_uploaded_file($_FILES["fotografia"]["tmp_name"], $foto_nombre);
    }

    $password_hash = password_hash($_POST["contraseña"], PASSWORD_DEFAULT);


    $sql_emp = "INSERT INTO empleados 
        (Documento_Empleado, Tipo_Documento, Nombre_Usuario, Apellido_Usuario, Edad, Correo_Electronico, Telefono, Genero, ID_Estado, ID_Rol, Fotos) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql_emp);
    $stmt->bind_param(
        "ssssissssss", 
        $num_doc, $tipo_doc, $nombres, $apellidos, $edad, $correo, $telefono, $genero, $estado, $rol, $foto_nombre
    );

    if($stmt->execute()){
        $sql_pass = "INSERT INTO contrasenas (Documento_Empleado, Contrasena_Hash) VALUES (?, ?)";
        $stmt2 = $conexion->prepare($sql_pass);
        $stmt2->bind_param("ss", $num_doc, $password_hash);
        $stmt2->execute();

        $mensaje = "<div class='alert alert-success'>Registro exitoso. ¡Ya puedes iniciar sesión!</div>";
        echo "<script>setTimeout(function(){ window.location = '../php/Login.php'; }, 2000);</script>";
    } else {
        $mensaje = "<div class='alert alert-danger'>Error: ".$stmt->error."</div>";
    }
}

echo $mensaje;
?>
