<?php
class Employee {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getThreeEmployees() {
        $query = "SELECT e.id_empleado, pe.nombre, pe.apellido, e.foto
                    FROM empleados e
                    JOIN personas pe ON e.id_persona = pe.id_persona
                    LIMIT 3";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>