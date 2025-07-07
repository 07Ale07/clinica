<?php
session_start();
$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clínica Dental - Iniciar Sesión</title>
    <link rel="stylesheet" href="../public/css/inicio.css">
</head>
<body>
    <div class="login-container">
        <img src="https://cdn-icons-png.flaticon.com/512/3726/3726789.png" alt="Clínica Dental Logo" class="logo">
        <h2>Clínica Dental</h2>
        <p class="subtitle">Accede a tu cuenta como paciente, odontólogo o administrador</p>

        <?php if ($error): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="../controlador/controller.php" method="POST">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <input type="submit" value="Iniciar Sesión">
        </form>
    </div>

    <footer>
        © <?php echo date("Y"); ?> Clínica Dental. Todos los derechos reservados.
    </footer>
</body>
</html>
