<?php
class Turno {
    private $conn;
    private $table_name = "turnos";
    
    public $id_turno;
    public $id_paciente;
    public $id_profesional;
    public $id_sillon;
    public $fecha_turno;
    public $hora_inicio;
    public $hora_fin;
    public $estado;
    public $observaciones;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                 SET id_paciente=:id_paciente, id_profesional=:id_profesional, 
                 id_sillon=:id_sillon, fecha_turno=:fecha_turno, 
                 hora_inicio=:hora_inicio, hora_fin=:hora_fin, 
                 estado=:estado, observaciones=:observaciones";
        
        $stmt = $this->conn->prepare($query);
        
        $this->id_paciente = htmlspecialchars(strip_tags($this->id_paciente));
        $this->id_profesional = htmlspecialchars(strip_tags($this->id_profesional));
        $this->id_sillon = htmlspecialchars(strip_tags($this->id_sillon));
        $this->fecha_turno = htmlspecialchars(strip_tags($this->fecha_turno));
        $this->hora_inicio = htmlspecialchars(strip_tags($this->hora_inicio));
        $this->hora_fin = htmlspecialchars(strip_tags($this->hora_fin));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        $this->observaciones = htmlspecialchars(strip_tags($this->observaciones));
        
        $stmt->bindParam(":id_paciente", $this->id_paciente);
        $stmt->bindParam(":id_profesional", $this->id_profesional);
        $stmt->bindParam(":id_sillon", $this->id_sillon);
        $stmt->bindParam(":fecha_turno", $this->fecha_turno);
        $stmt->bindParam(":hora_inicio", $this->hora_inicio);
        $stmt->bindParam(":hora_fin", $this->hora_fin);
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":observaciones", $this->observaciones);
        
        if($stmt->execute()) {
            $this->id_turno = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }
    
    public function obtenerPorPaciente($id_paciente) {
        $query = "SELECT t.*, pro.id_profesional, per.nombre as prof_nombre, per.apellido as prof_apellido,
                 s.nombre as sillon_nombre
                 FROM " . $this->table_name . " t
                 INNER JOIN profesionales pro ON t.id_profesional = pro.id_profesional
                 INNER JOIN personas per ON pro.id_persona = per.id_persona
                 INNER JOIN sillones s ON t.id_sillon = s.id_sillon
                 WHERE t.id_paciente = :id_paciente
                 ORDER BY t.fecha_turno DESC, t.hora_inicio DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_paciente", $id_paciente);
        $stmt->execute();
        return $stmt;
    }
    
    public function verificarDisponibilidad($id_profesional, $fecha, $hora_inicio, $hora_fin) {
        $query = "SELECT id_turno FROM " . $this->table_name . " 
                 WHERE id_profesional = :id_profesional 
                 AND fecha_turno = :fecha
                 AND ((hora_inicio <= :hora_inicio AND hora_fin > :hora_inicio) 
                 OR (hora_inicio < :hora_fin AND hora_fin >= :hora_fin)
                 OR (hora_inicio >= :hora_inicio AND hora_fin <= :hora_fin))";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_profesional", $id_profesional);
        $stmt->bindParam(":fecha", $fecha);
        $stmt->bindParam(":hora_inicio", $hora_inicio);
        $stmt->bindParam(":hora_fin", $hora_fin);
        $stmt->execute();
        
        return $stmt->rowCount() == 0;
    }
}
?>