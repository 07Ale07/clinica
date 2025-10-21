<?php
// controller/subir_mensajes.php

require_once '../conexion.php'; // Asumiendo que esto define $conexion como mysqli

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $nombre = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['phone'] ?? '');
    $asunto = trim($_POST['subject'] ?? '');
    $mensaje = trim($_POST['message'] ?? '');

    // Validación básica
    if (empty($nombre) || empty($email) || empty($asunto) || empty($mensaje)) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos obligatorios deben estar llenos.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'El email no es válido.']);
        exit;
    }

    // Preparar y ejecutar la inserción
    $stmt = $conexion->prepare("INSERT INTO mensajes_contacto (nombre, email, telefono, asunto, mensaje) VALUES (?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sssss", $nombre, $email, $telefono, $asunto, $mensaje);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Mensaje enviado correctamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al enviar el mensaje: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta: ' . $conexion->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}

$conexion->close();
?>