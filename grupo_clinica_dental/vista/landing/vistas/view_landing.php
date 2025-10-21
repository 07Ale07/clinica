<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($config['header_title']); ?> - Clínica Dental</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .data-section {
            padding: 60px 0;
            background-color: #f8f9fa;
        }
        .data-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .section-title {
            text-align: center;
            margin-bottom: 40px;
            color: #2c3e50;
            font-size: 2.2rem;
        }
        .data-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 50px;
        }
        .data-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }
        .data-card:hover {
            transform: translateY(-5px);
        }
        .data-card h3 {
            color: #3498db;
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 1.4rem;
        }
        .procedimiento-card {
            text-align: center;
            border-top: 4px solid #3498db;
        }
        .procedimiento-card .costo {
            font-weight: bold;
            color: #27ae60;
            font-size: 1.4rem;
            margin: 15px 0;
        }
        .paciente-card {
            border-top: 4px solid #9b59b6;
        }
        .empleado-card {
            border-top: 4px solid #e74c3c;
        }
        .obra-social-card {
            border-top: 4px solid #f39c12;
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            margin-top: 10px;
        }
        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }
        .badge-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        .data-label {
            font-weight: 600;
            color: #7f8c8d;
            display: block;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <h1><i class="fas fa-tooth"></i> <?php echo htmlspecialchars($config['header_title']); ?></h1>
            </div>
            <nav>
                <ul>
                    <?php foreach ($config['menu_items'] as $item): ?>
                        <li><a href="#"><?php echo htmlspecialchars($item); ?></a></li>
                    <?php endforeach; ?>
                    <li><a href="../inicio_sesion.php">Iniciar Sesión</a></li>
                </ul>
            </nav>
            <div class="nav-toggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h2><?php echo htmlspecialchars($config['hero_title']); ?></h2>
                <p><?php echo htmlspecialchars($config['hero_description']); ?></p>
                <div class="hero-buttons">
                    <a href="../pacientes" class="btn btn-primary"><?php echo htmlspecialchars($config['hero_button1']); ?></a>
                    <a href="#servicios" class="btn btn-secondary"><?php echo htmlspecialchars($config['hero_button2']); ?></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de datos de la clínica -->
    <section class="data-section">
        <div class="data-container">
            <h2 class="section-title">Información de Nuestra Clínica</h2>
            
            <!-- Procedimientos -->
            <h3 class="section-title">Procedimientos Destacados</h3>
            <div class="data-grid">
                <?php foreach ($datos['procedimientos'] as $procedimiento): ?>
                    <div class="data-card procedimiento-card">
                        <h3><?php echo htmlspecialchars($procedimiento['descripcion']); ?></h3>
                        <p class="costo">$<?php echo number_format($procedimiento['costo'], 2, ',', '.'); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Pacientes -->
            <h3 class="section-title">Pacientes Recientes</h3>
            <div class="data-grid">
                <?php foreach ($datos['pacientes'] as $paciente): ?>
                    <div class="data-card paciente-card">
                        <h3><?php echo htmlspecialchars($paciente['nombre'] . ' ' . $paciente['apellido']); ?></h3>
                        <span class="data-label">Fecha de registro:</span>
                        <p><?php echo date('d/m/Y', strtotime($paciente['fecha_registro'])); ?></p>
                        <span class="data-label">Tipo:</span>
                        <p><?php echo htmlspecialchars($paciente['tipo'] ?? 'Adulto'); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Empleados -->
            <h3 class="section-title">Nuestro Equipo</h3>
            <div class="data-grid">
                <?php foreach ($datos['empleados'] as $empleado): ?>
                    <div class="data-card empleado-card">
                        <h3><?php echo htmlspecialchars($empleado['nombre'] . ' ' . $empleado['apellido']); ?></h3>
                        <span class="data-label">Legajo:</span>
                        <p><?php echo htmlspecialchars($empleado['numero_legajo']); ?></p>
                        <span class="data-label">Tipo de contrato:</span>
                        <p><?php echo htmlspecialchars($empleado['tipo_contrato']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Obras Sociales -->
            <h3 class="section-title">Obras Sociales con las que Trabajamos</h3>
            <div class="data-grid">
                <?php foreach ($datos['obrasSociales'] as $obraSocial): ?>
                    <div class="data-card obra-social-card">
                        <h3><?php echo htmlspecialchars($obraSocial['nombre']); ?></h3>
                        <span class="data-label">Código nacional:</span>
                        <p><?php echo htmlspecialchars($obraSocial['codigo_nacional']); ?></p>
                        <span class="data-label">Teléfono:</span>
                        <p><?php echo htmlspecialchars($obraSocial['telefono']); ?></p>
                        <span class="badge badge-success">Activa</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Servicios -->
    <section id="servicios" class="services">
        <div class="container">
            <h2 class="section-title"><?php echo htmlspecialchars($config['services_title']); ?></h2>
            <div class="services-grid">
                <?php foreach ($config['services'] as $service): ?>
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="<?php echo htmlspecialchars($service['icon']); ?>"></i>
                        </div>
                        <h3><?php echo htmlspecialchars($service['title']); ?></h3>
                        <p><?php echo htmlspecialchars($service['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Sección about -->
    <section class="about-preview">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2><?php echo htmlspecialchars($config['about_title']); ?></h2>
                    <p><?php echo htmlspecialchars($config['about_description']); ?></p>
                    <a href="somos.html" class="btn btn-outline"><?php echo htmlspecialchars($config['about_button']); ?></a>
                </div>
                <div class="about-image">
                    <img src="<?php echo htmlspecialchars($config['about_image']); ?>" alt="Equipo de DentalSmile">
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonios -->
    <section id="testimonios" class="testimonials">
        <div class="container">
            <h2 class="section-title"><?php echo htmlspecialchars($config['testimonials_title']); ?></h2>
            <div class="testimonials-grid">
                <?php foreach ($config['testimonials'] as $testimonial): ?>
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            <p><?php echo htmlspecialchars($testimonial['quote']); ?></p>
                        </div>
                        <div class="testimonial-author">
                            <h4><?php echo htmlspecialchars($testimonial['name']); ?></h4>
                            <p><?php echo htmlspecialchars($testimonial['since']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta">
        <div class="container">
            <div class="cta-content">
                <h2><?php echo htmlspecialchars($config['cta_title']); ?></h2>
                <p><?php echo htmlspecialchars($config['cta_description']); ?></p>
                <a href="contacto.html" class="btn btn-light"><?php echo htmlspecialchars($config['cta_button']); ?></a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3><i class="fas fa-tooth"></i> <?php echo htmlspecialchars($config['footer_title']); ?></h3>
                    <p><?php echo htmlspecialchars($config['footer_description']); ?></p>
                </div>
                <div class="footer-section">
                    <h4>Enlaces rápidos</h4>
                    <ul>
                        <?php foreach ($config['footer_links'] as $link): ?>
                            <li><a href="#"><?php echo htmlspecialchars($link); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contacto</h4>
                    <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($config['footer_address']); ?></p>
                    <p><i class="fas fa-phone"></i> <?php echo htmlspecialchars($config['footer_phone']); ?></p>
                    <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($config['footer_email']); ?></p>
                </div>
                <div class="footer-section">
                    <h4>Horario</h4>
                    <p><?php echo nl2br(htmlspecialchars($config['footer_hours'])); ?></p>
                </div>
            </div>
            <div class="footer-bottom">
                <p><?php echo htmlspecialchars($config['footer_copyright']); ?></p>
            </div>
        </div>
    </footer>

    <script src="public/js/main.js"></script>
</body>
</html>