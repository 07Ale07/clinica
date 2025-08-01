<?php
require_once __DIR__ . '/../modelo/PacienteModel.php';

class PacienteController {
    public function verificarPaciente($dni) {
        $model = new PacienteModel();
        return $model->buscarPorDni($dni);
    }

    public function registrarPaciente($nombre, $apellido, $fecha_nac, $dni) {
        $model = new PacienteModel();
        return $model->registrarPaciente($nombre, $apellido, $fecha_nac, $dni);
    }
}