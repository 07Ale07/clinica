<?php
require_once(__DIR__ . '/../modelo/citas_modelo.php');

$citas = obtenerCitas();
$pacientes = obtenerPacientes();
$empleados = obtenerEmpleados();
$sillones = obtenerSillones();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DentalSmile - Sistema de Citas</title>
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

        /* Botones de acción */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin: 2rem 0;
        }

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
            text-decoration: none;
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

        .btn-danger {
            background: var(--coral);
        }

        .btn-danger:hover {
            background: #ff5252;
        }

        .btn-info {
            background: var(--gradient-accent);
            color: white;
        }

        .btn-info:hover {
            background: var(--accent-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 212, 170, 0.3);
        }

        /* Tablas */
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

        /* Badges de estado */
        .badge {
            padding: 0.4rem 0.8rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-pendiente {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge-confirmada {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-completada {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .badge-no_asistio {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Modal */
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

        /* Formularios */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--gray-800);
        }

        .form-control {
            width: 100%;
            padding: 1rem;
            border: 2px solid var(--gray-200);
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(0, 212, 170, 0.2);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }

        hr {
            border: none;
            height: 2px;
            background: var(--gray-200);
            margin: 3rem 0;
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
            
            .action-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Barra superior -->
    <div class="top-banner">
        <p><i class="fas fa-calendar-check"></i> Sistema de Gestión de Citas - DentalSmile</p>
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
            <h1><i class="fas fa-calendar-alt"></i> Gestión de Citas</h1>
        </div>
    </header>

    <div class="container">
        <!-- Sección de Citas -->
        <section class="section">
            <h2 class="section-title">Citas Programadas</h2>
            
            <div class="action-buttons">
                <button class="btn" onclick="openModal('citaModal')">
                    <i class="fas fa-plus"></i> Nueva Cita
                </button>

                <!-- Botón para descargar PDF de todas las citas -->
                <a href="../controlador/pdf_citas.php" target="_blank" class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i> Exportar Todas las Citas a PDF
                </a>
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Paciente</th>
                            <th>Empleado</th>
                            <th>Sillón</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Estado</th>
                            <th>Tipo</th>
                            <th>Observaciones</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($cita = $citas->fetch_assoc()): 
                            $badgeClass = "badge-" . $cita['estado'];
                        ?>
                            <tr>
                                <td data-label="Paciente"><?= $cita['nombre'] ?> <?= $cita['apellido'] ?></td>
                                <td data-label="Empleado"><?= $cita['id_empleado'] ?></td>
                                <td data-label="Sillón"><?= $cita['nombre_sillon'] ?></td>
                                <td data-label="Inicio"><?= $cita['fecha_inicio'] ?></td>
                                <td data-label="Fin"><?= $cita['fecha_fin'] ?></td>
                                <td data-label="Estado"><span class="badge <?= $badgeClass ?>"><?= $cita['estado'] ?></span></td>
                                <td data-label="Tipo"><?= $cita['tipo'] ?></td>
                                <td data-label="Observaciones"><?= $cita['observaciones'] ?></td>
                                <td data-label="Acciones">
                                    <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                                        <!-- Botón PDF individual -->
                                        <a href='../controlador/generar_pdf_cita.php?id_cita=<?= $cita['id_cita'] ?>' 
                                        class='btn btn-info' 
                                        target='_blank'
                                        style="padding: 0.5rem 1rem; font-size: 0.9rem; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                                        <i class="fas fa-download"></i> PDF
                                        </a>
                                        
                                        <!-- Botón Cancelar -->
                                        <form method="POST" action="../controlador/citas.php" style="display:inline">
                                            <input type="hidden" name="id_cita" value="<?= $cita['id_cita'] ?>">
                                            <input type="hidden" name="accion" value="desactivar">
                                            <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                                                <i class="fas fa-times"></i> Cancelar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <!-- Modal para Nueva Cita -->
    <div id="citaModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('citaModal')">&times;</span>
            <h2 class="section-title">Programar Nueva Cita</h2>
            
            <form method="POST" action="../controlador/citas.php">
                <input type="hidden" name="accion" value="crear">
                
                <div class="form-group">
                    <label for="id_paciente">Paciente:</label>
                    <select id="id_paciente" name="id_paciente" class="form-control" required>
                        <?php 
                        mysqli_data_seek($pacientes, 0);
                        while ($p = $pacientes->fetch_assoc()): ?>
                            <option value="<?= $p['id_paciente'] ?>"><?= $p['nombre'] ?> <?= $p['apellido'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="id_empleado">Empleado:</label>
                    <select id="id_empleado" name="id_empleado" class="form-control" required>
                        <?php 
                        mysqli_data_seek($empleados, 0);
                        while ($e = $empleados->fetch_assoc()): ?>
                            <option value="<?= $e['id_empleado'] ?>"><?= $e['nombre'] ?> <?= $e['apellido'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="id_sillon">Sillón:</label>
                    <select id="id_sillon" name="id_sillon" class="form-control" required>
                        <?php 
                        mysqli_data_seek($sillones, 0);
                        while ($s = $sillones->fetch_assoc()): ?>
                            <option value="<?= $s['id_sillon'] ?>"><?= $s['nombre'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="fecha_inicio">Fecha y Hora de Inicio:</label>
                    <input type="datetime-local" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="fecha_fin">Fecha y Hora de Fin:</label>
                    <input type="datetime-local" id="fecha_fin" name="fecha_fin" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="estado">Estado:</label>
                    <select id="estado" name="estado" class="form-control" required>
                        <option value="pendiente">Pendiente</option>
                        <option value="confirmada">Confirmada</option>
                        <option value="completada">Completada</option>
                        <option value="no_asistio">No asistió</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="tipo">Tipo de Cita:</label>
                    <select id="tipo" name="tipo" class="form-control" required>
                        <option value="consulta">Consulta</option>
                        <option value="tratamiento">Tratamiento</option>
                        <option value="control">Control</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="observaciones">Observaciones:</label>
                    <textarea id="observaciones" name="observaciones" class="form-control" rows="3"></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('citaModal')">Cancelar</button>
                    <button type="submit" class="btn"><i class="fas fa-save"></i> Guardar Cita</button>
                </div>
            </form>
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
    </script>
</body>
</html>