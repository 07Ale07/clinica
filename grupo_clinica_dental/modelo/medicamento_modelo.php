<?php

function agregarMedicamento($conexion, $nombre, $stock, $precio, $fecha_caducidad) {
    $sql = "INSERT INTO medicamentos (nombre, stock, precio, fecha_caducidad) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sids", $nombre, $stock, $precio, $fecha_caducidad);
    $stmt->execute();
    $stmt->close();
}

function eliminarMedicamento($conexion, $id) {
    $sql = "DELETE FROM medicamentos WHERE id_medicamento = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

function modificarMedicamento($conexion, $id, $nombre, $stock, $precio, $fecha_caducidad) {
    $sql = "UPDATE medicamentos SET nombre = ?, stock = ?, precio = ?, fecha_caducidad = ? WHERE id_medicamento = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sidsi", $nombre, $stock, $precio, $fecha_caducidad, $id);
    $stmt->execute();
    $stmt->close();
}

function listarMedicamentos($conexion) {
    $sql = "SELECT id_medicamento, nombre, stock, precio, fecha_caducidad FROM medicamentos";
    $result = $conexion->query($sql);
    $medicamentos = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $medicamentos[] = $row;
        }
    }
    return $medicamentos;
}

/**
 * Registra una entrada o salida en el inventario y actualiza el stock del medicamento.
 */
function registrarMovimientoStock($conexion, $id_medicamento, $cantidad, $tipo, $motivo) {
    // 1. Actualiza el stock en la tabla de medicamentos
    if ($tipo === 'entrada') {
        $sql = "UPDATE medicamentos SET stock = stock + ? WHERE id_medicamento = ?";
    } else { // 'salida'
        $sql = "UPDATE medicamentos SET stock = stock - ? WHERE id_medicamento = ?";
    }
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $cantidad, $id_medicamento);
    $stmt->execute();
    $stmt->close();

    // 2. Registra el movimiento en la tabla de movimientos_stock
    $sql = "INSERT INTO movimientos_stock (id_medicamento, cantidad, tipo_movimiento, motivo) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iiss", $id_medicamento, $cantidad, $tipo, $motivo);
    $stmt->execute();
    $stmt->close();
}

/**
 * Obtiene el historial de todos los movimientos de stock.
 */
function obtenerHistorialMovimientos($conexion) {
    $sql = "SELECT m.nombre, ms.cantidad, ms.tipo_movimiento, ms.fecha_movimiento, ms.motivo 
            FROM movimientos_stock ms
            JOIN medicamentos m ON ms.id_medicamento = m.id_medicamento
            ORDER BY ms.fecha_movimiento DESC";
    $result = $conexion->query($sql);
    $movimientos = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $movimientos[] = $row;
        }
    }
    return $movimientos;
}

/**
 * Obtiene los medicamentos con un stock por debajo de un umbral.
 */
function obtenerMedicamentosBajoStock($conexion, $umbral = 10) {
    $sql = "SELECT nombre, stock FROM medicamentos WHERE stock <= ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $umbral);
    $stmt->execute();
    $result = $stmt->get_result();
    $medicamentos_bajos = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $medicamentos_bajos[] = $row;
        }
    }
    $stmt->close();
    return $medicamentos_bajos;
}

/**
 * Obtiene los medicamentos que caducan en los próximos 30 días.
 */
function obtenerMedicamentosPorCaducar($conexion) {
    $sql = "SELECT nombre, fecha_caducidad FROM medicamentos WHERE fecha_caducidad <= CURDATE() + INTERVAL 30 DAY AND fecha_caducidad >= CURDATE() ORDER BY fecha_caducidad ASC";
    $result = $conexion->query($sql);
    $medicamentos_caducar = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $medicamentos_caducar[] = $row;
        }
    }
    return $medicamentos_caducar;
}
?>