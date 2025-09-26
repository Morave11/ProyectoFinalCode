<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link rel="icon" type="imagen" href="../Imagenes/Logo.webp">
<title>Recuperar contraseña</title>

<!-- Bootstrap para estilos base -->
<link href="../css/bootstrap.min.css" rel="stylesheet"/>

<link rel="stylesheet" href="../css/Rcontrasela.css">

<!-- Ícono del sitio -->
<link rel="icon" type="imagen" href="../Imagenes/Logo.webp">
</head>
<body>
<!-- Contenedor principal -->
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
    <div class="col-md-4">
        <div class="InicioI">
        <!-- Encabezado -->
        <div class="text-center mb-2">
            <h1>Recupere su contraseña</h1>
            <p>Ingrese el correo con el que se registro</p>
        </div>

        <!-- Formulario -->
        <form action="IniciarSesion.html" method="get">
            <!-- Campo Usuario -->
            <div class="mb-3">
            <label for="usuario" class="form-label">Correo</label>
            <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingrese su Correo Electrónico" required/>
            </div>

            <!-- Enviar correo -->
            <div class="d-grid">
            <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </form>
        </div>
    </div>
    </div>
</div>
</body>
</html> 