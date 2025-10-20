<?php
class SocialWork {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getAllSocialWorks() {
        $query = "SELECT * FROM obra_sociales";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>