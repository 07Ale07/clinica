<?php
require_once __DIR__ . '/../conexion.php';

class CitaModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function obtenerCitasPorPaciente($id_paciente) {
        try {
            $sql = "SELECT 
                        c.id_cita,
                        c.fecha_inicio,
                        c.fecha_fin,
                        c.estado,
                        c.tipo,
                        c.observaciones,
                        p.nombre,
                        p.apellido,
                        CONCAT(per_odo.nombre, ' ', per_odo.apellido) as nombre_odontologo
                    FROM citas c
                    LEFT JOIN pacientes pac ON c.id_paciente = pac.id_paciente
                    LEFT JOIN personas p ON pac.id_persona = p.id_persona
                    LEFT JOIN empleados e ON c.id_empleado = e.id_empleado
                    LEFT JOIN personas per_odo ON e.id_persona = per_odo.id_persona
                    WHERE c.id_paciente = ?
                    ORDER BY c.fecha_inicio DESC";
            
            $stmt = $this->db->prepare($sql);
            if (!$stmt) {
                error_log("Error al preparar consulta de citas: " . $this->db->error);
                return [];
            }

            $stmt->bind_param("i", $id_paciente);
            if (!$stmt->execute()) {
                error_log("Error al ejecutar consulta de citas: " . $stmt->error);
                return [];
            }

            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
            
        } catch (Exception $e) {
            error_log("Error al obtener citas del paciente: " . $e->getMessage());
            return [];
        }
    }

    public function cancelarCita($id_cita) {
        try {
            $sql = "UPDATE citas SET estado = 'cancelada' WHERE id_cita = ? AND estado IN ('pendiente', 'confirmada')";
            
            $stmt = $this->db->prepare($sql);
            if (!$stmt) {
                error_log("Error al preparar consulta de cancelación: " . $this->db->error);
                return false;
            }

            $stmt->bind_param("i", $id_cita);
            if (!$stmt->execute()) {
                error_log("Error al ejecutar cancelación de cita: " . $stmt->error);
                return false;
            }

            return $stmt->affected_rows > 0;
            
        } catch (Exception $e) {
            error_log("Error al cancelar cita: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerCitaPorId($id_cita) {
        try {
            $sql = "SELECT c.*, p.nombre, p.apellido, p.DNI 
                    FROM citas c
                    JOIN pacientes pac ON c.id_paciente = pac.id_paciente
                    JOIN personas p ON pac.id_persona = p.id_persona
                    WHERE c.id_cita = ?";
            
            $stmt = $this->db->prepare($sql);
            if (!$stmt) {
                error_log("Error al preparar consulta de cita: " . $this->db->error);
                return null;
            }

            $stmt->bind_param("i", $id_cita);
            if (!$stmt->execute()) {
                error_log("Error al ejecutar consulta de cita: " . $stmt->error);
                return null;
            }

            $result = $stmt->get_result();
            return $result->fetch_assoc();
            
        } catch (Exception $e) {
            error_log("Error al obtener cita por ID: " . $e->getMessage());
            return null;
        }
    }
}
?>