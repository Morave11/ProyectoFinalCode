<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Editar Perfil</title>
<!-- Bootstrap CSS -->
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/EdPerfil.css" rel="stylesheet">
<link rel="icon" type="image/webp" href="../Imagenes/Logo.webp">
</head>

<body>
<!-- Logo fijo -->
<img src="../Imagenes/Logo.webp" alt="Logo" class="logo">

<div class="header p-2 text-white text-center" style= "background-color: #778ee9">
    <h1 class="h1 mb-0">Editar Perfil</h1>
</div>

<div class="container mt-4">
    <div class="row justify-content-center">
    <div class="col-md-6">

        <!-- Card de Registro -->
        <div class="card shadow-sm mb-4">
        <div class="card-body">

            <form action="#" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="nombres" class="form-label">Nombres</label>
                <input type="text" id="nombres" name="nombres" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" class="form-control" required>
            </div>

            <div class="row">
                <div class="mb-3 col-md-6">
                <label for="tipodocumento" class="form-label">Tipo de Documento</label>
                <select id="tdocumento" name="tipodocumento" class="form-select" required>
                    <option value="">Seleccione...</option>
                    <option value="CC">Cédula de Ciudadanía (CC)</option>
                    <option value="CE">Cédula de Extranjería (CE)</option>
                    <option value="PP">Pasaporte (PP)</option>
                </select>
                </div>
                <div class="mb-3 col-md-6">
                <label for="numerodocumento" class="form-label">N° de Documento</label>
                <input type="number" id="ndocumento" name="numerodocumento" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <div class="mb-3 col-md-4">
                <label for="edad" class="form-label">Edad</label>
                <input type="number" id="edad" name="edad" class="form-control" min="0" required>
                </div>

                <div class="mb-3 col-md-8">
                <label for="genero" class="form-label">Género</label>
                <select id="genero" name="sexo" class="form-select" required>
                    <option value="">Seleccione...</option>
                    <option value="femenino">Femenino</option>
                    <option value="masculino">Masculino</option>
                </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input type="email" id="correo" name="correo" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Número Telefónico</label>
                <input type="tel" id="telefono" name="telefono" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="rol" class="form-label">Selecciona tu rol</label>
                <select id="rol" name="rol" class="form-select" required>
                <option value="">Seleccione...</option>
                <option value="Empleado">Empleado</option>
                <option value="Administrador">Administrador</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="fotografia" class="form-label">Fotografía</label>
                <input type="file" id="fotografia" name="fotografia" class="form-control" required accept="image/*">
            </div>

            <div class="row">
                <div class="mb mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" id="password" name="contraseña" class="form-control" required>
                </div>
            </div>

            <!-- Botón Registrarse -->
            <div class="d-grid">
                <button href="IniciarSesion.html" type="submit" class="btn">Guardar</button>
            </div>
            </form>

        </div>
        </div>

    </div>
    </div>
</div>
<!-- Footer -->
<footer class="footer">
    <p>Copyright © 2025 Fonrio</p>
</footer>
</body>
</html>