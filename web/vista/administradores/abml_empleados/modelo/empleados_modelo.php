<?php
require_once(__DIR__ . '/../conexion.php');

function obtenerCargos($solo_activos = true) {
    global $enlace;
    $sql = "SELECT * FROM cargos";
    return $enlace->query($sql);
}

function obtenerEmpleadosConPersonas() {
    global $enlace;
    $sql = "SELECT e.id_empleado, e.numero_legajo, e.tipo_contrato, e.telefono_interno,
                   p.nombre, p.apellido, p.DNI,
                   c.cargo
            FROM empleados e
            JOIN personas p ON e.id_persona = p.id_persona
            JOIN cargo_empleados ce ON ce.id_empleado = e.id_empleado
            JOIN cargos c ON c.id_cargo = ce.id_cargo";
    return $enlace->query($sql);
}

function insertarPersona($nombre, $apellido, $dni) {
    global $enlace;
    $stmt = $enlace->prepare("INSERT INTO personas (nombre, apellido, DNI) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $apellido, $dni);
    $stmt->execute();
    return $enlace->insert_id;
}

function insertarEmpleado($id_persona, $tipo_contrato, $numero_legajo, $telefono_interno) {
    global $enlace;
    $stmt = $enlace->prepare("INSERT INTO empleados (id_persona, tipo_contrato, numero_legajo, telefono_interno) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $id_persona, $tipo_contrato, $numero_legajo, $telefono_interno);
    $stmt->execute();
    return $enlace->insert_id;
}

function asignarCargo($id_empleado, $id_cargo) {
    global $enlace;
    $stmt = $enlace->prepare("INSERT INTO cargo_empleados (id_empleado, id_cargo) VALUES (?, ?)");
    $stmt->bind_param("ii", $id_empleado, $id_cargo);
    $stmt->execute();
}
