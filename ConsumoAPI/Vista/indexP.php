<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
</head>
<body>
    <h1>Lista de Productos</h1>
    <?= $mensaje ?? ''?>
    
    <?php if (is_array($productos)): ?>
        <ul>
            <?php foreach ($productos as $producto):?>
                <li> <?= htmlspecialchars($producto["ID_Producto"] ?? (string)$producto)?> </li>
                <?php endforeach;?>
        </ul>
    <?php else: ?> 
    <p style = "color:red;"> Error al obtener los Productos.</p>
    <?php endif; ?>
    
    <h2>Agregar nuevo Producto</h2>

    <form method="POST">
        <label for = "ID_Producto"> ID del Producto</label><br>
        <input type ="text" name="ID_Producto" id = "ID_Producto" required><br>
        <input type="submit" value="Agregar Producto">
    </form>
</body>
</html>