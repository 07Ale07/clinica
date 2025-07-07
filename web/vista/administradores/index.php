<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 'administrador') {
    header("Location: ../inicio_sesion.php");
    exit();
}
echo "<h2>Panel de Administración - " . $_SESSION['usuario']['nombre'] . "</h2>";
// Funcionalidades administrativas
?>
