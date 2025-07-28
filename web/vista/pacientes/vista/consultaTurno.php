<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Turnos - Clínica Dental</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Consulta de Turnos</h1>
        <form id="consultaForm">
            <label for="dni">Ingrese su DNI:</label>
            <input type="text" id="dni" name="dni" required placeholder="Ej: 32165498">
            <button type="submit">Consultar</button>
        </form>
        
        <div id="resultado">
            <!-- Aquí se mostrarán los resultados -->
        </div>
    </div>

    <script src="public/js/consulta.js"></script>
</body>
</html>