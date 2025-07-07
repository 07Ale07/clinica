<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel Odontólogo - Clínica Dental</title>
  <link rel="stylesheet" href="public/css/odontologo.css">
  <script defer src="public/js/odontologo_menu.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <div class="contenedor-superior">
    <div class="menu">
      <div class="opcion" onclick="cargarContenido('vista_odontologo_principal.php')">
        <i class="fas fa-home"></i> Principal
      </div>
      <div class="opcion" onclick="cargarContenido('vista_odontologo_turnos.php')">
        <i class="fas fa-calendar-check"></i> Turnos Hoy
      </div>
      <div class="opcion" onclick="cargarContenido('vista_odontologo_historial.php')">
        <i class="fas fa-notes-medical"></i> Historial
      </div>
      <div class="opcion" onclick="cargarContenido('vista_odontologo_enfermeria.php')">
        <i class="fas fa-user-nurse"></i> Enfermería
      </div>
    </div>
  </div>

  <div class="contenedor-inferior" id="contenido">
    <!-- Aquí se cargará el contenido dinámicamente -->
  </div>
</body>
</html>
