<?php
require_once __DIR__ . '/../modelo/Odontograma.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';
$odontograma = new Odontograma();

switch ($action) {
    case 'guardar':
        $data = json_decode(file_get_contents('php://input'), true);
        if ($odontograma->guardarOdontograma($data['id_paciente'], $data['odontograma'])) {
            echo json_encode(['success' => true, 'message' => 'Odontograma guardado']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al guardar']);
        }
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
}