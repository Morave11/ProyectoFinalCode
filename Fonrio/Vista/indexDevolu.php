<?php
// Variables esperadas
$mensaje = $mensaje ?? '';
$devoluciones = is_array($devoluciones ?? null) ? $devoluciones : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Devoluciones</title>

  <!-- Bootstrap + Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="stylesheet" href="../css/ventas.css" />
  <link rel="stylesheet" href="../css/compras.css" />
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
          <a href="RDevolucion.php" class="elemento-menu active">
            <i class="fa-solid fa-undo"></i><span>Devoluciones</span>
          </a>
          <a href="indexventas.php" class="elemento-menu">
            <i class="fa-solid fa-chart-line"></i><span>Ventas</span>
          </a>
        </div>
        <hr>
        <div class="seccion-menu">
          <a href="proveedor.php" class="elemento-menu">
            <i class="fa-solid fa-users"></i><span>Proveedores</span>
          </a>
          <a href="Productos.php" class="elemento-menu">
            <i class="fa-solid fa-boxes"></i><span>Productos</span>
          </a>
          
                                                 <a href="/indexdev.php" class="elemento-menu">
                        <i class="fas fa-users"></i>
                        <span>Devolucion</span>
                    </a>
                     <a class="elemento-menu d-flex align-items-center text-white text-decoration-none dropdown-toggle" 
     href="#" 
     id="rolesMenu" 
     role="button" 
     data-bs-toggle="dropdown" 
     aria-expanded="false">
    <i class="fas fa-user-friends me-2"></i><span>Roles</span>
  </a>
  <ul class="dropdown-menu" aria-labelledby="rolesMenu">
  <li><a class="dropdown-item" href="../indexcli.php">Cliente</a></li>
  <li><a class="dropdown-item" href="../Indexempleado.php">Empleado</a></li>
</ul>
        </div>
      </div>
    </div>

    <!-- CONTENIDO -->
    <div class="contenido-principal flex-grow-1">
      <!-- NAVBAR -->
      <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand">Sistema gestión de inventarios</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                  data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" 
                  aria-label="Toggle navigation">
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
          <h1 class="m-0">Registro de Devoluciones</h1>
        </div>

          <div class="text-center mt-3">
          <a href="/indexdetadevolu.php" class="btn btn-success">
            Detalle de Devolucion
          </a>
        </div>

       
      <!-- Mensajes -->
      <?= $mensaje ? "<div class='alert alert-info mt-3'>$mensaje</div>" : "" ?>


        <!-- TABLA DE DEVOLUCIONES -->
        <div class="mt-4">
          <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped align-middle">
              <thead class="table-dark text-center">
                <tr>
                  <th>ID Devolución</th>
                  <th>Fecha Devolución</th>
                  <th>Motivo</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($devoluciones)): ?>
                  <?php foreach ($devoluciones as $d): ?>
                    <?php
                      $partes = is_string($d) ? explode('________', $d) : [];
                      $ID_Devolucion    = htmlspecialchars($partes[0] ?? '');
                      $Fecha_Devolucion = htmlspecialchars($partes[1] ?? '');
                      $Motivo           = htmlspecialchars($partes[2] ?? '');
                    ?>
                    <tr>
                      <td><?= $ID_Devolucion ?></td>
                      <td><?= $Fecha_Devolucion ?></td>
                      <td><?= $Motivo ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="3" class="text-center text-muted">No hay devoluciones para mostrar.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- FORMULARIOS -->
        <div class="mt-5">
          <div class="row g-4">
            <!-- Crear -->
            <div class="col-md-6">
              <div class="card shadow-sm">
                <div class="card-body">
                  <h2 class="h4 mb-3">Agregar Devolución</h2>
                  <form method="POST" class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label">ID Devolución</label>
                      <input type="text" name="ID_Devolucion" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Fecha Devolución</label>
                      <input type="date" name="Fecha_Devolucion" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Motivo</label>
                      <input type="text" name="Motivo" class="form-control" required>
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
                  <h2 class="h4 mb-3">Actualizar Devolución</h2>
                  <form method="POST" class="row g-3">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="col-md-6">
                      <label class="form-label">ID Devolución (obligatorio)</label>
                      <input type="text" name="ID_Devolucion" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Fecha Devolución</label>
                      <input type="date" name="Fecha_Devolucion" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Motivo</label>
                      <input type="text" name="Motivo" class="form-control">
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
                  <h2 class="h4 mb-3">Eliminar Devolución</h2>
                  <form method="POST" class="row g-3">
                    <input type="hidden" name="_method" value="DELETE">
                    <div class="col-md-6">
                      <label class="form-label">ID Devolución</label>
                      <input type="text" name="ID_Devolucion" class="form-control" required>
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
    </div><!-- /contenido -->
  </div><!-- /d-flex -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
