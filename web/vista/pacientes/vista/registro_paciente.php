<?php include 'header.php'; ?>

<div class="container">
    <h2>Registro de Paciente</h2>
    <form action="index.php?action=registrar_paciente" method="post">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required>
        </div>
        <div class="form-group">
            <label for="fecha_nac">Fecha de Nacimiento:</label>
            <input type="date" id="fecha_nac" name="fecha_nac" required>
        </div>
        <div class="form-group">
            <label for="dni">DNI:</label>
            <input type="number" id="dni" name="dni" required>
        </div>
        <input type="hidden" name="dni" value="<?php echo $_POST['dni'] ?? ''; ?>">
        <button type="submit">Registrarse y Continuar</button>
    </form>
</div>

<?php include 'footer.php'; ?>