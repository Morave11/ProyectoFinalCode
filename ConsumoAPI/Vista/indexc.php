<?php
$mensaje  = $mensaje  ?? '';
$clientes = $clientes ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Clientes</title>
</head>
<body>
<h1>Lista de Clientes</h1>

<?= $mensaje ?>

<?php if (is_array($clientes) && !empty($clientes)): ?>
  <ul>
  <?php foreach ($clientes as $c): ?>
    <?php
      // Si tu API devuelve cada fila como string separada por ""
      $partes = is_string($c) ? explode('________', $c) : [];
      $Documento_Cliente = $partes[0] ?? '';
      $Nombre_Cliente    = $partes[1] ?? '';
      $Apellido_Cliente  = $partes[2] ?? '';
      $Telefono          = $partes[3] ?? '';
      $Fecha_Nacimiento  = $partes[4] ?? '';
      $Genero            = $partes[5] ?? '';
      $ID_Estado         = $partes[6] ?? '';
    ?>
    <li>
      <strong><?= htmlspecialchars($Documento_Cliente) ?></strong>
      <?= htmlspecialchars($Nombre_Cliente) ?>
      | Apellido: <?= htmlspecialchars($Apellido_Cliente) ?>
      | Teléfono: <?= htmlspecialchars($Telefono) ?>
      | Fecha Nac.: <?= htmlspecialchars($Fecha_Nacimiento) ?>
      | Género: <?= htmlspecialchars($Genero) ?>
      | Estado: <?= htmlspecialchars($ID_Estado) ?>
    </li>
  <?php endforeach; ?>
  </ul>
<?php else: ?>
  <p style="color:red;">Error al obtener los clientes.</p>
<?php endif; ?>

<hr>

<!-- ===== CREAR CLIENTE (POST) ===== -->
<h2>Agregar nuevo cliente</h2>
<form id="formCreate" method="POST">
  <label>Documento del Cliente:</label><br>
  <input type="text" name="Documento_Cliente" required><br><br>

  <label>Nombre:</label><br>
  <input type="text" name="Nombre_Cliente" required><br><br>

  <label>Apellido:</label><br>
  <input type="text" name="Apellido_Cliente" required><br><br>

  <label>Teléfono:</label><br>
  <input type="text" name="Telefono" required><br><br>

  <label>Fecha de Nacimiento:</label><br>
  <input type="date" name="Fecha_Nacimiento"><br><br>

  <label>Género:</label><br>
  <input type="text" name="Genero"><br><br>

  <label>ID Estado:</label><br>
  <input type="text" name="ID_Estado" required><br><br>

  <input type="submit" value="Agregar Cliente">
</form>

<hr>

<!-- ===== ACTUALIZAR CLIENTE (PUT simulado) ===== -->
<h2>Actualizar cliente</h2>
<form id="formUpdate" method="POST">
  <input type="hidden" name="_method" value="PUT">

  <label>Documento del Cliente a actualizar:</label><br>
  <input type="text" name="Documento_Cliente" required><br><br>

  <!-- Campos opcionales para actualización parcial -->
  <label>Nuevo Nombre:</label><br>
  <input type="text" name="Nombre_Cliente"><br><br>

  <label>Nuevo Apellido:</label><br>
  <input type="text" name="Apellido_Cliente"><br><br>

  <label>Nuevo Teléfono:</label><br>
  <input type="text" name="Telefono"><br><br>

  <label>Nueva Fecha de Nacimiento:</label><br>
  <input type="date" name="Fecha_Nacimiento"><br><br>

  <label>Nuevo Género:</label><br>
  <input type="text" name="Genero"><br><br>

  <label>Nuevo ID Estado:</label><br>
  <input type="text" name="ID_Estado"><br><br>

  <input type="submit" value="Actualizar Cliente">
</form>

<hr>

<!-- ===== ELIMINAR CLIENTE (DELETE simulado) ===== -->
<h2>Eliminar cliente</h2>
<form id="formDelete" method="POST">
  <input type="hidden" name="_method" value="DELETE">

  <label>Documento del Cliente a eliminar:</label><br>
  <input type="text" name="Documento_Cliente" required><br><br>

  <input type="submit" value="Eliminar Cliente" style="background:red;color:white;">
</form>

</body>
</html>