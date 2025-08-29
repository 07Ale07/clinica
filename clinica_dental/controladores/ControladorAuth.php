<?php
// ARCHIVO: controladores/ControladorAuth.php

class ControladorAuth {
    private $usuario;
    private $basedatos;
    
    public function __construct() {
        $this->basedatos = new BaseDatos();
        $this->usuario = new Usuario($this->basedatos->obtenerConexion());
    }
    
    // Mostrar el formulario de login
    public function mostrarLogin() {
        include 'vistas/auth/login.php';
    }
    
    // Procesar el inicio de sesión
    public function iniciarSesion() {
        $this->usuario->nombre = $_POST['usuario'];
        $this->usuario->clave = $_POST['clave'];
        
        if($this->usuario->verificarLogin()) {
            // Guardar datos en sesión
            $_SESSION['id_usuario'] = $this->usuario->id_usuario;
            $_SESSION['id_empleado'] = $this->usuario->id_empleado;
            $_SESSION['usuario'] = $this->usuario->nombre;
            $_SESSION['tipo_usuario'] = $this->usuario->tipo_usuario;
            $_SESSION['logueado'] = true;
            
            // Redirigir según el tipo de usuario
            header("Location: " . BASE_URL . "inicio.php");
            exit;
        } else {
            $error = "Nombre de usuario o contraseña incorrectos.";
            include 'vistas/auth/login.php';
        }
    }
    
    // Cerrar sesión
    public function salir() {
        session_destroy();
        header("Location: " . BASE_URL);
        exit;
    }
}
?>