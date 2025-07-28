<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clínica Dental - Sistema de Turnos</title>
    <link rel="stylesheet" href="public/css/estilo.css">
</head>
<body>
    <div class="container">
        <h1>Sistema de Gestión de Turnos</h1>
        <div class="search-box">
            <h2>Buscar Paciente</h2>
            <form id="searchForm">
                <div class="form-group">
                    <label for="dni">Número de Documento (DNI):</label>
                    <input type="text" id="dni" name="dni" required placeholder="Ingrese DNI del paciente">
                </div>
                <button type="submit" class="btn">Buscar</button>
            </form>
        </div>

        <div id="patientInfo" class="hidden">
            <h2>Información del Paciente</h2>
            <div id="patientDetails"></div>
        </div>

        <div id="existingAppointmentSection" class="hidden">
            <h2>Gestión de Turno Existente</h2>
            <div id="existingAppointmentDetails"></div>
        </div>

        <div id="appointmentSection" class="hidden">
            <h2>Asignar Nuevo Turno</h2>
            <div id="dentistSelection"></div>
            <div id="calendarSection" class="hidden">
                <h3>Seleccione Fecha y Hora</h3>
                <div id="calendar"></div>
                <button id="confirmAppointment" class="btn hidden">Confirmar Turno</button>
            </div>
        </div>

        <div id="confirmation" class="hidden">
            <h2>Turno Confirmado</h2>
            <div id="appointmentDetails"></div>
        </div>
    </div>

    <script src="public/js/script.js"></script>
</body>
</html>