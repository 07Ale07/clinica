<?php
require_once __DIR__ . '/../conexion.php';

class PacienteModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function buscarPorDni($dni) {
        // Validación básica del DNI antes de consultar
        if (!preg_match('/^\d{8,10}$/', $dni)) {
            return false;
        }

        $stmt = $this->db->prepare("SELECT p.*, pac.id_paciente 
                                  FROM personas p
                                  JOIN pacientes pac ON p.id_persona = pac.id_persona
                                  WHERE p.DNI = ?");
        if (!$stmt) {
            error_log("Error al preparar consulta: " . $this->db->error);
            return false;
        }

        $stmt->bind_param("s", $dni);
        if (!$stmt->execute()) {
            error_log("Error al ejecutar consulta: " . $stmt->error);
            return false;
        }

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function registrarPaciente($nombre, $apellido, $fecha_nac, $dni) {
        // Validaciones antes de insertar
        if (empty($nombre) || empty($apellido) || empty($dni) || empty($fecha_nac)) {
            error_log("Datos incompletos para registrar paciente");
            return false;
        }

        if (!preg_match('/^\d{8,10}$/', $dni)) {
            error_log("Formato de DNI inválido: " . $dni);
            return false;
        }

        $this->db->begin_transaction();
        try {
            // 1. Insertar persona
            $stmtPersona = $this->db->prepare("INSERT INTO personas (nombre, apellido, DNI) VALUES (?, ?, ?)");
            if (!$stmtPersona) {
                throw new Exception("Error al preparar inserción de persona: " . $this->db->error);
            }

            $stmtPersona->bind_param("sss", $nombre, $apellido, $dni);
            if (!$stmtPersona->execute()) {
                throw new Exception("Error al insertar persona: " . $stmtPersona->error);
            }

            $id_persona = $this->db->insert_id;

            // 2. Insertar paciente
            $fecha_registro = date('Y-m-d');
            $tipo = $this->determinarTipoPaciente($fecha_nac);
            
            $stmtPaciente = $this->db->prepare("INSERT INTO pacientes 
                                              (id_persona, fecha_registro, tipo, activo) 
                                              VALUES (?, ?, ?, 1)");
            if (!$stmtPaciente) {
                throw new Exception("Error al preparar inserción de paciente: " . $this->db->error);
            }

            $stmtPaciente->bind_param("iss", $id_persona, $fecha_registro, $tipo);
            if (!$stmtPaciente->execute()) {
                throw new Exception("Error al insertar paciente: " . $stmtPaciente->error);
            }

            $this->db->commit();
            return $id_persona;
        } catch (Exception $e) {
            $this->db->rollback();
            error_log("Error en transacción: " . $e->getMessage());
            return false;
        }
    }

    private function determinarTipoPaciente($fecha_nac) {
        $fechaNac = new DateTime($fecha_nac);
        $hoy = new DateTime();
        $edad = $hoy->diff($fechaNac)->y;

        if ($edad < 18) return 'menor';
        if ($edad > 65) return 'geriatrico';
        return 'adulto';
    }
}
?>