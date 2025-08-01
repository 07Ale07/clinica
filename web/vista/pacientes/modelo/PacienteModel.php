<?php
require_once __DIR__ . '/../conexion.php';

class PacienteModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function buscarPorDni($dni) {
        $stmt = $this->db->prepare("SELECT * FROM personas WHERE dni = ?");
        $stmt->bind_param("i", $dni);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function registrarPaciente($nombre, $apellido, $fecha_nac, $dni) {
        $stmt = $this->db->prepare("INSERT INTO personas (nombre, apellido, fecha, dni) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $nombre, $apellido, $fecha_nac, $dni);
        
        if ($stmt->execute()) {
            $id_persona = $this->db->insert_id;
            
            $num_paciente = "PAC-" . str_pad($id_persona, 5, "0", STR_PAD_LEFT);
            $stmt2 = $this->db->prepare("INSERT INTO pacientes (id_persona, numero_paciente) VALUES (?, ?)");
            $stmt2->bind_param("is", $id_persona, $num_paciente);
            $stmt2->execute();
            
            return $id_persona;
        }
        return false;
    }
}
?>