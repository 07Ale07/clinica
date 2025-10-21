<?php
class PerformedProcedure {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getAllPerformedProcedures() {
        $query = "SELECT 
                    CONCAT(per_pac.nombre, ' ', per_pac.apellido) AS paciente,
                    proc.descripcion AS procedimiento,
                    pr.fecha,
                    pr.img_antes,
                    pr.img_despues,
                    pr.observaciones,
                    CONCAT(per_emp.nombre, ' ', per_emp.apellido) AS empleado
                  FROM procedimientos_realizados pr
                  JOIN pacientes pa ON pr.id_paciente = pa.id_paciente
                  JOIN personas per_pac ON pa.id_persona = per_pac.id_persona
                  JOIN procedimientos proc ON pr.id_procedimiento = proc.id_procedimiento
                  LEFT JOIN empleados e ON pr.id_empleado = e.id_empleado
                  LEFT JOIN personas per_emp ON e.id_persona = per_emp.id_persona";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
