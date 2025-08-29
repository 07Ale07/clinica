<?php
// ARCHIVO: configuracion/basedatos.php

class BaseDatos {
    private $servidor = "localhost";
    private $nombre_bd = "clinica";
    private $usuario = "root"; // Cambiar según tu configuración
    private $contrasena = ""; // Cambiar según tu configuración
    public $conexion;

    public function obtenerConexion() {
        $this->conexion = null;
        try {
            $this->conexion = new PDO(
                "mysql:host=" . $this->servidor . ";dbname=" . $this->nombre_bd, 
                $this->usuario, 
                $this->contrasena
            );
            $this->conexion->exec("set names utf8");
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $excepcion) {
            echo "Error de conexión: " . $excepcion->getMessage();
        }
        return $this->conexion;
    }
}
?>