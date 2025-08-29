<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Turnos - Clínica Dental</title>
</head>
<body>
    <h1>Mis Turnos</h1>
    
    <?php if ($turnos->rowCount() > 0): ?>
        <table border="1">
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Odontólogo</th>
                <th>Sillón</th>
                <th>Estado</th>
                <th>Observaciones</th>
            </tr>
            <?php while ($row = $turnos->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo $row['fecha_turno']; ?></td>
                <td><?php echo $row['hora_inicio'] . ' - ' . $row['hora_fin']; ?></td>
                <td><?php echo $row['prof_nombre'] . ' ' . $row['prof_apellido']; ?></td>
                <td><?php echo $row['sillon_nombre']; ?></td>
                <td><?php echo $row['estado']; ?></td>
                <td><?php echo $row['observaciones']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No tiene turnos registrados.</p>
    <?php endif; ?>
    
    <p><a href="index.php">Volver al inicio</a></p>
</body>
</html>