<?php
require_once(__DIR__ . '/../conexion.php'); // trae $enlace

class Empleado {
    private $db;

    public function __construct() {
        global $enlace;  // usamos la conexión creada en conexion.php
        $this->db = $enlace;
    }

    public function obtenerEmpleadosConPersonas() {
        $sql = "SELECT e.id_empleado, e.numero_legajo, e.tipo_contrato, e.telefono_interno,
                       e.foto, e.activo,
                       p.nombre, p.apellido, p.DNI,
                       c.cargo
                FROM empleados e
                JOIN personas p ON e.id_persona = p.id_persona
                JOIN cargo_empleados ce ON ce.id_empleado = e.id_empleado
                JOIN cargos c ON c.id_cargo = ce.id_cargo";
        return $this->db->query($sql);
    }

    public function obtenerEmpleadoPorId($id) {
        $sql = "SELECT e.*, p.nombre, p.apellido, p.DNI, c.id_cargo
                FROM empleados e
                JOIN personas p ON e.id_persona = p.id_persona
                JOIN cargo_empleados ce ON ce.id_empleado = e.id_empleado
                JOIN cargos c ON c.id_cargo = ce.id_cargo
                WHERE e.id_empleado = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function activarEmpleado($id) {
        $sql = "UPDATE empleados SET activo = 1 WHERE id_empleado = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function desactivarEmpleado($id) {
        $sql = "UPDATE empleados SET activo = 0 WHERE id_empleado = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function agregarEmpleado($legajo, $nombre, $apellido, $dni, $contrato, $interno, $cargo, $fotoNombre) {
        $sqlPersona = "INSERT INTO personas (nombre, apellido, DNI) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sqlPersona);
        $stmt->bind_param("ssi", $nombre, $apellido, $dni);
        $stmt->execute();
        $id_persona = $this->db->insert_id;

        $sqlEmpleado = "INSERT INTO empleados (numero_legajo, tipo_contrato, telefono_interno, foto, activo, id_persona)
                        VALUES (?, ?, ?, ?, 1, ?)";
        $stmt2 = $this->db->prepare($sqlEmpleado);
        $stmt2->bind_param("ssssi", $legajo, $contrato, $interno, $fotoNombre, $id_persona);
        $stmt2->execute();
        $id_empleado = $this->db->insert_id;

        $sqlCargo = "INSERT INTO cargo_empleados (id_empleado, id_cargo) VALUES (?, ?)";
        $stmt3 = $this->db->prepare($sqlCargo);
        $stmt3->bind_param("ii", $id_empleado, $cargo);
        return $stmt3->execute();
    }

    public function editarEmpleado($id_empleado, $legajo, $nombre, $apellido, $dni, $contrato, $interno, $cargo, $fotoNombre = null) {
        // actualizar persona
        $sqlPersona = "UPDATE personas p
                       JOIN empleados e ON p.id_persona = e.id_persona
                       SET p.nombre = ?, p.apellido = ?, p.DNI = ?
                       WHERE e.id_empleado = ?";
        $stmt = $this->db->prepare($sqlPersona);
        $stmt->bind_param("ssii", $nombre, $apellido, $dni, $id_empleado);
        $stmt->execute();

        // actualizar empleado
        if ($fotoNombre) {
            $sqlEmpleado = "UPDATE empleados SET numero_legajo=?, tipo_contrato=?, telefono_interno=?, foto=? WHERE id_empleado=?";
            $stmt2 = $this->db->prepare($sqlEmpleado);
            $stmt2->bind_param("ssssi", $legajo, $contrato, $interno, $fotoNombre, $id_empleado);
        } else {
            $sqlEmpleado = "UPDATE empleados SET numero_legajo=?, tipo_contrato=?, telefono_interno=? WHERE id_empleado=?";
            $stmt2 = $this->db->prepare($sqlEmpleado);
            $stmt2->bind_param("sssi", $legajo, $contrato, $interno, $id_empleado);
        }
        $stmt2->execute();

        // actualizar cargo
        $sqlCargo = "UPDATE cargo_empleados SET id_cargo=? WHERE id_empleado=?";
        $stmt3 = $this->db->prepare($sqlCargo);
        $stmt3->bind_param("ii", $cargo, $id_empleado);
        return $stmt3->execute();
    }

    // Nuevo método para obtener los cargos
    public function obtenerCargos() {
        $sql = "SELECT id_cargo, cargo FROM cargos ORDER BY cargo";
        return $this->db->query($sql);
    }
}
