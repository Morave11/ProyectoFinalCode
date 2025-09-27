<?php
include_once __DIR__ . '/../php/conexion.php';

// Traer también la ruta de la foto.
$sql = "
  SELECT 
    Nombre_Producto, 
    MAX(fotos) AS foto, 
    SUM(Stock_Minimo) AS stock_total 
  FROM Productos 
  GROUP BY Nombre_Producto
";
$result = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <!-- Font Awesome (iconos del sidebar) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <!-- Estilos del sidebar unificado -->
  <link rel="stylesheet" href="../css/compra.css">
  <!-- Estilos propios de productos -->
  <link rel="stylesheet" href="../css/productos.css">
  <title>Productos</title>
</head>

<body>
  <div class="d-flex" style="min-height: 100vh;">

    <!-- SIDEBAR (unificado) -->
    <div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-primary text-white">
      <a class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
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
          <a href="ventas.php" class="elemento-menu">
            <i class="fa-solid fa-chart-line"></i><span>Ventas</span>
          </a>
        </div>
        <hr>
        <div class="seccion-menu">
          <a href="proveedor.php" class="elemento-menu">
            <i class="fa-solid fa-users"></i><span>Proveedores</span>
          </a>
          <a href="Productos.php" class="elemento-menu activo">
            <i class="fa-solid fa-boxes"></i><span>Productos</span>
          </a>

                  <div class="dropdown">
  <a class="elemento-menu d-flex align-items-center text-white text-decoration-none dropdown-toggle" 
     href="#" 
     id="rolesMenu" 
     role="button" 
     data-bs-toggle="dropdown" 
     aria-expanded="false">
    <i class="fas fa-user-friends me-2"></i><span>Roles</span>
  </a>
  <ul class="dropdown-menu" aria-labelledby="rolesMenu">
  <li><a class="dropdown-item" href="roles.php">Cliente</a></li>
  <li><a class="dropdown-item" href="IndexEm.php">Empleado</a></li>
</ul>
        </div>
      </div>
    </div>

    <!-- CONTENIDO -->
    <div class="flex-grow-1">
      <!-- NAVBAR (se mantiene tuyo) -->
      <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
        <div class="container-fluid">
          <!-- En móvil, si quieres un botón para mostrar/ocultar sidebar,
               podemos implementar un offcanvas; por ahora lo dejo limpio -->
          <a class="navbar-brand" href="#">Sistema gestión de inventarios</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                  aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarNav"></div>

          <div class="dropdown ms-auto">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
               id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
              <strong>mdo</strong>
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

      <!-- TARJETAS DINÁMICAS -->
      <div class="container mt-4">
        <div class="row justify-content-center">
          <?php while($row = $result->fetch_assoc()): ?>
            <?php
              $ruta = $row['foto'];
              if (!$ruta || trim($ruta) === '') {
                $ruta = 'https://via.placeholder.com/400x200?text=' . urlencode($row['Nombre_Producto']);
              }
            ?>
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
              <div class="card text-center h-100">
                <img 
                  src="<?php echo htmlspecialchars($ruta); ?>"
                  class="card-img-top"
                  alt="<?php echo htmlspecialchars($row['Nombre_Producto']); ?>"
                  style="object-fit:cover; height:200px;">
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title"><?php echo htmlspecialchars($row['Nombre_Producto']); ?></h5>
                  <p class="card-text fs-1 fw-bold mb-0">
                    <?php echo (int)$row['stock_total']; ?>
                  </p>
                  <p class="card-text text-muted mb-3">Unidades en stock</p>
                  <a href="#" class="btn btn-primary mt-auto">Ver detalles</a>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      </div>

      <footer class="text-center py-4 mt-auto">
        <p class="mb-0">Copyright © 2025 Fonrio</p>
      </footer>
    </div>
  </div>

  <script src="../js/bootstrap.bundle.min.js"></script>
  <script>
    // (Opcional) Esta redirección puede ocultar la página al volver con 'Atrás'
    // Si no la necesitas, elimínala.
    window.addEventListener('pageshow', function(event) {
      if (event.persisted || (performance && performance.getEntriesByType && performance.getEntriesByType("navigation")[0]?.type === "back_forward")) {
        window.location.href = 'InicioA.php';
      }
    });
  </script>
</body>
</html>
