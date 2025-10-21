<?php
require_once __DIR__ . '/../modelo/PacienteModel.php';

class PacienteController {
    public function verificarPaciente($dni) {
        $model = new PacienteModel();
        return $model->buscarPorDni($dni);
    }

    public function registrarPaciente($nombre, $apellido, $fecha_nac, $dni) {
        // Sanitizar y validar datos antes de enviar al modelo
        $nombre = trim($nombre);
        $apellido = trim($apellido);
        $dni = trim($dni);
        
        if (empty($nombre) || empty($apellido) || empty($dni) || empty($fecha_nac)) {
            throw new Exception("Todos los campos son obligatorios");
        }

        $model = new PacienteModel();
        $id_persona = $model->registrarPaciente($nombre, $apellido, $fecha_nac, $dni);

        if (!$id_persona) {
            throw new Exception("Error al registrar el paciente. Por favor intente nuevamente.");
        }

        return $id_persona;
    }
}
?>