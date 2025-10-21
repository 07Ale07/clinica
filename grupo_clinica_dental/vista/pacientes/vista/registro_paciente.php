<?php include 'header.php'; ?>

<div class="container">
    <h2>Registro de Paciente</h2>
    
    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <form action="index.php?action=registrar_paciente" method="post" id="registroForm">
        <input type="hidden" name="dni" value="<?php echo htmlspecialchars($_POST['dni'] ?? ''); ?>">
        
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required 
                   value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>">
        </div>
        
        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required
                   value="<?php echo htmlspecialchars($_POST['apellido'] ?? ''); ?>">
        </div>
        
        <div class="form-group">
            <label for="fecha_nac">Fecha de Nacimiento:</label>
            <input type="date" id="fecha_nac" name="fecha_nac" required
                   max="<?php echo date('Y-m-d'); ?>"
                   value="<?php echo htmlspecialchars($_POST['fecha_nac'] ?? ''); ?>">
        </div>
        
        <div class="form-group">
            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni" required 
                   pattern="\d{8,10}" title="DNI debe tener 8 a 10 dígitos"
                   value="<?php echo htmlspecialchars($_POST['dni'] ?? ''); ?>" readonly>
            <small class="form-text text-muted">8 a 10 dígitos</small>
        </div>
        
        <button type="submit" class="btn btn-primary">Registrarse y Continuar</button>
    </form>
</div>

<?php include 'footer.php'; ?>