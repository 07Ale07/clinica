<?php include 'header.php'; ?>

<div class="container">
    <h2>Verificar Paciente</h2>
    <form action="index.php?action=verificar_paciente" method="post">
        <div class="form-group">
            <label for="dni">DNI:</label>
            <input type="number" id="dni" name="dni" required>
        </div>
        <button type="submit">Continuar</button>
    </form>
</div>

<?php include 'footer.php'; ?>