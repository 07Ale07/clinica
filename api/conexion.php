<?php

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'clinica_dental';

// Conectar a la base de datos
$conexion = new mysqli($host, $user, $password, $dbname);
if ($conexion->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en la conexión']);
    exit;
}

?>
