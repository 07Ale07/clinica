<?php
require_once(__DIR__ . '/../modelo/empleados_modelo.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $dni = $_POST['dni'];
    $tipo_contrato = $_POST['tipo_contrato'];
    $numero_legajo = $_POST['numero_legajo'];
    $telefono_interno = $_POST['telefono_interno'];
    $id_cargo = $_POST['id_cargo'];

    $id_persona = insertarPersona($nombre, $apellido, $dni);
    $id_empleado = insertarEmpleado($id_persona, $tipo_contrato, $numero_legajo, $telefono_interno);
    asignarCargo($id_empleado, $id_cargo);

    header("Location: ../index.php");
    exit();
}
