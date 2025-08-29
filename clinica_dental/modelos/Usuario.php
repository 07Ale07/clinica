<?php
// ARCHIVO: modelos/Usuario.php

class Usuario {
    private $conexion;
    private $tabla_usuarios = "usuarios";
    private $tabla_empleados = "empleados";
    private $tabla_personas = "personas";

    public $id_usuario;
    public $id_empleado;
    public $nombre;
    public $clave;
    public $tipo_usuario;

    public function __construct($db) {
        $this->conexion = $db;
    }

    // Método para verificar las credenciales del usuario
    public function verificarLogin() {
        $consulta = "SELECT u.id_usuario, u.id_empleado, u.usuario, u.clave, 
                    p.nombre, p.apellido, e.tipo_contrato
                    FROM " . $this->tabla_usuarios . " u 
                    INNER JOIN " . $this->tabla_empleados . " e ON u.id_empleado = e.id_empleado
                    INNER JOIN " . $this->tabla_personas . " p ON e.id_persona = p.id_persona
                    WHERE u.usuario = :usuario LIMIT 1";
        
        $stmt = $this->conexion->prepare($consulta);
        $stmt->bindParam(":usuario", $this->nombre);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verificar la contraseña (sin hashear en este caso)
            if ($this->clave === $fila['clave']) {
                $this->id_usuario = $fila['id_usuario'];
                $this->id_empleado = $fila['id_empleado'];
                $this->tipo_usuario = $fila['tipo_contrato']; // Usamos tipo_contrato como tipo de usuario
                return true;
            }
        }
        return false;
    }
}
?>