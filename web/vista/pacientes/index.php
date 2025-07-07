<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 'paciente') {
    header("Location: ../inicio_sesion.php");
    exit();
}
echo "<h2>Bienvenido, " . $_SESSION['usuario']['nombre'] . "</h2>";
echo "<p>Desde aquí puedes sacar o consultar tus turnos.</p>";
// Aquí iría la funcionalidad para turnos
?>
