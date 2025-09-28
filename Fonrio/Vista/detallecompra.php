<?php
// Variables esperadas
$mensaje = $mensaje ?? '';
$detallesCompra = is_array($detallesCompra ?? null) ? $detallesCompra : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Detalle Compras</title>

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
          <a href="proveedor.php" class="elemento-menu">
            <i class="fa-solid fa-users"></i><span>Proveedores</span>
          </a>
          <a href="Productos.php" class="elemento-menu">
            <i class="fa-solid fa-boxes"></i><span>Productos</span>
          </a>
          <div class="elemento-menu">
            <i class="fas fa-user-friends"></i><span>Usuarios</span>
          </div>
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
          <h1 class="m-0">Registro de Detalle Compras</h1>
        </div>

        <!-- Mensajes -->
        <?php if (!empty($mensaje)): ?>
          <div class="mt-3"><?= $mensaje ?></div>
        <?php endif; ?>

        <!-- TABLA DE DETALLE COMPRAS -->
        <div class="mt-4">
          <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped align-middle">
              <thead class="table-dark text-center">
                <tr>
                  <th>ID Entrada</th>
                  <th>ID Proveedor</th>
                  <th>Cantidad</th>
                  <th>Fecha Entrada</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($detallesCompra)): ?>
                  <?php foreach ($detallesCompra as $d): ?>
                    <?php
                      $partes = is_string($d) ? explode('________', $d) : [];
                      $ID_Entrada   = htmlspecialchars($partes[0] ?? '');
                      $ID_Proveedor = htmlspecialchars($partes[1] ?? '');
                      $Cantidad     = htmlspecialchars($partes[2] ?? '');
                      $Fecha        = htmlspecialchars($partes[3] ?? '');
                    ?>
                    <tr>
                      <td><?= $ID_Entrada ?></td>
                      <td><?= $ID_Proveedor ?></td>
                      <td><?= $Cantidad ?></td>
                      <td><?= $Fecha ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="4" class="text-center text-muted">No hay detalles de compras para mostrar.</td>
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
                  <h2 class="h4 mb-3">Agregar Detalle Compra</h2>
                  <form method="POST" class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label">ID Entrada</label>
                      <input type="text" name="ID_Entrada" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">ID Proveedor</label>
                      <input type="text" name="ID_Proveedor" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Cantidad</label>
                      <input type="number" name="Cantidad" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Fecha Entrada</label>
                      <input type="date" name="Fecha_Entrada" class="form-control" required>
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
                  <h2 class="h4 mb-3">Actualizar Detalle Compra</h2>
                  <form method="POST" class="row g-3">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="col-md-6">
                      <label class="form-label">ID Entrada (obligatorio)</label>
                      <input type="text" name="ID_Entrada" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">ID Proveedor (obligatorio)</label>
                      <input type="text" name="ID_Proveedor" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Cantidad</label>
                      <input type="number" name="Cantidad" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Fecha Entrada</label>
                      <input type="date" name="Fecha_Entrada" class="form-control">
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
                  <h2 class="h4 mb-3">Eliminar Detalle Compra</h2>
                  <form method="POST" class="row g-3">
                    <input type="hidden" name="_method" value="DELETE">
                    <div class="col-md-6">
                      <label class="form-label">ID Entrada</label>
                      <input type="text" name="ID_Entrada" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">ID Proveedor</label>
                      <input type="text" name="ID_Proveedor" class="form-control" required>
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
