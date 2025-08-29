<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Mis Turnos - Clínica Dental</title>
</head>
<body>
    <h1>Buscar Mis Turnos</h1>
    
    <form method="post" action="index.php?accion=ver_turnos">
        <div>
            <label for="dni">Ingrese su DNI:</label>
            <input type="text" id="dni" name="dni" required>
        </div>
        
        <button type="submit">Buscar Turnos</button>
    </form>
    
    <p><a href="index.php">Volver al Inicio</a></p>
</body>
</html>