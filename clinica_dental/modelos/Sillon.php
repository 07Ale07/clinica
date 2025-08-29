<?php
class Sillon {
    private $conn;
    private $table_name = "sillones";
    
    public $id_sillon;
    public $nombre;
    public $descripcion;
    public $activo;
    public $fecha_creacion;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function obtenerActivos() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE activo = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>