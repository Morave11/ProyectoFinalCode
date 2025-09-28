<?php
require_once __DIR__ . '/Controlador/crudProductoController.php';

$controller = new crudProductoController();
$controller->manejarPeticion();
