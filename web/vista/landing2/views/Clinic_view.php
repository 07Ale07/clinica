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
            <th>ID</th>
            <th>Descripción</th>
            <th>Costo</th>
        </tr>
        <?php foreach ($procedures as $procedure): ?>
        <tr>
            <td><?php echo htmlspecialchars($procedure['id_procedimiento']); ?></td>
            <td><?php echo htmlspecialchars($procedure['descripcion']); ?></td>
            <td><?php echo htmlspecialchars($procedure['costo']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Pacientes (3 primeros)</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>DNI</th>
            <th>Fecha Registro</th>
            <th>Tipo</th>
            <th>Alergias</th>
            <th>Observaciones</th>
        </tr>
        <?php foreach ($patients as $patient): ?>
        <tr>
            <td><?php echo htmlspecialchars($patient['id_paciente']); ?></td>
            <td><?php echo htmlspecialchars($patient['nombre']); ?></td>
            <td><?php echo htmlspecialchars($patient['apellido']); ?></td>
            <td><?php echo htmlspecialchars($patient['DNI']); ?></td>
            <td><?php echo htmlspecialchars($patient['fecha_registro']); ?></td>
            <td><?php echo htmlspecialchars($patient['tipo'] ?? 'N/A'); ?></td>
            <td><?php echo htmlspecialchars($patient['alergias'] ?? 'N/A'); ?></td>
            <td><?php echo htmlspecialchars($patient['observaciones_generales'] ?? 'N/A'); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Empleados (3 primeros)</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Número Legajo</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Tipo Contrato</th>
            <th>Teléfono Interno</th>
        </tr>
        <?php foreach ($employees as $employee): ?>
        <tr>
            <td><?php echo htmlspecialchars($employee['id_empleado']); ?></td>
            <td><?php echo htmlspecialchars($employee['numero_legajo']); ?></td>
            <td><?php echo htmlspecialchars($employee['nombre']); ?></td>
            <td><?php echo htmlspecialchars($employee['apellido']); ?></td>
            <td><?php echo htmlspecialchars($employee['tipo_contrato']); ?></td>
            <td><?php echo htmlspecialchars($employee['telefono_interno'] ?? 'N/A'); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Obras Sociales</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Código Nacional</th>
            <th>CUIT</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Dirección</th>
            <th>Página Web</th>
            <th>Requiere Autorización</th>
            <th>Días Carencia</th>
        </tr>
        <?php foreach ($socialWorks as $socialWork): ?>
        <tr>
            <td><?php echo htmlspecialchars($socialWork['id_obra_social']); ?></td>
            <td><?php echo htmlspecialchars($socialWork['nombre']); ?></td>
            <td><?php echo htmlspecialchars($socialWork['codigo_nacional']); ?></td>
            <td><?php echo htmlspecialchars($socialWork['cuit']); ?></td>
            <td><?php echo htmlspecialchars($socialWork['telefono']); ?></td>
            <td><?php echo htmlspecialchars($socialWork['email']); ?></td>
            <td><?php echo htmlspecialchars($socialWork['direccion']); ?></td>
            <td><?php echo htmlspecialchars($socialWork['pagina_web']); ?></td>
            <td><?php echo $socialWork['requiere_autorizacion'] ? 'Sí' : 'No'; ?></td>
            <td><?php echo htmlspecialchars($socialWork['dias_carencia']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>