<?php
require_once '../conexion.php';

/**
 * Valida un usuario consultando su contraseña desencriptada.
 * Retorna el rol como string ('admin', 'odontologo', 'paciente', 'farmaceutico') si es válido, o false si no.
 */
function validar_inicio_sesion($usuario, $contrasena) {
    global $enlace;

    $usuario = mysqli_real_escape_string($enlace, $usuario);
    $contrasena = mysqli_real_escape_string($enlace, $contrasena);

    // Primero verificar si es administrador (tabla admins)
    $query_admin = "
        SELECT id_admin, admin, clave 
        FROM admins 
        WHERE admin = '$usuario' 
        LIMIT 1
    ";

    $resultado_admin = mysqli_query($enlace, $query_admin);

    if ($fila_admin = mysqli_fetch_assoc($resultado_admin)) {
        if ($fila_admin['clave'] === $contrasena) {
            // Es administrador válido
            $_SESSION['id_admin'] = $fila_admin['id_admin'];
            return 'admin';
        }
    }

    // Si no es admin, buscar en usuarios normales
    $query = "
        SELECT u.usuario,
               clave as password_desencriptada,
               e.id_cargo
        FROM usuarios u
        JOIN cargo_empleados e ON u.id_empleado = e.id_empleado
        WHERE u.usuario = '$usuario'
        LIMIT 1
    ";

    $resultado = mysqli_query($enlace, $query);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        if ($fila['password_desencriptada'] === $contrasena) {
            $id_cargo = $fila['id_cargo'];

            // Determinar rol por id_cargo
            switch ($id_cargo) {
                case 1:
                    return 'odontologo';
                case 2:
                    return 'paciente';
                case 3:
                    return 'farmaceutico'; 
            }
        }
    }

    return false;
}