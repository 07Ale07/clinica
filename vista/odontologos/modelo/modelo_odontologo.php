<?php
class OdontologoModelo {
    private $enlace;

    public function __construct($enlace) {
        $this->enlace = $enlace;
    }

    /**
     * Función equivalente a: GET /historial/:id_empleado
     * Obtener historial de pacientes atendidos por odontólogo
     */
    public function obtenerHistorialPacientesAtendidos($id_empleado) {
        $sql = "SELECT 
                p.id_paciente AS id,
                CONCAT(pe.nombre, ' ', pe.apellido) AS name,
                DATE_FORMAT(MAX(c.fecha_inicio), '%Y-%m-%d %H:%i:%s') AS lastVisit,
                (SELECT tipo FROM citas WHERE id_paciente = p.id_paciente AND id_empleado = ? ORDER BY fecha_inicio DESC LIMIT 1) AS diagnosis
            FROM pacientes p
            JOIN personas pe ON p.id_persona = pe.id_persona
            JOIN citas c ON p.id_paciente = c.id_paciente
            WHERE c.id_empleado = ? AND c.estado = 'completada' AND c.fecha_inicio < NOW()
            GROUP BY p.id_paciente, pe.nombre, pe.apellido
            ORDER BY MAX(c.fecha_inicio) DESC";

        $stmt = $this->enlace->prepare($sql);
        $stmt->bind_param("ii", $id_empleado, $id_empleado);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $historial = [];
        while ($fila = $resultado->fetch_assoc()) {
            $historial[] = $fila;
        }
        $stmt->close();
        return $historial;
    }

    /**
     * Función equivalente a: GET /usuario/:id_usuario
     * Obtener id_empleado desde id_usuario
     */
    public function obtenerIdEmpleadoDesdeUsuario($id_usuario) {
        $sql = "SELECT id_empleado FROM usuarios WHERE id_usuario = ?";
        
        $stmt = $this->enlace->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $usuario = $resultado->fetch_assoc();
        $stmt->close();
        return $usuario;
    }

    // Las funciones anteriores se mantienen igual...
    public function obtenerHorariosOdontologo($id_empleado, $dia = null, $fecha = null) {
        $sql = "SELECT * FROM horario_empleados 
                WHERE id_empleado = ? 
                AND activo = 1";
        $params = [$id_empleado];

        if ($dia) {
            $sql .= ' AND dia_semana = ?';
            $params[] = $dia;
        }

        if ($fecha) {
            $sql .= " AND (
                (fecha_desde IS NULL OR fecha_desde <= ?) 
                AND (fecha_hasta IS NULL OR fecha_hasta >= ?)
            )";
            $params[] = $fecha;
            $params[] = $fecha;
        }

        $stmt = $this->enlace->prepare($sql);
        
        if (count($params) > 0) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $resultado = $stmt->get_result();
        $horarios = [];
        while ($fila = $resultado->fetch_assoc()) {
            $horarios[] = $fila;
        }
        $stmt->close();
        return $horarios;
    }

    public function obtenerCitasOdontologo($id_usuario, $fecha) {
        $sql = "SELECT c.id_cita, c.fecha_inicio, pe.nombre AS nombre_paciente, c.tipo, c.estado
                FROM citas c
                JOIN pacientes p ON c.id_paciente = p.id_paciente
                JOIN personas pe ON p.id_persona = pe.id_persona
                WHERE c.id_empleado = ? AND DATE(c.fecha_inicio) = ?";

        $stmt = $this->enlace->prepare($sql);
        $stmt->bind_param("is", $id_usuario, $fecha);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $citas = [];
        while ($fila = $resultado->fetch_assoc()) {
            $citas[] = $fila;
        }
        $stmt->close();
        return $citas;
    }

    public function obtenerDatosPaciente($idPaciente) {
        $sql = "SELECT pa.id_paciente, pe.nombre, pe.apellido
                FROM pacientes pa
                JOIN personas pe ON pa.id_persona = pe.id_persona
                WHERE pa.id_paciente = ?
                LIMIT 1";

        $stmt = $this->enlace->prepare($sql);
        $stmt->bind_param("i", $idPaciente);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $paciente = $resultado->fetch_assoc();
        $stmt->close();
        return $paciente;
    }

    public function obtenerTurnosDelDia($idOdontologo) {
        $fechaActual = date('Y-m-d');
        
        $sql = "SELECT pa.id_paciente, pe.nombre, pe.apellido, TIME(t.fecha_inicio) AS hora_turno 
                FROM citas t 
                JOIN pacientes pa ON t.id_paciente = pa.id_paciente 
                JOIN personas pe ON pa.id_persona = pe.id_persona
                WHERE t.id_empleado = ? AND DATE(t.fecha_inicio) = ?
                ORDER BY TIME(t.fecha_inicio) ASC";

        $stmt = $this->enlace->prepare($sql);
        $stmt->bind_param("is", $idOdontologo, $fechaActual);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $turnos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $turnos[] = $fila;
        }
        $stmt->close();
        return $turnos;
    }

    public function buscarPacientes($query) {
        $searchTerm = "%" . $query . "%";
        
        $sql = "SELECT pa.id_paciente, pe.nombre, pe.apellido 
                FROM pacientes pa
                JOIN personas pe ON pa.id_persona = pe.id_persona 
                WHERE pe.nombre LIKE ? OR pe.apellido LIKE ? 
                LIMIT 20";
        
        $stmt = $this->enlace->prepare($sql);
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $pacientes = [];
        while ($fila = $resultado->fetch_assoc()) {
            $pacientes[] = $fila;
        }
        $stmt->close();
        return $pacientes;
    }

    public function obtenerHistorialPaciente($idPaciente) {
        $sql = "SELECT pr.fecha, p.descripcion AS procedimiento, pr.observaciones 
                FROM procedimientos_realizados pr
                JOIN procedimientos p ON pr.id_procedimiento = p.id_procedimiento
                WHERE pr.id_paciente = ? 
                ORDER BY pr.fecha DESC";

        $stmt = $this->enlace->prepare($sql);
        $stmt->bind_param("i", $idPaciente);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $historial = [];
        while ($fila = $resultado->fetch_assoc()) {
            $historial[] = $fila;
        }
        $stmt->close();
        return $historial;
    }
}
?>