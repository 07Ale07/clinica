<?php
// Credenciales de la base de datos
$servidor = 'localhost';
$usuario = 'root';
$password = '';
$base = 'clinica';

// Crea una nueva conexión
$conexion = new mysqli($servidor, $usuario, $password, $base);

// Verifica si la conexión falló
if ($conexion->connect_error) {
    // Si falla, termina la ejecución y muestra el error
    die("Error de conexión: " . $conexion->connect_error);
}
?>