<?php
class CargoModel {
    private $conn;
    private $table_name = "cargos";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id_cargo DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_cargo = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                 (cargo, descripcion, puede_liquidar_honorarios) 
                 VALUES (:cargo, :descripcion, :puede_liquidar_honorarios)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':cargo', $data['cargo']);
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':puede_liquidar_honorarios', $data['puede_liquidar_honorarios']);
        
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table_name . " 
                 SET cargo = :cargo, 
                     descripcion = :descripcion, 
                     puede_liquidar_honorarios = :puede_liquidar_honorarios 
                 WHERE id_cargo = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':cargo', $data['cargo']);
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':puede_liquidar_honorarios', $data['puede_liquidar_honorarios']);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    public function deactivate($id) {
        $query = "UPDATE " . $this->table_name . " SET activo = 0 WHERE id_cargo = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }

    public function activate($id) {
        $query = "UPDATE " . $this->table_name . " SET activo = 1 WHERE id_cargo = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }
}
?>