<?php
// landing/somos.php
require_once '../conexion.php';

// Check database connection
if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}

function getCurrentConfig($conexion) {
    $sql = "SELECT config_json FROM somos_configs WHERE status = 'aplicado' ORDER BY updated_at DESC LIMIT 1";
    $result = $conexion->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $config = json_decode($row['config_json'], true);
        if ($config === null) {
            die("JSON decode error: " . json_last_error_msg());
        }
        return $config;
    }
    // Log if no applied config is found
    error_log("No applied configuration found in somos_configs, using default.");
    return getDefaultConfig();
}

function getDefaultConfig() {
    return [
        'header_title' => 'DentalCare',
        'menu_items' => ['Inicio', 'Quiénes Somos', 'Contacto'],
        'about_title' => 'Quiénes Somos',
        'about_subtitle' => 'Conoce más sobre nuestra historia, valores y equipo profesional',
        'history_title' => 'Nuestra Historia',
        'history_description' => 'DentalSmile nació en 2008 con la visión de crear un centro dental donde la excelencia médica se combine con un trato humano y personalizado. Desde nuestros humildes comienzos con apenas dos consultorios, hemos crecido hasta convertirnos en una clínica de referencia en la ciudad. Nuestro fundador, el Dr. Javier Martínez, imaginó un espacio donde los pacientes se sintieran cómodos y seguros, rompiendo con el estereotipo de que ir al dentista debe ser una experiencia traumática.',
        'values_title' => 'Nuestros Valores',
        'values' => [
            ['icon' => 'fas fa-user-md', 'title' => 'Profesionalidad', 'description' => 'Contamos con dentistas altamente cualificados y en constante formación para ofrecer los tratamientos más avanzados.'],
            ['icon' => 'fas fa-heart', 'title' => 'Compromiso', 'description' => 'Nos comprometemos con cada paciente de manera individual, buscando siempre la mejor solución para sus necesidades.'],
            ['icon' => 'fas fa-shield-alt', 'title' => 'Seguridad', 'description' => 'Cumplimos con todos los protocolos de esterilización y seguridad para garantizar tratamientos seguros y confiables.'],
            ['icon' => 'fas fa-hands-helping', 'title' => 'Empatía', 'description' => 'Comprendemos las preocupaciones de nuestros pacientes y trabajamos para hacer de su visita una experiencia agradable.']
        ],
        'team_title' => 'Nuestro Equipo',
        'team' => [
            ['image' => '', 'name' => 'Dr. Javier Martínez', 'role' => 'Director y Especialista en Implantología', 'description' => 'Con más de 20 años de experiencia, el Dr. Martínez es pionero en técnicas de implantología avanzada.'],
            ['image' => '', 'name' => 'Dra. Laura Sánchez', 'role' => 'Ortodoncista', 'description' => 'Especializada en ortodoncia invisible y tratamientos de corrección dental para adultos y niños.'],
            ['image' => '', 'name' => 'Dr. Carlos Rodríguez', 'role' => 'Especialista en Estética Dental', 'description' => 'Apasionado por devolver la sonrisa a sus pacientes mediante carillas, blanqueamientos y reconstrucciones.'],
            ['image' => '', 'name' => 'Dra. Marta López', 'role' => 'Endodoncista', 'description' => 'Experta en tratamientos de conductos y soluciones para salvar piezas dentales en riesgo.']
        ],
        'footer_title' => 'DentalCare',
        'footer_description' => 'Tu clínica dental de confianza donde cuidamos de tu sonrisa con los más altos estándares de calidad.',
        'footer_links' => ['Inicio', 'Quiénes Somos', 'Servicios', 'Contacto'],
        'footer_address' => 'Av. Principal #123, Ciudad',
        'footer_phone' => '(123) 456-7890',
        'footer_email' => 'info@dentalsmile.com',
        'footer_hours' => "Lunes - Viernes: 9:00 - 18:00\nSábado: 9:00 - 13:00\nDomingo: Cerrado",
        'footer_copyright' => '© 2025 DentalSmile - Todos los derechos reservados'
    ];
}

$config = getCurrentConfig($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($config['header_title']); ?> - Quiénes Somos</title>
    <link rel="stylesheet" href="../public/css/styles_somos.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Barra superior -->
    <div class="top-banner">
        <p><i class="fas fa-crown"></i> ¡Somos la mejor clínica dental de la región! Reconocidos por nuestra excelencia en 2025</p>
    </div>

    <!-- Menú de navegación -->
    <header>
        <div class="container">
            <div class="logo">
                <h1><i class="fas fa-tooth"></i> <?php echo htmlspecialchars($config['header_title']); ?></h1>
            </div>
            <nav>
                <ul>
                    <li><a href="../../landing2">Inicio</a></li>
                    <li><a href="somos.php" class="active">Quiénes Somos</a></li>
                    <li><a href="contacto.php">Contacto</a></li>
                    <li><a href="../../inicio_sesion.php">Iniciar Sesión</a></li>
                </ul>
            </nav>
            <div class="nav-toggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </header>

    <section class="page-banner loading">
        <div class="container">
            <h2><?php echo htmlspecialchars($config['about_title']); ?></h2>
            <p><?php echo htmlspecialchars($config['about_subtitle']); ?></p>
        </div>
    </section>

    <section class="history loading">
        <div class="container">
            <h2><?php echo htmlspecialchars($config['history_title']); ?></h2>
            <p><?php echo htmlspecialchars($config['history_description']); ?></p>
        </div>
    </section>

    <section class="values loading">
        <div class="container">
            <h2><?php echo htmlspecialchars($config['values_title']); ?></h2>
            <div class="values-grid">
                <?php foreach ($config['values'] as $value): ?>
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="<?php echo htmlspecialchars($value['icon']); ?>"></i>
                        </div>
                        <h3><?php echo htmlspecialchars($value['title']); ?></h3>
                        <p><?php echo htmlspecialchars($value['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="team loading">
        <div class="container">
            <h2><?php echo htmlspecialchars($config['team_title']); ?></h2>
            <div class="team-grid">
                <?php foreach ($config['team'] as $member): ?>
                    <div class="team-card">
                        <?php if (!empty($member['image'])): ?>
                            <img src="<?php echo htmlspecialchars($member['image']); ?>" alt="<?php echo htmlspecialchars($member['name']); ?>">
                        <?php else: ?>
                            <img src="/clinica/web/vista/landing/public/images/placeholder.jpg" alt="Placeholder">
                        <?php endif; ?>
                        <h3><?php echo htmlspecialchars($member['name']); ?></h3>
                        <h4><?php echo htmlspecialchars($member['role']); ?></h4>
                        <p><?php echo htmlspecialchars($member['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <footer class="loading">
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
                            <li><a href="<?php echo htmlspecialchars(strtolower(str_replace(' ', '_', $link)) . '.php'); ?>"><?php echo htmlspecialchars($link); ?></a></li>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loadingElements = document.querySelectorAll('.loading');
            loadingElements.forEach((element, index) => {
                setTimeout(() => {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, index * 200);
            });

            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            document.querySelectorAll('section, .footer-content').forEach(section => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(20px)';
                section.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                observer.observe(section);
            });

            const mobileMenuBtn = document.querySelector('.nav-toggle');
            const navLinks = document.querySelector('nav ul');
            if (mobileMenuBtn && navLinks) {
                mobileMenuBtn.addEventListener('click', () => {
                    navLinks.classList.toggle('active');
                });
            }
        });
    </script>
</body>
</html>
<?php
if (isset($conexion)) {
    $conexion->close();
}
?>