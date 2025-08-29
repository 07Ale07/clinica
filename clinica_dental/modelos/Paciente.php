<?php
class Paciente {
    private $conn;
    private $table_name = "pacientes";
    
    public $id_paciente;
    public $id_persona;
    public $id_grupo_familiar;
    public $id_obra_social;
    public $nro_afiliado;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                 SET id_persona=:id_persona, id_obra_social=:id_obra_social, 
                 nro_afiliado=:nro_afiliado";
        
        $stmt = $this->conn->prepare($query);
        
        $this->id_persona = htmlspecialchars(strip_tags($this->id_persona));
        $this->id_obra_social = htmlspecialchars(strip_tags($this->id_obra_social));
        $this->nro_afiliado = htmlspecialchars(strip_tags($this->nro_afiliado));
        
        $stmt->bindParam(":id_persona", $this->id_persona);
        $stmt->bindParam(":id_obra_social", $this->id_obra_social);
        $stmt->bindParam(":nro_afiliado", $this->nro_afiliado);
        
        if($stmt->execute()) {
            $this->id_paciente = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }
    
    public function buscarPorPersona($id_persona) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_persona = :id_persona LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_persona", $id_persona);
        $stmt->execute();
        return $stmt;
    }
}
?>