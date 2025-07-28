<?php
require_once __DIR__ . '/../conexion.php';

class TurnoModel {
    private $db;

    public function __construct() {
        global $enlace;
        $this->db = $enlace;
    }

    public function consultarTurnoPorDni($dni) {
        $stmt = $this->db->prepare("
            SELECT p.nombre, p.apellido, c.fecha, c.hora 
            FROM citas c
            JOIN personas p ON c.dni_paciente = p.dni
            WHERE p.dni = ?
        ");
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
}
?>