<?php
require_once 'modelo/CitaModel.php';

class CitaController {
    private $citaModel;

    public function __construct() {
        $this->citaModel = new CitaModel();
    }

    public function obtenerCitasPorPaciente($id_paciente) {
        return $this->citaModel->obtenerCitasPorPaciente($id_paciente);
    }

    public function cancelarCita($id_cita) {
        return $this->citaModel->cancelarCita($id_cita);
    }

    public function obtenerCitaPorId($id_cita) {
        return $this->citaModel->obtenerCitaPorId($id_cita);
    }
}
?>