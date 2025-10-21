<?php
require_once __DIR__ . '/../modelo/PacienteModel.php';
require_once __DIR__ . '/../modelo/TurnoModel.php';
require_once __DIR__ . '/../modelo/CitaModel.php';
require 'modelo/OdontologoModel.php';
require_once 'controlador/PacienteController.php';
require_once 'controlador/TurnoController.php';
require_once 'controlador/CitController.php';
error_log("Datos recibidos: " . print_r($_POST, true));

class Router {
    private $viewsPath;
    private $citaController;

    public function __construct() {
        $this->viewsPath = VIEWS_PATH;
        $this->citaController = new CitaController();
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
                case 'consultar_turno':
                    $this->consultarTurno();
                    break;
                case 'cancelar_cita':
                    $this->cancelarCita();
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
            try {
                // Sanitización manual usando alternativas modernas
                $nombre = isset($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre']), ENT_QUOTES, 'UTF-8') : '';
                $apellido = isset($_POST['apellido']) ? htmlspecialchars(trim($_POST['apellido']), ENT_QUOTES, 'UTF-8') : '';
                $fecha_nac = isset($_POST['fecha_nac']) ? trim($_POST['fecha_nac']) : '';
                $dni = isset($_POST['dni']) ? preg_replace('/[^0-9]/', '', trim($_POST['dni'])) : '';
    
                // Validaciones básicas
                if (empty($nombre) || empty($apellido) || empty($fecha_nac) || empty($dni)) {
                    throw new Exception("Todos los campos son obligatorios");
                }
    
                if (!preg_match('/^[\p{L}\s]+$/u', $nombre)) {
                    throw new Exception("El nombre solo puede contener letras y espacios");
                }
    
                if (!preg_match('/^[\p{L}\s]+$/u', $apellido)) {
                    throw new Exception("El apellido solo puede contener letras y espacios");
                }
    
                if (!preg_match('/^\d{8,10}$/', $dni)) {
                    throw new Exception("El DNI debe contener entre 8 y 10 dígitos");
                }
    
                // Validación de fecha más robusta
                if (!DateTime::createFromFormat('Y-m-d', $fecha_nac)) {
                    throw new Exception("Formato de fecha inválido (use AAAA-MM-DD)");
                }
    
                $fecha_nac_obj = new DateTime($fecha_nac);
                $hoy = new DateTime();
                $edad_minima = (new DateTime())->sub(new DateInterval('P120Y')); // 120 años máximo
    
                if ($fecha_nac_obj > $hoy) {
                    throw new Exception("La fecha de nacimiento no puede ser futura");
                }
    
                if ($fecha_nac_obj < $edad_minima) {
                    throw new Exception("La edad máxima permitida es 120 años");
                }
    
                // Registrar el paciente
                $controller = new PacienteController();
                $id_persona = $controller->registrarPaciente($nombre, $apellido, $fecha_nac, $dni);
    
                if (!$id_persona) {
                    throw new Exception("Error al registrar el paciente. Por favor intente nuevamente.");
                }
    
                // Obtener odontólogos para la siguiente vista
                $odontologos = (new TurnoController())->obtenerOdontologos();
                if (empty($odontologos)) {
                    throw new Exception("No hay odontólogos disponibles para asignar turnos");
                }
    
                // Mostrar vista de selección de odontólogo
                include $this->viewsPath . 'seleccion_odontologo.php';
    
            } catch (Exception $e) {
                // Preparar datos para volver a mostrar el formulario
                $datos_formulario = [
                    'nombre' => $_POST['nombre'] ?? '',
                    'apellido' => $_POST['apellido'] ?? '',
                    'fecha_nac' => $_POST['fecha_nac'] ?? '',
                    'dni' => $_POST['dni'] ?? ''
                ];
                
                // Pasar el mensaje de error a la vista
                $error_message = $e->getMessage();
                
                // Incluir la vista de registro con los datos y el error
                include $this->viewsPath . 'registro_paciente.php';
            }
        } else {
            // Si no es POST, redirigir al inicio
            header('Location: index.php');
            exit();
        }
    }

    private function mostrarOdontologos() {
        $controller = new TurnoController();
        $odontologos = $controller->obtenerOdontologos();
        include $this->viewsPath . 'seleccion_odontologo.php';
    }

    private function confirmarTurno() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $id_persona = $_POST['id_persona'] ?? null;
                $id_empleado = $_POST['id_odontologo'] ?? null;
                $fecha = $_POST['fecha'] ?? '';
                $hora = $_POST['hora'] ?? '';
                $email = $_POST['email'] ?? '';

                if (empty($id_persona) || empty($id_empleado) || empty($fecha) || empty($hora)) {
                    throw new Exception("Datos de turno incompletos");
                }

                $controller = new TurnoController();
                $id_turno = $controller->crearTurno($id_persona, $id_empleado, $fecha, $hora);

                if ($id_turno) {
                    // Guardar datos para mostrar en la confirmación
                    $_SESSION['turno_confirmado'] = [
                        'id_turno' => $id_turno,
                        'fecha' => $fecha,
                        'hora' => $hora,
                        'email' => $email
                    ];
                    
                    include $this->viewsPath . 'confirmacion_turno.php';
                } else {
                    throw new Exception("Error al crear el turno");
                }
            } catch (Exception $e) {
                // Recargar la vista de selección de odontólogo con error
                $error_message = $e->getMessage();
                $odontologos = (new TurnoController())->obtenerOdontologos();
                include $this->viewsPath . 'seleccion_odontologo.php';
            }
        } else {
            throw new Exception("Método no permitido");
        }
    }

    private function consultarTurno() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dni = $_POST['dni'] ?? null;

            if (empty($dni)) {
                throw new Exception("DNI no proporcionado");
            }

            $controller = new PacienteController();
            $paciente = $controller->verificarPaciente($dni);

            if ($paciente) {
                // Obtener las citas del paciente usando el controlador de citas
                $citas = $this->citaController->obtenerCitasPorPaciente($paciente['id_paciente']);
                
                include $this->viewsPath . 'consultar_turno.php';
            } else {
                $error_message = "No se encontró un paciente con el DNI proporcionado.";
                include $this->viewsPath . 'consultar_turno.php';
            }
        } else {
            include $this->viewsPath . 'consultar_turno.php';
        }
    }

    private function cancelarCita() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id_cita = $_GET['id'] ?? null;

            if (empty($id_cita)) {
                throw new Exception("ID de cita no proporcionado");
            }

            // Obtener información de la cita antes de cancelar
            $cita = $this->citaController->obtenerCitaPorId($id_cita);
            
            if (!$cita) {
                throw new Exception("No se encontró la cita especificada");
            }

            // Cancelar la cita
            $resultado = $this->citaController->cancelarCita($id_cita);

            if ($resultado) {
                $_SESSION['mensaje_exito'] = "La cita ha sido cancelada exitosamente";
                
                // Redirigir de vuelta a la consulta de turnos con el mismo paciente
                $pacienteController = new PacienteController();
                $paciente = $pacienteController->verificarPaciente($cita['DNI']);
                
                if ($paciente) {
                    $citas = $this->citaController->obtenerCitasPorPaciente($paciente['id_paciente']);
                    include $this->viewsPath . 'consultar_turno.php';
                } else {
                    // Si no encontramos al paciente, redirigir al formulario de consulta
                    header('Location: index.php?action=consultar_turno');
                    exit();
                }
            } else {
                throw new Exception("Error al cancelar la cita. La cita puede que ya haya sido cancelada o no se pueda modificar.");
            }
        } else {
            throw new Exception("Método no permitido");
        }
    }

    private function mostrarError($mensaje) {
        echo "<div class='error' style='color:red; padding:20px; border:1px solid #f00; margin:20px;'>";
        echo "<h2>Error</h2>";
        echo "<p>{$mensaje}</p>";
        echo "<a href='index.php' class='btn'>Volver al inicio</a>";
        echo "</div>";
    }
}