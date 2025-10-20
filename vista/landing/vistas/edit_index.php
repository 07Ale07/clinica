<?php
// landing/vistas/edit_index.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor de Landing Page - DentalSmile</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Segoe+UI:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :root {
            --primary-color: #1a4b8c;
            --secondary-color: #2c5aa0;
            --accent-color: #00d4aa;
            --light-blue: #e8f4f8;
            --white: #ffffff;
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-300: #dee2e6;
            --gray-600: #6c757d;
            --gray-800: #343a40;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --shadow-hover: 0 15px 40px rgba(0, 0, 0, 0.15);
            --gradient: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            --gradient-accent: linear-gradient(135deg, var(--accent-color) 0%, #00b4d8 100%);
            --border-radius: 16px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--gray-800);
            background: linear-gradient(45deg, #f8f9ff 0%, #e8f4f8 50%, #f0f8ff 100%);
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Header del editor */
        .editor-header {
            background: var(--gradient);
            color: white;
            padding: 2rem 0;
            text-align: center;
            margin-bottom: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
        }

        .editor-header h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .editor-header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Formulario de edición */
        #editForm {
            background: var(--white);
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            margin-bottom: 3rem;
        }

        .form-section {
            margin-bottom: 2.5rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid var(--gray-200);
        }

        .form-section:last-of-type {
            border-bottom: none;
        }

        .form-section h2 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--accent-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-section h2 i {
            color: var(--accent-color);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--gray-800);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-group label i {
            color: var(--accent-color);
            width: 20px;
        }

        .form-control {
            width: 100%;
            padding: 1rem;
            border: 2px solid var(--gray-200);
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(0, 212, 170, 0.2);
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        /* Bloques de servicios y testimonios */
        .service-block, .testimonial-block {
            background: var(--gray-100);
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--accent-color);
        }

        .service-block h3, .testimonial-block h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .service-block h3 i, .testimonial-block h3 i {
            color: var(--accent-color);
        }

        /* Botones */
        .btn {
            background: var(--gradient);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: bold;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            background: var(--gradient-accent);
        }

        .btn-secondary {
            background: var(--gray-600);
        }

        .btn-secondary:hover {
            background: var(--gray-800);
        }

        .btn-success {
            background: #28a745;
        }

        .btn-success:hover {
            background: #218838;
        }

        .form-actions {
            text-align: center;
            margin-top: 2rem;
        }

        /* Lista de configuraciones en espera */
        .pending-configs {
            background: var(--white);
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
        }

        .pending-configs h2 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        #pendingList {
            list-style: none;
        }

        #pendingList li {
            padding: 1.5rem;
            border: 1px solid var(--gray-200);
            border-radius: 10px;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        #pendingList li:hover {
            box-shadow: var(--shadow);
            transform: translateY(-2px);
        }

        .config-info {
            flex: 1;
        }

        .config-title {
            font-weight: bold;
            color: var(--primary-color);
        }

        .config-date {
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        .config-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: var(--gray-600);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--gray-300);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .editor-header h1 {
                font-size: 2rem;
            }
            
            #editForm {
                padding: 1.5rem;
            }
            
            #pendingList li {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .config-actions {
                width: 100%;
                justify-content: flex-end;
            }
        }

        /* Tabs para navegación */
        .tabs {
            display: flex;
            margin-bottom: 2rem;
            background: var(--white);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .tab {
            flex: 1;
            padding: 1rem;
            text-align: center;
            background: var(--gray-100);
            cursor: pointer;
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
        }

        .tab.active {
            background: var(--white);
            border-bottom: 3px solid var(--accent-color);
            font-weight: bold;
        }

        .tab:hover {
            background: var(--light-blue);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Iconos decorativos */
        .icon-decorative {
            color: var(--accent-color);
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="editor-header">
            <h1><i class="fas fa-edit"></i> Editor de Landing Page</h1>
            <p>Modifica el contenido de tu sitio web DentalSmile</p>
        </div>

        <!-- Tabs de navegación -->
        <div class="tabs">
            <div class="tab active" onclick="showTab('edit')">Editor de Contenido</div>
            <div class="tab" onclick="showTab('pending')">Configuraciones en Espera</div>
        </div>

        <!-- Pestaña de Editor -->
        <div id="edit-tab" class="tab-content active">
            <form id="editForm">
                <div class="form-section">
                    <h2><i class="fas fa-heading"></i> Header</h2>
                    <div class="form-group">
                        <label><i class="fas fa-font"></i> Título:</label>
                        <input type="text" name="header_title" value="<?php echo htmlspecialchars($currentConfig['header_title']); ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-bars"></i> Items de Menú (separados por coma):</label>
                        <input type="text" name="menu_items" value="<?php echo htmlspecialchars(implode(',', $currentConfig['menu_items'])); ?>" class="form-control" required>
                    </div>
                </div>

                <div class="form-section">
                    <h2><i class="fas fa-star"></i> Sección Hero</h2>
                    <div class="form-group">
                        <label><i class="fas fa-heading"></i> Título:</label>
                        <input type="text" name="hero_title" value="<?php echo htmlspecialchars($currentConfig['hero_title']); ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-align-left"></i> Descripción:</label>
                        <textarea name="hero_description" class="form-control" required><?php echo htmlspecialchars($currentConfig['hero_description']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-button"></i> Botón 1:</label>
                        <input type="text" name="hero_button1" value="<?php echo htmlspecialchars($currentConfig['hero_button1']); ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-button"></i> Botón 2:</label>
                        <input type="text" name="hero_button2" value="<?php echo htmlspecialchars($currentConfig['hero_button2']); ?>" class="form-control" required>
                    </div>
                </div>

                <div class="form-section">
                    <h2><i class="fas fa-teeth"></i> Servicios</h2>
                    <div class="form-group">
                        <label><i class="fas fa-heading"></i> Título de Servicios:</label>
                        <input type="text" name="services_title" value="<?php echo htmlspecialchars($currentConfig['services_title']); ?>" class="form-control" required>
                    </div>
                    <?php foreach ($currentConfig['services'] as $i => $service): ?>
                        <div class="service-block">
                            <h3><i class="fas fa-cog"></i> Servicio <?php echo $i+1; ?></h3>
                            <div class="form-group">
                                <label><i class="fas fa-image"></i> Imagen URL:</label>
                                <input type="text" name="services_<?php echo $i; ?>_image" value="<?php echo htmlspecialchars($service['image']); ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-heading"></i> Título:</label>
                                <input type="text" name="services_<?php echo $i; ?>_title" value="<?php echo htmlspecialchars($service['title']); ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-align-left"></i> Descripción:</label>
                                <textarea name="services_<?php echo $i; ?>_description" class="form-control" required><?php echo htmlspecialchars($service['description']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-icons"></i> Ícono (clase Font Awesome):</label>
                                <input type="text" name="services_<?php echo $i; ?>_icon" value="<?php echo htmlspecialchars($service['icon']); ?>" class="form-control" required>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="form-section">
                    <h2><i class="fas fa-users"></i> Sección Sobre Nosotros</h2>
                    <div class="form-group">
                        <label><i class="fas fa-heading"></i> Título:</label>
                        <input type="text" name="about_title" value="<?php echo htmlspecialchars($currentConfig['about_title']); ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-align-left"></i> Descripción:</label>
                        <textarea name="about_description" class="form-control" required><?php echo htmlspecialchars($currentConfig['about_description']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-button"></i> Botón:</label>
                        <input type="text" name="about_button" value="<?php echo htmlspecialchars($currentConfig['about_button']); ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-image"></i> Imagen URL:</label>
                        <input type="text" name="about_image" value="<?php echo htmlspecialchars($currentConfig['about_image']); ?>" class="form-control" required>
                    </div>
                </div>

                <div class="form-section">
                    <h2><i class="fas fa-comments"></i> Testimonios</h2>
                    <div class="form-group">
                        <label><i class="fas fa-heading"></i> Título de Testimonios:</label>
                        <input type="text" name="testimonials_title" value="<?php echo htmlspecialchars($currentConfig['testimonials_title']); ?>" class="form-control" required>
                    </div>
                    <?php foreach ($currentConfig['testimonials'] as $i => $testimonial): ?>
                        <div class="testimonial-block">
                            <h3><i class="fas fa-quote-left"></i> Testimonio <?php echo $i+1; ?></h3>
                            <div class="form-group">
                                <label><i class="fas fa-quote-right"></i> Cita:</label>
                                <textarea name="testimonials_<?php echo $i; ?>_quote" class="form-control" required><?php echo htmlspecialchars($testimonial['quote']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-user"></i> Nombre:</label>
                                <input type="text" name="testimonials_<?php echo $i; ?>_name" value="<?php echo htmlspecialchars($testimonial['name']); ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-calendar"></i> Desde:</label>
                                <input type="text" name="testimonials_<?php echo $i; ?>_since" value="<?php echo htmlspecialchars($testimonial['since']); ?>" class="form-control" required>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="form-section">
                    <h2><i class="fas fa-bullhorn"></i> Sección CTA</h2>
                    <div class="form-group">
                        <label><i class="fas fa-heading"></i> Título:</label>
                        <input type="text" name="cta_title" value="<?php echo htmlspecialchars($currentConfig['cta_title']); ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-align-left"></i> Descripción:</label>
                        <textarea name="cta_description" class="form-control" required><?php echo htmlspecialchars($currentConfig['cta_description']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-button"></i> Botón:</label>
                        <input type="text" name="cta_button" value="<?php echo htmlspecialchars($config['cta_button']); ?>" class="form-control" required>
                    </div>
                </div>

                <div class="form-section">
                    <h2><i class="fas fa-shoe-prints"></i> Footer</h2>
                    <div class="form-group">
                        <label><i class="fas fa-heading"></i> Título:</label>
                        <input type="text" name="footer_title" value="<?php echo htmlspecialchars($currentConfig['footer_title']); ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-align-left"></i> Descripción:</label>
                        <textarea name="footer_description" class="form-control" required><?php echo htmlspecialchars($currentConfig['footer_description']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-link"></i> Enlaces (separados por coma):</label>
                        <input type="text" name="footer_links" value="<?php echo htmlspecialchars(implode(',', $currentConfig['footer_links'])); ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-map-marker-alt"></i> Dirección:</label>
                        <input type="text" name="footer_address" value="<?php echo htmlspecialchars($currentConfig['footer_address']); ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-phone"></i> Teléfono:</label>
                        <input type="text" name="footer_phone" value="<?php echo htmlspecialchars($currentConfig['footer_phone']); ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-envelope"></i> Email:</label>
                        <input type="text" name="footer_email" value="<?php echo htmlspecialchars($currentConfig['footer_email']); ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-clock"></i> Horario:</label>
                        <textarea name="footer_hours" class="form-control" required><?php echo htmlspecialchars($currentConfig['footer_hours']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-copyright"></i> Copyright:</label>
                        <input type="text" name="footer_copyright" value="<?php echo htmlspecialchars($currentConfig['footer_copyright']); ?>" class="form-control" required>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn" onclick="saveChanges()">
                        <i class="fas fa-save"></i> Guardar en Espera
                    </button>
                </div>
            </form>
        </div>

        <!-- Pestaña de Configuraciones en Espera -->
        <div id="pending-tab" class="tab-content">
            <div class="pending-configs">
                <h2><i class="fas fa-clock"></i> Configuraciones en Espera</h2>
                <ul id="pendingList">
                    <?php
                    $sql = "SELECT id, created_at, config_json FROM landing_configs WHERE status = 'espera' ORDER BY created_at DESC";
                    $result = $conexion->query($sql);
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $config = json_decode($row['config_json'], true);
                            $title = isset($config['header_title']) ? htmlspecialchars($config['header_title']) : 'Sin título';
                            echo "<li>
                                <div class='config-info'>
                                    <div class='config-title'>{$title}</div>
                                    <div class='config-date'>Creado: {$row['created_at']}</div>
                                </div>
                                <div class='config-actions'>
                                    <button class='btn btn-success btn-sm' onclick='applyChanges({$row['id']})'>
                                        <i class='fas fa-check'></i> Aplicar
                                    </button>
                                    <button class='btn btn-secondary btn-sm' onclick='previewChanges({$row['id']})'>
                                        <i class='fas fa-eye'></i> Vista Previa
                                    </button>
                                </div>
                            </li>";
                        }
                    } else {
                        echo "<div class='empty-state'>
                            <i class='fas fa-inbox'></i>
                            <h3>No hay configuraciones en espera</h3>
                            <p>Las configuraciones guardadas aparecerán aquí</p>
                        </div>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Ocultar todas las pestañas
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Desactivar todas las pestañas
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Activar la pestaña seleccionada
            document.getElementById(tabName + '-tab').classList.add('active');
            document.querySelector(`.tab:nth-child(${tabName === 'edit' ? 1 : 2})`).classList.add('active');
        }
        
        function saveChanges() {
            // Lógica para guardar cambios
            alert('Cambios guardados en espera. Debes implementar la lógica real para guardar en base de datos.');
        }
        
        function applyChanges(configId) {
            // Lógica para aplicar cambios
            alert(`Aplicando configuración con ID: ${configId}. Debes implementar la lógica real.`);
        }
        
        function previewChanges(configId) {
            // Lógica para vista previa
            alert(`Vista previa de configuración con ID: ${configId}. Debes implementar la lógica real.`);
        }
    </script>
</body>
</html>