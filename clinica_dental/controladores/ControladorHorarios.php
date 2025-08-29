<?php
class ControladorHorarios {
    private $horarioEmpleado;
    private $empleado;
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
        $this->horarioEmpleado = new HorarioEmpleado($db);
        $this->empleado = new Empleado($db);
    }
    
    // Mostrar formulario de gestión de horarios
    public function mostrarGestionHorarios() {
        $odontologos = $this->empleado->obtenerOdontologos();
        
        // Si se seleccionó un empleado, obtener sus horarios
        $horarios = null;
        if (isset($_GET['id_empleado'])) {
            $id_empleado = $_GET['id_empleado'];
            $horarios = $this->horarioEmpleado->obtenerPorEmpleado($id_empleado);
        }
        
        include 'vistas/horarios/gestion_horarios.php';
    }
    
    // Agregar nuevo horario
    public function agregarHorario() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->horarioEmpleado->id_empleado = $_POST['id_empleado'];
            $this->horarioEmpleado->dia_semana = $_POST['dia_semana'];
            $this->horarioEmpleado->hora_inicio = $_POST['hora_inicio'];
            $this->horarioEmpleado->hora_fin = $_POST['hora_fin'];
            $this->horarioEmpleado->activo = isset($_POST['activo']) ? 1 : 0;
            
            if ($this->horarioEmpleado->crear()) {
                $mensaje = "Horario agregado correctamente.";
                header("Location: index.php?accion=gestion_horarios&id_empleado=" . $_POST['id_empleado'] . "&mensaje=" . urlencode($mensaje));
                exit;
            } else {
                $error = "Error al agregar el horario.";
                include 'vistas/horarios/error.php';
            }
        }
    }
    
    // Actualizar horario
    public function actualizarHorario() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->horarioEmpleado->id_horario = $_POST['id_horario'];
            $this->horarioEmpleado->id_empleado = $_POST['id_empleado'];
            $this->horarioEmpleado->dia_semana = $_POST['dia_semana'];
            $this->horarioEmpleado->hora_inicio = $_POST['hora_inicio'];
            $this->horarioEmpleado->hora_fin = $_POST['hora_fin'];
            $this->horarioEmpleado->activo = isset($_POST['activo']) ? 1 : 0;
            
            if ($this->horarioEmpleado->actualizar()) {
                $mensaje = "Horario actualizado correctamente.";
                header("Location: index.php?accion=gestion_horarios&id_empleado=" . $_POST['id_empleado'] . "&mensaje=" . urlencode($mensaje));
                exit;
            } else {
                $error = "Error al actualizar el horario.";
                include 'vistas/horarios/error.php';
            }
        }
    }
    
    // Eliminar horario
    public function eliminarHorario() {
        if (isset($_GET['id_horario'])) {
            $this->horarioEmpleado->id_horario = $_GET['id_horario'];
            
            if ($this->horarioEmpleado->eliminar()) {
                $mensaje = "Horario eliminado correctamente.";
                header("Location: index.php?accion=gestion_horarios&id_empleado=" . $_GET['id_empleado'] . "&mensaje=" . urlencode($mensaje));
                exit;
            } else {
                $error = "Error al eliminar el horario.";
                include 'vistas/horarios/error.php';
            }
        }
    }
}
?>