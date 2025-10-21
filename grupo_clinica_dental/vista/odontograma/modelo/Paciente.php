<?php
require_once 'Conexion.php';

class Paciente {
    private $db;
    
    public function __construct() {
        $conexion = new Conexion();
        $this->db = $conexion->getConexion();
    }

    public function getPacientesActivos() {
        $query = "SELECT p.id_paciente, per.nombre, per.apellido, per.DNI 
                 FROM pacientes p
                 JOIN personas per ON p.id_persona = per.id_persona
                 WHERE p.activo = 1";
        return $this->db->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public function getPacienteById($id_paciente) {
        $stmt = $this->db->prepare("SELECT per.* FROM pacientes p
                                  JOIN personas per ON p.id_persona = per.id_persona
                                  WHERE p.id_paciente = ?");
        $stmt->bind_param("i", $id_paciente);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}