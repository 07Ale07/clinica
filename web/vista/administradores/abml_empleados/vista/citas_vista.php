<?php
require_once(__DIR__ . '/../modelo/citas_modelo.php');

$citas = obtenerCitas();
$pacientes = obtenerPacientes();
$empleados = obtenerEmpleados();
$sillones = obtenerSillones();
?>

<h2>Listado de Citas</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>Paciente</th>
        <th>Empleado</th>
        <th>Sillón</th>
        <th>Inicio</th>
        <th>Fin</th>
        <th>Estado</th>
        <th>Tipo</th>
        <th>Obs.</th>
        <th>Acciones</th>
    </tr>
    <?php while ($cita = $citas->fetch_assoc()): ?>
        <tr>
            <td><?= $cita['nombre'] ?> <?= $cita['apellido'] ?></td>
            <td><?= $cita['id_empleado'] ?></td>
            <td><?= $cita['nombre_sillon'] ?></td>
            <td><?= $cita['fecha_inicio'] ?></td>
            <td><?= $cita['fecha_fin'] ?></td>
            <td><?= $cita['estado'] ?></td>
            <td><?= $cita['tipo'] ?></td>
            <td><?= $cita['observaciones'] ?></td>
            <td>
                <form method="POST" action="../controlador/citas.php" style="display:inline">
                    <input type="hidden" name="id_cita" value="<?= $cita['id_cita'] ?>">
                    <input type="hidden" name="accion" value="desactivar">
                    <button type="submit">Cancelar</button>
                </form>
                <!-- Podés agregar botón de "modificar" con JavaScript si querés edición directa -->
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<h3>Nueva Cita</h3>
<form method="POST" action="../controlador/citas.php">
    <input type="hidden" name="accion" value="crear">

    <label>Paciente:
        <select name="id_paciente">
            <?php while ($p = $pacientes->fetch_assoc()): ?>
                <option value="<?= $p['id_paciente'] ?>"><?= $p['nombre'] ?> <?= $p['apellido'] ?></option>
            <?php endwhile; ?>
        </select>
    </label><br>

    <label>Empleado:
        <select name="id_empleado">
            <?php while ($e = $empleados->fetch_assoc()): ?>
                <option value="<?= $e['id_empleado'] ?>"><?= $e['nombre'] ?> <?= $e['apellido'] ?></option>
            <?php endwhile; ?>
        </select>
    </label><br>

    <label>Sillón:
        <select name="id_sillon">
            <?php while ($s = $sillones->fetch_assoc()): ?>
                <option value="<?= $s['id_sillon'] ?>"><?= $s['nombre'] ?></option>
            <?php endwhile; ?>
        </select>
    </label><br>

    <label>Fecha inicio: <input type="datetime-local" name="fecha_inicio"></label><br>
    <label>Fecha fin: <input type="datetime-local" name="fecha_fin"></label><br>

    <label>Estado:
        <select name="estado">
            <option value="pendiente">Pendiente</option>
            <option value="confirmada">Confirmada</option>
            <option value="completada">Completada</option>
            <option value="no_asistio">No asistió</option>
        </select>
    </label><br>

    <label>Tipo:
        <select name="tipo">
            <option value="consulta">Consulta</option>
            <option value="tratamiento">Tratamiento</option>
            <option value="control">Control</option>
        </select>
    </label><br>

    <label>Observaciones:<br>
        <textarea name="observaciones" rows="3" cols="40"></textarea>
    </label><br>

    <button type="submit">Guardar</button>
</form>
