<?php
// landing/contacto.php
require_once '../conexion.php';

// Obtener configuración de somos.php para el encabezado y pie de página
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
    error_log("No applied configuration found in somos_configs, using default.");
    return [
        'header_title' => 'DentalSmile',
        'footer_links' => ['Inicio', 'Quiénes Somos', 'Servicios', 'Contacto'],
        'footer_title' => 'DentalSmile',
        'footer_description' => 'Tu clínica dental de confianza donde cuidamos de tu sonrisa con los más altos estándares de calidad.',
        'footer_address' => 'Av. Principal #123, Ciudad',
        'footer_phone' => '(123) 456-7890',
        'footer_email' => 'info@dentalsmile.com',
        'footer_hours' => "Lunes - Viernes: 9:00 - 18:00\nSábado: 9:00 - 13:00\nDomingo: Cerrado",
        'footer_copyright' => '© 2025 DentalSmile - Todos los derechos reservados'
    ];
}

// Obtener configuración actual de contacto
function getCurrentContactConfig($conexion) {
    $sql = "SELECT config_json FROM contact_configs WHERE status = 'aplicado' ORDER BY updated_at DESC LIMIT 1";
    $result = $conexion->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return json_decode($row['config_json'], true);
    }
    return [
        'contact_address' => 'Av. Principal #123, Col. Centro<br>Ciudad, CP 28000',
        'contact_phones' => '(123) 456-7890<br>(123) 456-7891',
        'contact_emails' => 'info@dentalsmile.com<br>citas@dentalsmile.com',
        'contact_hours' => "Lunes a Viernes: 9:00 - 18:00<br>Sábados: 9:00 - 13:00<br>Domingos: Cerrado",
        'social_facebook' => '#',
        'social_instagram' => '#',
        'social_twitter' => '#',
        'social_youtube' => '#'
    ];
}

// Función para formatear texto con saltos de línea
function formatContactText($text) {
    return nl2br(htmlspecialchars($text));
}

$config = getCurrentConfig($conexion);
$contactConfig = getCurrentContactConfig($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($config['header_title']); ?> - Contacto</title>
    <link rel="stylesheet" href="../public/css/styles_contacto.css?v=<?php echo time(); ?>">
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
                    <li><a href="somos.php">Quiénes Somos</a></li>
                    <li><a href="contacto.php" class="active">Contacto</a></li>
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
            <h2>Contacto</h2>
            <p>Estamos aquí para responder todas tus preguntas y agendar tu cita</p>
        </div>
    </section>

    <section class="contact loading">
        <div class="container">
            <div class="contact-container">
                <div class="contact-info">
                    <h3>Información de Contacto</h3>
                    
                    <div class="contact-detail">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Dirección</h4>
                            <p><?php echo formatContactText($contactConfig['contact_address']); ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-detail">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Teléfonos</h4>
                            <p><?php echo formatContactText($contactConfig['contact_phones']); ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-detail">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Email</h4>
                            <p><?php echo formatContactText($contactConfig['contact_emails']); ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-detail">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Horario de Atención</h4>
                            <p><?php echo formatContactText($contactConfig['contact_hours']); ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-detail">
                        <div class="contact-icon">
                            <i class="fas fa-share-alt"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Síguenos en redes</h4>
                            <div class="social-links">
                                <a href="<?php echo htmlspecialchars($contactConfig['social_facebook']); ?>"><i class="fab fa-facebook-f"></i></a>
                                <a href="<?php echo htmlspecialchars($contactConfig['social_instagram']); ?>"><i class="fab fa-instagram"></i></a>
                                <a href="<?php echo htmlspecialchars($contactConfig['social_twitter']); ?>"><i class="fab fa-twitter"></i></a>
                                <a href="<?php echo htmlspecialchars($contactConfig['social_youtube']); ?>"><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="contact-form">
                    <h3>Envíanos un mensaje</h3>
                    <form id="contactForm">
                        <div class="form-group">
                            <label for="name">Nombre completo</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Correo electrónico</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Teléfono</label>
                            <input type="tel" id="phone" name="phone">
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">Asunto</label>
                            <select id="subject" name="subject" required>
                                <option value="">Selecciona una opción</option>
                                <option value="cita">Solicitud de cita</option>
                                <option value="info">Solicitud de información</option>
                                <option value="presupuesto">Solicitud de presupuesto</option>
                                <option value="otros">Otros</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Mensaje</label>
                            <textarea id="message" name="message" required></textarea>
                        </div>
                        
                        <div class="form-submit">
                            <button type="submit" class="btn-primary">Enviar mensaje</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3762.888853724726!2d-99.1679491856182!3d19.4270207460819!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d1ff37585b5d1b%3A0x5f4a3ff3b0097b2d!2sPalacio%20de%20Bellas%20Artes!5e0!3m2!1ses!2smx!4v1621558356783!5m2!1ses!2smx" allowfullscreen="" loading="lazy"></iframe>
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
                    <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars(str_replace('<br>', ', ', $contactConfig['contact_address'])); ?></p>
                    <p><i class="fas fa-phone"></i> <?php echo htmlspecialchars(explode("\n", $contactConfig['contact_phones'])[0]); ?></p>
                    <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars(explode("\n", $contactConfig['contact_emails'])[0]); ?></p>
                </div>
                <div class="footer-section">
                    <h4>Horario</h4>
                    <?php
                    $horarios = explode("\n", $contactConfig['contact_hours']);
                    foreach ($horarios as $horario) {
                        if (trim($horario) !== '') {
                            echo "<p>" . htmlspecialchars(trim($horario)) . "</p>";
                        }
                    }
                    ?>
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
                observer.observe(section);
            });

            document.getElementById('contactForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                
                fetch('../controlador/subir_mensajes.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        this.reset(); // Limpia el formulario
                    }
                })
                .catch(error => {
                    alert('Error al enviar: ' + error);
                });
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