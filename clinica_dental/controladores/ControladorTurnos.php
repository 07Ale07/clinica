<?php
// ARCHIVO: controladores/ControladorTurnos.php

// Incluir modelos necesarios
include_once 'modelos/Persona.php';
include_once 'modelos/Paciente.php';
include_once 'modelos/Profesional.php';
include_once 'modelos/Turno.php';
include_once 'modelos/Sillon.php';
include_once 'modelos/ObraSocial.php';
include_once 'modelos/HorarioProfesional.php';

class ControladorTurnos {
    private $turno;
    private $persona;
    private $paciente;
    private $profesional;
    private $sillon;
    private $obraSocial;
    private $horarioProfesional;
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
        $this->turno = new Turno($db);
        $this->persona = new Persona($db);
        $this->paciente = new Paciente($db);
        $this->profesional = new Profesional($db);
        $this->sillon = new Sillon($db);
        $this->obraSocial = new ObraSocial($db);
        $this->horarioProfesional = new HorarioProfesional($db);
    }
    
    // Mostrar el formulario de turno
    public function mostrarFormularioTurno() {
        $odontologos = $this->profesional->obtenerOdontologos();
        $sillones = $this->sillon->obtenerActivos();
        $obrasSociales = $this->obraSocial->obtenerActivas();
        
        include 'vistas/turnos/sacar_turno.php';
    }
    
    // Procesar solicitud de turno
    public function procesarTurno() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Verificar si el paciente ya existe
            $stmt = $this->persona->buscarPorDNI($_POST['dni']);
            
            if ($stmt->rowCount() > 0) {
                // Paciente existe
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $id_persona = $row['id_persona'];
                
                // Verificar si ya tiene registro en pacientes
                $stmtPaciente = $this->paciente->buscarPorPersona($id_persona);
                if ($stmtPaciente->rowCount() > 0) {
                    $rowPaciente = $stmtPaciente->fetch(PDO::FETCH_ASSOC);
                    $id_paciente = $rowPaciente['id_paciente'];
                } else {
                    // Crear registro en pacientes
                    $this->paciente->id_persona = $id_persona;
                    $this->paciente->id_obra_social = $_POST['id_obra_social'];
                    $this->paciente->nro_afiliado = $_POST['nro_afiliado'];
                    
                    if ($this->paciente->crear()) {
                        $id_paciente = $this->paciente->id_paciente;
                    } else {
                        $error = "Error al crear el registro del paciente.";
                        include 'vistas/turnos/error.php';
                        return;
                    }
                }
            } else {
                // Crear nueva persona
                $this->persona->nombre = $_POST['nombre'];
                $this->persona->apellido = $_POST['apellido'];
                $this->persona->fecha_nac = $_POST['fecha_nac'];
                $this->persona->dni = $_POST['dni'];
                $this->persona->telefono = $_POST['telefono'];
                $this->persona->sexo = $_POST['sexo'];
                $this->persona->estado = 1;
                
                if ($this->persona->crear()) {
                    $id_persona = $this->persona->id_persona;
                    
                    // Crear registro en pacientes
                    $this->paciente->id_persona = $id_persona;
                    $this->paciente->id_obra_social = $_POST['id_obra_social'];
                    $this->paciente->nro_afiliado = $_POST['nro_afiliado'];
                    
                    if ($this->paciente->crear()) {
                        $id_paciente = $this->paciente->id_paciente;
                    } else {
                        $error = "Error al crear el registro del paciente.";
                        include 'vistas/turnos/error.php';
                        return;
                    }
                } else {
                    $error = "Error al crear la persona.";
                    include 'vistas/turnos/error.php';
                    return;
                }
            }
            
            // Obtener el día de la semana de la fecha seleccionada
            $fecha_turno = $_POST['fecha_turno'];
            $dia_semana = $this->obtenerDiaSemana($fecha_turno);
            $hora_inicio = $_POST['hora_inicio'];
            
            // Verificar si el profesional está disponible en ese día y hora
            if ($this->horarioProfesional->verificarDisponibilidad($_POST['id_profesional'], $dia_semana, $hora_inicio)) {
                // Verificar disponibilidad de turno
                $hora_fin = date('H:i', strtotime($hora_inicio . ' +1 hour'));
                
                if ($this->turno->verificarDisponibilidad($_POST['id_profesional'], $fecha_turno, $hora_inicio, $hora_fin)) {
                    // Crear el turno
                    $this->turno->id_paciente = $id_paciente;
                    $this->turno->id_profesional = $_POST['id_profesional'];
                    $this->turno->id_sillon = $_POST['id_sillon'];
                    $this->turno->fecha_turno = $_POST['fecha_turno'];
                    $this->turno->hora_inicio = $hora_inicio;
                    $this->turno->hora_fin = $hora_fin;
                    $this->turno->estado = 'pendiente';
                    $this->turno->observaciones = $_POST['observaciones'];
                    
                    if ($this->turno->crear()) {
                        $mensaje = "Turno solicitado correctamente. Espera la confirmación.";
                        include 'vistas/turnos/exito.php';
                    } else {
                        $error = "Error al crear el turno.";
                        include 'vistas/turnos/error.php';
                    }
                } else {
                    $error = "El profesional ya tiene un turno en ese horario.";
                    $odontologos = $this->profesional->obtenerOdontologos();
                    $sillones = $this->sillon->obtenerActivos();
                    $obrasSociales = $this->obraSocial->obtenerActivas();
                    include 'vistas/turnos/sacar_turno.php';
                }
            } else {
                $error = "El profesional no atiende en el día y horario seleccionado.";
                $odontologos = $this->profesional->obtenerOdontologos();
                $sillones = $this->sillon->obtenerActivos();
                $obrasSociales = $this->obraSocial->obtenerActivas();
                include 'vistas/turnos/sacar_turno.php';
            }
        }
    }
    
    // Función auxiliar para obtener el día de la semana en español
    private function obtenerDiaSemana($fecha) {
        $dias = array(
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo'
        );
        
        $dia_ingles = date('l', strtotime($fecha));
        return isset($dias[$dia_ingles]) ? $dias[$dia_ingles] : '';
    }
    
    // Mostrar turnos del paciente
    public function verTurnosPaciente($dni) {
        // Buscar paciente por DNI
        $stmt = $this->persona->buscarPorDNI($dni);
        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_persona = $row['id_persona'];
            
            // Buscar si tiene registro en pacientes
            $stmtPaciente = $this->paciente->buscarPorPersona($id_persona);
            
            if ($stmtPaciente->rowCount() > 0) {
                $rowPaciente = $stmtPaciente->fetch(PDO::FETCH_ASSOC);
                $id_paciente = $rowPaciente['id_paciente'];
                
                // Obtener turnos del paciente
                $turnos = $this->turno->obtenerPorPaciente($id_paciente);
                include 'vistas/turnos/mis_turnos.php';
            } else {
                $error = "No se encontró registro de paciente.";
                include 'vistas/turnos/error.php';
            }
        } else {
            $error = "No se encontró persona con ese DNI.";
            include 'vistas/turnos/error.php';
        }
    }
}
?>