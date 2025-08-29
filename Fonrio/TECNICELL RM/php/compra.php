<?php
date_default_timezone_set('America/Bogota');
include 'conexion.php';

// Consulta para select de proveedores, productos y empleados
$proveedores = $conexion->query("SELECT ID_Proveedor FROM proveedores");
$productos   = $conexion->query("SELECT ID_Producto, Nombre_Producto FROM productos");
$empleados   = $conexion->query("SELECT Documento_Empleado FROM empleados");
$gamas = $conexion->query("SELECT ID_Gama, Nombre_Gama FROM gamas");

// Valor por defecto para categoría (modifica si deseas)
$categoria_defecto = 'CAT001';

$mensaje = "";

// Insertar datos (compras y detalle_compras)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idEntrada = $_POST['idEntrada'];
    $precio = $_POST['precio'];
    $idProducto = $_POST['idProducto']; // Puede venir vacío si es nuevo
    $empleado = $_POST['empleado'];
    $cantidad = $_POST['cantidad'];
    $fecha = $_POST['fecha'];
    $proveedor = $_POST['proveedor'];

    // Campos para producto nuevo (solo nombre y gama)
    $nuevo_nombre = trim($_POST['nuevo_nombre'] ?? "");
    $nuevo_gama = $_POST['nuevo_gama'] ?? "";
    $fechaHoy = date('Y-m-d');

    if (!is_numeric($cantidad) || $cantidad < 1) {
        $mensaje = '<div class="alert alert-danger">La cantidad debe ser mayor o igual a 1.</div>';
    } elseif ($fecha !== $fechaHoy) {
        $mensaje = '<div class="alert alert-danger">Solo puedes registrar la compra con la fecha de hoy (' . $fechaHoy . ').</div>';
    } elseif (empty($idProducto) && empty($nuevo_nombre)) {
        $mensaje = '<div class="alert alert-danger">Debes seleccionar un producto o registrar uno nuevo.</div>';
    } else {
        // Si es producto nuevo
        if (!empty($nuevo_nombre)) {
            if (empty($nuevo_gama)) {
                $mensaje = '<div class="alert alert-danger">Completa la gama del producto nuevo.</div>';
            } else {
                // Generar ID de producto único simple
                $newIdProducto = "PROD" . str_pad(rand(100,999) . time()%10000, 6, "0", STR_PAD_LEFT);
                // Insertar el producto nuevo con stock inicial = cantidad
                $stmtNew = $conexion->prepare("INSERT INTO productos (ID_Producto, Nombre_Producto, Descripcion, Precio_Venta, Stock_Minimo, ID_Categoria, ID_Estado, ID_Gama) VALUES (?, ?, '', 0, ?, ?, 'EST001', ?)");
                $stmtNew->bind_param("ssiss", $newIdProducto, $nuevo_nombre, $cantidad, $categoria_defecto, $nuevo_gama);
                if($stmtNew->execute()) {
                    // Éxito, no es necesario registrar en compras/detalle
                    header("Location: compra.php?msg=ok");
                    exit();
                } else {
                    $mensaje = '<div class="alert alert-danger">No se pudo registrar el producto nuevo.</div>';
                }
                $stmtNew->close();
            }
        } else {
            // Producto existente: flujo de compra/detalle normal
            // Insertar en compras (ignora si ya existe la clave primaria)
            $stmt = $conexion->prepare("INSERT IGNORE INTO compras (ID_Entrada, Precio_Compra, ID_Producto, Documento_Empleado) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sdss", $idEntrada, $precio, $idProducto, $empleado);
            $ok1 = $stmt->execute();
            $stmt->close();

            // 2. Insertar en detalle_compras (solo si existe la compra principal)
            $check = $conexion->prepare("SELECT 1 FROM compras WHERE ID_Entrada = ?");
            $check->bind_param("s", $idEntrada);
            $check->execute();
            $check->store_result();

            if ($check->num_rows > 0) {
                $stmt2 = $conexion->prepare("INSERT INTO detalle_compras (Fecha_Entrada, Cantidad, ID_Proveedor, ID_Entrada) VALUES (?, ?, ?, ?)");
                $stmt2->bind_param("siss", $fecha, $cantidad, $proveedor, $idEntrada);
                if ($stmt2->execute()) {
                    header("Location: compra.php?msg=ok");
                    exit();
                } else {
                    $mensaje = '<div class="alert alert-danger">Error al guardar en detalle_compras. Revisa los datos.</div>';
                }
                $stmt2->close();
            } else {
                $mensaje = '<div class="alert alert-danger">Error: No se pudo registrar la compra principal.</div>';
            }
            $check->close();
        }
    }
}

// Consulta para mostrar los datos
$sql = "SELECT c.ID_Entrada, c.Precio_Compra, c.ID_Producto, c.Documento_Empleado, 
        d.Cantidad, d.Fecha_Entrada, d.ID_Proveedor
        FROM compras c
        JOIN detalle_compras d ON c.ID_Entrada = d.ID_Entrada
        ORDER BY d.Fecha_Entrada DESC";
$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/compra.css" />
  <title>Compras</title>
</head>
<body>

<a href="../html/Index.html">
    <img src="../Imagenes/Logo.webp" alt="Logo esquina" class="logo" />
  </a>
  <div class="cabecera">
    <h1 class="titulo">Compras</h1>
  </div>


  <?php
    if (isset($_GET['msg']) && $_GET['msg'] == 'ok') {
        echo '<div class="alert alert-success">¡Compra registrada correctamente!</div>';
    } elseif (isset($_GET['msg']) && $_GET['msg'] == 'error') {
        echo '<div class="alert alert-danger">Ocurrió un error al registrar la compra.</div>';
    }
    if ($mensaje) echo $mensaje;
  ?>

<form class="container mt-3" method="POST" autocomplete="off">
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
            <option value="<?= $p['ID_Producto'] ?>"><?= $p['ID_Producto'] ?> - <?= $p['Nombre_Producto'] ?></option>
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
        while($gama = $gamasReselect->fetch_assoc()): ?>
          <option value="<?= $gama['ID_Gama'] ?>"><?= $gama['Nombre_Gama'] ?></option>
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
            <option value="<?= $e['Documento_Empleado'] ?>"><?= $e['Documento_Empleado'] ?></option>
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
            <option value="<?= $pr['ID_Proveedor'] ?>"><?= $pr['ID_Proveedor'] ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="col-12 text-center mt-4">
      <button type="submit" class="btn btn-primary">Guardar Compra</button>
    </div>
  </div>
</form>

<div class="container mt-5">
  <h2 class="titulo text-center text-dark mb-4">Compras Registradas</h2>
  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-primary">
        <tr>
          <th>ID Entrada</th>
          <th>Precio Compra</th>
          <th>ID Producto</th>
          <th>Documento Empleado</th>
          <th>Cantidad</th>
          <th>Fecha Entrada</th>
          <th>ID Proveedor</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['ID_Entrada'] ?></td>
          <td>$<?= number_format($row['Precio_Compra'],2) ?></td>
          <td><?= $row['ID_Producto'] ?></td>
          <td><?= $row['Documento_Empleado'] ?></td>
          <td><?= $row['Cantidad'] ?></td>
          <td><?= $row['Fecha_Entrada'] ?></td>
          <td><?= $row['ID_Proveedor'] ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<footer class="footer">
  <p>Copyright © 2025 Fonrio</p>
</footer>

<script>
window.addEventListener('pageshow', function(event) {
    if (event.persisted || (performance && performance.getEntriesByType && performance.getEntriesByType("navigation")[0]?.type === "back_forward")) {
        window.location.href = 'InicioA.php';
    }
});
</script>
</body>
</html>
<?php $conexion->close();?> asi quedo solo cambie el html y el css