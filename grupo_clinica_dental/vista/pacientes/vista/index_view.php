<?php include 'header.php'; ?>

<div class="container">
    <h2>Sistema de Turnos</h2>
    <div class="options">
        <div class="option-card" onclick="window.location.href='index.php?action=verificar_paciente'">
            <h3>Sacar Turno</h3>
            <p>Nuevo turno para atención</p>
        </div>
        <div class="option-card" onclick="window.location.href='index.php?action=consultar_turno'">
            <h3>Consultar Turno</h3>
            <p>Ver o modificar turno existente</p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>