<?php include 'header.php'; ?>

<div class="container">
    <h2>Turno Confirmado</h2>
    <div class="confirmation-message">
        <p>¡Su turno ha sido registrado exitosamente!</p>
        <p>Fecha: <?php echo htmlspecialchars($_POST['fecha']); ?></p>
        <p>Hora: <?php echo htmlspecialchars($_POST['hora']); ?></p>
        
        <?php if (!empty($_POST['email'])): ?>
            <p>Se enviará una confirmación a: <?php echo htmlspecialchars($_POST['email']); ?></p>
        <?php endif; ?>
    </div>
    
    <a href="index.php" class="btn">Volver al inicio</a>
</div>

<?php include 'footer.php'; ?>