<?php
date_default_timezone_set('America/Bogota');
include 'conexion.php';
$mensaje = "";

// Combo dinámico de ventas
$ventas = $conexion->query("SELECT ID_Venta FROM ventas");

// --------- AGREGAR DEVOLUCIÓN + DETALLE ----------
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ID_Devolucion'])) {
    $idDevolucion = $_POST['ID_Devolucion'];
    $motivo = $_POST['Motivo'];
    $fecha = $_POST['Fecha_Devolucion'];
    $idVenta = $_POST['ID_Venta'];
    $cantidadDevuelta = $_POST['Cantidad_Devuelta'];
    $fechaHoy = date('Y-m-d');

    if (empty($idDevolucion) || empty($motivo) || empty($fecha) || empty($idVenta) || empty($cantidadDevuelta)) {
        $mensaje = '<div class="alert alert-danger">Todos los campos son obligatorios.</div>';
    } elseif ($fecha !== $fechaHoy) {
        $mensaje = '<div class="alert alert-danger">Solo puedes seleccionar la fecha de hoy (' . $fechaHoy . ').</div>';
    } else {
        // 1. Insertar en devoluciones
        $stmt = $conexion->prepare("INSERT IGNORE INTO devoluciones (ID_Devolucion, Fecha_Devolucion, Motivo) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $idDevolucion, $fecha, $motivo);
        $stmt->execute();
        $stmt->close();

        // 2. Verificar que exista la devolución principal antes de insertar detalle
        $check = $conexion->prepare("SELECT 1 FROM devoluciones WHERE ID_Devolucion = ?");
        $check->bind_param("s", $idDevolucion);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $stmt2 = $conexion->prepare("INSERT INTO detalle_devoluciones (ID_Devolucion, Cantidad_Devuelta, ID_Venta) VALUES (?, ?, ?)");
            $stmt2->bind_param("sis", $idDevolucion, $cantidadDevuelta, $idVenta);
            if ($stmt2->execute()) {
                header("Location: RDevolucion.php?msg=ok");
                exit();
            } else {
                $mensaje = '<div class="alert alert-danger">Error al guardar el detalle de devolución.</div>';
            }
            $stmt2->close();
        } else {
            $mensaje = '<div class="alert alert-danger">Error: No se pudo registrar la devolución principal.</div>';
        }
        $check->close();
    }
}

// --------- ELIMINAR DEVOLUCIÓN ----------
if (isset($_GET['eliminar'])) {
    $idDevolucion = $_GET['eliminar'];
    $conexion->query("DELETE FROM devoluciones WHERE ID_Devolucion='$idDevolucion'");
    header("Location: RDevolucion.php?msg=del");
    exit();
}

// --------- LISTAR DEVOLUCIONES CON DETALLE ----------
$sql = "SELECT d.ID_Devolucion, d.Fecha_Devolucion, d.Motivo, 
               det.Cantidad_Devuelta, det.ID_Venta
        FROM devoluciones d
        JOIN detalle_devoluciones det ON d.ID_Devolucion = det.ID_Devolucion
        ORDER BY d.Fecha_Devolucion DESC";
$registros = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Bootstrap (tu archivo local) -->
  <link rel="stylesheet" href="../css/bootstrap.min.css" />
  <!-- Estilos propios de esta página -->
  <link rel="stylesheet" href="../css/RDevoluciones.css" />
  <!-- Estilos del sidebar unificado -->
  <link rel="stylesheet" href="../css/compra.css" />
  <link rel="icon" href="../Imagenes/Logo.webp" type="image/webp" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

  <title>Registro Devoluciones</title>
  
</head>
<body>
  <div class="d-flex" style="min-height: 100vh;">

    <!-- SIDEBAR (igual que Inicio) -->
    <div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-primary text-white">
      <a class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
        TECNICELL RM
      </a>
      <hr>
      <div class="menu-barra-lateral">
        <div class="seccion-menu">
          <a href="InicioA.php" class="elemento-menu">
            <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
          </a>
          <a href="compra.php" class="elemento-menu">
            <i class="fas fa-shopping-cart"></i><span>Compras</span>
          </a>
          <a href="RDevolucion.php" class="elemento-menu activo">
            <i class="fas fa-undo"></i><span>Devoluciones</span>
          </a>
          <a href="ventas.php" class="elemento-menu">
            <i class="fas fa-chart-line"></i><span>Ventas</span>
          </a>
        </div>
        <hr>
        <div class="seccion-menu">
          <a href="proveedor.php" class="elemento-menu">
            <i class="fas fa-users"></i><span>Proveedores</span>
          </a>
          <a href="Productos.php" class="elemento-menu">
            <i class="fas fa-boxes"></i><span>Productos</span>
          </a>
           <div class="elemento-menu">
                        <i class="fas fa-user-friends"></i>
                        <span>Usuarios</span>
                    </div>
        </div>
      </div>
    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="flex-grow-1">
      <!-- Tu logo (se respeta) -->
      <a href="../html/Index.html">
        <img src="../Imagenes/Logo.webp" alt="Logo esquina" class="logo" />
      </a>

      <!-- Cabecera original -->
      <div class="cabecera">
        <h1 class="titulo">Registro de Devoluciones</h1>
      </div>

      <!-- Mensajes -->
      <div class="container mt-4">
        <?php
          if (isset($_GET['msg']) && $_GET['msg'] == 'ok') {
              echo '<div class="alert alert-success">¡Devolución registrada correctamente!</div>';
          } elseif (isset($_GET['msg']) && $_GET['msg'] == 'del') {
              echo '<div class="alert alert-success">¡Devolución eliminada correctamente!</div>';
          } elseif (isset($_GET['msg']) && $_GET['msg'] == 'error') {
              echo '<div class="alert alert-danger">Ocurrió un error al registrar la devolución.</div>';
          }
          if ($mensaje) echo $mensaje;
        ?>
      </div>

      <!-- Formulario -->
      <form class="container mt-3" method="POST" autocomplete="off">
        <div class="row g-3">
          <div class="col-md-6">
            <label for="Fecha_Devolucion" class="form-label">Fecha:</label>
            <input type="date" class="form-control" id="Fecha_Devolucion" name="Fecha_Devolucion"
                   required min="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>">
          </div>
          <div class="col-md-6">
            <label for="ID_Devolucion" class="form-label">N° Devolución:</label>
            <input type="text" class="form-control" id="ID_Devolucion" name="ID_Devolucion" placeholder="DEV001" required>
          </div>
          <div class="col-12">
            <label for="Motivo" class="form-label">Motivo:</label>
            <input type="text" class="form-control" id="Motivo" name="Motivo" placeholder="Motivo de la devolución" required>
          </div>
          <div class="col-md-6">
            <label for="ID_Venta" class="form-label">Venta asociada:</label>
            <select class="form-select" id="ID_Venta" name="ID_Venta" required>
              <option value="">Seleccione</option>
              <?php while($v = $ventas->fetch_assoc()): ?>
                <option value="<?= $v['ID_Venta'] ?>"><?= $v['ID_Venta'] ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label for="Cantidad_Devuelta" class="form-label">Cantidad devuelta:</label>
            <input type="number" class="form-control" id="Cantidad_Devuelta" name="Cantidad_Devuelta" min="1" value="1" required>
          </div>
          <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-primary">Guardar Devolución</button>
          </div>
        </div>
      </form>

      <!-- Tabla -->
      <div class="container mt-5">
        <h2 class="titulo text-center text-dark mb-4">Devoluciones Registradas</h2>
        <div class="table-responsive">
          <table class="table table-bordered table-striped align-middle">
            <thead class="table-primary">
              <tr>
                <th>N° Devolución</th>
                <th>Fecha</th>
                <th>Motivo</th>
                <th>ID Venta</th>
                <th>Cantidad Devuelta</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = $registros->fetch_assoc()): ?>
                <tr>
                  <td><?= $row['ID_Devolucion'] ?></td>
                  <td><?= $row['Fecha_Devolucion'] ?></td>
                  <td><?= $row['Motivo'] ?></td>
                  <td><?= $row['ID_Venta'] ?></td>
                  <td><?= $row['Cantidad_Devuelta'] ?></td>
                  <td>
                    <a href="RDevolucion.php?eliminar=<?= urlencode($row['ID_Devolucion']) ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('¿Seguro que deseas eliminar esta devolución?');">Eliminar</a>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>

      <footer class="footer">
        <p>Copyright © 2025 Fonrio</p>
      </footer>
    </div>
  </div>

  <!-- JS de Bootstrap (si usas el bundle local, cámbialo aquí) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Importante: eliminé la redirección a Inicio.php que ocultaba la página al volver del historial -->
</body>
</html>
<?php $conexion->close(); ?>
