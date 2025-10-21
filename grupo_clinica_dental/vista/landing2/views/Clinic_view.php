<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DentalCare - Clínica Dental Premium</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1a4b8c;
            --secondary-color: #2c5aa0;
            --accent-color: #00d4aa;
            --light-blue: #e8f4f8;
            --white: #ffffff;
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-600: #6c757d;
            --gray-800: #1a4b8c;
            --gold: #ffd166;
            --coral: #ff6b6b;
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

        /* Barra superior */
        .top-banner {
            background: var(--gradient);
            color: white;
            text-align: center;
            padding: 0.8rem;
            font-weight: bold;
            font-size: 1.1rem;
        }

        /* Menú de navegación */
        .navbar {
            background: var(--white);
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 0.8rem 0;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            font-weight: bold;
            font-size: 1.5rem;
            color: var(--primary-color);
        }

        .logo i {
            margin-right: 0.5rem;
            color: var(--accent-color);
        }

        .nav-links {
            display: flex;
            list-style: none;
        }

        .nav-links li {
            margin-left: 2rem;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--gray-800);
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            padding: 0.5rem 0;
        }

        .nav-links a:hover {
            color: var(--accent-color);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent-color);
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--primary-color);
            cursor: pointer;
        }

        /* Imagen destacada */
        .featured-image {
            width: 100%;
            height: 500px;
            position: relative;
            overflow: hidden;
        }

        .featured-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            padding: 2rem;
        }

        .image-overlay h2 {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .image-overlay p {
            font-size: 1.5rem;
            max-width: 700px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        /* Header */
        .header {
            background: var(--gradient);
            color: white;
            padding: 3rem 0;
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .header h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            animation: slideDown 1s ease-out;
        }

        .header p {
            font-size: 1.5rem;
            opacity: 0.9;
            max-width: 800px;
            margin: 0 auto;
            animation: slideUp 1s ease-out 0.3s both;
        }

        @keyframes slideDown {
            from { transform: translateY(-30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Section Styling */
        .section {
            margin: 5rem 0;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .section-title {
            text-align: center;
            font-size: 2.8rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 5px;
            background: var(--accent-color);
            border-radius: 2px;
        }

        .section-subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: var(--gray-600);
            max-width: 800px;
            margin: 0 auto 3rem;
            line-height: 1.6;
        }

        /* Info entre secciones - MODIFICADO PARA DISPOSICIÓN HORIZONTAL */
        .info-section {
            background: var(--white);
            padding: 3rem;
            border-radius: var(--border-radius);
            margin: 4rem 0;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 3rem;
            transition: all 0.3s ease;
        }

        .info-section:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .info-content {
            flex: 1;
        }

        .info-content h2 {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            position: relative;
        }

        .info-content h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 400px;
            height: 3px;
            background: var(--accent-color);
            border-radius: 2px;
        }

        .info-content p {
            font-size: 1.1rem;
            color: var(--gray-600);
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }

        .info-image {
            flex: 1;
            text-align: center;
        }

        .info-image img {
            width: 100%;
            max-width: 1000px;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .info-image img:hover {
            transform: scale(1.03);
        }

        /* Estilo alternado para las secciones */
        .info-section:nth-child(even) {
            flex-direction: row-reverse;
        }

        /* Carrusel de Procedimientos */
        .procedures-carousel-container {
            position: relative;
            margin: 3rem 0 5rem;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            height: 500px;
        }

        .procedures-carousel {
            display: flex;
            transition: transform 0.5s ease-in-out;
            height: 100%;
        }

        .procedure-slide {
            min-width: 100%;
            position: relative;
            display: flex;
            align-items: center;
            background: var(--white);
        }

        .procedure-image {
            width: 50%;
            height: 100%;
            object-fit: cover;
        }

        .procedure-content {
            width: 50%;
            padding: 3rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .procedure-content h3 {
            font-size: 2.2rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        .procedure-price {
            font-size: 2rem;
            color: var(--accent-color);
            font-weight: bold;
            margin: 1.5rem 0;
        }

        .procedure-description {
            color: var(--gray-600);
            margin-bottom: 2rem;
            line-height: 1.6;
            font-size: 1.1rem;
        }

        .procedure-btn {
            background: var(--gradient);
            color: white;
            border: none;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: bold;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
            align-self: center;
        }

        .procedure-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            background: var(--gradient-accent);
        }

        .carousel-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.9);
            color: var(--primary-color);
            border: none;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            z-index: 10;
        }

        .carousel-nav:hover {
            background: var(--white);
            transform: translateY(-50%) scale(1.1);
            color: var(--accent-color);
        }

        .carousel-nav.prev { left: 25px; }
        .carousel-nav.next { right: 25px; }

        .carousel-indicators {
            position: absolute;
            bottom: 25px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 12px;
        }

        .indicator {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .indicator.active {
            background: var(--accent-color);
            transform: scale(1.3);
            border-color: white;
        }

        /* Testimonios */
        .testimonial-section {
            background: var(--light-blue);
            padding: 5rem 0;
            margin: 5rem 0;
            border-radius: var(--border-radius);
        }

        .testimonial {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
        }

        .testimonial-text {
            font-size: 1.3rem;
            font-style: italic;
            color: var(--gray-800);
            margin-bottom: 2rem;
            position: relative;
            line-height: 1.8;
        }

        .testimonial-text::before,
        .testimonial-text::after {
            content: '"';
            font-size: 4rem;
            color: var(--accent-color);
            opacity: 0.3;
            position: absolute;
        }

        .testimonial-text::before {
            top: -20px;
            left: -15px;
        }

        .testimonial-text::after {
            bottom: -40px;
            right: -15px;
        }

        .testimonial-author {
            font-weight: bold;
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        /* Casos de Éxito */
        .before-after-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
            gap: 2.5rem;
            margin-top: 3rem;
        }

        .before-after-card {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 1.3rem;
            transition: all 0.3s ease;
        }

        .before-after-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover);
        }

        .procedure-title {
            font-size: 1.4rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        .before-after-images {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .before-after-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 12px;
            position: relative;
        }

        .img-label {
            position: absolute;
            top: 12px;
            left: 12px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .procedure-info {
            margin-bottom: 1.5rem;
        }

        .procedure-details {
            color: var(--gray-600);
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Equipo Profesional */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2.5rem;
            margin-top: 3rem;
        }

        .card {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
        }

        .employee-card {
            text-align: center;
            padding: 2.5rem 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .employee-avatar {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 1.5rem auto;
            border: 4px solid var(--accent-color);
            transition: all 0.3s ease;
        }

        .employee-card:hover .employee-avatar {
            transform: scale(1.1);
            box-shadow: 0 12px 30px rgba(0, 212, 170, 0.4);
        }

        .employee-name {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .employee-role {
            color: var(--accent-color);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .employee-desc {
            color: var(--gray-600);
            margin-top: 1rem;
            font-size: 0.95rem;
            line-height: 1.6;
            text-align: center;
        }

        /* Obras Sociales */
        .insurance-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .insurance-card {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 2.5rem 2rem;
            text-align: center;
            transition: all 0.3s ease;
            border-top: 5px solid var(--accent-color);
        }

        .insurance-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover);
        }

        .insurance-icon {
            font-size: 3rem;
            color: var(--accent-color);
            margin-bottom: 1.5rem;
        }

        .insurance-name {
            font-size: 1.4rem;
            color: var(--primary-color);
            margin-bottom: 1.2rem;
            font-weight: bold;
        }

        .insurance-details {
            color: var(--gray-600);
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Footer */
        .footer {
            background: var(--gray-800);
            color: white;
            text-align: center;
            padding: 4rem 0 2rem;
            margin-top: 6rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .footer h3 {
            font-size: 2.2rem;
            margin-bottom: 1.5rem;
        }

        .footer p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        .social-links {
            margin: 2.5rem 0;
        }

        .social-links a {
            color: white;
            font-size: 1.5rem;
            margin: 0 1rem;
            transition: color 0.3s ease;
        }

        .social-links a:hover {
            color: var(--accent-color);
        }

        .footer-bottom {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0.7;
        }

        /* Botón flotante de WhatsApp */
        .floating-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: var(--accent-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            box-shadow: 0 6px 20px rgba(0, 212, 170, 0.5);
            z-index: 1000;
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
        }

        .floating-btn:hover {
            transform: scale(1.1) rotate(10deg);
            box-shadow: 0 8px 25px rgba(0, 212, 170, 0.7);
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(0, 212, 170, 0.7); }
            70% { box-shadow: 0 0 0 15px rgba(0, 212, 170, 0); }
            100% { box-shadow: 0 0 0 0 rgba(0, 212, 170, 0); }
        }

        /* Responsive */
        @media (max-width: 992px) {
            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: var(--white);
                flex-direction: column;
                padding: 1rem 0;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            }

            .nav-links.active {
                display: flex;
            }

            .nav-links li {
                margin: 0.5rem 0;
                text-align: center;
            }

            .mobile-menu-btn {
                display: block;
            }

            .procedure-slide {
                flex-direction: column;
            }
            
            .procedure-image, .procedure-content {
                width: 100%;
            }
            
            .procedure-image {
                height: 300px;
            }
            
            .procedures-carousel-container {
                height: auto;
            }

            .featured-image {
                height: 400px;
            }

            .image-overlay h2 {
                font-size: 2.5rem;
            }

            .info-section {
                flex-direction: column;
                text-align: center;
            }
            
            .info-section:nth-child(even) {
                flex-direction: column;
            }
            
            .info-content h2::after {
                left: 50%;
                transform: translateX(-50%);
            }
        }

        @media (max-width: 768px) {
            .header h1 { font-size: 2.5rem; }
            .header p { font-size: 1.2rem; }
            .section-title { font-size: 2.2rem; }
            .section-subtitle { font-size: 1.1rem; }
            .cards-grid { grid-template-columns: 1fr; }
            .before-after-grid { grid-template-columns: 1fr; }
            .insurance-grid { grid-template-columns: 1fr; }
            .carousel-nav { width: 50px; height: 50px; font-size: 1.2rem; }
            .procedure-content h3 { font-size: 1.8rem; }
            .procedure-price { font-size: 1.7rem; }
            .testimonial-text { font-size: 1.1rem; }
            .before-after-img { height: 150px; }

            .featured-image {
                height: 350px;
            }

            .image-overlay h2 {
                font-size: 2rem;
            }

            .image-overlay p {
                font-size: 1.2rem;
            }
        }

        /* Loading Animation */
        .loading {
            opacity: 0;
            animation: fadeIn 0.8s ease-out forwards;
        }

        @keyframes fadeIn {
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <!-- Barra superior -->
    <div class="top-banner">
        <p><i class="fas fa-crown"></i> ¡Somos la mejor clínica dental de la región! Reconocidos por nuestra excelencia en 2025</p>
    </div>

    <!-- Menú de navegación -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <i class="fas fa-tooth"></i> DentalSmile
            </div>
            <ul class="nav-links">
                <li><a href="#"><i class="fas fa-home"></i> Inicio</a></li>
                <li><a href="../landing/vistas/somos.php"><i class="fas fa-info-circle"></i> Nosotros</a></li>
                <li><a href="../landing/vistas/contacto.php"><i class="fas fa-phone"></i> Contacto</a></li>
                <li><a href="../inicio_sesion.php"><i class="fas fa-phone"></i>Iniciar Sesion</a></li>
            </ul>
            <button class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Imagen destacada -->
    <div class="featured-image">
        <img src="uploads/sonrisaperfecta.png" alt="Sonrisa perfecta - DentalCare">
        <div class="image-overlay">
            <h2>Transformamos Sonrisas, Creamos Confianza</h2>
            <p>En DentalCare combinamos tecnología de vanguardia con el talento de nuestros especialistas para ofrecerte los mejores resultados.</p>
        </div>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <h1><i class="fas fa-tooth"></i> DentalSmile Premium</h1>
            <p>Sonrisas perfectas, cuidado excepcional</p>
        </div>
    </header>

    <div class="container">
        <!-- Carrusel de Procedimientos -->
        <section class="section loading">
            <h2 class="section-title"><i class="fas fa-medical"></i> Nuestros Procedimientos</h2>
            <p class="section-subtitle">Ofrecemos los tratamientos dentales más avanzados con los mejores especialistas del país</p>
            <div class="procedures-carousel-container">
                <div class="procedures-carousel" id="proceduresCarousel">
                    <?php foreach ($procedures as $procedure): ?>
                    <div class="procedure-slide">
                        <img src="uploads/<?php echo htmlspecialchars($procedure['img']); ?>" 
                             alt="<?php echo htmlspecialchars($procedure['descripcion']); ?>" 
                             class="procedure-image">
                        <div class="procedure-content">
                            <h3><?php echo htmlspecialchars($procedure['descripcion']); ?></h3>
                            <div class="procedure-price">$<?php echo htmlspecialchars($procedure['costo']); ?></div>
                            <p class="procedure-description">Tratamiento profesional con la más alta calidad y tecnología avanzada para obtener resultados óptimos y duraderos.</p>
                            <a href="../landing/vistas/contacto.php
                            " class="procedure-btn">Más Información</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-nav prev" onclick="changeSlide(-1)"><i class="fas fa-chevron-left"></i></button>
                <button class="carousel-nav next" onclick="changeSlide(1)"><i class="fas fa-chevron-right"></i></button>
                <div class="carousel-indicators">
                    <?php for ($i = 0; $i < count($procedures); $i++): ?>
                    <div class="indicator <?php echo $i === 0 ? 'active' : ''; ?>" onclick="goToSlide(<?php echo $i; ?>)"></div>
                    <?php endfor; ?>
                </div>
            </div>
        </section>

        <!-- Sección informativa 1 -->
        <div class="info-section loading">
            <div class="info-content">
                <h2>Tecnología de Vanguardia</h2>
                <p>En DentalCare Premium utilizamos la tecnología más avanzada en odontología para garantizar diagnósticos precisos y tratamientos mínimamente invasivos. Nuestro equipamiento de última generación incluye scanners intraorales 3D, tomografía computarizada de haz cónico y software de planificación digital de sonrisas.</p>
                <p>Esto nos permite ofrecerte resultados predecibles, tratamientos más cortos y una experiencia dental confortable y sin dolor.</p>
            </div>
            <div class="info-image">
                <img src="uploads/tec.png" alt="Tecnología dental de vanguardia - DentalCare">
            </div>
        </div>

        <!-- Sección de Testimonios -->
        <section class="testimonial-section loading">
            <div class="container">
                <h2 class="section-title">Opiniones de Nuestros Pacientes</h2>
                <p class="section-subtitle">La satisfacción de nuestros pacientes es nuestra mayor prioridad</p>
                <div class="testimonial">
                    <p class="testimonial-text">Llevo años confiando en DentalCare para el cuidado de my familia. Los resultados son siempre excepcionales y el trato es increíblemente profesional. Mi sonrisa nunca había lucido tan bien.</p>
                    <p class="testimonial-author">- María González, paciente desde 2018</p>
                </div>
            </div>
        </section>

        <!-- Sección informativa 2 -->
        <div class="info-section loading">
            <div class="info-content">
                <h2>Un Enfoque Personalizado</h2>
                <p>En DentalCare Premium entendemos que cada paciente es único. Por eso, diseñamos planes de tratamiento personalizados que se adaptan a tus necesidades específicas, objetivos estéticos y situación particular.</p>
                <p>Nuestro equipo de especialistas trabaja de forma coordinada para ofrecerte una atención integral, desde la primera consulta hasta el seguimiento posterior al tratamiento.</p>
            </div>
            <div class="info-image">
                <img src="uploads/image.png" alt="Atención personalizada - DentalCare">
            </div>
        </div>

        <!-- Casos de Éxito -->
        <section class="section loading">
            <h2 class="section-title"><i class="fas fa-star"></i> Casos de Éxito</h2>
            <p class="section-subtitle">Resultados reales que demuestran nuestra experiencia y compromiso con la excelencia</p>
            <div class="before-after-grid">
                <?php foreach ($performedProcedures as $pr): ?>
                <div class="before-after-card">
                    <div class="procedure-title"><?php echo htmlspecialchars($pr['procedimiento']); ?></div>
                    <div class="before-after-images">
                        <?php if($pr['img_antes']): ?>
                        <div style="position: relative;">
                            <img src="uploads/<?php echo htmlspecialchars($pr['img_antes']); ?>" 
                                 alt="Antes del tratamiento" class="before-after-img">
                            <div class="img-label">Antes</div>
                        </div>
                        <?php else: ?>
                        <div class="before-after-img" style="background: var(--gray-200); display: flex; align-items: center; justify-content: center; color: var(--gray-600);">
                            <i class="fas fa-image" style="font-size: 2rem;"></i>
                        </div>
                        <?php endif; ?>
                        
                        <?php if($pr['img_despues']): ?>
                        <div style="position: relative;">
                            <img src="uploads/<?php echo htmlspecialchars($pr['img_despues']); ?>" 
                                 alt="Después del tratamiento" class="before-after-img">
                            <div class="img-label">Después</div>
                        </div>
                        <?php else: ?>
                        <div class="before-after-img" style="background: var(--gray-200); display: flex; align-items: center; justify-content: center; color: var(--gray-600);">
                            <i class="fas fa-image" style="font-size: 2rem;"></i>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="procedure-info">
                        <div class="procedure-details">
                            <strong>Paciente:</strong> <?php echo htmlspecialchars($pr['paciente']); ?><br>
                            <strong>Fecha:</strong> <?php echo htmlspecialchars($pr['fecha']); ?><br>
                            <strong>Especialista:</strong> <?php echo htmlspecialchars($pr['empleado'] ?? 'No especificado'); ?>
                        </div>
                        <?php if(!empty($pr['observaciones'])): ?>
                        <p style="margin-top: 1rem; font-style: italic; color: var(--gray-600);">
                            "<?php echo htmlspecialchars($pr['observaciones']); ?>"
                        </p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Equipo Profesional -->
        <section class="section loading">
            <h2 class="section-title"><i class="fas fa-user-md"></i> Nuestro Equipo</h2>
            <p class="section-subtitle">Profesionales altamente capacitados y comprometidos con tu salud dental</p>
            <div class="cards-grid">
                <?php foreach ($employees as $employee): ?>
                <div class="card">
                    <div class="employee-card">
                        <img src="uploads/<?php echo htmlspecialchars($employee['foto']); ?>" 
                             alt="Dr. <?php echo htmlspecialchars($employee['nombre'] . ' ' . $employee['apellido']); ?>" 
                             class="employee-avatar">
                        <div class="employee-name">
                            Dr. <?php echo htmlspecialchars($employee['nombre'] . ' ' . $employee['apellido']); ?>
                        </div>
                        <div class="employee-role">Especialista Dental</div>
                        <div class="employee-desc">
                            Años de experiencia brindando sonrisas perfectas. Especializado en ortodoncia y estética dental.
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Sección informativa 3 -->
        <div class="info-section loading">
            <div class="info-content">
                <h2>Compromiso con la Excelencia</h2>
                <p>En DentalCare Premium no nos conformamos con menos que lo mejor. Nuestro compromiso con la excelencia se refleja en cada aspecto de nuestra práctica: desde la esterilización avanzada de instrumental hasta la formación continua de nuestro equipo.</p>
                <p>Somos pioneros en la implementación de técnicas innovadoras y seguimos los más altos estándares internacionales de calidad y seguridad.</p>
            </div>
            <div class="info-image">
                <img src="https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Compromiso con la excelencia - DentalCare">
            </div>
        </div>

        <!-- Obras Sociales -->
        <section class="section loading">
            <h2 class="section-title"><i class="fas fa-handshake"></i> Obras Sociales</h2>
            <p class="section-subtitle">Trabajamos con las principales obras sociales para brindarte la mejor cobertura</p>
            <div class="insurance-grid">
                <?php foreach ($socialWorks as $socialWork): ?>
                <div class="insurance-card">
                    <div class="insurance-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="insurance-name"><?php echo htmlspecialchars($socialWork['nombre']); ?></div>
                    <div class="insurance-details">
                        <p><i class="fas fa-phone"></i> <?php echo htmlspecialchars($socialWork['telefono']); ?></p>
                        <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($socialWork['direccion']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>

    <!-- Botón flotante de WhatsApp -->
    <a href="https://wa.me/3704376847?text=Hola,%20me%20interesa%20saber%20más%20sobre%20sus%20servicios" class="floating-btn" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <h3><i class="fas fa-tooth"></i> DentalCare Premium</h3>
            <p>Tu sonrisa es nuestra pasión</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 DentalCare Premium. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        // Carrusel de procedimientos
        let currentSlide = 0;
        const slides = document.querySelectorAll('.procedure-slide');
        const indicators = document.querySelectorAll('.indicator');
        const totalSlides = slides.length;

        function showSlide(index) {
            const carousel = document.getElementById('proceduresCarousel');
            carousel.style.transform = `translateX(-${index * 100}%)`;
            
            indicators.forEach((indicator, i) => {
                indicator.classList.toggle('active', i === index);
            });
            
            currentSlide = index;
        }

        function changeSlide(direction) {
            let newIndex = (currentSlide + direction + totalSlides) % totalSlides;
            showSlide(newIndex);
        }

        function goToSlide(index) {
            showSlide(index);
        }

        // Auto-play carousel
        setInterval(() => {
            changeSlide(1);
        }, 5000);

        // Loading animations
        document.addEventListener('DOMContentLoaded', function() {
            const loadingElements = document.querySelectorAll('.loading');
            loadingElements.forEach((element, index) => {
                setTimeout(() => {
                    element.style.opacity = '1';
                }, index * 200);
            });
        });

        // Efecto de aparición al hacer scroll
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = 1;
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.section').forEach(section => {
            section.style.opacity = 0;
            section.style.transform = 'translateY(20px)';
            section.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(section);
        });

        // Menú móvil
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const navLinks = document.querySelector('.nav-links');
        
        mobileMenuBtn.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
    </script>
</body>
</html>