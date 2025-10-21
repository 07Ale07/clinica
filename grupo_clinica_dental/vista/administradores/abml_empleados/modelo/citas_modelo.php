<?php
require_once(__DIR__ . '/../conexion.php');

function obtenerCitas() {
    global $enlace;
    $sql = "SELECT c.*, p.nombre, p.apellido, s.nombre AS nombre_sillon
            FROM citas c
            LEFT JOIN pacientes pa ON pa.id_paciente = c.id_paciente
            LEFT JOIN personas p ON p.id_persona = pa.id_persona
            LEFT JOIN sillones s ON s.id_sillon = c.id_sillon
            WHERE c.estado != 'cancelada'";
    return $enlace->query($sql);
}

function obtenerPacientes() {
    global $enlace;
    return $enlace->query("SELECT p.id_paciente, pe.nombre, pe.apellido 
                           FROM pacientes p 
                           JOIN personas pe ON pe.id_persona = p.id_persona");
}

function obtenerEmpleados() {
    global $enlace;
    return $enlace->query("SELECT e.id_empleado, pe.nombre, pe.apellido 
                           FROM empleados e 
                           JOIN personas pe ON pe.id_persona = e.id_persona");
}

function obtenerSillones() {
    global $enlace;
    return $enlace->query("SELECT * FROM sillones WHERE activo = 1");
}

function insertarCita($id_paciente, $id_empleado, $id_sillon, $fecha_inicio, $fecha_fin, $estado, $tipo, $observaciones) {
    global $enlace;
    $stmt = $enlace->prepare("INSERT INTO citas (id_paciente, id_empleado, id_sillon, fecha_inicio, fecha_fin, estado, tipo, observaciones)
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiisssss", $id_paciente, $id_empleado, $id_sillon, $fecha_inicio, $fecha_fin, $estado, $tipo, $observaciones);
    $stmt->execute();
}

function modificarCita($id_cita, $id_paciente, $id_empleado, $id_sillon, $fecha_inicio, $fecha_fin, $estado, $tipo, $observaciones) {
    global $enlace;
    $stmt = $enlace->prepare("UPDATE citas 
                              SET id_paciente=?, id_empleado=?, id_sillon=?, fecha_inicio=?, fecha_fin=?, estado=?, tipo=?, observaciones=? 
                              WHERE id_cita=?");
    $stmt->bind_param("iiisssssi", $id_paciente, $id_empleado, $id_sillon, $fecha_inicio, $fecha_fin, $estado, $tipo, $observaciones, $id_cita);
    $stmt->execute();
}

function desactivarCita($id_cita) {
    global $enlace;
    $stmt = $enlace->prepare("UPDATE citas SET estado='cancelada' WHERE id_cita=?");
    $stmt->bind_param("i", $id_cita);
    $stmt->execute();
}
