<?php
require_once('../modelo/empleados_modelo.php');

$empleados = obtenerEmpleadosConPersonas();
$cargos = obtenerCargos();

?>

<h2>Empleados (Odontólogos incluidos)</h2>
<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>Legajo</th><th>Nombre</th><th>Apellido</th><th>DNI</th><th>Contrato</th><th>Interno</th><th>Cargo</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $empleados->fetch_assoc()): ?>
            <tr>
                <td><?= $row['numero_legajo'] ?></td>
                <td><?= $row['nombre'] ?></td>
                <td><?= $row['apellido'] ?></td>
                <td><?= $row['DNI'] ?></td>
                <td><?= $row['tipo_contrato'] ?></td>
                <td><?= $row['telefono_interno'] ?></td>
                <td><?= $row['cargo'] ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<h3>Nuevo Empleado</h3>
<form method="POST" action="../controlador/empleados.php">
    <label>Nombre: <input type="text" name="nombre" required></label><br>
    <label>Apellido: <input type="text" name="apellido" required></label><br>
    <label>DNI: <input type="text" name="dni"></label><br>
    <label>Tipo Contrato:
        <select name="tipo_contrato" required>
            <option value="permanente">Permanente</option>
            <option value="temporal">Temporal</option>
            <option value="honorarios">Honorarios</option>
            <option value="pasantia">Pasantía</option>
        </select>
    </label><br>
    <label>Legajo: <input type="text" name="numero_legajo"></label><br>
    <label>Teléfono interno: <input type="text" name="telefono_interno"></label><br>
    <label>Cargo:
        <select name="id_cargo" required>
            <?php while ($c = $cargos->fetch_assoc()): ?>
                <option value="<?= $c['id_cargo'] ?>"><?= $c['cargo'] ?></option>
            <?php endwhile; ?>
        </select>
    </label><br>
    <button type="submit">Guardar</button>
</form>
