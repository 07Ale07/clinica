<?php
session_start();
require_once '../modelo/validar_inicio.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    $rol = validar_inicio_sesion($usuario, $contrasena);

    if ($rol) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['rol'] = $rol;

        switch ($rol) {
            case 'admin':
                
                header('Location: ../vista/administradores/control_Admin/index.php');
                break;
            case 'odontologo':
                header('Location: ../vista/odontologos/index.php');
                break;
            case 'Farmaceutico':
                header('Location: ../vista/farmaceuticos/index_farmacia.php');
                break;
            case 'paciente':
                header('Location: ../vista/pacientes/index.php');
                break;
            default:
                $_SESSION['error'] = 'Rol desconocido.';
                header('Location: ../vista/inicio_sesion.php');
        }
    } else {
        $_SESSION['error'] = 'Usuario o contraseña incorrectos.';
        header('Location: ../vista/inicio_sesion.php');
    }
    exit;
}

header('Location: ../vista/inicio_sesion.php');
exit;
