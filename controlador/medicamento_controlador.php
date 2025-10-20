<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Clinica/web/vista/conexion.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Clinica/web/modelo/medicamento_modelo.php');

function obtenerMedicamentos() {
    global $conexion;
    return listarMedicamentos($conexion);
}

function obtenerInformesFarmacia() {
    global $conexion;
    $movimientos = obtenerHistorialMovimientos($conexion);
    $bajo_stock = obtenerMedicamentosBajoStock($conexion);
    $por_caducar = obtenerMedicamentosPorCaducar($conexion);
    return ['movimientos' => $movimientos, 'bajo_stock' => $bajo_stock, 'por_caducar' => $por_caducar];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    
    global $conexion;

    switch ($accion) {
        case 'agregar':
            $nombre = $_POST['nombre'];
            $stock = $_POST['stock'];
            $precio = $_POST['precio'];
            $fecha_caducidad = $_POST['fecha_caducidad'];
            agregarMedicamento($conexion, $nombre, $stock, $precio, $fecha_caducidad);
            break;
        case 'eliminar':
            $id = $_POST['id'];
            eliminarMedicamento($conexion, $id);
            break;
        case 'modificar':
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $stock = $_POST['stock'];
            $precio = $_POST['precio'];
            $fecha_caducidad = $_POST['fecha_caducidad'];
            modificarMedicamento($conexion, $id, $nombre, $stock, $precio, $fecha_caducidad);
            break;
        case 'entrada_stock':
            $id_medicamento = $_POST['id_medicamento'];
            $cantidad = $_POST['cantidad'];
            $motivo = $_POST['motivo'];
            registrarMovimientoStock($conexion, $id_medicamento, $cantidad, 'entrada', $motivo);
            break;
        default:
            break;
    }

    header('Location: /Clinica/web/vista/farmaceuticos/index_farmacia.php');
    exit;
}
?>