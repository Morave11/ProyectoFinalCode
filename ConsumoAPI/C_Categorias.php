<?php
// Preguntar al usuario si está registrado
$respuesta = readline("¿Estás registrado en el sistema? (si/no): ");

if ($respuesta != "si") {
    die("No tienes permiso\n");
}

echo "Tienes permisos para ver información.\n";

// Preguntar qué desea ver: ID o Nombre
$opcion = readline("¿Qué deseas ver? (0 = ID_Categoria, 1 = Nombre_Categoria): ");

$url = "http://localhost:8080/Categorias";

$consumo = file_get_contents($url);

if ($consumo === FALSE) {
    die("Error al consumir el servicio.\n");
}

$categorias = json_decode($consumo);

if (json_last_error() !== JSON_ERROR_NONE) {
    die("Error al decodificar JSON: " . json_last_error_msg() . "\n");
}

// Recorrer categorías
foreach ($categorias as $categoria) {
    // dividir el string en partes (ej: ["Celulares", "CAT001"])
    $partes = preg_split('/\s+/', trim($categoria));

    $id = array_pop($partes);         // último es el ID
    $nombre = implode(" ", $partes);  // lo demás es el nombre

    if ($opcion == "0") {
        echo $id . "\n"; // Solo ID
    } elseif ($opcion == "1") {
        echo $nombre . "\n"; // Solo Nombre
    } else {
        echo "Opción no válida\n";
        break;
    }
}
?>

