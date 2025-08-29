<?php
// ARCHIVO: vistas/auth/login.php

// Si ya está logueado, redirigir al inicio
if (isset($_SESSION['logueado']) && $_SESSION['logueado'] === true) {
    header("Location: " . BASE_URL . "inicio.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Clínica Dental</title>
</head>
<body>
    <h1>Sistema de Clínica Dental</h1>
    <h2>Iniciar Sesión</h2>
    
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form method="post" action="">
        <input type="hidden" name="login" value="1">
        
        <div>
            <label for="nombre">Usuario:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>
        
        <div>
            <label for="clave">Contraseña:</label>
            <input type="password" id="clave" name="clave" required>
        </div>
        
        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>