<?php

$mensaje = $mensaje ?? '';
$compras = $compras ?? [];   
?>  
<!DOCTYPE html>
<html lang="es">    
<head>
    <meta charset="UTF-8">
    <title>Compras</title>
</head>
<body>  
<h1>Lista de Compras</h1>
<?= $mensaje ?>

<?php if (is_array($compras) && !empty($compras)): ?>
    <ul>
        <?php foreach ($compras as $c): ?>
            <?php
            // Tu API devuelve cada fila como string con "________"
            $partes = is_string($c) ? explode('________', $c) : [];
            $ID_Entrada         = $partes[0] ?? '';
            $Precio_Compra      = $partes[1] ?? '';
            $ID_Producto        = $partes[2] ?? '';
            $Documento_Empleado = $partes[3] ?? '';
            ?>
            <li>
                <strong><?= htmlspecialchars($ID_Entrada) ?></strong>
                | Precio: <?= htmlspecialchars($Precio_Compra) ?>
                | Producto ID: <?= htmlspecialchars($ID_Producto) ?>
                | Empleado Doc: <?= htmlspecialchars($Documento_Empleado) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p style="color:red;">Error al obtener las compras.</p> 
<?php endif; ?>
<h2>Agregar nueva compra</h2>
<form method="POST">        
    <label for="ID_Entrada">ID de la Entrada:</label><br>
    <input type="text" name="ID_Entrada" id="ID_Entrada" required><br><br>

    <label for="Precio_Compra">Precio de Compra:</label><br>
    <input type="number" step="0.01" name="Precio_Compra" id="Precio_Compra" required><br><br>

    <label for="ID_Producto">ID del Producto:</label><br>
    <input type="text" name="ID_Producto" id="ID_Producto" required><br><br>

    <label for="Documento_Empleado">Documento del Empleado:</label><br>
    <input type="text" name="Documento_Empleado" id="Documento_Empleado" required><br><br>

    <input type="submit" value="Agregar Compra">    
</form>

<hr>
<h2>Actualizar compra</h2>
<form id="formUpdate" method="POST">
  <input type="hidden" name="_method" value="PUT">

    <label >ID de la Entrada a actualizar:</label><br>
    <input type="text" name="ID_Entrada"  required><br><br> 

    <label >Nuevo Precio de Compra:</label><br>
    <input type="number" step="0.01" name="Precio_Compra" ><br><br>

    <label >Nuevo ID del Producto:</label><br>
    <input type="text" name="ID_Producto" ><br><br>  
        
    <label >Nuevo Documento del Empleado:</label><br>
    <input type="text" name="Documento_Empleado" ><br><br>

    <input type="submit" value="Actualizar Compra"> 
</form>

<hr>
<h2>Eliminar compra</h2>
<form id="formDelete" method="POST">
  <input type="hidden" name="_method" value="DELETE">

    <label >ID de la Entrada a eliminar:</label><br>
    <input type="text" name="ID_Entrada"  required><br><br> 

    <input type="submit" value="Eliminar Compra" style="background:red;color:white;">

</body> 
</html>