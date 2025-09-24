<?php
$mensaje = $mensaje ?? '';
$ventas  = $ventas ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Ventas</title>
</head>
<body>
<h1>Lista de Ventas</h1>

<?= $mensaje ?>

<?php if (is_array($ventas) && !empty($ventas)): ?>
<ul>
<?php foreach ($ventas as $v): ?>
    <?php
        $partes = is_string($v) ? explode('________', $v) : [];
        $ID_Venta          = $partes[0] ?? '';
        $Documento_Cliente = $partes[1] ?? '';
        $Documento_Empleado= $partes[2] ?? '';
    ?>
    <li>
        <strong><?= htmlspecialchars($ID_Venta) ?></strong>
        | Cliente: <?= htmlspecialchars($Documento_Cliente) ?>
        | Empleado: <?= htmlspecialchars($Documento_Empleado) ?>
    </li>
<?php endforeach; ?>
</ul>
<?php else: ?>
<p style="color:red;">Error al obtener las ventas.</p>
<?php endif; ?>

<hr>


<h2>Registrar venta</h2>
<form method="POST">
<label>ID Venta:</label><br>
<input type="text" name="ID_Venta" required><br><br>

<label>Documento Cliente:</label><br>
<input type="text" name="Documento_Cliente" required><br><br>

<label>Documento Empleado:</label><br>
<input type="text" name="Documento_Empleado" required><br><br>

<input type="submit" value="Registrar Venta">
</form>

<hr>


<h2>Actualizar venta</h2>
<form method="POST">
    <input type="hidden" name="_method" value="PUT">

    <label>ID Venta a actualizar:</label><br>
    <input type="text" name="ID_Venta" required><br><br>

    <label>Nuevo Documento Cliente:</label><br>
    <input type="text" name="Documento_Cliente"><br><br>

    <label>Nuevo Documento Empleado:</label><br>
    <input type="text" name="Documento_Empleado"><br><br>

    <input type="submit" value="Actualizar Venta">
</form>

<hr>


<h2>Eliminar venta</h2>
<form method="POST">
    <input type="hidden" name="_method" value="DELETE">

    <label>ID Venta a eliminar:</label><br>
    <input type="text" name="ID_Venta" required><br><br>

    <input type="submit" value="Eliminar Venta" style="background:red;color:white;">
</form>

</body>
</html>
