<?php
date_default_timezone_set('America/Bogota');
include 'conexion.php';

// (Opcional) Mostrar errores en desarrollo
// error_reporting(E_ALL); ini_set('display_errors', 1);

// Selects iniciales (para combos)
$proveedores = $conexion->query("SELECT ID_Proveedor FROM proveedores");
$productos   = $conexion->query("SELECT ID_Producto, Nombre_Producto FROM productos");
$empleados   = $conexion->query("SELECT Documento_Empleado FROM empleados");
$gamas       = $conexion->query("SELECT ID_Gama, Nombre_Gama FROM gamas");

$categoria_defecto = 'CAT001';
$mensaje = "";

// Insertar datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Campos esperados
    $idEntrada   = $_POST['idEntrada'];
    $precio      = $_POST['precio'];
    $idProducto  = $_POST['idProducto']; // puede venir vacío si es nuevo
    $empleado    = $_POST['empleado'];
    $cantidad    = $_POST['cantidad'];
    $fecha       = $_POST['fecha'];
    $proveedor   = $_POST['proveedor'];

    $nuevo_nombre = trim($_POST['nuevo_nombre'] ?? "");
    $nuevo_gama   = $_POST['nuevo_gama'] ?? "";
    $fechaHoy     = date('Y-m-d');

    // --- Manejo de foto (opcional) ---
    $rutaFoto = null;
    if (!empty($_FILES['foto']['name'])) {
        $dir = "../imagenes/productos/";
        if (!is_dir($dir)) { @mkdir($dir, 0777, true); }

        $extPerm = ['jpg','jpeg','png','webp'];
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $esImagen = @getimagesize($_FILES['foto']['tmp_name']);
        $tamMax   = 5 * 1024 * 1024; // 5MB

        if ($esImagen && in_array($ext, $extPerm) && $_FILES['foto']['size'] <= $tamMax) {
            // si es producto existente usamos su ID; si no, "prod"
            $nombreBase  = !empty($idProducto) ? $idProducto : 'prod';
            $nombreUnico = $nombreBase . "_" . time() . "." . $ext;
            $destino     = $dir . $nombreUnico;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                // Guardar ruta relativa
                $rutaFoto = $destino;
            } else {
                $mensaje .= '<div class="alert alert-warning">La foto no se pudo subir. Se continuará sin imagen.</div>';
            }
        } else {
            $mensaje .= '<div class="alert alert-warning">Formato o tamaño de imagen inválido. Se continuará sin imagen.</div>';
        }
    }

    // Validaciones
    if (!is_numeric($cantidad) || $cantidad < 1) {
        $mensaje .= '<div class="alert alert-danger">La cantidad debe ser mayor o igual a 1.</div>';
    } elseif ($fecha !== $fechaHoy) {
        $mensaje .= '<div class="alert alert-danger">Solo puedes registrar la compra con la fecha de hoy (' . htmlspecialchars($fechaHoy) . ').</div>';
    } elseif (empty($idProducto) && empty($nuevo_nombre)) {
        $mensaje .= '<div class="alert alert-danger">Debes seleccionar un producto o registrar uno nuevo.</div>';
    } else {
        // Flujo: Producto nuevo
        if (!empty($nuevo_nombre)) {
            if (empty($nuevo_gama)) {
                $mensaje .= '<div class="alert alert-danger">Completa la gama del producto nuevo.</div>';
            } else {
                // Genera ID_Producto simple (ajústalo si tienes otra convención)
                $newIdProducto = "PROD" . str_pad((string)((rand(100,999) . (time()%10000))%1000000), 6, "0", STR_PAD_LEFT);

                $stmtNew = $conexion->prepare("
                    INSERT INTO productos
                        (ID_Producto, Nombre_Producto, Descripcion, Precio_Venta, Stock_Minimo, ID_Categoria, ID_Estado, ID_Gama, fotos)
                    VALUES (?, ?, '', 0, ?, ?, 'EST001', ?, ?)
                ");
                // Nota: colocamos 'fotos' directamente si existe $rutaFoto
                $stmtNew->bind_param("ssisss",
                    $newIdProducto, $nuevo_nombre, $cantidad, $categoria_defecto, $nuevo_gama, $rutaFoto
                );

                if ($stmtNew->execute()) {
                    header("Location: compra.php?msg=ok");
                    exit();
                } else {
                    $mensaje .= '<div class="alert alert-danger">No se pudo registrar el producto nuevo.</div>';
                }
                $stmtNew->close();
            }
        } else {
            // Flujo: Producto existente -> insertar compra y detalle
            // compras(ID_Entrada, Precio_Compra, ID_Producto, Documento_Empleado)
            $stmt = $conexion->prepare("
                INSERT IGNORE INTO compras
                    (ID_Entrada, Precio_Compra, ID_Producto, Documento_Empleado)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->bind_param("sdss", $idEntrada, $precio, $idProducto, $empleado);
            $ok1 = $stmt->execute();
            $stmt->close();

            // Confirmar que quedó la compra principal
            $check = $conexion->prepare("SELECT 1 FROM compras WHERE ID_Entrada = ?");
            $check->bind_param("s", $idEntrada);
            $check->execute();
            $check->store_result();

            if ($check->num_rows > 0) {
                // detalle_compras(Fecha_Entrada, Cantidad, ID_Proveedor, ID_Entrada)
                $stmt2 = $conexion->prepare("
                    INSERT INTO detalle_compras
                        (Fecha_Entrada, Cantidad, ID_Proveedor, ID_Entrada)
                    VALUES (?, ?, ?, ?)
                ");
                $stmt2->bind_param("siss", $fecha, $cantidad, $proveedor, $idEntrada);

                if ($stmt2->execute()) {
                    // Si hubo foto, actualizar en productos (campo 'fotos')
                    if ($rutaFoto) {
                        $stmtFoto = $conexion->prepare("UPDATE productos SET fotos=? WHERE ID_Producto=?");
                        $stmtFoto->bind_param("ss", $rutaFoto, $idProducto);
                        $stmtFoto->execute();
                        $stmtFoto->close();
                    }
                    header("Location: compra.php?msg=ok");
                    exit();
                } else {
                    $mensaje .= '<div class="alert alert-danger">Error al guardar en detalle_compras. Revisa los datos.</div>';
                }
                $stmt2->close();
            } else {
                $mensaje .= '<div class="alert alert-danger">Error: No se pudo registrar la compra principal.</div>';
            }
            $check->close();
        }
    }
}

// Consulta para mostrar datos con foto (JOIN a productos usando 'fotos')
$sql = "
SELECT
    c.ID_Entrada, c.Precio_Compra, c.ID_Producto, c.Documento_Empleado,
    d.Cantidad, d.Fecha_Entrada, d.ID_Proveedor,
    p.Nombre_Producto, p.fotos
FROM compras c
JOIN detalle_compras d ON c.ID_Entrada = d.ID_Entrada
LEFT JOIN productos p ON p.ID_Producto = c.ID_Producto
ORDER BY d.Fecha_Entrada DESC, c.ID_Entrada DESC
";
$result = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="stylesheet" href="../css/compra.css" />
  <title>Compras</title>
</head>
<body>
  <div class="d-flex" style="min-height: 100vh;">

    <!-- SIDEBAR -->
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
          <a href="compra.php" class="elemento-menu activo">
            <i class="fas fa-shopping-cart"></i><span>Compras</span>
          </a>
          <a href="RDevolucion.php" class="elemento-menu">
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
            <i class="fas fa-user-friends"></i><span>Usuarios</span>
          </div>
        </div>
      </div>
    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="flex-grow-1">
      <!-- Cabecera -->
      <div class="cabecera">
        <h1 class="titulo">Compras</h1>
      </div>

      <div class="container mt-4">
        <?php
          if (isset($_GET['msg']) && $_GET['msg'] == 'ok') {
              echo '<div class="alert alert-success">¡Compra registrada correctamente!</div>';
          } elseif (isset($_GET['msg']) && $_GET['msg'] == 'error') {
              echo '<div class="alert alert-danger">Ocurrió un error al registrar la compra.</div>';
          }
          if ($mensaje) echo $mensaje;
        ?>

        <!-- FORMULARIO COMPLETO -->
        <form class="container-fluid mt-3" method="POST" autocomplete="off" enctype="multipart/form-data">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">ID Entrada</label>
              <input type="text" name="idEntrada" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Precio Compra</label>
              <input type="number" step="0.01" name="precio" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Producto existente</label>
              <select name="idProducto" class="form-select">
                <option value="">Seleccione producto existente (si aplica)</option>
                <?php
                $productosReselect = $conexion->query("SELECT ID_Producto, Nombre_Producto FROM productos");
                while($p = $productosReselect->fetch_assoc()): ?>
                  <option value="<?= htmlspecialchars($p['ID_Producto']) ?>">
                    <?= htmlspecialchars($p['ID_Producto']) ?> - <?= htmlspecialchars($p['Nombre_Producto']) ?>
                  </option>
                <?php endwhile; ?>
              </select>
            </div>

            <div class="col-12 text-center my-2">
              <span style="font-weight:bold;">O bien, registra un nuevo producto:</span>
            </div>
            <div class="col-md-7">
              <label class="form-label">Nombre del nuevo producto</label>
              <input type="text" name="nuevo_nombre" class="form-control" placeholder="Solo si es producto nuevo">
            </div>
            <div class="col-md-5">
              <label class="form-label">Gama</label>
              <select name="nuevo_gama" class="form-select">
                <option value="">---</option>
                <?php
                $gamasReselect = $conexion->query("SELECT ID_Gama, Nombre_Gama FROM gamas");
                while($g = $gamasReselect->fetch_assoc()): ?>
                  <option value="<?= htmlspecialchars($g['ID_Gama']) ?>"><?= htmlspecialchars($g['Nombre_Gama']) ?></option>
                <?php endwhile; ?>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Documento Empleado</label>
              <select name="empleado" class="form-select" required>
                <option value="">Seleccione</option>
                <?php
                $empleadosReselect = $conexion->query("SELECT Documento_Empleado FROM empleados");
                while($e = $empleadosReselect->fetch_assoc()): ?>
                  <option value="<?= htmlspecialchars($e['Documento_Empleado']) ?>"><?= htmlspecialchars($e['Documento_Empleado']) ?></option>
                <?php endwhile; ?>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">Cantidad</label>
              <input type="number" name="cantidad" class="form-control" min="1" value="1" required>
            </div>
            <div class="col-md-3">
              <label class="form-label">Fecha Entrada</label>
              <input type="date" name="fecha" class="form-control" required min="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>">
            </div>
            <div class="col-md-6">
              <label class="form-label">ID Proveedor</label>
              <select name="proveedor" class="form-select" required>
                <option value="">Seleccione</option>
                <?php
                $proveedoresReselect = $conexion->query("SELECT ID_Proveedor FROM proveedores");
                while($pr = $proveedoresReselect->fetch_assoc()): ?>
                  <option value="<?= htmlspecialchars($pr['ID_Proveedor']) ?>"><?= htmlspecialchars($pr['ID_Proveedor']) ?></option>
                <?php endwhile; ?>
              </select>
            </div>

            <!-- FOTO OPCIONAL -->
            <div class="col-12 mt-2">
              <label class="form-label">Foto del producto (opcional)</label>
              <input type="file" name="foto" class="form-control" accept="image/*">
              <div class="form-text">JPG, PNG o WEBP. Máx. 5MB.</div>
            </div>

            <div class="col-12 text-center mt-4">
              <button type="submit" class="btn btn-primary">Guardar Compra</button>
            </div>
          </div>
        </form>

        <!-- TABLA -->
        <div class="container-fluid mt-5">
          <h2 class="titulo text-center text-dark mb-4">Compras Registradas</h2>
          <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
              <thead class="table-primary">
                <tr>
                  <th>Foto</th>
                  <th>Producto</th>
                  <th>ID Entrada</th>
                  <th>Precio Compra</th>
                  <th>Documento Empleado</th>
                  <th>Cantidad</th>
                  <th>Fecha Entrada</th>
                  <th>ID Proveedor</th>
                </tr>
              </thead>
              <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                  <td style="width:110px;">
                    <?php
                      $src = $row['fotos'] ? $row['fotos'] : 'https://via.placeholder.com/100x70?text=Sin+Foto';
                    ?>
                    <img src="<?= htmlspecialchars($src) ?>" alt="<?= htmlspecialchars($row['Nombre_Producto'] ?? 'Producto') ?>" style="max-width:100px; height:auto; border-radius:6px;">
                  </td>
                  <td>
                    <div class="fw-semibold"><?= htmlspecialchars($row['Nombre_Producto'] ?? $row['ID_Producto']) ?></div>
                    <small class="text-muted"><?= htmlspecialchars($row['ID_Producto']) ?></small>
                  </td>
                  <td><?= htmlspecialchars($row['ID_Entrada']) ?></td>
                  <td>$<?= number_format((float)$row['Precio_Compra'],2) ?></td>
                  <td><?= htmlspecialchars($row['Documento_Empleado']) ?></td>
                  <td><?= (int)$row['Cantidad'] ?></td>
                  <td><?= htmlspecialchars($row['Fecha_Entrada']) ?></td>
                  <td><?= htmlspecialchars($row['ID_Proveedor']) ?></td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>

        <footer class="footer text-center mt-5">
          <p>Copyright © 2025 Fonrio</p>
        </footer>
      </div>
    </div>
  </div>

  <script>
  window.addEventListener('pageshow', function(event) {
      if (event.persisted || (performance && performance.getEntriesByType && performance.getEntriesByType("navigation")[0]?.type === "back_forward")) {
          window.location.href = 'InicioA.php';
      }
  });
  </script>
</body>
</html>
<?php $conexion->close(); ?>
