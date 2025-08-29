<?php
class Empleado {
    private $conn;
    private $table_name = "empleados";
    private $table_personas = "personas";
    private $table_especialidades = "empleado_especialidades";
    
    public $id_empleado;
    public $id_persona;
    public $numero_legajo;
    public $tipo_contrato;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function obtenerOdontologos() {
        $query = "SELECT e.id_empleado, p.nombre, p.apellido, e.numero_legajo 
                 FROM " . $this->table_name . " e
                 INNER JOIN " . $this->table_personas . " p ON e.id_persona = p.id_persona
                 INNER JOIN " . $this->table_especialidades . " ee ON e.id_empleado = ee.id_empleado
                 WHERE ee.id_especialidad IN (1,2,3,4,5) 
                 ORDER BY p.apellido, p.nombre";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function obtenerPorId($id_empleado) {
        $query = "SELECT e.*, p.nombre, p.apellido, p.DNI 
                 FROM " . $this->table_name . " e
                 INNER JOIN " . $this->table_personas . " p ON e.id_persona = p.id_persona
                 WHERE e.id_empleado = :id_empleado LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_empleado", $id_empleado);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id_empleado = $row['id_empleado'];
            $this->id_persona = $row['id_persona'];
            $this->numero_legajo = $row['numero_legajo'];
            $this->tipo_contrato = $row['tipo_contrato'];
            return true;
        }
        return false;
    }
}
?>