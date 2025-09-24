<?php
$mensaje   = $mensaje   ?? '';
$productos = $productos ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Productos</title>
</head>
<body>
<h1>Lista de Productos</h1>

<?= $mensaje ?>

<?php if (is_array($productos) && !empty($productos)): ?>
  <ul>
  <?php foreach ($productos as $p): ?>
    <?php
      $partes = is_string($p) ? explode('________', $p) : [];
      $ID_Producto    = $partes[0] ?? '';
      $Nombre         = $partes[1] ?? '';
      $Descripcion    = $partes[2] ?? '';
      $Precio         = $partes[3] ?? '';
      $Stock          = $partes[4] ?? '';
      $ID_Categoria   = $partes[5] ?? '';
      $ID_Estado      = $partes[6] ?? '';
      $ID_Gama        = $partes[7] ?? '';
    ?>
    <li>
      <strong><?= htmlspecialchars($ID_Producto) ?></strong>
      <?= htmlspecialchars($Nombre) ?>
      | Precio: <?= htmlspecialchars($Precio) ?>
      | Stock: <?= htmlspecialchars($Stock) ?>
      | Desc: <?= htmlspecialchars($Descripcion) ?>
      | Cat: <?= htmlspecialchars($ID_Categoria) ?>
      | Est: <?= htmlspecialchars($ID_Estado) ?>
      | Gama: <?= htmlspecialchars($ID_Gama) ?>
    </li>
  <?php endforeach; ?>
  </ul>
<?php else: ?>
  <p style="color:red;">Error al obtener los productos.</p>
<?php endif; ?>

<hr>


<h2>Agregar nuevo producto</h2>
<form id="formCreate" method="POST">
  <label>ID del Producto:</label><br>
  <input type="text" name="ID_Producto" required><br><br>

  <label>Nombre del Producto:</label><br>
  <input type="text" name="Nombre_Producto" required><br><br>

  <label>Precio de Venta:</label><br>
  <input type="number" step="0.01" name="Precio_Venta" required><br><br>

  <label>Stock:</label><br>
  <input type="number" name="Stock_Minimo" required><br><br>

  <label>Descripción:</label><br>
  <textarea name="Descripcion"></textarea><br><br>

  <label>Fotos (URL o ruta):</label><br>
  <input type="text" name="Fotos"><br><br>

  <label>ID Categoría:</label><br>
  <input type="text" name="ID_Categoria" required><br><br>

  <label>ID Estado:</label><br>
  <input type="text" name="ID_Estado" required><br><br>

  <label>ID Gama:</label><br>
  <input type="text" name="ID_Gama" required><br><br>

  <input type="submit" value="Agregar Producto">
</form>

<hr>


<h2>Actualizar producto</h2>
<form id="formUpdate" method="POST">
  <input type="hidden" name="_method" value="PUT">

  <label>ID del Producto a actualizar:</label><br>
  <input type="text" name="ID_Producto" required><br><br>

  <!-- Deja estos sin required para poder actualizar parcialmente -->
  <label>Nuevo nombre:</label><br>
  <input type="text" name="Nombre_Producto"><br><br>

  <label>Nuevo precio:</label><br>
  <input type="number" step="0.01" name="Precio_Venta"><br><br>

  <label>Nuevo stock:</label><br>
  <input type="number" name="Stock_Minimo"><br><br>

  <label>Nueva descripción:</label><br>
  <textarea name="Descripcion"></textarea><br><br>

  <label>Nueva foto (URL o ruta):</label><br>
  <input type="text" name="Fotos"><br><br>

  <label>Nueva categoría:</label><br>
  <input type="text" name="ID_Categoria"><br><br>

  <label>Nuevo estado:</label><br>
  <input type="text" name="ID_Estado"><br><br>

  <label>Nueva gama:</label><br>
  <input type="text" name="ID_Gama"><br><br>

  <input type="submit" value="Actualizar Producto">
</form>

<hr>


<h2>Eliminar producto</h2>
<form id="formDelete" method="POST">
  <input type="hidden" name="_method" value="DELETE">

  <label>ID del Producto a eliminar:</label><br>
  <input type="text" name="ID_Producto" required><br><br>

  <input type="submit" value="Eliminar Producto" style="background:red;color:white;">
</form>

</body>
</html>