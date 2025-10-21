<?php include 'header.php'; ?>

<div class="container">
    <h2>Consultar Turnos del Paciente</h2>
    
    <?php if (isset($_SESSION['mensaje_exito'])): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($_SESSION['mensaje_exito']); ?>
            <?php unset($_SESSION['mensaje_exito']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-error">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($paciente) && !empty($citas)): ?>
        <div class="paciente-info">
            <h3>Paciente: <?php echo htmlspecialchars($paciente['nombre'] . ' ' . $paciente['apellido']); ?></h3>
            <p>DNI: <?php echo htmlspecialchars($paciente['DNI']); ?></p>
        </div>

        <div class="citas-list">
            <h4>Citas Registradas:</h4>
            <table class="citas-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Odontólogo</th>
                        <th>Estado</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($citas as $cita): ?>
                        <tr>
                            <td><?php echo date('d/m/Y', strtotime($cita['fecha_inicio'])); ?></td>
                            <td><?php echo date('H:i', strtotime($cita['fecha_inicio'])); ?></td>
                            <td><?php echo htmlspecialchars($cita['nombre_odontologo'] ?? 'No asignado'); ?></td>
                            <td>
                                <span class="estado-<?php echo htmlspecialchars($cita['estado']); ?>">
                                    <?php echo htmlspecialchars($cita['estado']); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($cita['tipo'] ?? 'Consulta'); ?></td>
                            <td>
                                <?php if ($cita['estado'] == 'pendiente' || $cita['estado'] == 'confirmada'): ?>
                                    <button onclick="cancelarCita(<?php echo $cita['id_cita']; ?>)" class="btn-cancelar">Cancelar</button>
                                <?php else: ?>
                                    <span class="text-muted">No disponible</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php elseif (isset($paciente) && empty($citas)): ?>
        <div class="no-citas">
            <p>El paciente no tiene citas registradas.</p>
        </div>
    <?php endif; ?>

    <?php if (!isset($paciente)): ?>
        <form action="index.php?action=consultar_turno" method="post">
            <div class="form-group">
                <label for="dni">DNI del Paciente:</label>
                <input type="number" id="dni" name="dni" required placeholder="Ingrese el DNI">
            </div>
            <button type="submit" class="btn-primary">Buscar Citas</button>
        </form>
    <?php endif; ?>

    <div class="actions">
        <a href="index.php" class="btn-secondary">Volver al Inicio</a>
        <?php if (isset($paciente)): ?>
            <a href="index.php?action=consultar_turno" class="btn-secondary">Nueva Búsqueda</a>
        <?php endif; ?>
    </div>
</div>

<script>
function modificarCita(idCita) {
    if (confirm('¿Desea modificar esta cita?')) {
        // Por ahora redirige a modificar, puedes implementar esta funcionalidad después
        alert('Funcionalidad de modificación en desarrollo');
        // window.location.href = 'index.php?action=modificar_cita&id=' + idCita;
    }
}

function cancelarCita(idCita) {
    if (confirm('¿Está seguro de que desea cancelar esta cita? Esta acción no se puede deshacer.')) {
        window.location.href = 'index.php?action=cancelar_cita&id=' + idCita;
    }
}
</script>

<style>
.citas-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.citas-table th, .citas-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.citas-table th {
    background-color: #f2f2f2;
}

.estado-pendiente { color: orange; font-weight: bold; }
.estado-confirmada { color: green; font-weight: bold; }
.estado-completada { color: blue; font-weight: bold; }
.estado-cancelada { color: red; font-weight: bold; }
.estado-no_asistio { color: purple; font-weight: bold; }

.btn-modificar { 
    background-color: #4CAF50; 
    color: white; 
    border: none; 
    padding: 5px 10px; 
    margin: 2px;
    cursor: pointer;
    border-radius: 3px;
}

.btn-cancelar { 
    background-color: #f44336; 
    color: white; 
    border: none; 
    padding: 5px 10px; 
    margin: 2px;
    cursor: pointer;
    border-radius: 3px;
}

.alert-error {
    background-color: #ffebee;
    color: #c62828;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 20px;
    border: 1px solid #f5c6cb;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 20px;
    border: 1px solid #c3e6cb;
}

.paciente-info {
    background-color: #e8f5e8;
    padding: 15px;
    border-radius: 4px;
    margin-bottom: 20px;
    border: 1px solid #c3e6cb;
}

.no-citas {
    background-color: #fff3cd;
    padding: 15px;
    border-radius: 4px;
    margin-bottom: 20px;
    border: 1px solid #ffeaa7;
}

.text-muted {
    color: #6c757d;
    font-style: italic;
}

.btn-primary {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 4px;
    display: inline-block;
    margin-top: 10px;
    margin-right: 10px;
}

.actions {
    margin-top: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-group input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    max-width: 300px;
}
</style>

<?php include 'footer.php'; ?>