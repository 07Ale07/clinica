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
                        <?php echo htmlspecialchars($odontologo['nombre'] . ' ' . $odontologo['apellido'] ); ?>
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
            <select id="hora" name="hora" required>
                <option value="09:00">09:00</option>
                <option value="10:00">10:00</option>
                <option value="11:00">11:00</option>
                <option value="12:00">12:00</option>
                <option value="15:00">15:00</option>
                <option value="16:00">16:00</option>
                <option value="17:00">17:00</option>
                <option value="18:00">18:00</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="email">¿Desea recibir notificación por correo?</label>
            <input type="email" id="email" name="email" placeholder="Ingrese su correo electrónico">
        </div>
        
        <button type="submit">Confirmar Turno</button>
    </form>
</div>

<?php include 'footer.php'; ?>