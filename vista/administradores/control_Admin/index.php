<?php
session_start();
// Verificar si es administrador
if (!isset($_SESSION['id_admin'])) {
    header('Location: ../login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DentalSmile - Panel de Administración</title>
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

        /* Header */
        .header {
            background: var(--gradient);
            color: white;
            padding: 2rem 0;
            position: relative;
            overflow: hidden;
            text-align: center;
            margin-bottom: 2rem;
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

        /* Navigation Cards */
        .nav-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 2rem;
        }

        .nav-card {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
            height: 100%;
            text-decoration: none;
            color: inherit;
        }

        .nav-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .card-header {
            padding: 20px;
            background: var(--gradient);
            color: white;
            display: flex;
            align-items: center;
        }

        .card-header i {
            font-size: 1.8rem;
            margin-right: 15px;
        }

        .card-header h3 {
            font-size: 1.4rem;
            font-weight: 600;
        }

        .card-content {
            padding: 20px;
            flex-grow: 1;
        }

        .card-content p {
            color: var(--gray-600);
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .card-stats {
            display: flex;
            justify-content: space-between;
            background-color: var(--gray-100);
            padding: 15px 20px;
            border-top: 1px solid var(--gray-200);
            font-size: 0.9rem;
            color: var(--gray-600);
        }

        /* Botones de acción */
        .action-buttons {
            display: flex;
            justify-content: flex-end;
            margin: 2rem 0;
        }

        .btn {
            background: var(--gradient);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            font-weight: bold;
            font-size: 1rem;
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
            .nav-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .header h1 { font-size: 2rem; }
            
            .nav-grid {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Barra superior -->
    <div class="top-banner">
        <p><i class="fas fa-user-shield"></i> Panel de Administración - DentalSmile</p>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <h1><i class="fas fa-cogs"></i> Panel de Control Administrativo</h1>
        </div>
    </header>

    <div class="container">
        <div class="action-buttons">
            <a href="../../inicio_sesion.php" class="btn btn-secondary">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </div>
        
        <div class="nav-grid">
            <a href="../abml_inventario" class="nav-card">
                <div class="card-header">
                    <i class="fas fa-box"></i>
                    <h3>Inventario</h3>
                </div>
                <div class="card-content">
                    <p>Gestiona productos, controla el stock y realiza seguimiento de existencias.</p>
                </div>
                <div class="card-stats">
                    <span>Gestión completa</span>
                    <span><i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
            
            <a href="../abml_empleados/vista/empleados_vista.php" class="nav-card">
                <div class="card-header">
                    <i class="fas fa-users"></i>
                    <h3>Empleados</h3>
                </div>
                <div class="card-content">
                    <p>Administra el personal, roles, horarios y permisos de los empleados.</p>
                </div>
                <div class="card-stats">
                    <span>Gestión de personal</span>
                    <span><i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
            
            <a href="../abml_empleados/vista/citas_vista.php" class="nav-card">
                <div class="card-header">
                    <i class="fas fa-calendar-check"></i>
                    <h3>Citas</h3>
                </div>
                <div class="card-content">
                    <p>Gestiona las citas programadas, calendario y asignación de recursos.</p>
                </div>
                <div class="card-stats">
                    <span>Gestión de agenda</span>
                    <span><i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
            
            <a href="../../landing/modelo/modelo_edit_controlador.php" class="nav-card">
                <div class="card-header">
                    <i class="fas fa-globe"></i>
                    <h3>Página Web</h3>
                </div>
                <div class="card-content">
                    <p>Modifica el contenido, diseño y elementos de tu página principal.</p>
                </div>
                <div class="card-stats">
                    <span>Editar contenido</span>
                    <span><i class="fas fa-arrow-right"></i></span>
                </div>
            </a>

            <a href="vista/ver_mensajes.php" class="nav-card">
                <div class="card-header">
                    <i class="fas fa-envelope"></i>
                    <h3>Mensajería</h3>
                </div>
                <div class="card-content">
                    <p>Revisa y responde los mensajes de los visitantes de tu sitio web.</p>
                </div>
                <div class="card-stats">
                    <span>Comunicación</span>
                    <span><i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
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
</body>
</html>