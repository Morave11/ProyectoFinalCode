<?php
date_default_timezone_set('America/Bogota');

include 'conexion.php';

// Función para obtener el stock actual de un producto
function obtenerStock($conexion, $idProducto) {
    $res = $conexion->query("SELECT Stock_Minimo FROM Productos WHERE ID_Producto='$idProducto' LIMIT 1");
    if ($row = $res->fetch_assoc()) return (int)$row['Stock_Minimo'];
    return 0;
}

$mensaje = "";

// Cargar opciones para los selects
$clientes = $conexion->query("SELECT Documento_Cliente, CONCAT(Nombre_Cliente,' ',Apellido_Cliente) AS Nombre FROM Clientes");
$empleados = $conexion->query("SELECT Documento_Empleado, CONCAT(Nombre_Usuario,' ',Apellido_Usuario) AS Nombre FROM Empleados");
$productos = $conexion->query("SELECT ID_Producto, Nombre_Producto FROM Productos");

// AGREGAR
if (isset($_POST['agregar'])) {
    $ID_Venta = $_POST['ID_Venta'];
    $Documento_Cliente = $_POST['Documento_Cliente'];
    $Documento_Empleado = $_POST['Documento_Empleado'];
    $Cantidad = $_POST['Cantidad'];
    $Fecha_Salida = $_POST['Fecha_Salida'];
    $ID_Producto = $_POST['ID_Producto'];

    $fechaHoy = date('Y-m-d');
    $stockProducto = obtenerStock($conexion, $ID_Producto);

    if (!is_numeric($Cantidad) || $Cantidad < 1) {
        $mensaje = '<div class="alert alert-danger">La cantidad debe ser mayor o igual a 1.</div>';
    } elseif ($Cantidad > $stockProducto) {
        $mensaje = '<div class="alert alert-danger">No hay suficiente stock disponible para este producto. (Stock actual: ' . $stockProducto . ')</div>';
    } elseif ($Fecha_Salida !== $fechaHoy) {
        $mensaje = '<div class="alert alert-danger">Solo puedes seleccionar la fecha de hoy para la venta (' . $fechaHoy . ').</div>';
    } else {
        $conexion->query("INSERT INTO Ventas (ID_Venta, Documento_Cliente, Documento_Empleado) VALUES ('$ID_Venta', '$Documento_Cliente', '$Documento_Empleado')");
        $conexion->query("INSERT INTO Detalle_Ventas (Cantidad, Fecha_Salida, ID_Producto, ID_Venta) VALUES ('$Cantidad', '$Fecha_Salida', '$ID_Producto', '$ID_Venta')");
        header("Location: ventas.php?msg=ok");
        exit();
    }
}

// ELIMINAR
if (isset($_GET['eliminar'])) {
    $ID_Venta = $_GET['eliminar'];
    $conexion->query("DELETE FROM Detalle_Ventas WHERE ID_Venta='$ID_Venta'");
    $conexion->query("DELETE FROM Ventas WHERE ID_Venta='$ID_Venta'");
    header("Location: ventas.php?msg=del");
    exit();
}

// EDITAR / ACTUALIZAR
if (isset($_POST['actualizar'])) {
    $ID_Venta = $_POST['ID_Venta'];
    $Documento_Cliente = $_POST['Documento_Cliente'];
    $Documento_Empleado = $_POST['Documento_Empleado'];
    $Cantidad = $_POST['Cantidad'];
    $Fecha_Salida = $_POST['Fecha_Salida'];
    $ID_Producto = $_POST['ID_Producto'];

    $fechaHoy = date('Y-m-d');
    $stockProducto = obtenerStock($conexion, $ID_Producto);

    if (!is_numeric($Cantidad) || $Cantidad < 1) {
        $mensaje = '<div class="alert alert-danger">La cantidad debe ser mayor o igual a 1.</div>';
    } elseif ($Cantidad > $stockProducto) {
        $mensaje = '<div class="alert alert-danger">No hay suficiente stock disponible para este producto. (Stock actual: ' . $stockProducto . ')</div>';
    } elseif ($Fecha_Salida !== $fechaHoy) {
        $mensaje = '<div class="alert alert-danger">Solo puedes seleccionar la fecha de hoy para la venta (' . $fechaHoy . ').</div>';
    } else {
        $conexion->query("UPDATE Ventas SET Documento_Cliente='$Documento_Cliente', Documento_Empleado='$Documento_Empleado' WHERE ID_Venta='$ID_Venta'");
        $conexion->query("UPDATE Detalle_Ventas SET Cantidad='$Cantidad', Fecha_Salida='$Fecha_Salida', ID_Producto='$ID_Producto' WHERE ID_Venta='$ID_Venta'");
        header("Location: ventas.php?msg=edit");
        exit();
    }
}

// MOSTRAR LOS DATOS
$registros = $conexion->query(
    "SELECT v.*, dv.Cantidad, dv.Fecha_Salida, dv.ID_Producto
    FROM Ventas v
    JOIN Detalle_Ventas dv ON v.ID_Venta = dv.ID_Venta
    ORDER BY v.ID_Venta DESC"
);

// Para editar
$editando = false;
if (isset($_GET['editar'])) {
    $editando = true;
    $ID_Venta = $_GET['editar'];
    $res = $conexion->query(
        "SELECT v.*, dv.Cantidad, dv.Fecha_Salida, dv.ID_Producto
        FROM Ventas v
        JOIN Detalle_Ventas dv ON v.ID_Venta = dv.ID_Venta
        WHERE v.ID_Venta='$ID_Venta'"
    );
    $filaEditar = $res->fetch_assoc();

    // Para selects en edición
    $clientes = $conexion->query("SELECT Documento_Cliente, CONCAT(Nombre_Cliente,' ',Apellido_Cliente) AS Nombre FROM Clientes");
    $empleados = $conexion->query("SELECT Documento_Empleado, CONCAT(Nombre_Usuario,' ',Apellido_Usuario) AS Nombre FROM Empleados");
    $productos = $conexion->query("SELECT ID_Producto, Nombre_Producto FROM Productos");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Ventas</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/ventas.css">
</head>
<body>
<a href="../html/Inicio.html">
    <img src="../Imagenes/Logo.webp" alt="Logo esquina" class="logo" />
</a>
<div class="container my-5">
    <h2 class="text-center mb-4">CRUD de Ventas</h2>

    <?php
    // Mensajes de acciones
    if (isset($_GET['msg']) && $_GET['msg'] == 'ok') {
        echo '<div class="alert alert-success">¡Venta registrada correctamente!</div>';
    } elseif (isset($_GET['msg']) && $_GET['msg'] == 'edit') {
        echo '<div class="alert alert-success">¡Venta actualizada correctamente!</div>';
    } elseif (isset($_GET['msg']) && $_GET['msg'] == 'del') {
        echo '<div class="alert alert-success">¡Venta eliminada correctamente!</div>';
    } elseif (isset($_GET['msg']) && $_GET['msg'] == 'error') {
        echo '<div class="alert alert-danger">Ocurrió un error.</div>';
    }
    if ($mensaje) echo $mensaje;
    ?>

    <div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
    <?php if ($editando): ?>
        <div class="card shadow-sm mb-4">
        <div class="card-body">
        <h5 class="card-title mb-3">Editando venta: <?= $filaEditar['ID_Venta'] ?></h5>
        <form method="POST">
            <input type="hidden" name="ID_Venta" value="<?= $filaEditar['ID_Venta'] ?>">
            <div class="mb-2">
                <label class="form-label">Cliente</label>
                <select name="Documento_Cliente" class="form-select" required>
                    <option value="">Seleccione cliente</option>
                    <?php while($cl = $clientes->fetch_assoc()): ?>
                    <option value="<?= $cl['Documento_Cliente'] ?>" <?= ($cl['Documento_Cliente']==$filaEditar['Documento_Cliente']) ? 'selected':'' ?>>
                        <?= $cl['Nombre'] ?> (<?= $cl['Documento_Cliente'] ?>)
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-2">
                <label class="form-label">Empleado</label>
                <select name="Documento_Empleado" class="form-select" required>
                    <option value="">Seleccione empleado</option>
                    <?php while($em = $empleados->fetch_assoc()): ?>
                    <option value="<?= $em['Documento_Empleado'] ?>" <?= ($em['Documento_Empleado']==$filaEditar['Documento_Empleado']) ? 'selected':'' ?>>
                        <?= $em['Nombre'] ?> (<?= $em['Documento_Empleado'] ?>)
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-2">
                <label class="form-label">Cantidad</label>
                <input type="number" name="Cantidad" value="<?= $filaEditar['Cantidad'] ?>" class="form-control" required min="1">
            </div>
            <div class="mb-2">
                <label class="form-label">Fecha Salida</label>
                <input type="date" name="Fecha_Salida" value="<?= date('Y-m-d') ?>" class="form-control" required min="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Producto</label>
                <select name="ID_Producto" class="form-select" required>
                    <option value="">Seleccione producto</option>
                    <?php while($pr = $productos->fetch_assoc()): ?>
                    <option value="<?= $pr['ID_Producto'] ?>" <?= ($pr['ID_Producto']==$filaEditar['ID_Producto']) ? 'selected':'' ?>>
                        <?= $pr['Nombre_Producto'] ?> (<?= $pr['ID_Producto'] ?>)
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" name="actualizar" class="btn btn-warning">Actualizar</button>
                <a href="ventas.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
        </div>
        </div>
    <?php else: ?>
        <div class="card shadow-sm mb-4">
        <div class="card-body">
        <h5 class="card-title mb-3">Agregar nueva venta</h5>
        <form method="POST">
            <div class="mb-2">
                <label class="form-label">ID Venta</label>
                <input type="text" name="ID_Venta" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Cliente</label>
                <select name="Documento_Cliente" class="form-select" required>
                    <option value="">Seleccione cliente</option>
                    <?php while($cl = $clientes->fetch_assoc()): ?>
                    <option value="<?= $cl['Documento_Cliente'] ?>">
                        <?= $cl['Nombre'] ?> (<?= $cl['Documento_Cliente'] ?>)
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-2">
                <label class="form-label">Empleado</label>
                <select name="Documento_Empleado" class="form-select" required>
                    <option value="">Seleccione empleado</option>
                    <?php while($em = $empleados->fetch_assoc()): ?>
                    <option value="<?= $em['Documento_Empleado'] ?>">
                        <?= $em['Nombre'] ?> (<?= $em['Documento_Empleado'] ?>)
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-2">
                <label class="form-label">Cantidad</label>
                <input type="number" name="Cantidad" class="form-control" required min="1">
            </div>
            <div class="mb-2">
                <label class="form-label">Fecha Salida</label>
                <input type="date" name="Fecha_Salida" class="form-control" required min="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Producto</label>
                <select name="ID_Producto" class="form-select" required>
                    <option value="">Seleccione producto</option>
                    <?php while($pr = $productos->fetch_assoc()): ?>
                    <option value="<?= $pr['ID_Producto'] ?>">
                        <?= $pr['Nombre_Producto'] ?> (<?= $pr['ID_Producto'] ?>)
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" name="agregar" class="btn btn-primary w-100">Agregar</button>
        </form>
        </div>
        </div>
    <?php endif; ?>
    </div>
    </div>

    <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-primary">
        <tr>
            <th>ID Venta</th>
            <th>Cliente</th>
            <th>Empleado</th>
            <th>Cantidad</th>
            <th>Fecha Salida</th>
            <th>Producto</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $clientes_nombres = [];
        $c_n = $conexion->query("SELECT Documento_Cliente, CONCAT(Nombre_Cliente,' ',Apellido_Cliente) AS Nombre FROM Clientes");
        while($row = $c_n->fetch_assoc()){ $clientes_nombres[$row['Documento_Cliente']] = $row['Nombre']; }
        $empleados_nombres = [];
        $e_n = $conexion->query("SELECT Documento_Empleado, CONCAT(Nombre_Usuario,' ',Apellido_Usuario) AS Nombre FROM Empleados");
        while($row = $e_n->fetch_assoc()){ $empleados_nombres[$row['Documento_Empleado']] = $row['Nombre']; }
        $productos_nombres = [];
        $p_n = $conexion->query("SELECT ID_Producto, Nombre_Producto FROM Productos");
        while($row = $p_n->fetch_assoc()){ $productos_nombres[$row['ID_Producto']] = $row['Nombre_Producto']; }

        mysqli_data_seek($registros, 0);
        while($row = $registros->fetch_assoc()): ?>
        <tr>
            <td><?= $row['ID_Venta'] ?></td>
            <td><?= isset($clientes_nombres[$row['Documento_Cliente']]) ? $clientes_nombres[$row['Documento_Cliente']] . " ({$row['Documento_Cliente']})" : $row['Documento_Cliente'] ?></td>
            <td><?= isset($empleados_nombres[$row['Documento_Empleado']]) ? $empleados_nombres[$row['Documento_Empleado']] . " ({$row['Documento_Empleado']})" : $row['Documento_Empleado'] ?></td>
            <td><?= $row['Cantidad'] ?></td>
            <td><?= $row['Fecha_Salida'] ?></td>
            <td><?= isset($productos_nombres[$row['ID_Producto']]) ? $productos_nombres[$row['ID_Producto']] . " ({$row['ID_Producto']})" : $row['ID_Producto'] ?></td>
            <td class="acciones">
                <a href="ventas.php?editar=<?= urlencode($row['ID_Venta']) ?>" class="btn btn-warning btn-sm">Editar</a>
                <a href="ventas.php?eliminar=<?= urlencode($row['ID_Venta']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este registro?');">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>
    <script>
window.addEventListener('pageshow', function(event) {
    // Si la página se está mostrando desde el historial (al presionar "Atrás")
    if (event.persisted || (performance && performance.getEntriesByType && performance.getEntriesByType("navigation")[0]?.type === "back_forward")) {
        window.location.href = 'InicioA.php';
    }
});
</script>
</body>
</html>
<?php $conexion->close(); ?>
