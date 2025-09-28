<?php
$mensaje   = $mensaje ?? '';
$productos = $productos ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Productos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="stylesheet" href="./css/menu.css"/>
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
        <a href="InicioA.php" class="elemento-menu"><i class="fa-solid fa-tachometer-alt"></i><span>Dashboard</span></a>
        <a href="compra.php" class="elemento-menu"><i class="fa-solid fa-shopping-cart"></i><span>Compras</span></a>
        <a href="RDevolucion.php" class="elemento-menu"><i class="fa-solid fa-undo"></i><span>Devoluciones</span></a>
        <a href="indexventas.php" class="elemento-menu"><i class="fa-solid fa-chart-line"></i><span>Ventas</span></a>
      </div>
      <hr>
      <div class="seccion-menu">
        <a href="../indexproveedor.php" class="elemento-menu"><i class="fas fa-users"></i><span>Proveedores</span></a>
        <a href="Productos.php" class="elemento-menu activo"><i class="fas fa-boxes"></i><span>Productos</span></a>
      </div>
    </div>
  </div>

  <!-- CONTENIDO PRINCIPAL -->
  <div class="contenido-principal flex-grow-1">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand">Sistema gestión de inventarios</a>
        <div class="dropdown ms-auto">
          <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
            <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong>Perfil</strong>
          </a>
          <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
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
        <h1 class="m-0">Gestión de Productos</h1>
      </div>

      <!-- Mensajes -->
      <?= $mensaje ? "<div class='alert alert-info mt-3'>$mensaje</div>" : "" ?>

      <!-- TABLA DE PRODUCTOS -->
      <?php if (!empty($productos)): ?>
        <div class="table-responsive mt-4">
          <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-dark">
              <tr>
                <th>ID Producto</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio Venta</th>
                <th>Stock Mínimo</th>
                <th>Categoría</th>
                <th>Estado</th>
                <th>Gama</th>
                <th>Foto</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($productos as $p):
                $campos = is_string($p) ? explode('________', $p) : [];
                $ID_Producto     = $campos[0] ?? "";
                $Nombre_Producto = $campos[1] ?? "Sin nombre";
                $Descripcion     = $campos[2] ?? "";
                $Precio_Venta    = $campos[3] ?? "";
                $Stock_Minimo    = $campos[4] ?? "";
                $ID_Categoria    = $campos[5] ?? "";
                $ID_Estado       = $campos[6] ?? "";
                $ID_Gama         = $campos[7] ?? "";
                $Fotos           = $campos[8] ?? "";
              ?>
              <tr>
                <td><?= htmlspecialchars($ID_Producto) ?></td>
                <td><?= htmlspecialchars($Nombre_Producto) ?></td>
                <td><?= htmlspecialchars($Descripcion) ?></td>
                <td>$<?= htmlspecialchars($Precio_Venta) ?></td>
                <td><?= htmlspecialchars($Stock_Minimo) ?></td>
                <td><?= htmlspecialchars($ID_Categoria) ?></td>
                <td><?= htmlspecialchars($ID_Estado) ?></td>
                <td><?= htmlspecialchars($ID_Gama) ?></td>
                <td><img src="<?= $Fotos ?: "https://via.placeholder.com/80x50?text=".urlencode($Nombre_Producto); ?>" alt="<?= htmlspecialchars($Nombre_Producto); ?>" style="width:80px; height:auto;"></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <p class="text-center text-muted mt-4">No hay productos disponibles.</p>
      <?php endif; ?>

      <!-- FORMULARIOS CRUD (sin cambios) -->
      <div class="row mt-5 g-4">
        <!-- Crear -->
        <div class="col-md-6">
          <div class="card shadow-sm">
            <div class="card-body">
              <h2 class="h4 mb-3">Añadir Producto</h2>
              <form method="POST" class="row g-3">
                <input type="text" name="ID_Producto" placeholder="ID Producto" class="form-control" required>
                <input type="text" name="Nombre_Producto" placeholder="Nombre" class="form-control" required>
                <input type="text" name="Descripcion" placeholder="Descripción" class="form-control">
                <input type="text" name="Precio_Venta" placeholder="Precio Venta" class="form-control">
                <input type="text" name="Stock_Minimo" placeholder="Stock Mínimo" class="form-control">
                <input type="text" name="ID_Categoria" placeholder="ID Categoría" class="form-control">
                <input type="text" name="ID_Estado" placeholder="ID Estado" class="form-control">
                <input type="text" name="ID_Gama" placeholder="ID Gama" class="form-control">
                <input type="text" name="Fotos" placeholder="URL Foto" class="form-control">
                <div class="col-12 text-center mt-3">
                  <button type="submit" class="btn btn-success">Guardar</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Actualizar -->
        <div class="col-md-6">
          <div class="card shadow-sm">
            <div class="card-body">
              <h2 class="h4 mb-3">Actualizar Producto</h2>
              <form method="POST" class="row g-3">
                <input type="hidden" name="_method" value="PUT">
                <input type="text" name="ID_Producto" placeholder="ID Producto a actualizar" class="form-control" required>
                <input type="text" name="Nombre_Producto" placeholder="Nuevo Nombre" class="form-control">
                <input type="text" name="Descripcion" placeholder="Nueva Descripción" class="form-control">
                <input type="text" name="Precio_Venta" placeholder="Nuevo Precio Venta" class="form-control">
                <input type="text" name="Stock_Minimo" placeholder="Nuevo Stock Mínimo" class="form-control">
                <input type="text" name="ID_Categoria" placeholder="Nueva ID Categoría" class="form-control">
                <input type="text" name="ID_Estado" placeholder="Nuevo ID Estado" class="form-control">
                <input type="text" name="ID_Gama" placeholder="Nueva ID Gama" class="form-control">
                <input type="text" name="Fotos" placeholder="Nueva URL Foto" class="form-control">
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
              <h2 class="h4 mb-3">Eliminar Producto</h2>
              <form method="POST" class="row g-3">
    <input type="hidden" name="_method" value="DELETE">
    <input type="text" name="ID_Producto" placeholder="ID Producto a eliminar" class="form-control" required>
    <div class="col-12 text-center mt-3">
        <button type="submit" class="btn btn-danger">Eliminar</button>
    </div>
</form>

            </div>
          </div>
        </div>

      </div><!-- /row -->

      <footer class="footer mt-5 text-center text-muted">
        <p class="m-0">Copyright © 2025 Fonrio</p>
      </footer>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
