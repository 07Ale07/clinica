<?php
require_once __DIR__ . '/../modelo/PacienteModel.php';
require_once __DIR__ . '/../modelo/TurnoModel.php';
require 'modelo/OdontologoModel.php';
require_once 'controlador/PacienteController.php';
require_once __DIR__ . '/TurnoController.php';

class Router {
    private $viewsPath;

    public function __construct() {
        $this->viewsPath = VIEWS_PATH;
    }

    public function route() {
        $action = $_GET['action'] ?? 'index';

        try {
            switch ($action) {
                case 'verificar_paciente':
                    $this->verificarPaciente();
                    break;
                case 'registrar_paciente':
                    $this->registrarPaciente();
                    break;
                case 'seleccionar_odontologo':
                    $this->mostrarOdontologos();
                    break;
                case 'confirmar_turno':
                    $this->confirmarTurno();
                    break;
                case 'index':
                default:
                    $this->mostrarIndex();
            }
        } catch (Exception $e) {
            $this->mostrarError($e->getMessage());
        }
    }

    private function mostrarIndex() {
        include $this->viewsPath . 'index_view.php';
    }

    private function verificarPaciente() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dni = $_POST['dni'] ?? null;

            if (empty($dni)) {
                throw new Exception("DNI no proporcionado");
            }

            $controller = new PacienteController();
            $paciente = $controller->verificarPaciente($dni);

            if ($paciente) {
                $odontologos = (new TurnoController())->obtenerOdontologos();
                include $this->viewsPath . 'seleccion_odontologo.php';
            } else {
                include $this->viewsPath . 'registro_paciente.php';
            }
        } else {
            include $this->viewsPath . 'verificar_paciente.php';
        }
    }

    private function registrarPaciente() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $apellido = $_POST['apellido'] ?? '';
            $fecha_nac = $_POST['fecha_nac'] ?? '';
            $dni = $_POST['dni'] ?? '';

            if (empty($nombre) || empty($apellido) || empty($dni)) {
                throw new Exception("Datos incompletos");
            }

            $controller = new PacienteController();
            $id_persona = $controller->registrarPaciente($nombre, $apellido, $fecha_nac, $dni);

            if ($id_persona) {
                $odontologos = (new TurnoController())->obtenerOdontologos();
                include $this->viewsPath . 'seleccion_odontologo.php';
            } else {
                throw new Exception("Error al registrar paciente");
            }
        } else {
            throw new Exception("Método no permitido");
        }
    }

    private function mostrarOdontologos() {
        $controller = new TurnoController();
        $odontologos = $controller->obtenerOdontologos();
        include $this->viewsPath . 'seleccion_odontologo.php';
    }

    private function confirmarTurno() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_persona = $_POST['id_persona'] ?? null;
            $id_empleado = $_POST['id_odontologo'] ?? null;
            $fecha = $_POST['fecha'] ?? '';
            $hora = $_POST['hora'] ?? '';

            if (empty($id_persona) || empty($id_empleado) || empty($fecha) || empty($hora)) {
                throw new Exception("Datos de turno incompletos");
            }

            $controller = new TurnoController();
            $result = $controller->crearTurno($id_persona, $id_empleado, $fecha, $hora);

            if ($result) {
                include $this->viewsPath . 'confirmacion_turno.php';
            } else {
                throw new Exception("Error al crear el turno");
            }
        } else {
            throw new Exception("Método no permitido");
        }
    }

    private function mostrarError($mensaje) {
        // Podrías crear una vista específica para errores
        echo "<div class='error' style='color:red; padding:20px; border:1px solid #f00; margin:20px;'>";
        echo "<h2>Error</h2>";
        echo "<p>{$mensaje}</p>";
        echo "<a href='index.php' class='btn'>Volver al inicio</a>";
        echo "</div>";
    }
}