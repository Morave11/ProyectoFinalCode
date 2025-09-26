<?php
$mensaje = $mensaje ?? '';
$ventas  = $ventas ?? [];

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ventas</title>

  <!-- Bootstrap + FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

  <!-- Estilos de esta página -->
  <link rel="stylesheet" href="../css/ventas.css">
</head>
<body class="ventas-page">

<div class="d-flex" style="min-height:100vh;">

  <!-- SIDEBAR -->
  <div class="barra-lateral d-flex flex-column flex-shrink-0 p-3 bg-primary text-white">
    <a class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
      TECNICELL RM
    </a>
    <hr>
    <div class="menu-barra-lateral">
      <div class="seccion-menu">
        <a href="InicioA.php" class="elemento-menu">
          <i class="fas fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
        <a href="/php/compra.php" class="elemento-menu">
          <i class="fas fa-shopping-cart"></i>
          <span>Compras</span>
        </a>
        <a href="RDevolucion.php" class="elemento-menu">
          <i class="fas fa-undo"></i>
          <span>Devoluciones</span>
        </a>
        <a href="indexventas.php" class="elemento-menu">
          <i class="fas fa-chart-line"></i>
          <span>Ventas</span>
        </a>
      </div>
      <hr>
      <div class="seccion-menu">
        <a href="proveedor.php" class="elemento-menu">
          <i class="fas fa-building"></i>
          <span>Proveedores</span>
        </a>
        <a href="/Vista/Productos.php" class="elemento-menu">
          <i class="fas fa-boxes"></i>
          <span>Productos</span>
        </a>
      </div>
    </div>
  </div>

  <!-- CONTENIDO -->
  <div class="contenido-principal flex-grow-1">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand">Sistema gestión de inventarios</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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

    <!-- CONTENIDO DE VENTAS -->
    <div class="container py-4">
      <h1 class="mb-4">Lista de Ventas</h1>

      <?php if ($mensaje): ?>
        <?= $mensaje ?>
      <?php endif; ?>

      <?php if (is_array($ventas) && !empty($ventas)): ?>
        <ul class="list-unstyled mb-5">
          <?php foreach ($ventas as $v): ?>
            <?php
              $ID_Venta           = $v['ID_Venta']           ?? '';
              $Documento_Cliente  = $v['Documento_Cliente']  ?? '';
              $Documento_Empleado = $v['Documento_Empleado'] ?? '';
            ?>
            <li class="mb-2">
              <span class="fw-bold"><?= htmlspecialchars($ID_Venta) ?></span>
              <span class="text-muted"> | Cliente: <?= htmlspecialchars($Documento_Cliente) ?></span>
              <span class="text-muted"> | Empleado: <?= htmlspecialchars($Documento_Empleado) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <div class="alert alert-danger">Error al obtener las ventas.</div>
      <?php endif; ?>

      <div class="row g-4">
        <!-- Registrar -->
        <div class="col-md-6">
          <div class="card shadow-sm">
            <div class="card-body">
              <h2 class="h4 mb-3">Registrar venta</h2>
              <form method="POST" class="vstack gap-3">
                <div>
                  <label class="form-label">ID Venta</label>
                  <input type="text" name="ID_Venta" class="form-control" required>
                </div>
                <div>
                  <label class="form-label">Documento Cliente</label>
                  <input type="text" name="Documento_Cliente" class="form-control" required>
                </div>
                <div>
                  <label class="form-label">Documento Empleado</label>
                  <input type="text" name="Documento_Empleado" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Registrar Venta</button>
              </form>
            </div>
          </div>
        </div>

        <!-- Actualizar -->
        <div class="col-md-6">
          <div class="card shadow-sm">
            <div class="card-body">
              <h2 class="h4 mb-3">Actualizar venta</h2>
              <form method="POST" class="vstack gap-3">
                <input type="hidden" name="_method" value="PUT">
                <div>
                  <label class="form-label">ID Venta a actualizar</label>
                  <input type="text" name="ID_Venta" class="form-control" required>
                </div>
                <div>
                  <label class="form-label">Nuevo Documento Cliente</label>
                  <input type="text" name="Documento_Cliente" class="form-control">
                </div>
                <div>
                  <label class="form-label">Nuevo Documento Empleado</label>
                  <input type="text" name="Documento_Empleado" class="form-control">
                </div>
                <button type="submit" class="btn btn-warning w-100">Actualizar Venta</button>
              </form>
            </div>
          </div>
        </div>

        <!-- Eliminar -->
        <div class="col-md-6">
          <div class="card shadow-sm">
            <div class="card-body">
              <h2 class="h4 mb-3">Eliminar venta</h2>
              <form method="POST" class="vstack gap-3">
                <input type="hidden" name="_method" value="DELETE">
                <div>
                  <label class="form-label">ID Venta a eliminar</label>
                  <input type="text" name="ID_Venta" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-danger w-100">Eliminar Venta</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /container -->
  </div><!-- /contenido-principal -->
</div><!-- /d-flex -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
</body>
</html>
