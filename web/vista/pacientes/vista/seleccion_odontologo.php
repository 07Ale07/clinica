<?php include 'header.php'; ?>

<div class="container">
    <h2>Seleccionar Odontólogo</h2>
    <form action="index.php?action=confirmar_turno" method="post">
        <input type="hidden" name="id_persona" value="<?php echo $paciente['id_persona'] ?? ''; ?>">
        
        <div class="form-group">
            <label for="id_odontologo">Odontólogo:</label>
            <select id="id_odontologo" name="id_odontologo" required>
                <?php foreach ($odontologos as $odontologo): ?>
                    <option value="<?php echo $odontologo['id_persona']; ?>">
                        <?php echo $odontologo['nombre'] . ' ' . $odontologo['apellido'] . ' - Mat: ' . $odontologo['matricula']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required min="<?php echo date('Y-m-d'); ?>">
        </div>
        
        <div class="form-group">
            <label for="hora">Hora:</label>
            <input type="time" id="hora" name="hora" required>
        </div>
        
        <div class="form-group">
            <label for="email">¿Desea recibir notificación por correo?</label>
            <input type="email" id="email" name="email" placeholder="Ingrese su correo electrónico">
        </div>
        
        <button type="submit">Confirmar Turno</button>
    </form>
</div>

<?php include 'footer.php'; ?>