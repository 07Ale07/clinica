<?php
// controlador_odontologo.php
session_start();
$idOdontologo = $_SESSION['id_empleado'] ?? 1;

require_once 'modelo/modelo_odontologo.php';
$odontologoModelo = new OdontologoModelo($enlace);

// Obtener los turnos del día siempre
$turnosHoy = $odontologoModelo->obtenerTurnosDelDia($idOdontologo);

// Inicializar variables para los resultados
$pacientes = [];
$historial = [];
$paciente_buscado = null;
$horarios = [];
$citas = [];
$historialPacientesAtendidos = []; // Nueva variable para historial de pacientes atendidos
$usuarioData = []; // Nueva variable para datos de usuario

// Manejar las acciones del usuario
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'buscar_paciente':
            if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
                $pacientes = $odontologoModelo->buscarPacientes(trim($_GET['query']));
            }
            break;
            
        case 'ver_historial':
            if (isset($_GET['id_paciente'])) {
                $idPaciente = intval($_GET['id_paciente']);
                $paciente_buscado = $odontologoModelo->obtenerDatosPaciente($idPaciente);
                $historial = $odontologoModelo->obtenerHistorialPaciente($idPaciente);
            }
            break;

        case 'ver_horarios':
            $dia = $_GET['dia'] ?? null;
            $fecha = $_GET['fecha'] ?? date('Y-m-d');
            $horarios = $odontologoModelo->obtenerHorariosOdontologo($idOdontologo, $dia, $fecha);
            break;
            
        case 'ver_citas':
            $fecha = $_GET['fecha'] ?? date('Y-m-d');
            $citas = $odontologoModelo->obtenerCitasOdontologo($idOdontologo, $fecha)   ;
            break;

        // NUEVAS ACCIONES PARA HISTORIAL
        case 'ver_historial_todos':
            // Obtener historial de todos los pacientes atendidos por el odontólogo
            $historialPacientesAtendidos = $odontologoModelo->obtenerHistorialPacientesAtendidos($idOdontologo);
            break;
            
        case 'obtener_usuario':
            if (isset($_GET['id_usuario'])) {
                $id_usuario = intval($_GET['id_usuario']);
                $usuarioData = $odontologoModelo->obtenerIdEmpleadoDesdeUsuario($id_usuario);
            }
            break;
    }
}

// Cargar la vista principal
require_once 'vista/vista_odontologo.php';
?>