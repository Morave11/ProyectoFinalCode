<?php
require_once __DIR__ . '/../Modelo/ProductosService.php';

$productosService = new ProductosService();
$productos = $productosService->obtenerProductos();

if (!is_array($productos)) {
    $productos = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Productos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="stylesheet" href="./css/menu.css"/>
</head>
<body>
<div class="d-flex" style="min-height: 100vh;">

  <!-- BARRA LATERAL -->
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
        <a href="../indexproveedor.php" class="elemento-menu"><i class="fa-solid fa-users"></i><span>Proveedores</span></a>
        <a href="Productos.php" class="elemento-menu activo"><i class="fa-solid fa-boxes"></i><span>Productos</span></a>

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
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav"></div>

        <div class="dropdown ms-auto">
          <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
            id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong>Perfil</strong>
          </a>
          <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="Perfil.html">Mi perfil</a></li>
            <li><a class="dropdown-item" href="EditarPerfil.php">Editar perfil</a></li>
            <li><a class="dropdown-item" href="Registro.php">Registrarse</a></li>
            <li><a class="dropdown-item" href="Index.php">Cerrar Sesión</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- CABECERA -->
    <div class="container py-4">
      <div class="d-flex align-items-center justify-content-center gap-3">
        <img src="../Imagenes/Logo.webp" alt="Logo TECNICELL" style="height:48px; width:auto;" />
        <h1 class="m-0">Productos en Stock</h1>
      </div>

      <!-- BOTONES DE ACCIÓN -->
      <div class="d-flex justify-content-end gap-2 my-3">
        <a href="./indexcrudproducto.php" class="btn btn-success">Añadir, Actualizar, Eliminar</a>
      </div>

      <!-- TARJETAS DINÁMICAS -->
      <div class="container mt-2">
        <div class="row justify-content-center">
          <?php if (!empty($productos)): ?>
            <?php foreach ($productos as $producto): ?>
              <?php
                $campos = explode("________", $producto);
                $idProducto   = $campos[0] ?? "";
                $nombre       = $campos[1] ?? "Sin nombre";
                $descripcion  = $campos[2] ?? "";
                $precioCompra = $campos[3] ?? "";
                $stock        = $campos[4] ?? "";
                $categoria    = $campos[5] ?? "";
                $estado       = $campos[6] ?? "";
                $garantia     = $campos[7] ?? "";
              ?>
              <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100">
                  <img src="https://via.placeholder.com/400x200?text=<?= urlencode($nombre); ?>"
                        class="card-img-top" alt="<?= htmlspecialchars($nombre); ?>">
                  <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($nombre); ?></h5>
                    <p class="card-text"><strong>Descripción:</strong> <?= htmlspecialchars($descripcion); ?></p>
                    <p class="card-text"><strong>Precio Compra:</strong> $<?= htmlspecialchars($precioCompra); ?></p>
                    <p class="card-text"><strong>Stock:</strong> <?= htmlspecialchars($stock); ?></p>
                    <p class="card-text"><strong>Categoría:</strong> <?= htmlspecialchars($categoria); ?></p>
                    <p class="card-text"><strong>Estado:</strong> <?= htmlspecialchars($estado); ?></p>
                    <p class="card-text"><strong>Garantía:</strong> <?= htmlspecialchars($garantia); ?></p>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p class="text-center text-muted">No hay productos disponibles.</p>
          <?php endif; ?>
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
