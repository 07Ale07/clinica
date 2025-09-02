<?php
session_start();
// Verificar si es administrador
if (!isset($_SESSION['id_admin'])) {
    header('Location: ../login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1>Panel de Control Administrativo</h1>
            <a href="../../inicio_sesion.php" class="logout-btn">Cerrar Sesión</a>
        </header>
        
        <nav class="admin-nav">
            <div class="nav-grid">
                <a href="../abml_inventario" class="nav-card">
                    <div class="card-content">
                        <h3>📦 Inventario</h3>
                        <p>Gestionar productos y stock</p>
                    </div>
                </a>
                
                <a href="../abml_empleados" class="nav-card">
                    <div class="card-content">
                        <h3>👥 Empleados</h3>
                        <p>Administrar personal</p>
                    </div>
                </a>
                
                <a href="../../landing/modelo/modelo_edit_controlador.php" class="nav-card">
                    <div class="card-content">
                        <h3>🌐 Editar Página Principal</h3>
                        <p>Modificar contenido del sitio</p>
                    </div>
                </a>
            </div>
        </nav>
    </div>
</body>
</html>