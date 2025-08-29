<?php
class Persona {
    private $conn;
    private $table_name = "personas";
    
    public $id_persona;
    public $nombre;
    public $apellido;
    public $fecha_nac;
    public $dni;
    public $telefono;
    public $id_email;
    public $sexo;
    public $id_direccion;
    public $estado;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function buscarPorDNI($dni) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE dni = :dni LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":dni", $dni);
        $stmt->execute();
        return $stmt;
    }
    
    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                 SET nombre=:nombre, apellido=:apellido, fecha_nac=:fecha_nac, 
                 dni=:dni, telefono=:telefono, sexo=:sexo, estado=:estado";
        
        $stmt = $this->conn->prepare($query);
        
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->fecha_nac = htmlspecialchars(strip_tags($this->fecha_nac));
        $this->dni = htmlspecialchars(strip_tags($this->dni));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->sexo = htmlspecialchars(strip_tags($this->sexo));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":fecha_nac", $this->fecha_nac);
        $stmt->bindParam(":dni", $this->dni);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":sexo", $this->sexo);
        $stmt->bindParam(":estado", $this->estado);
        
        if($stmt->execute()) {
            $this->id_persona = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }
}
?>