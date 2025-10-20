<?php
class Patient {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getThreePatients() {
        $query = "SELECT p.id_paciente, pe.nombre, pe.apellido, pe.DNI, p.fecha_registro, p.tipo, p.alergias, p.observaciones_generales
                  FROM pacientes p
                  JOIN personas pe ON p.id_persona = pe.id_persona
                  LIMIT 3";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>