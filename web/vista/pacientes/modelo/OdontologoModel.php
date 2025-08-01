<?php
require_once '../conexion.php';

class OdontologoModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function obtenerOdontologos() {
        $query = "SELECT p.id_persona, p.nombre, p.apellido, pr.matricula 
                  FROM personas p
                  JOIN empleados e ON p.id_persona = e.id_persona
                  JOIN profesionales pr ON e.id_empleado = pr.id_empleado
                  WHERE e.id_cargo = 1";
                  
        $result = $this->db->query($query);
        $odontologos = [];
        
        while ($row = $result->fetch_assoc()) {
            $odontologos[] = $row;
        }
        
        return $odontologos;
    }
}
?>