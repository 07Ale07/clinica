<?php
class Procedure {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getAllProcedures() {
        $query = "SELECT * FROM procedimientos";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>