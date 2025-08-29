<?php
class HorarioEmpleado {
    private $conn;
    private $table_name = "horario_empleados";
    
    public $id_horario;
    public $id_empleado;
    public $dia_semana;
    public $hora_inicio;
    public $hora_fin;
    public $activo;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function verificarDisponibilidad($id_empleado, $dia_semana, $hora) {
        $query = "SELECT id_horario FROM " . $this->table_name . " 
                 WHERE id_empleado = :id_empleado 
                 AND dia_semana = :dia_semana
                 AND hora_inicio <= :hora 
                 AND hora_fin > :hora
                 AND activo = 1
                 AND (fecha_hasta IS NULL OR fecha_hasta >= CURDATE())";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_empleado", $id_empleado);
        $stmt->bindParam(":dia_semana", $dia_semana);
        $stmt->bindParam(":hora", $hora);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }

    public function obtenerPorEmpleado($id_empleado) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE id_empleado = :id_empleado 
                 ORDER BY FIELD(dia_semana, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'), 
                 hora_inicio";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_empleado", $id_empleado);
        $stmt->execute();
        return $stmt;
    }

    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                 SET id_empleado=:id_empleado, dia_semana=:dia_semana, 
                 hora_inicio=:hora_inicio, hora_fin=:hora_fin, 
                 activo=:activo, fecha_desde=CURDATE()";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":id_empleado", $this->id_empleado);
        $stmt->bindParam(":dia_semana", $this->dia_semana);
        $stmt->bindParam(":hora_inicio", $this->hora_inicio);
        $stmt->bindParam(":hora_fin", $this->hora_fin);
        $stmt->bindParam(":activo", $this->activo);
        
        if($stmt->execute()) {
            $this->id_horario = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                 SET dia_semana=:dia_semana, hora_inicio=:hora_inicio, 
                 hora_fin=:hora_fin, activo=:activo 
                 WHERE id_horario=:id_horario";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":dia_semana", $this->dia_semana);
        $stmt->bindParam(":hora_inicio", $this->hora_inicio);
        $stmt->bindParam(":hora_fin", $this->hora_fin);
        $stmt->bindParam(":activo", $this->activo);
        $stmt->bindParam(":id_horario", $this->id_horario);
        
        return $stmt->execute();
    }

    public function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_horario = :id_horario";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_horario", $this->id_horario);
        
        return $stmt->execute();
    }
}
?>