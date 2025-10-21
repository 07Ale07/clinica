<?php
require_once 'Conexion.php';

class Odontograma {
    private $db;
    
    public function __construct() {
        $conexion = new Conexion();
        $this->db = $conexion->getConexion();
    }

    public function guardarOdontograma($id_paciente, $datos) {
        $json = json_encode($datos);
        $query = "INSERT INTO odontogramas (id_paciente, odontograma) VALUES (?, ?) 
                 ON DUPLICATE KEY UPDATE odontograma = VALUES(odontograma)";
        
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            error_log("Error en prepare: " . $this->db->error);
            return false;
        }
        
        $stmt->bind_param("is", $id_paciente, $json);
        return $stmt->execute();
    }

   public function obtenerOdontograma($id_paciente) {
    $query = "SELECT odontograma FROM odontogramas 
             WHERE id_paciente = ? 
             ORDER BY fecha_actualizacion DESC 
             LIMIT 1";
    
    $stmt = $this->db->prepare($query);
    if (!$stmt) {
        error_log("Error en prepare: " . $this->db->error);
        return null;
    }
    
    $stmt->bind_param("i", $id_paciente);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Decodificar el JSON correctamente
        $odontograma = json_decode($row['odontograma'], true);
        
        // Verificar si la decodificación fue exitosa
        if (json_last_error() === JSON_ERROR_NONE) {
            return $odontograma;
        } else {
            error_log("Error decodificando JSON: " . json_last_error_msg());
            return null;
        }
    }
    return null;
}
    
}