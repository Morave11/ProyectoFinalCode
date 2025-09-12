<?php
// Pedir el nombre del cliente
$nombre = readline("Por favor, ingresa el nombre del cliente: ");

// Consumir el endpoint
$url = "http://localhost:8080/Detalles";
$consumo = file_get_contents($url);

if ($consumo === FALSE) {
    die("Error al consumir el servicio.\n");
}

// Decodificar JSON en un array de strings
$clientes = json_decode($consumo, true);

$encontrado = false;
foreach ($clientes as $linea) {
    // Separar por "________"
    $campos = explode("________", $linea);

    // Buscar coincidencia parcial en el nombre
    if (stripos($campos[1], $nombre) !== false) {
        $encontrado = true;

        echo "------------------------\n";
        echo "Documento: " . $campos[0] . "\n";
        echo "Nombre: " . $campos[1] . "\n";
        echo "Apellido: " . $campos[2] . "\n";
        echo "Teléfono: " . $campos[3] . "\n";
        echo "Fecha de nacimiento: " . $campos[4] . "\n";
        echo "Género: " . $campos[5] . "\n";
        echo "Estado: " . $campos[6] . "\n";
    }
}

if (!$encontrado) {
    echo "Cliente no encontrado.\n";
}
?>
