<?php
require_once __DIR__ . '/../conexion.php';

class TurnoModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Crea un nuevo turno verificando disponibilidad y consistencia de datos
     */
    public function crearTurno($id_persona, $id_empleado, $fecha, $hora) {
        // Validar datos de entrada
        if (empty($id_persona) || empty($id_empleado) || empty($fecha) || empty($hora)) {
            throw new Exception("Datos incompletos para crear el turno");
        }

        // Obtener id_paciente
        $id_paciente = $this->obtenerIdPaciente($id_persona);
        if (!$id_paciente) {
            throw new Exception("No se encontró el paciente asociado");
        }

        // Verificar disponibilidad del odontólogo
        $odontologoModel = new OdontologoModel();
        if (!$odontologoModel->verificarDisponibilidad($id_empleado, $fecha, $hora)) {
            throw new Exception("El odontólogo no está disponible en ese horario");
        }

        // Preparar fechas para la cita
        $fecha_inicio = $fecha . ' ' . $hora . ':00';
        $fecha_fin = date('Y-m-d H:i:s', strtotime($fecha_inicio . ' +1 hour'));

        // Insertar la cita
        $query = "INSERT INTO citas 
                  (id_paciente, id_empleado, fecha_inicio, fecha_fin, estado, tipo) 
                  VALUES (?, ?, ?, ?, 'pendiente', 'consulta')";
        
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new Exception("Error al preparar la inserción: " . $this->db->error);
        }

        $stmt->bind_param("iiss", $id_paciente, $id_empleado, $fecha_inicio, $fecha_fin);
        
        if ($stmt->execute()) {
            $id_cita = $this->db->insert_id;
            $stmt->close();
            return $id_cita;
        } else {
            $error = $stmt->error;
            $stmt->close();
            throw new Exception("Error al crear el turno: " . $error);
        }
    }

    /**
     * Obtiene el ID de paciente a partir del ID de persona
     */
    private function obtenerIdPaciente($id_persona) {
        $query = "SELECT id_paciente FROM pacientes WHERE id_persona = ? AND activo = 1";
        
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            error_log("Error al preparar consulta de paciente: " . $this->db->error);
            return false;
        }
        
        $stmt->bind_param("i", $id_persona);
        
        if (!$stmt->execute()) {
            error_log("Error al ejecutar consulta de paciente: " . $stmt->error);
            return false;
        }
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row ? $row['id_paciente'] : false;
    }

    /**
     * Verifica si un paciente ya tiene un turno en la misma fecha
     */
    public function verificarTurnoExistente($id_persona, $fecha) {
        $id_paciente = $this->obtenerIdPaciente($id_persona);
        if (!$id_paciente) return false;

        $query = "SELECT COUNT(*) as count 
                  FROM citas 
                  WHERE id_paciente = ? 
                  AND DATE(fecha_inicio) = ? 
                  AND estado IN ('pendiente', 'confirmada')";
        
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            error_log("Error al preparar consulta de turno existente: " . $this->db->error);
            return false;
        }
        
        $stmt->bind_param("is", $id_paciente, $fecha);
        
        if (!$stmt->execute()) {
            error_log("Error al ejecutar consulta de turno existente: " . $stmt->error);
            return false;
        }
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row['count'] > 0;
    }
}
?>