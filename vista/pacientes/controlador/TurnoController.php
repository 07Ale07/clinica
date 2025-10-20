<?php
require_once __DIR__ . '/../modelo/OdontologoModel.php';
require_once __DIR__ . '/../modelo/TurnoModel.php';

class TurnoController {
    private $odontologoModel;
    private $turnoModel;

    public function __construct() {
        $this->odontologoModel = new OdontologoModel();
        $this->turnoModel = new TurnoModel();
    }

    public function obtenerOdontologos() {
        return $this->odontologoModel->obtenerOdontologos();
    }

    public function crearTurno($id_persona, $id_empleado, $fecha, $hora) {
        // Validaciones adicionales
        if (!$this->validarFechaHora($fecha, $hora)) {
            throw new Exception("Fecha u hora no válidas");
        }

        // Verificar si el paciente ya tiene un turno ese día
        if ($this->turnoModel->verificarTurnoExistente($id_persona, $fecha)) {
            throw new Exception("Ya tiene un turno agendado para esta fecha");
        }

        return $this->turnoModel->crearTurno($id_persona, $id_empleado, $fecha, $hora);
    }

    /**
     * Valida que la fecha y hora sean correctas
     */
    private function validarFechaHora($fecha, $hora) {
        // Verificar formato de fecha
        if (!DateTime::createFromFormat('Y-m-d', $fecha)) {
            return false;
        }

        // Verificar que no sea una fecha pasada
        $fechaObj = new DateTime($fecha);
        $hoy = new DateTime();
        if ($fechaObj < $hoy->setTime(0, 0, 0)) {
            return false;
        }

        // Verificar formato de hora
        if (!preg_match('/^([0-1][0-9]|2[0-3]):[0-5][0-9]$/', $hora)) {
            return false;
        }

        // Verificar que esté en horario laboral (9-12 y 15-18)
        $horaNum = (int) explode(':', $hora)[0];
        if (($horaNum < 9 || $horaNum > 18) || ($horaNum > 12 && $horaNum < 15)) {
            return false;
        }

        // Verificar que no sea fin de semana
        $diaSemana = $fechaObj->format('w');
        if ($diaSemana == 0 || $diaSemana == 6) { // 0 = Domingo, 6 = Sábado
            return false;
        }

        return true;
    }

    /**
     * Obtiene horarios disponibles para un odontólogo en una fecha específica
     */
    public function obtenerHorariosDisponibles($id_empleado, $fecha) {
        $horariosLaborales = ['09:00', '10:00', '11:00', '12:00', '15:00', '16:00', '17:00', '18:00'];
        $horariosDisponibles = [];

        foreach ($horariosLaborales as $hora) {
            if ($this->odontologoModel->verificarDisponibilidad($id_empleado, $fecha, $hora)) {
                $horariosDisponibles[] = $hora;
            }
        }

        return $horariosDisponibles;
    }
}
?>