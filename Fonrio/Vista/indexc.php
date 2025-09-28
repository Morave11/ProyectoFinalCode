<?php
$mensaje  = $mensaje  ?? '';
$clientes = is_array($clientes ?? null) ? $clientes : [];

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Clientes</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="stylesheet" href="../css/menu.css" />
</head>
<body>
<div class="d-flex" style="min-height: 100vh;">

  <!-- SIDEBAR -->
  <div class="barra-lateral d-flex flex-column flex-shrink-0 p-3 bg-primary text-white">
    <a class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
      TECNICELL RM
    </a>
    <hr>
    <div class="menu-barra-lateral">
      <div class="seccion-menu">
        <a href="InicioA.php" class="elemento-menu">
          <i class="fa-solid fa-tachometer-alt"></i><span>Dashboard</span>
        </a>
        <a href="compra.php" class="elemento-menu">
          <i class="fa-solid fa-shopping-cart"></i><span>Compras</span>
        </a>
        <a href="RDevolucion.php" class="elemento-menu">
          <i class="fa-solid fa-undo"></i><span>Devoluciones</span>
        </a>
        <a href="indexventas.php" class="elemento-menu">
          <i class="fa-solid fa-chart-line"></i><span>Ventas</span>
        </a>
      </div>
      <hr>
      <div class="seccion-menu">
        <a href="/indexproveedor.php" class="elemento-menu">
          <i class="fas fa-users"></i>
          <span>Proveedores</span>
        </a>
        <a href="Productos.php" class="elemento-menu">
          <i class="fas fa-boxes"></i>
          <span>Productos</span>
        </a>
           <a href="/indexdev.php" class="elemento-menu">
                        <i class="fas fa-users"></i>
                        <span>Devolucion</span>
                    </a>
        <div class="dropdown">
          <a class="elemento-menu d-flex align-items-center text-white text-decoration-none dropdown-toggle" 
             href="#" id="rolesMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user-friends me-2"></i><span>Roles</span>
          </a>
          <ul class="dropdown-menu" aria-labelledby="rolesMenu">
            <li><a class="dropdown-item" href="../indexcli.php">Cliente</a></li>
            <li><a class="dropdown-item" href="../Indexempleado.php">Empleado</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- CONTENIDO PRINCIPAL -->
  <div class="contenido-principal flex-grow-1">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand">Sistema gestión de inventarios</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarNav" aria-controls="navbarNav" 
                aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav"></div>

        <div class="dropdown ms-auto">
          <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
             id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="fotos_empleados/6865b20c9ef22_Foto de carnet Mateo.jpeg"
                 alt="" width="32" height="32" class="rounded-circle me-2">
            <strong>Perfil</strong>
          </a>
          <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="Perfil.html">Mi perfil</a></li>
            <li><a class="dropdown-item" href="EditarPerfil.php">Editar perfil</a></li>
            <li><a class="dropdown-item" href="Registro.php">Registrarse</a></li>
            <li><a class="dropdown-item" href="Index.html">Cerrar Sesión</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- CABECERA -->
    <div class="container py-4">
      <div class="d-flex align-items-center justify-content-center gap-3">
        <img src="../Imagenes/Logo.webp" alt="Logo TECNICELL" style="height:48px; width:auto;" />
        <h1 class="m-0">Registro de Clientes</h1>
      </div>

      <!-- Mensajes -->
      <?= $mensaje ? "<div class='alert alert-info mt-3'>$mensaje</div>" : "" ?>

      <!-- TABLA -->
      <?php if (is_array($clientes) && !empty($clientes)): ?>
        <div class="table-responsive mt-4">
          <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-dark">
              <tr>
                <th>Documento</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Fecha Nac.</th>
                <th>Género</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($clientes as $c): 
                $partes = is_string($c) ? explode('________', $c) : [];
                $Documento_Cliente = $partes[0] ?? '';
                $Nombre_Cliente    = $partes[1] ?? '';
                $Apellido_Cliente  = $partes[2] ?? '';
                $Telefono          = $partes[3] ?? '';
                $Fecha_Nacimiento  = $partes[4] ?? '';
                $Genero            = $partes[5] ?? '';
                $ID_Estado         = $partes[6] ?? '';
              ?>
              <tr>
                <td><?= htmlspecialchars($Documento_Cliente) ?></td>
                <td><?= htmlspecialchars($Nombre_Cliente) ?></td>
                <td><?= htmlspecialchars($Apellido_Cliente) ?></td>
                <td><?= htmlspecialchars($Telefono) ?></td>
                <td><?= htmlspecialchars($Fecha_Nacimiento) ?></td>
                <td><?= htmlspecialchars($Genero) ?></td>
                <td><?= htmlspecialchars($ID_Estado) ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <p class="text-danger mt-4">No hay clientes para mostrar.</p>
      <?php endif; ?>
<!-- FORMULARIOS -->
<div class="row mt-5">
  <div class="row g-4">
    <!-- Crear -->
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h2 class="h4 mb-3">Añadir Cliente</h2>
          <form method="POST" class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Documento</label>
              <input type="text" name="Documento_Cliente" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Nombre</label>
              <input type="text" name="Nombre_Cliente" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Apellido</label>
              <input type="text" name="Apellido_Cliente" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Teléfono</label>
              <input type="text" name="Telefono" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Fecha Nacimiento</label>
              <input type="date" name="Fecha_Nacimiento" class="form-control">
            </div>
         <div class="col-md-6">
                    <label class="form-label">Género</label>
                    <select name="Genero" class="form-control" required>
                      <option value="">--Seleccione--</option>
                      <option value="F">Femenino</option>
                      <option value="M">Masculino</option>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Estado</label>
                    <select name="ID_Estado" class="form-control" required>
                      <option value="">--Seleccione--</option>
                      <option value="EST001">Activo</option>
                      <option value="EST002">Inactivo</option>
                      <option value="EST003">En proceso</option>
                    </select>
                  </div>
            <div class="col-12 text-center mt-3">
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Actualizar -->
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h2 class="h4 mb-3">Actualizar Cliente</h2>
          <form method="POST" class="row g-3">
            <input type="hidden" name="_method" value="PUT">
            <div class="col-md-6">
              <label class="form-label">Documento a actualizar</label>
              <input type="text" name="Documento_Cliente" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Nuevo Nombre</label>
              <input type="text" name="Nombre_Cliente" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Nuevo Apellido</label>
              <input type="text" name="Apellido_Cliente" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Nuevo Teléfono</label>
              <input type="text" name="Telefono" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Nueva Fecha Nac.</label>
              <input type="date" name="Fecha_Nacimiento" class="form-control">
            </div>
         <div class="col-md-6">
                    <label class="form-label">Género</label>
                    <select name="Genero" class="form-control" required>
                      <option value="">--Seleccione--</option>
                      <option value="F">Femenino</option>
                      <option value="M">Masculino</option>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Estado</label>
                    <select name="ID_Estado" class="form-control" required>
                      <option value="">--Seleccione--</option>
                      <option value="EST001">Activo</option>
                      <option value="EST002">Inactivo</option>
                      <option value="EST003">En proceso</option>
                    </select>
                  </div>
            <div class="col-12 text-center mt-3">
              <button type="submit" class="btn btn-warning">Actualizar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Eliminar -->
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h2 class="h4 mb-3">Eliminar Cliente</h2>
          <form method="POST" class="row g-3">
            <input type="hidden" name="_method" value="DELETE">
            <div class="col-md-6">
              <label class="form-label">Documento a eliminar</label>
              <input type="text" name="Documento_Cliente" class="form-control" required>
            </div>
            <div class="col-12 text-center mt-3">
              <button type="submit" class="btn btn-danger">Eliminar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div><!-- /row -->
</div><!-- /formularios -->

<footer class="footer mt-5 text-center text-muted">
  <p class="m-0">Copyright © 2025 Fonrio</p>
</footer>
</div><!-- /container -->
</div><!-- /contenido-principal -->
</div><!-- /d-flex -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>