<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Clínica Dental</title>
  <link rel="stylesheet" href="public/css/presentacion.css">
</head>
<body>
  <div class="hero">
    <div class="overlay"></div>
    <div class="hero-content">
      <img src="https://cdn-icons-png.flaticon.com/512/3726/3726789.png" alt="Clínica Logo" class="logo">
      <h1>Clínica Dental</h1>
      <p class="subtitulo">Tu salud bucal, en manos expertas</p>
      <div class="btn-group">
        <a href="vista/inicio_sesion.php" class="btn">Iniciar Sesión</a>
        <a href="vista/pacientes/consultar_turno.php" class="btn">Consultar Turno</a>
        <a href="vista/pacientes/sacar_turno.php" class="btn">Sacar Turno</a>
      </div>
    </div>
  </div>

  <section class="info">
    <div class="container">
      <h2>¿Quiénes somos?</h2>
      <p>
        Somos una clínica dental moderna y profesional con más de 20 años de experiencia. 
        Nuestro compromiso es brindar atención personalizada con tecnología de vanguardia.
      </p>

      <div class="features">
        <div class="feature">
          <h3>✔️ Profesionales calificados</h3>
          <p>Contamos con un equipo multidisciplinario y altamente capacitado en todas las especialidades odontológicas.</p>
        </div>
        <div class="feature">
          <h3>🦷 Tecnología avanzada</h3>
          <p>Utilizamos equipamiento de última generación para brindar diagnósticos y tratamientos precisos.</p>
        </div>
        <div class="feature">
          <h3>🏥 Atención accesible</h3>
          <p>Horarios extendidos, turnos online, y atención cálida para que te sientas como en casa.</p>
        </div>
      </div>
    </div>
  </section>

  <footer>
    © <?php echo date("Y"); ?> Clínica Dental — Todos los derechos reservados.
  </footer>
  <script src="public/js/animaciones_inicio.js"></script>

</body>
</html>
