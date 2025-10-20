<?php
require_once '../conexion.php';

// Consulta para obtener todos los mensajes, ordenados por fecha descendente
$sql = "SELECT id, nombre, email, telefono, asunto, mensaje, fecha_envio FROM mensajes_contacto ORDER BY fecha_envio DESC";
$result = $enlace->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Mensajes - DentalSmile</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;500;600;700&display=swap" rel="stylesheet">
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

        /* Header */
        .header {
            background: var(--gradient);
            color: white;
            padding: 2rem 0;
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
            font-size: 2.5rem;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Section Styling */
        .section {
            margin: 3rem 0;
        }

        .section-title {
            text-align: center;
            font-size: 2.2rem;
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

        /* Tabla de mensajes */
        .table-container {
            overflow-x: auto;
            margin: 2rem 0;
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1.2rem 1rem;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }

        th {
            background: var(--gradient);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
            position: sticky;
            top: 0;
        }

        tr:hover {
            background-color: var(--light-blue);
        }

        .mensaje-col {
            max-width: 300px;
            word-wrap: break-word;
        }

        .message-preview {
            max-height: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        .message-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            background: var(--gradient);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            background: var(--gradient-accent);
        }

        .btn-view {
            background: var(--primary-color);
        }

        .btn-delete {
            background: var(--coral);
        }

        /* Modal para ver mensaje completo */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 2000;
            overflow-y: auto;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background: var(--white);
            margin: 5% auto;
            padding: 2.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-hover);
            width: 90%;
            max-width: 700px;
            position: relative;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .close-modal {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            font-size: 1.8rem;
            color: var(--gray-600);
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close-modal:hover {
            color: var(--coral);
        }

        .message-detail {
            background: var(--gray-100);
            padding: 1.5rem;
            border-radius: 10px;
            margin: 1rem 0;
        }

        .message-detail p {
            margin-bottom: 0.5rem;
        }

        .message-detail strong {
            color: var(--primary-color);
        }

        /* Filtros y búsqueda */
        .filters {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .search-box {
            display: flex;
            align-items: center;
            background: var(--white);
            border-radius: 50px;
            padding: 0.5rem 1rem;
            box-shadow: var(--shadow);
        }

        .search-box input {
            border: none;
            outline: none;
            padding: 0.5rem;
            width: 250px;
            background: transparent;
        }

        .filter-select {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            border: 2px solid var(--gray-200);
            background: var(--white);
            cursor: pointer;
        }

        /* Footer */
        .footer {
            background: var(--gray-800);
            color: white;
            text-align: center;
            padding: 3rem 0 1.5rem;
            margin-top: 4rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .footer h3 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }

        .footer p {
            font-size: 1rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        .social-links {
            margin: 1.5rem 0;
        }

        .social-links a {
            color: white;
            font-size: 1.2rem;
            margin: 0 0.8rem;
            transition: color 0.3s ease;
        }

        .social-links a:hover {
            color: var(--accent-color);
        }

        .footer-bottom {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0.7;
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
            
            .modal-content {
                margin: 10% auto;
                width: 95%;
                padding: 1.5rem;
            }

            .filters {
                flex-direction: column;
                align-items: stretch;
            }

            .search-box {
                width: 100%;
            }

            .search-box input {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .header h1 { font-size: 2rem; }
            .section-title { font-size: 1.8rem; }
            
            table, thead, tbody, th, td, tr {
                display: block;
            }
            
            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            
            tr {
                border: 1px solid var(--gray-200);
                border-radius: var(--border-radius);
                margin-bottom: 1rem;
                padding: 1rem;
            }
            
            td {
                border: none;
                border-bottom: 1px solid var(--gray-200);
                position: relative;
                padding-left: 50%;
            }
            
            td:before {
                position: absolute;
                top: 1rem;
                left: 1rem;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                font-weight: bold;
                content: attr(data-label);
            }

            .message-actions {
                justify-content: center;
                margin-top: 1rem;
            }
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--gray-600);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--gray-300);
        }
    </style>
</head>
<body>
    <!-- Barra superior -->
    <div class="top-banner">
        <p><i class="fas fa-envelope"></i> Sistema de Gestión de Mensajes - DentalSmile</p>
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
                <li><a href="../inicio_sesion.php"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</a></li>
            </ul>
            <button class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <h1><i class="fas fa-envelope-open-text"></i> Mensajes de Contacto</h1>
            <p>Gestiona todos los mensajes recibidos desde el formulario de contacto</p>
        </div>
    </header>

    <div class="container">
        <!-- Sección de Mensajes -->
        <section class="section">
            <h2 class="section-title">Mensajes Recibidos</h2>
            
            <!-- Filtros y búsqueda -->
            <div class="filters">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Buscar en mensajes...">
                </div>
                
                <select class="filter-select" id="filterSelect">
                    <option value="all">Todos los mensajes</option>
                    <option value="today">Hoy</option>
                    <option value="week">Esta semana</option>
                    <option value="month">Este mes</option>
                </select>
            </div>
            
            <div class="table-container">
                <?php if ($result->num_rows > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Asunto</th>
                                <th>Mensaje</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td data-label="Nombre"><?= htmlspecialchars($row['nombre']) ?></td>
                                    <td data-label="Email"><?= htmlspecialchars($row['email']) ?></td>
                                    <td data-label="Teléfono"><?= htmlspecialchars($row['telefono'] ?? 'N/A') ?></td>
                                    <td data-label="Asunto"><?= htmlspecialchars($row['asunto']) ?></td>
                                    <td data-label="Mensaje" class="mensaje-col">
                                        <div class="message-preview">
                                            <?= nl2br(htmlspecialchars($row['mensaje'])) ?>
                                        </div>
                                    </td>
                                    <td data-label="Fecha"><?= htmlspecialchars($row['fecha_envio']) ?></td>
                                    <td data-label="Acciones">
                                        <div class="message-actions">
                                            <button class="btn btn-view" onclick="viewMessage(<?= $row['id'] ?>, '<?= htmlspecialchars($row['nombre']) ?>', '<?= htmlspecialchars($row['email']) ?>', '<?= htmlspecialchars($row['telefono'] ?? 'N/A') ?>', '<?= htmlspecialchars($row['asunto']) ?>', `<?= nl2br(htmlspecialchars($row['mensaje'])) ?>`, '<?= htmlspecialchars($row['fecha_envio']) ?>')">
                                                <i class="fas fa-eye"></i> Ver
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h3>No hay mensajes recibidos</h3>
                        <p>Los mensajes enviados desde el formulario de contacto aparecerán aquí.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <!-- Modal para ver mensaje completo -->
    <div id="messageModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('messageModal')">&times;</span>
            <h2 class="section-title">Detalles del Mensaje</h2>
            
            <div class="message-detail">
                <p><strong>Nombre:</strong> <span id="modalNombre"></span></p>
                <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                <p><strong>Teléfono:</strong> <span id="modalTelefono"></span></p>
                <p><strong>Asunto:</strong> <span id="modalAsunto"></span></p>
                <p><strong>Fecha:</strong> <span id="modalFecha"></span></p>
                <p><strong>Mensaje:</strong></p>
                <div id="modalMensaje" style="padding: 1rem; background: white; border-radius: 8px; margin-top: 0.5rem;"></div>
            </div>
            
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal('messageModal')">Cerrar</button>
                <a href="#" id="modalReplyLink" class="btn"><i class="fas fa-reply"></i> Responder</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <h3><i class="fas fa-tooth"></i> DentalSmile</h3>
            <p>Tu sonrisa es nuestra pasión</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 DentalSmile. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        // Funciones para modales
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Cerrar modal al hacer clic fuera del contenido
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }

        // Menú móvil
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const navLinks = document.querySelector('.nav-links');
        
        mobileMenuBtn.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });

        // Función para ver mensaje completo
        function viewMessage(id, nombre, email, telefono, asunto, mensaje, fecha) {
            document.getElementById('modalNombre').textContent = nombre;
            document.getElementById('modalEmail').textContent = email;
            document.getElementById('modalTelefono').textContent = telefono;
            document.getElementById('modalAsunto').textContent = asunto;
            document.getElementById('modalMensaje').innerHTML = mensaje;
            document.getElementById('modalFecha').textContent = fecha;
            
            // Configurar enlace de respuesta
            document.getElementById('modalReplyLink').href = `mailto:${email}?subject=Re: ${asunto}`;
            
            openModal('messageModal');
        }

        // Búsqueda y filtrado
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchText) ? '' : 'none';
            });
        });

        document.getElementById('filterSelect').addEventListener('change', function() {
            // Aquí se implementaría la lógica de filtrado por fecha
            // Por ahora es solo una demostración visual
            console.log('Filtro seleccionado:', this.value);
        });
    </script>
</body>
</html>
<?php
$enlace->close();
?>