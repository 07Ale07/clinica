<?php
// landing/index.php
require_once 'conexion.php';

function getCurrentConfig($conexion) {
    $sql = "SELECT config_json FROM landing_configs WHERE status = 'aplicado' ORDER BY updated_at DESC LIMIT 1";
    $result = $conexion->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return json_decode($row['config_json'], true);
    }
    // Configuración por defecto basada en index.html original
    return [
        'header_title' => 'DentalSmile',
        'menu_items' => ['Inicio', 'Quiénes Somos', 'Servicios', 'Contacto', 'Ubicación'],
        'hero_title' => 'Tu sonrisa es nuestra prioridad',
        'hero_description' => 'Profesionales dedicados a cuidar de tu salud dental con los más altos estándares de calidad',
        'hero_button1' => 'Solicitar Cita',
        'hero_button2' => 'Nuestros Servicios',
        'services_title' => 'Nuestros Servicios',
        'services' => [
            ['image' => '', 'title' => 'Blanqueamiento Dental', 'description' => 'Recupera el blanco natural de tus dientes con nuestro tratamiento profesional.', 'icon' => 'fas fa-tooth'],
            ['image' => '', 'title' => 'Ortodoncia', 'description' => 'Corrige la alineación de tus dientes con nuestros tratamientos de ortodoncia.', 'icon' => 'fas fa-teeth'],
            ['image' => '', 'title' => 'Limpieza Dental', 'description' => 'Elimina el sarro y mantén tus dientes libres de bacterias con nuestra limpieza profesional.', 'icon' => 'fas fa-toothbrush'],
            ['image' => '', 'title' => 'Implantes Dentales', 'description' => 'Recupera la funcionalidad y estética de tu sonrisa con implantes de la más alta calidad.', 'icon' => 'fas fa-teeth-open']
        ],
        'about_title' => 'Expertos en salud dental',
        'about_description' => 'En DentalSmile llevamos más de 15 años cuidando de las sonrisas de nuestros pacientes. Contamos con tecnología de última generación y un equipo de profesionales altamente cualificados.',
        'about_button' => 'Conoce más sobre nosotros',
        'about_image' => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80',
        'testimonials_title' => 'Lo que dicen nuestros pacientes',
        'testimonials' => [
            ['quote' => '"El mejor tratamiento dental que he recibido. Profesionales y un trato excelente."', 'name' => 'María González', 'since' => 'Paciente desde 2018'],
            ['quote' => '"Me realizaron un blanqueamiento dental y los resultados fueron increíbles. ¡Totalmente recomendable!"', 'name' => 'Carlos Rodríguez', 'since' => 'Paciente desde 2020'],
            ['quote' => '"Llevo a mis hijos desde hace años y siempre contentos con el trato recibido. Grandes profesionales."', 'name' => 'Ana Martínez', 'since' => 'Paciente desde 2015']
        ],
        'cta_title' => '¿Necesitas una consulta?',
        'cta_description' => 'Solicita tu cita ahora y recibe una evaluación completa sin compromiso',
        'cta_button' => 'Contactar ahora',
        'footer_title' => 'DentalSmile',
        'footer_description' => 'Tu clínica dental de confianza donde cuidamos de tu sonrisa con los más altos estándares de calidad.',
        'footer_links' => ['Inicio', 'Quiénes Somos', 'Servicios', 'Contacto'],
        'footer_address' => 'Av. Principal #123, Ciudad',
        'footer_phone' => '(123) 456-7890',
        'footer_email' => 'info@dentalsmile.com',
        'footer_hours' => "Lunes - Viernes: 9:00 - 18:00\nSábado: 9:00 - 13:00\nDomingo: Cerrado",
        'footer_copyright' => '© 2023 DentalSmile - Todos los derechos reservados'
    ];
}

$config = getCurrentConfig($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($config['header_title']); ?> - Clínica Dental</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

    <section class="cta">
        <div class="container">
            <div class="cta-content">
                <h2><?php echo htmlspecialchars($config['cta_title']); ?></h2>
                <p><?php echo htmlspecialchars($config['cta_description']); ?></p>
                <a href="contacto.html" class="btn btn-light"><?php echo htmlspecialchars($config['cta_button']); ?></a>
            </div>
        </div>
    </section>

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