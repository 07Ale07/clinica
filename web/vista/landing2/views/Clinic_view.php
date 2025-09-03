<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clínica - Datos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { color: #333; }
    </style>
</head>
<body>
    <h2>Procedimientos</h2>
    <table>
        <tr>
            <th>Descripción</th>
            <th>Costo</th>
            <th>Imagen</th>
        </tr>
        <?php foreach ($procedures as $procedure): ?>
        <tr>
            <td><?php echo htmlspecialchars($procedure['descripcion']); ?></td>
            <td><?php echo htmlspecialchars($procedure['costo']); ?></td>
            <td><img src="uploads/<?php echo htmlspecialchars($procedure['img']); ?>" alt="Imagen del procedimiento" width="100" height="100"></td>

        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Procedimientos Realizados</h2>
    <table>
        <tr>
            <th>Paciente</th>
            <th>Procedimiento</th>
            <th>Fecha</th>
            <th>Imagen Antes</th>
            <th>Imagen Después</th>
            <th>Observaciones</th>
            <th>Empleado</th>
        </tr>
        <?php foreach ($performedProcedures as $pr): ?>
        <tr>
            <td><?php echo htmlspecialchars($pr['paciente']); ?></td>
            <td><?php echo htmlspecialchars($pr['procedimiento']); ?></td>
            <td><?php echo htmlspecialchars($pr['fecha']); ?></td>
            <td>
                <?php if($pr['img_antes']): ?>
                    <img src="uploads/<?php echo htmlspecialchars($pr['img_antes']); ?>" width="80" height="80">
                <?php else: ?>
                    N/A
                <?php endif; ?>
            </td>
            <td>
                <?php if($pr['img_despues']): ?>
                    <img src="uploads/<?php echo htmlspecialchars($pr['img_despues']); ?>" width="80" height="80">
                <?php else: ?>
                    N/A
                <?php endif; ?>
            </td>
            <td><?php echo htmlspecialchars($pr['observaciones'] ?? 'N/A'); ?></td>
            <td><?php echo htmlspecialchars($pr['empleado'] ?? 'N/A'); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>


    <h2>Empleados (3 primeros)</h2>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Foto</th>
        </tr>
        <?php foreach ($employees as $employee): ?>
        <tr>

            <td><?php echo htmlspecialchars($employee['nombre']); ?></td>
            <td><?php echo htmlspecialchars($employee['apellido']); ?></td>
            <td><img src="uploads/<?php echo htmlspecialchars($employee['foto']); ?>" alt="Foto de <?php echo htmlspecialchars($employee['apellido']); ?>" width="80" height="80"></td>

        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Obras Sociales</h2>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Dirección</th>
        </tr>
        <?php foreach ($socialWorks as $socialWork): ?>
        <tr>
            <td><?php echo htmlspecialchars($socialWork['nombre']); ?></td>
            <td><?php echo htmlspecialchars($socialWork['telefono']); ?></td>
            <td><?php echo htmlspecialchars($socialWork['direccion']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>