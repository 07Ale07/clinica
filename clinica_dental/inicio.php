<?php
// ARCHIVO: inicio.php (página después del login)
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    header("Location: index.php");
    exit;
}

// Configuración básica
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));

// Convertir el ID de tipo de usuario a un nombre legible
$tipos_usuario = [
    1 => 'Administrador',
    2 => 'Odontólogo', 
    3 => 'Recepcionista',
    4 => 'Paciente'
];

$tipo_usuario_nombre = isset($tipos_usuario[$_SESSION['id_tipo_usuario']]) 
    ? $tipos_usuario[$_SESSION['id_tipo_usuario']] 
    : 'Usuario';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio - Clínica Dental</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .bienvenida { background-color: #f0f8ff; padding: 20px; border-radius: 5px; }
        .menu { margin: 20px 0; }
        .menu ul { list-style-type: none; padding: 0; }
        .menu li { margin: 10px 0; }
        .menu a { 
            display: block; 
            padding: 10px 15px; 
            background-color: #2c7da0; 
            color: white; 
            text-decoration: none; 
            border-radius: 4px; 
            width: 200px; 
        }
        .menu a:hover { background-color: #1a5d7a; }
    </style>
</head>
<body>
    <div class="bienvenida">
        <h1>Bienvenido al Sistema de Clínica Dental</h1>
        <p>Hola, <strong><?php echo $_SESSION['nombre']; ?></strong> (<?php echo $tipo_usuario_nombre; ?>)</p>
    </div>
    
    <div class="menu">
        <h2>Menú Principal</h2>
        
        <?php if ($_SESSION['id_tipo_usuario'] == 1): // Administrador ?>
            <ul>
                <li><a href="admin/usuarios.php">Administrar Usuarios</a></li>
                <li><a href="admin/odontologos.php">Gestionar Odontólogos</a></li>
                <li><a href="admin/turnos.php">Ver Todos los Turnos</a></li>
                <li><a href="admin/configuracion.php">Configuración del Sistema</a></li>
                <li><a href="vistas/horarios/gestion_horarios.php">Gestionar Horarios</a></li>
            </ul>
        
        <?php elseif ($_SESSION['id_tipo_usuario'] == 2): // Odontólogo ?>
            <ul>
                <li><a href="odontologo/turnos.php">Mis Turnos de Hoy</a></li>
                <li><a href="odontologo/agenda.php">Mi Agenda</a></li>
                <li><a href="odontologo/pacientes.php">Mis Pacientes</a></li>
                <li><a href="odontologo/historial.php">Historial de Atenciones</a></li>
            </ul>
        
        <?php elseif ($_SESSION['id_tipo_usuario'] == 3): // Recepcionista ?>
            <ul>
                <li><a href="recepcion/turnos.php">Gestionar Turnos</a></li>
                <li><a href="recepcion/pacientes.php">Gestionar Pacientes</a></li>
                <li><a href="recepcion/caja.php">Caja y Pagos</a></li>
            </ul>
        
        <?php elseif ($_SESSION['id_tipo_usuario'] == 4): // Paciente ?>
            <ul>
                <li><a href="index.php?accion=sacar_turno">Sacar un Turno</a></li>
                <li><a href="index.php?accion=ver_turnos">Mis Turnos</a></li>
                <li><a href="pacientes/perfil.php">Mi Perfil</a></li>
                <li><a href="pacientes/historial.php">Mi Historial</a></li>
            </ul>
        <?php endif; ?>
    </div>
    
    <p><a href="index.php?accion=salir">Cerrar Sesión</a></p>
</body>
</html>