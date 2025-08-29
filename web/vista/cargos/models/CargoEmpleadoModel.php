<?php
class CargoEmpleadoModel {
    private $conn;
    private $table_name = "cargo_empleados";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT ce.*, e.nombre as empleado_nombre, c.cargo as nombre_cargo 
                 FROM " . $this->table_name . " ce
                 LEFT JOIN empleados e ON ce.id_empleado = e.id_empleado
                 LEFT JOIN cargos c ON ce.id_cargo = c.id_cargo
                 ORDER BY ce.id_cargo_empleados DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE id_cargo_empleados = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                 (id_empleado, id_cargo, activo) 
                 VALUES (:id_empleado, :id_cargo, :activo)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id_empleado', $data['id_empleado']);
        $stmt->bindParam(':id_cargo', $data['id_cargo']);
        $stmt->bindParam(':activo', $data['activo']);
        
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table_name . " 
                 SET id_empleado = :id_empleado, 
                     id_cargo = :id_cargo, 
                     activo = :activo 
                 WHERE id_cargo_empleados = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id_empleado', $data['id_empleado']);
        $stmt->bindParam(':id_cargo', $data['id_cargo']);
        $stmt->bindParam(':activo', $data['activo']);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    public function deactivate($id) {
        $query = "UPDATE " . $this->table_name . " SET activo = 0 WHERE id_cargo_empleados = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }

    public function activate($id) {
        $query = "UPDATE " . $this->table_name . " SET activo = 1 WHERE id_cargo_empleados = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }

    // Métodos para obtener datos de relaciones
    public function getEmpleados() {
        $query = "SELECT id_empleado, nombre FROM empleados WHERE activo = 1 ORDER BY nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getCargos() {
        $query = "SELECT id_cargo, cargo FROM cargos WHERE activo = 1 ORDER BY cargo";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function checkExistingAssignment($id_empleado, $id_cargo, $exclude_id = null) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " 
                 WHERE id_empleado = :id_empleado AND id_cargo = :id_cargo";
        
        if ($exclude_id) {
            $query .= " AND id_cargo_empleados != :exclude_id";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_empleado', $id_empleado);
        $stmt->bindParam(':id_cargo', $id_cargo);
        
        if ($exclude_id) {
            $stmt->bindParam(':exclude_id', $exclude_id);
        }
        
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['count'] > 0;
    }
}
?>