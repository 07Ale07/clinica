<?php
// landing/vistas/edit_index.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Landing Page</title>
    <link rel="stylesheet" href="../public/css/editor.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Editar Contenidos de la Landing Page</h1>
        <form id="editForm">
            <h2>Header</h2>
            <label>Título: <input type="text" name="header_title" value="<?php echo htmlspecialchars($currentConfig['header_title']); ?>" required></label>
            <label>Items de Menú (separados por coma): <input type="text" name="menu_items" value="<?php echo htmlspecialchars(implode(',', $currentConfig['menu_items'])); ?>" required></label>

            <h2>Sección Hero</h2>
            <label>Título: <input type="text" name="hero_title" value="<?php echo htmlspecialchars($currentConfig['hero_title']); ?>" required></label>
            <label>Descripción: <textarea name="hero_description" required><?php echo htmlspecialchars($currentConfig['hero_description']); ?></textarea></label>
            <label>Botón 1: <input type="text" name="hero_button1" value="<?php echo htmlspecialchars($currentConfig['hero_button1']); ?>" required></label>
            <label>Botón 2: <input type="text" name="hero_button2" value="<?php echo htmlspecialchars($currentConfig['hero_button2']); ?>" required></label>

            <h2>Servicios</h2>
            <label>Título de Servicios: <input type="text" name="services_title" value="<?php echo htmlspecialchars($currentConfig['services_title']); ?>" required></label>
            <?php foreach ($currentConfig['services'] as $i => $service): ?>
                <div class="service-block">
                    <h3>Servicio <?php echo $i+1; ?></h3>
                    <label>Imagen URL: <input type="text" name="services_<?php echo $i; ?>_image" value="<?php echo htmlspecialchars($service['image']); ?>"></label>
                    <label>Título: <input type="text" name="services_<?php echo $i; ?>_title" value="<?php echo htmlspecialchars($service['title']); ?>" required></label>
                    <label>Descripción: <textarea name="services_<?php echo $i; ?>_description" required><?php echo htmlspecialchars($service['description']); ?></textarea></label>
                    <label>Ícono (clase Font Awesome, ej. fas fa-tooth): <input type="text" name="services_<?php echo $i; ?>_icon" value="<?php echo htmlspecialchars($service['icon']); ?>" required></label>
                </div>
            <?php endforeach; ?>

            <h2>Sección Sobre Nosotros</h2>
            <label>Título: <input type="text" name="about_title" value="<?php echo htmlspecialchars($currentConfig['about_title']); ?>" required></label>
            <label>Descripción: <textarea name="about_description" required><?php echo htmlspecialchars($currentConfig['about_description']); ?></textarea></label>
            <label>Botón: <input type="text" name="about_button" value="<?php echo htmlspecialchars($currentConfig['about_button']); ?>" required></label>
            <label>Imagen URL: <input type="text" name="about_image" value="<?php echo htmlspecialchars($currentConfig['about_image']); ?>" required></label>

            <h2>Testimonios</h2>
            <label>Título de Testimonios: <input type="text" name="testimonials_title" value="<?php echo htmlspecialchars($currentConfig['testimonials_title']); ?>" required></label>
            <?php foreach ($currentConfig['testimonials'] as $i => $testimonial): ?>
                <div class="testimonial-block">
                    <h3>Testimonio <?php echo $i+1; ?></h3>
                    <label>Cita: <textarea name="testimonials_<?php echo $i; ?>_quote" required><?php echo htmlspecialchars($testimonial['quote']); ?></textarea></label>
                    <label>Nombre: <input type="text" name="testimonials_<?php echo $i; ?>_name" value="<?php echo htmlspecialchars($testimonial['name']); ?>" required></label>
                    <label>Desde: <input type="text" name="testimonials_<?php echo $i; ?>_since" value="<?php echo htmlspecialchars($testimonial['since']); ?>" required></label>
                </div>
            <?php endforeach; ?>

            <h2>Sección CTA</h2>
            <label>Título: <input type="text" name="cta_title" value="<?php echo htmlspecialchars($currentConfig['cta_title']); ?>" required></label>
            <label>Descripción: <textarea name="cta_description" required><?php echo htmlspecialchars($currentConfig['cta_description']); ?></textarea></label>
            <label>Botón: <input type="text" name="cta_button" value="<?php echo htmlspecialchars($config['cta_button']); ?>" required></label>

            <h2>Footer</h2>
            <label>Título: <input type="text" name="footer_title" value="<?php echo htmlspecialchars($currentConfig['footer_title']); ?>" required></label>
            <label>Descripción: <textarea name="footer_description" required><?php echo htmlspecialchars($currentConfig['footer_description']); ?></textarea></label>
            <label>Enlaces (separados por coma): <input type="text" name="footer_links" value="<?php echo htmlspecialchars(implode(',', $currentConfig['footer_links'])); ?>" required></label>
            <label>Dirección: <input type="text" name="footer_address" value="<?php echo htmlspecialchars($currentConfig['footer_address']); ?>" required></label>
            <label>Teléfono: <input type="text" name="footer_phone" value="<?php echo htmlspecialchars($currentConfig['footer_phone']); ?>" required></label>
            <label>Email: <input type="text" name="footer_email" value="<?php echo htmlspecialchars($currentConfig['footer_email']); ?>" required></label>
            <label>Horario: <textarea name="footer_hours" required><?php echo htmlspecialchars($currentConfig['footer_hours']); ?></textarea></label>
            <label>Copyright: <input type="text" name="footer_copyright" value="<?php echo htmlspecialchars($currentConfig['footer_copyright']); ?>" required></label>

            <button type="button" onclick="saveChanges()">Guardar en Espera</button>
        </form>

        <h2>Configuraciones en Espera</h2>
        <ul id="pendingList">
            <?php
            $sql = "SELECT id, created_at, config_json FROM landing_configs WHERE status = 'espera' ORDER BY created_at DESC";
            $result = $conexion->query($sql);
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $config = json_decode($row['config_json'], true);
                    $title = isset($config['header_title']) ? htmlspecialchars($config['header_title']) : 'Sin título';
                    echo "<li>ID: {$row['id']} - Creado: {$row['created_at']} - Título: {$title} <button onclick='applyChanges({$row['id']})'>Aplicar</button></li>";
                }
            } else {
                echo "<li>No hay configuraciones en espera.</li>";
            }
            ?>
        </ul>
    </div>

    <script src="../public/js/editor.js"></script>
</body>
</html>