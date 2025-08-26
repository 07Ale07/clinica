<?php
require_once '../conexion.php';

class OdontologoModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function obtenerOdontologos() {
        // Consulta optimizada para obtener odontólogos
        $query = "SELECT 
                    p.id_persona, 
                    p.nombre, 
                    p.apellido, 
                    e.id_empleado,
                    e.numero_legajo,
                    GROUP_CONCAT(es.especialidad SEPARATOR ', ') as especialidades
                  FROM personas p
                  INNER JOIN empleados e ON p.id_persona = e.id_persona
                  INNER JOIN cargo_empleados ce ON e.id_empleado = ce.id_empleado
                  LEFT JOIN empleado_especialidades ee ON e.id_empleado = ee.id_empleado
                  LEFT JOIN especialidades es ON ee.id_especialidad = es.id_especialidad
                  WHERE ce.id_cargo = 1  -- Asumiendo que 1 es el ID para odontólogos
                  GROUP BY p.id_persona
                  ORDER BY p.apellido, p.nombre";
        
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            error_log("Error al preparar consulta de odontólogos: " . $this->db->error);
            return [];
        }
        
        if (!$stmt->execute()) {
            error_log("Error al ejecutar consulta de odontólogos: " . $stmt->error);
            return [];
        }
        
        $result = $stmt->get_result();
        $odontologos = [];
        
        while ($row = $result->fetch_assoc()) {
            $odontologos[] = $row;
        }
        
        $stmt->close();
        return $odontologos;
    }

    /**
     * Verifica si un odontólogo está disponible en una fecha y hora específica
     */
    public function verificarDisponibilidad($id_empleado, $fecha, $hora) {
        $fecha_inicio = $fecha . ' ' . $hora . ':00';
        $fecha_fin = date('Y-m-d H:i:s', strtotime($fecha_inicio . ' +1 hour'));
        
        $query = "SELECT COUNT(*) as count 
                  FROM citas 
                  WHERE id_empleado = ? 
                  AND fecha_inicio < ? 
                  AND fecha_fin > ? 
                  AND estado IN ('pendiente', 'confirmada')";
        
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            error_log("Error al preparar consulta de disponibilidad: " . $this->db->error);
            return false;
        }
        
        $stmt->bind_param("iss", $id_empleado, $fecha_fin, $fecha_inicio);
        
        if (!$stmt->execute()) {
            error_log("Error al ejecutar consulta de disponibilidad: " . $stmt->error);
            return false;
        }
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row['count'] == 0;
    }
}
?>