<?php
require_once __DIR__ . '/Controlador/ClienteController.php';

// Crear instancia del controlador y manejar la petición
$controller = new ClienteController();
$controller->manejarPeticioncliente();
