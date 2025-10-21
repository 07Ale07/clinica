<?php
// landing/modelo/modelo_edit_controlador.php
session_start();

// Verificar si el usuario está autenticado (deberías implementar tu propia lógica de autenticación)


// Configuración de la página
$pagina_titulo = "Panel de Control - Editor de Contenido";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pagina_titulo; ?></title>
    <link rel="stylesheet" href="../public/css/controller.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="controlador-container">
        <header class="controlador-header">
            <h1><i class="fas fa-cogs"></i> Panel de Control</h1>
            <p>Selecciona qué sección deseas editar</p>
        </header>

        <div class="opciones-grid">
            <div class="opcion-card">
                <div class="opcion-icon">
                    <i class="fas fa-home"></i>
                </div>
                <h2>Página Principal</h2>
                <p>Edita el contenido de la página de inicio, hero section, testimonios y call to action.</p>
                <a href="modelo_edit_index.php" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Editar Página Principal
                </a>
            </div>

            <div class="opcion-card">
                <div class="opcion-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h2>Contacto</h2>
                <p>Modifica la información de contacto, formularios y datos de la clínica.</p>
                <a href="modelo_edit_contacto.php" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Editar Contacto
                </a>
            </div>


            <div class="opcion-card">
                <div class="opcion-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h2>Quiénes Somos</h2>
                <p>Edita la información sobre la clínica, equipo y historia.</p>
                <a href="modelo_edit_somos.php" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Editar Quiénes Somos
                </a>
            </div>

            <div class="opcion-card">
                <div class="opcion-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <h2>Vista Previa</h2>
                <p>Ve cómo se ve tu sitio web con los cambios actuales.</p>
                <a href="../index.php" target="_blank" class="btn btn-secondary">
                    <i class="fas fa-external-link-alt"></i> Ver Sitio Web
                </a>
            </div>
        </div>

        <footer class="controlador-footer">
            <p>&copy; 2023 DentalSmile - Panel de Control</p>
            <a href="../index.php" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Volver al Sitio
            </a>
        </footer>
    </div>
</body>
</html>
