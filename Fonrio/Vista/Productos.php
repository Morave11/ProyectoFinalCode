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
  <link rel="stylesheet" href="/Fonrio/css/menu.css"/>
</head>
<body>
<div class="d-flex" style="min-height: 100vh;">

  <div class="barra-lateral d-flex flex-column flex-shrink-0 p-3 bg-primary text-white">
      <a class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        TECNICELL RM
      </a>
      <hr>
      <div class="menu-barra-lateral">
        <div class="seccion-menu">
         <a href="/Fonrio/Vista/InicioA.php" class="elemento-menu">
            <i class="fa-solid fa-tachometer-alt"></i><span>Dashboard</span>
          </a>
          <a href="/Fonrio/indexcompras.php" class="elemento-menu active">
            <i class="fa-solid fa-shopping-cart"></i><span>Compras</span>
          </a>
          <a href="/Fonrio/indexdev.php" class="elemento-menu">
            <i class="fa-solid fa-undo"></i><span>Devoluciones</span>
          </a>
          <a href="/Fonrio/indexventas.php" class="elemento-menu">
            <i class="fa-solid fa-chart-line"></i><span>Ventas</span>
          </a>
        </div>
        <hr>
        <div class="seccion-menu">
          <a href="/Fonrio/indexproveedor.php" class="elemento-menu">
            <i class="fa-solid fa-users"></i><span>Proveedores</span>
          </a>
         <a href="/Fonrio/indexproducto.php" class="elemento-menu">
            <i class="fa-solid fa-boxes"></i><span>Productos</span>
          </a>
          <a class="elemento-menu d-flex align-items-center text-white text-decoration-none dropdown-toggle" 
             href="#" id="rolesMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
             <i class="fas fa-user-friends me-2"></i><span>Roles</span>
          </a>
          <ul class="dropdown-menu" aria-labelledby="rolesMenu">
            <li><a class="dropdown-item" href="/Fonrio/indexcli.php">Cliente</a></li>
            <li><a class="dropdown-item" href="/Fonrio/indexempleado.php">Empleado</a></li>
          </ul>
        </div>
      </div>
    </div>

  <div class="contenido-principal flex-grow-1">

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand">Sistema gestión de inventarios</a>
        <div class="dropdown ms-auto">
          <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
           <img src="/Fonrio/php/fotos_empleados/686fe89fe865f_Foto Kevin.jpeg"
                   alt="" width="32" height="32" class="rounded-circle me-2">
              <strong>Perfil</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
              <li><a class="dropdown-item" href="Perfil.html">Mi perfil</a></li>
              <li><a class="dropdown-item" href="EditarPerfil.php">Editar perfil</a></li>
              <li><a class="dropdown-item" href="Registro.php">Registrarse</a></li>
              <li><a class="dropdown-item" href="/Fonrio/Vista/Index.php">Cerrar Sesión</a></li>
            </ul>
        </div>
      </div>
    </nav>

    <div class="container py-4">
      <div class="d-flex align-items-center justify-content-center gap-3">
        <img src="../Imagenes/Logo.webp" alt="Logo TECNICELL" style="height:48px; width:auto;" />
        <h1 class="m-0">Gestión de Productos</h1>
      </div>

      <?= $mensaje ? "<div class='alert alert-info mt-3'>$mensaje</div>" : "" ?>

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

                <!-- Celda de imagen corregida -->
                <td>
                  <?php
                    $src = trim($Fotos);
                    if ($src === '') {
                        $src = "https://via.placeholder.com/80x50?text=" . urlencode($Nombre_Producto);
                    } elseif (stripos($src, 'data:image') === 0) {
                        // Base64
                    } elseif (preg_match('~^https?://~i', $src)) {
                        // URL completa
                    } else {
                        $src = '/Fonrio/' . ltrim($src, '/');
                    }
                  ?>
                  <img src="<?= htmlspecialchars($src) ?>"
                       alt="<?= htmlspecialchars($Nombre_Producto) ?>"
                       style="width:80px;height:auto;border-radius:4px;">
                </td>

              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <p class="text-center text-muted mt-4">No hay productos disponibles.</p>
      <?php endif; ?>

      <div class="row mt-5 g-4">
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

      </div>

      <footer class="footer mt-5 text-center text-muted">
        <p class="m-0">Copyright © 2025 Fonrio</p>
      </footer>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
