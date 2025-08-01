<?php
require_once __DIR__ . '/../conexion.php';

class TurnoModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function crearTurno($id_persona, $id_empleado, $fecha, $hora) {
        $stmt = $this->db->prepare("INSERT INTO citas (id_persona, id_empleado, fecha, hora) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $id_persona, $id_empleado, $fecha, $hora);
        return $stmt->execute();
    }
}
?>