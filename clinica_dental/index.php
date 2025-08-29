<?php
// ARCHIVO: index.php (punto de entrada principal)
session_start();

// Configuración básica
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));

// Incluir configuración de base de datos primero
include 'configuracion/basedatos.php';

// Crear instancia de base de datos
$basedatos = new BaseDatos();
$db = $basedatos->obtenerConexion();

// Procesar la solicitud
$accion = isset($_GET['accion']) ? $_GET['accion'] : '';

// SOLUCIÓN: Solo redirigir a inicio.php si está logueado Y no es una acción pública
if (isset($_SESSION['logueado']) && $_SESSION['logueado'] === true && 
    !in_array($accion, ['salir', 'ver_turnos', 'sacar_turno'])) {
    header("Location: inicio.php");
    exit;
}

// Manejar acciones
switch ($accion) {
    case 'salir':
        // Cerrar sesión
        session_destroy();
        header("Location: " . BASE_URL);
        exit;
        break;
        
    case 'sacar_turno':
        include 'controladores/ControladorTurnos.php';
        $controladorTurnos = new ControladorTurnos($db);
        $controladorTurnos->mostrarFormularioTurno();
        exit;
        break;
        
    case 'procesar_turno':
        include 'controladores/ControladorTurnos.php';
        $controladorTurnos = new ControladorTurnos($db);
        $controladorTurnos->procesarTurno();
        exit;
        break;
        
    case 'ver_turnos':
        include 'controladores/ControladorTurnos.php';
        $controladorTurnos = new ControladorTurnos($db);
        
        if (isset($_POST['dni'])) {
            $controladorTurnos->verTurnosPaciente($_POST['dni']);
        } else {
            include 'vistas/turnos/buscar_turnos.php';
        }
        exit;
        break;
        
    default:
        // Procesar login si se envió el formulario
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
            include 'controladores/ControladorAuth.php';
            include 'modelos/Usuario.php';
            
            $controladorAuth = new ControladorAuth();
            $controladorAuth->iniciarSesion();
            exit;
        }
        
        // Mostrar página de inicio con opciones
        include 'vistas/inicio_publico.php';
        exit;
        break;
}
?>  