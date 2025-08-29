<?php
// Verificar si se proporcionó un ID de horario
if (!isset($_GET['id_horario']) || !isset($_GET['id_profesional'])) {
    header("Location: index.php?accion=gestion_horarios");
    exit;
}

$id_horario = $_GET['id_horario'];
$id_profesional = $_GET['id_profesional'];

// Aquí iría la lógica para obtener los datos del horario específico
// y mostrarlos en un formulario de edición
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Horario - Clínica Dental</title>
</head>
<body>
    <h1>Editar Horario</h1>
    
    <p>Formulario para editar horario ID: <?php echo $id_horario; ?></p>
    
    <form method="post" action="index.php?accion=actualizar_horario">
        <input type="hidden" name="id_horario" value="<?php echo $id_horario; ?>">
        <input type="hidden" name="id_profesional" value="<?php echo $id_profesional; ?>">
        
        <!-- Campos de edición aquí -->
        
        <button type="submit">Actualizar Horario</button>
    </form>
    
    <p><a href="index.php?accion=gestion_horarios&id_profesional=<?php echo $id_profesional; ?>">Volver a Gestión de Horarios</a></p>
</body>
</html>