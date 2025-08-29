<?php
class ObraSocial {
    private $conn;
    private $table_name = "obras_sociales";
    
    public $id_obra_social;
    public $nombre;
    public $codigo;
    public $telefono;
    public $email;
    public $id_direccion;
    public $activo;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function obtenerActivas() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE activo = 1 ORDER BY nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>