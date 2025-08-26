<?php
// index.php
require_once __DIR__ . '/modelo/Paciente.php';

$pacientes = (new Paciente())->getPacientesActivos();

// Verificar si ya se seleccionó un paciente
if(isset($_GET['id_paciente'])) {
    require __DIR__ . '/vista/odontograma.php';
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Selección de Paciente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Seleccionar Paciente</h1>
        <div class="list-group">
            <?php foreach ($pacientes as $p): ?>
                <a href="index.php?id_paciente=<?= $p['id_paciente'] ?>" 
                   class="list-group-item list-group-item-action">
                    <?= "{$p['nombre']} {$p['apellido']} - {$p['DNI']}" ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>