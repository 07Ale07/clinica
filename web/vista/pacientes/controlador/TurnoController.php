<?php
require_once __DIR__ . '/../modelo/OdontologoModel.php';
require_once __DIR__ . '/../modelo/TurnoModel.php';

class TurnoController {
    public function obtenerOdontologos() {
        $model = new OdontologoModel();
        return $model->obtenerOdontologos();
    }

    public function crearTurno($id_persona, $id_empleado, $fecha, $hora) {
        $model = new TurnoModel();
        return $model->crearTurno($id_persona, $id_empleado, $fecha, $hora);
    }
}