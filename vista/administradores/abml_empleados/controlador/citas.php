<?php
require_once('../modelo/citas_modelo.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];

    if ($accion === 'crear') {
        insertarCita($_POST['id_paciente'], $_POST['id_empleado'], $_POST['id_sillon'],
                     $_POST['fecha_inicio'], $_POST['fecha_fin'], $_POST['estado'],
                     $_POST['tipo'], $_POST['observaciones']);
    }

    if ($accion === 'modificar') {
        modificarCita($_POST['id_cita'], $_POST['id_paciente'], $_POST['id_empleado'], $_POST['id_sillon'],
                      $_POST['fecha_inicio'], $_POST['fecha_fin'], $_POST['estado'],
                      $_POST['tipo'], $_POST['observaciones']);
    }

    if ($accion === 'desactivar') {
        desactivarCita($_POST['id_cita']);
    }

    header("Location: ../public/index.php");
    exit();
}
