<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Horarios - Clínica Dental</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .activo { color: green; }
        .inactivo { color: red; }
    </style>
</head>
<body>
    <h1>Gestión de Horarios de Profesionales</h1>
    
    <?php if (isset($_GET['mensaje'])): ?>
        <p style="color: green;"><?php echo urldecode($_GET['mensaje']); ?></p>
    <?php endif; ?>
    
    <form method="get" action="">
        <input type="hidden" name="accion" value="gestion_horarios">
        
        <label for="id_empleado">Seleccionar Profesional:</label>
        <select id="id_empleado" name="id_empleado" onchange="this.form.submit()" required>
            <option value="">Seleccione un profesional</option>
            <?php while ($row = $odontologos->fetch(PDO::FETCH_ASSOC)): ?>
                <option value="<?php echo $row['id_empleado']; ?>" 
                    <?php if (isset($_GET['id_empleado']) && $_GET['id_empleado'] == $row['id_empleado']) echo 'selected'; ?>>
                    <?php echo $row['nombre'] . ' ' . $row['apellido'] . ' (' . $row['numero_legajo'] . ')'; ?>
                </option>
            <?php endwhile; ?>
        </select>
    </form>
    
    <?php if (isset($horarios)): ?>
        <h2>Horarios del Profesional</h2>
        
        <h3>Agregar Nuevo Horario</h3>
        <form method="post" action="index.php?accion=agregar_horario">
            <input type="hidden" name="id_empleado" value="<?php echo $_GET['id_empleado']; ?>">
            
            <label for="dia_semana">Día de la semana:</label>
            <select id="dia_semana" name="dia_semana" required>
                <option value="Lunes">Lunes</option>
                <option value="Martes">Martes</option>
                <option value="Miércoles">Miércoles</option>
                <option value="Jueves">Jueves</option>
                <option value="Viernes">Viernes</option>
                <option value="Sábado">Sábado</option>
                <option value="Domingo">Domingo</option>
            </select>
            
            <label for="hora_inicio">Hora inicio:</label>
            <input type="time" id="hora_inicio" name="hora_inicio" required>
            
            <label for="hora_fin">Hora fin:</label>
            <input type="time" id="hora_fin" name="hora_fin" required>
            
            <label for="activo">Activo:</label>
            <input type="checkbox" id="activo" name="activo" value="1" checked>
            
            <button type="submit">Agregar Horario</button>
        </form>
        
        <h3>Horarios Existentes</h3>
        <?php if ($horarios->rowCount() > 0): ?>
            <table>
                <tr>
                    <th>Día</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
                <?php while ($row = $horarios->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo $row['dia_semana']; ?></td>
                    <td><?php echo $row['hora_inicio']; ?></td>
                    <td><?php echo $row['hora_fin']; ?></td>
                    <td class="<?php echo $row['activo'] ? 'activo' : 'inactivo'; ?>">
                        <?php echo $row['activo'] ? 'Activo' : 'Inactivo'; ?>
                    </td>
                    <td>
                        <a href="index.php?accion=editar_horario&id_horario=<?php echo $row['id_horario']; ?>&id_empleado=<?php echo $_GET['id_empleado']; ?>">Editar</a> | 
                        <a href="index.php?accion=eliminar_horario&id_horario=<?php echo $row['id_horario']; ?>&id_empleado=<?php echo $_GET['id_empleado']; ?>" 
                           onclick="return confirm('¿Está seguro de eliminar este horario?')">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No hay horarios registrados para este profesional.</p>
        <?php endif; ?>
    <?php endif; ?>
    
    <p><a href="inicio.php">Volver al Inicio</a></p>
</body>
</html>