<?php
require_once '../conexion.php';

/**
 * Valida un usuario consultando su contraseña desencriptada.
 * Retorna el rol como string ('admin', 'odontologo', 'paciente') si es válido, o false si no.
 */
function validar_inicio_sesion($usuario, $contrasena) {
    global $enlace;

    $usuario = mysqli_real_escape_string($enlace, $usuario);
    $contrasena = mysqli_real_escape_string($enlace, $contrasena);

    // Buscar usuario con clave desencriptada
    $query = "
        SELECT u.usuario,
               CAST(AES_DECRYPT(u.clave, '1234') AS CHAR) AS password_desencriptada,
               e.id_cargo
        FROM usuarios u
        JOIN empleados e ON u.id_empleado = e.id_empleado
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
                default:
                    return 'farmaceutico'; 
            }
        }
    }

    return false;
}
