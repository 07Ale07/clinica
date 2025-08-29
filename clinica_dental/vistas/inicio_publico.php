<?php
// ARCHIVO: vistas/inicio_publico.php
?>
<!DOCTYPE html>
<html lang="es">
    
<head>
    <meta charset="UTF-8">
    <title>Clínica Dental - Inicio</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .seccion { margin-bottom: 30px; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        h1 { color: #2c7da0; }
        h2 { color: #333; }
        form { margin: 15px 0; }
        label { display: block; margin: 5px 0; }
        input[type="text"], input[type="password"] { padding: 8px; width: 250px; margin-bottom: 10px; }
        button { padding: 10px 15px; background-color: #2c7da0; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #1a5d7a; }
        .error { color: red; margin: 10px 0; }
    </style>
</head>

<body>
    <h1>Bienvenido a la Clínica Dental</h1>
    
    <div class="seccion">
        <h2>Soy Paciente</h2>
        <ul>
            <li><a href="index.php?accion=sacar_turno">Sacar un turno online</a></li>
            <li>
                <form method="post" action="index.php?accion=ver_turnos">
                    <label for="dni">Ver mis turnos (ingrese DNI):</label>
                    <input type="text" id="dni" name="dni" required>
                    <button type="submit">Buscar Turnos</button>
                </form>
            </li>
        </ul>
    </div>
    
    <div class="seccion">
        <h2>Soy Profesional</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
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
    </div>
</body>
</html>