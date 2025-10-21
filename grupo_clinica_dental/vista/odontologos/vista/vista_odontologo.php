<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo de Odontólogos - DentalSmile</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
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

        /* Main Container */
        .main-container {
            display: flex;
            max-width: 1200px;
            margin: 2rem auto;
            gap: 2rem;
            padding: 0 2rem;
        }

        .main-content {
            flex: 3;
        }

        .sidebar-content {
            flex: 1;
        }

        /* Tarjetas */
        .odontologo-card {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .odontologo-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .odontologo-card h2 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .odontologo-card h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--accent-color);
            border-radius: 2px;
        }

        /* Listas */
        .list-group {
            list-style: none;
            padding: 0;
        }

        .list-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.2rem 1rem;
            border-bottom: 1px solid var(--gray-200);
            transition: background-color 0.3s ease;
        }

        .list-item:hover {
            background-color: var(--light-blue);
        }

        .patient-info {
            flex: 2;
        }

        .patient-info-right {
            flex: 1;
            text-align: right;
        }

        .patient-id {
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        /* Formularios de búsqueda */
        .search-form {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .search-form input,
        .search-form select {
            flex: 1;
            padding: 0.8rem 1rem;
            border: 2px solid var(--gray-200);
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .search-form input:focus,
        .search-form select:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(0, 212, 170, 0.2);
        }

        .search-form button {
            background: var(--gradient);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .search-form button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            background: var(--gradient-accent);
        }

        /* Lista vacía */
        .empty-list {
            text-align: center;
            padding: 2rem;
            color: var(--gray-600);
        }

        /* Botones */
        .btn {
            background: var(--gradient);
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 50px;
            font-weight: bold;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            background: var(--gradient-accent);
        }

        .btn-historial {
            background: var(--secondary-color);
        }

        .btn-odontograma {
            background: var(--accent-color);
            color: #333;
        }

        .btn-odontograma:hover {
            background: #00b4d8;
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        /* Tablas */
        .table-responsive {
            overflow-x: auto;
            margin: 1.5rem 0;
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
        }

        .historial-table {
            width: 100%;
            border-collapse: collapse;
        }

        .historial-table th,
        .historial-table td {
            padding: 1.2rem 1rem;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }

        .historial-table th {
            background: var(--gradient);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
            position: sticky;
            top: 0;
        }

        .historial-table tr:hover {
            background-color: var(--light-blue);
        }

        /* Badges */
        .diagnosis-badge {
            background-color: #e9ecef;
            padding: 0.4rem 0.8rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--gray-800);
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
            max-width: 800px;
            max-height: 80vh;
            overflow-y: auto;
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

        .odontograma-container {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid var(--gray-200);
            border-radius: 10px;
            background-color: var(--gray-100);
        }

        /* Detalles del paciente */
        .patient-details p {
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .patient-details p:last-child {
            border-bottom: none;
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
            
            .main-container {
                flex-direction: column;
            }
            
            .modal-content {
                margin: 10% auto;
                width: 95%;
                padding: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .header h1 { font-size: 2rem; }
            
            .search-form {
                flex-direction: column;
            }
            
            .list-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .patient-info-right {
                text-align: left;
                width: 100%;
            }
            
            .action-buttons {
                width: 100%;
                justify-content: flex-start;
            }
            
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
        }
    </style>
</head>
<body>
    <!-- Barra superior -->
    <div class="top-banner">
        <p><i class="fas fa-user-md"></i> Módulo de Odontólogos - DentalSmile</p>
    </div>

    <!-- Menú de navegación -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <i class="fas fa-tooth"></i> DentalSmile
            </div>
            <ul class="nav-links active">
                <li><a href="index.php"><i class="fas fa-home"></i> Inicio</a></li>
                <li><a href="?action=ver_historial_todos"><i class="fas fa-history"></i> Historial de Pacientes</a></li>
                <li><a href="?action=ver_horarios"><i class="fas fa-clock"></i> Mis Horarios</a></li>
                <li><a href="?action=ver_citas"><i class="fas fa-calendar"></i> Mis Citas</a></li>
            </ul>
            <button class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <h1><i class="fas fa-user-md"></i> Panel del Odontólogo</h1>
            <p>Listado de turnos, búsqueda de pacientes y acceso a historiales.</p>
        </div>
    </header>

    <div class="main-container">
        <div class="main-content">
            <!-- Sección de Turnos del Día -->
            <div class="odontologo-card">
                <h2>Turnos para Hoy (<?php echo date('d/m/Y'); ?>)</h2>
                <?php if (empty($turnosHoy)): ?>
                    <div class="empty-list">
                        <p>No tienes citas programadas para hoy.</p>
                    </div>
                <?php else: ?>
                    <ul class="list-group">
                        <?php foreach ($turnosHoy as $turno): ?>
                            <li class="list-item">
                                <span class="patient-info">
                                    <?php echo htmlspecialchars($turno['nombre'] . ' ' . $turno['apellido']); ?>
                                    <span class="patient-id">(ID: <?php echo htmlspecialchars($turno['id_paciente']); ?>)</span>
                                </span>
                                <span class="patient-info-right">
                                    <i class="fas fa-clock"></i> <?php echo htmlspecialchars(date('H:i', strtotime($turno['hora_turno']))); ?>
                                    <button class="btn btn-odontograma" onclick="verOdontograma(<?php echo htmlspecialchars($turno['id_paciente']); ?>, '<?php echo htmlspecialchars($turno['nombre'] . ' ' . $turno['apellido']); ?>')">
                                        <i class="fas fa-tooth"></i> Odontograma
                                    </button>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            
            <!-- Sección de Búsqueda de Pacientes -->
            <div class="odontologo-card">
                <h2>Buscador de Pacientes</h2>
                <form class="search-form" action="index.php" method="GET">
                    <input type="hidden" name="action" value="buscar_paciente">
                    <input type="text" name="query" placeholder="Buscar por nombre o apellido..." value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
                    <button type="submit"><i class="fas fa-search"></i> Buscar</button>
                </form>

                <?php if (!empty($pacientes)): ?>
                    <h3>Resultados de la búsqueda:</h3>
                    <ul class="list-group">
                        <?php foreach ($pacientes as $paciente): ?>
                            <li class="list-item">
                                <span class="patient-info">
                                    <?php echo htmlspecialchars($paciente['nombre'] . ' ' . $paciente['apellido']); ?>
                                    <span class="patient-id">(ID: <?php echo htmlspecialchars($paciente['id_paciente']); ?>)</span>
                                </span>
                                <div class="action-buttons">
                                    <a href="?action=ver_historial&id_paciente=<?php echo htmlspecialchars($paciente['id_paciente']); ?>&query=<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>" class="btn btn-historial">
                                        <i class="fas fa-history"></i> Historial
                                    </a>
                                    <button class="btn btn-odontograma" onclick="verOdontograma(<?php echo htmlspecialchars($paciente['id_paciente']); ?>, '<?php echo htmlspecialchars($paciente['nombre'] . ' ' . $paciente['apellido']); ?>')">
                                        <i class="fas fa-tooth"></i> Odontograma
                                    </button>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Sección de Horarios -->
            <?php if (isset($_GET['action']) && $_GET['action'] === 'ver_horarios'): ?>
            <div class="odontologo-card">
                <h2><i class="fas fa-clock"></i> Mis Horarios</h2>
                <form class="search-form" action="index.php" method="GET">
                    <input type="hidden" name="action" value="ver_horarios">
                    <input type="date" name="fecha" value="<?php echo $_GET['fecha'] ?? date('Y-m-d'); ?>">
                    <select name="dia">
                        <option value="">Todos los días</option>
                        <option value="Lunes" <?php echo ($_GET['dia'] ?? '') === 'Lunes' ? 'selected' : ''; ?>>Lunes</option>
                        <option value="Martes" <?php echo ($_GET['dia'] ?? '') === 'Martes' ? 'selected' : ''; ?>>Martes</option>
                        <option value="Miércoles" <?php echo ($_GET['dia'] ?? '') === 'Miércoles' ? 'selected' : ''; ?>>Miércoles</option>
                        <option value="Jueves" <?php echo ($_GET['dia'] ?? '') === 'Jueves' ? 'selected' : ''; ?>>Jueves</option>
                        <option value="Viernes" <?php echo ($_GET['dia'] ?? '') === 'Viernes' ? 'selected' : ''; ?>>Viernes</option>
                        <option value="Sábado" <?php echo ($_GET['dia'] ?? '') === 'Sábado' ? 'selected' : ''; ?>>Sábado</option>
                        <option value="Domingo" <?php echo ($_GET['dia'] ?? '') === 'Domingo' ? 'selected' : ''; ?>>Domingo</option>
                    </select>
                    <button type="submit"><i class="fas fa-filter"></i> Filtrar</button>
                </form>

                <?php if (empty($horarios)): ?>
                    <div class="empty-list">
                        <p>No tienes horarios configurados para los criterios seleccionados.</p>
                    </div>
                <?php else: ?>
                    <ul class="list-group">
                        <?php foreach ($horarios as $horario): ?>
                            <li class="list-item">
                                <span class="patient-info">
                                    <strong><?php echo htmlspecialchars($horario['dia_semana']); ?></strong>
                                    <?php if (!empty($horario['fecha_desde']) || !empty($horario['fecha_hasta'])): ?>
                                        <br><small>
                                            <?php if (!empty($horario['fecha_desde'])): ?>
                                                Desde: <?php echo htmlspecialchars(date('d/m/Y', strtotime($horario['fecha_desde']))); ?>
                                            <?php endif; ?>
                                            <?php if (!empty($horario['fecha_hasta'])): ?>
                                                - Hasta: <?php echo htmlspecialchars(date('d/m/Y', strtotime($horario['fecha_hasta']))); ?>
                                            <?php endif; ?>
                                        </small>
                                    <?php endif; ?>
                                </span>
                                <span class="patient-info-right">
                                    <i class="fas fa-clock"></i> 
                                    <?php echo htmlspecialchars(date('H:i', strtotime($horario['hora_inicio']))); ?> 
                                    - 
                                    <?php echo htmlspecialchars(date('H:i', strtotime($horario['hora_fin']))); ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- Sección de Citas -->
            <?php if (isset($_GET['action']) && $_GET['action'] === 'ver_citas'): ?>
            <div class="odontologo-card">
                <h2><i class="fas fa-calendar"></i> Mis Citas</h2>
                <form class="search-form" action="index.php" method="GET">
                    <input type="hidden" name="action" value="ver_citas">
                    <input type="date" name="fecha" value="<?php echo $_GET['fecha'] ?? date('Y-m-d'); ?>">
                    <button type="submit"><i class="fas fa-filter"></i> Filtrar por Fecha</button>
                </form>

                <?php if (empty($citas)): ?>
                    <div class="empty-list">
                        <p>No tienes citas programadas para la fecha seleccionada.</p>
                    </div>
                <?php else: ?>
                    <ul class="list-group">
                        <?php foreach ($citas as $cita): ?>
                            <li class="list-item">
                                <span class="patient-info">
                                    <strong><?php echo htmlspecialchars($cita['nombre_paciente']); ?></strong>
                                    <br>
                                    <small>Tipo: <?php echo htmlspecialchars($cita['tipo']); ?> | 
                                    Estado: <?php echo htmlspecialchars($cita['estado']); ?></small>
                                </span>
                                <span class="patient-info-right">
                                    <i class="fas fa-clock"></i> 
                                    <?php echo htmlspecialchars(date('H:i', strtotime($cita['fecha_inicio']))); ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- Sección de Historial Completo de Pacientes Atendidos -->
            <?php if (isset($_GET['action']) && $_GET['action'] === 'ver_historial_todos'): ?>
            <div class="odontologo-card">
                <h2><i class="fas fa-history"></i> Historial Completo de Pacientes Atendidos</h2>
                
                <?php if (empty($historialPacientesAtendidos)): ?>
                    <div class="empty-list">
                        <p>No has atendido a ningún paciente aún.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="historial-table">
                            <thead>
                                <tr>
                                    <th>Paciente</th>
                                    <th>Última Visita</th>
                                    <th>Diagnóstico</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($historialPacientesAtendidos as $paciente): ?>
                                    <tr>
                                        <td data-label="Paciente">
                                            <strong><?php echo htmlspecialchars($paciente['name']); ?></strong>
                                            <br><small>ID: <?php echo htmlspecialchars($paciente['id']); ?></small>
                                        </td>
                                        <td data-label="Última Visita">
                                            <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($paciente['lastVisit']))); ?>
                                        </td>
                                        <td data-label="Diagnóstico">
                                            <span class="diagnosis-badge"><?php echo htmlspecialchars($paciente['diagnosis'] ?? 'Sin diagnóstico'); ?></span>
                                        </td>
                                        <td data-label="Acciones">
                                            <div class="action-buttons">
                                                <a href="?action=ver_historial&id_paciente=<?php echo htmlspecialchars($paciente['id']); ?>" 
                                                   class="btn btn-historial" title="Ver Historial Detallado">
                                                    <i class="fas fa-file-medical"></i> Historial
                                                </a>
                                                <button class="btn btn-odontograma" onclick="verOdontograma(<?php echo htmlspecialchars($paciente['id']); ?>, '<?php echo htmlspecialchars($paciente['name']); ?>')">
                                                    <i class="fas fa-tooth"></i> Odontograma
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>

        <div class="sidebar-content">
            <div class="odontologo-card">
                <?php if ($paciente_buscado): ?>
                    <h2>Historial de <?php echo htmlspecialchars($paciente_buscado['nombre'] . ' ' . $paciente_buscado['apellido']); ?></h2>
                    <?php if (!empty($historial)): ?>
                        <div class="patient-details">
                            <?php foreach ($historial as $registro): ?>
                                <p><strong>Fecha:</strong> <?php echo htmlspecialchars(date('d/m/Y', strtotime($registro['fecha']))); ?></p>
                                <p><strong>Procedimiento:</strong> <?php echo htmlspecialchars($registro['procedimiento']); ?></p>
                                <?php if (!empty($registro['observaciones'])): ?>
                                    <p><strong>Observaciones:</strong> <?php echo htmlspecialchars($registro['observaciones']); ?></p>
                                <?php endif; ?>
                                <hr>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-list">
                            <p>Este paciente no tiene un historial clínico registrado.</p>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <h2>Historial Clínico</h2>
                    <div class="empty-list">
                        <p>Busca un paciente y selecciona "Historial" para ver sus detalles aquí.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal para Odontograma -->
    <div id="odontogramaModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2 id="modalTitle">Odontograma del Paciente</h2>
            <div id="odontogramaContainer" class="odontograma-container">
                <!-- Aquí se cargará el odontograma via AJAX -->
                <p>Cargando odontograma...</p>
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
        // Funciones para el modal
        const modal = document.getElementById('odontogramaModal');
        const closeBtn = document.querySelector('.close-modal');
        const modalTitle = document.getElementById('modalTitle');
        const odontogramaContainer = document.getElementById('odontogramaContainer');

        // Función para ver odontograma
        function verOdontograma(idPaciente, nombrePaciente) {
            modalTitle.textContent = `Odontograma de ${nombrePaciente} (ID: ${idPaciente})`;
            
            // Mostrar loading
            odontogramaContainer.innerHTML = '<p><i class="fas fa-spinner fa-spin"></i> Cargando odontograma...</p>';
            
            // Abrir modal
            modal.style.display = 'block';
            
            // Cargar odontograma via AJAX
            cargarOdontograma(idPaciente);
        }

        // Función para cargar odontograma via AJAX
        function cargarOdontograma(idPaciente) {
            // Aquí puedes hacer una llamada AJAX para cargar el odontograma
            // Por ahora, simulamos la carga con un iframe o contenido estático
            odontogramaContainer.innerHTML = `
                <div style="text-align: center;">
                    <h3>Odontograma del Paciente ID: ${idPaciente}</h3>
                    <p>Esta funcionalidad cargaría el odontograma específico del paciente.</p>
                    <div style="background: #f0f0f0; padding: 20px; border-radius: 5px; margin: 20px 0;">
                        <p><strong>Simulación de Odontograma</strong></p>
                        <p>Aquí iría la representación gráfica de los dientes del paciente</p>
                        <p>Estado de cada pieza dental, tratamientos realizados, etc.</p>
                    </div>
                    <button onclick="cerrarModal()" class="btn" style="background: var(--coral);">
                        <i class="fas fa-times"></i> Cerrar
                    </button>
                </div>
            `;
            
            // Para una implementación real, descomenta esto:
            /*
            fetch(`../odontograma/cargar_odontograma.php?id_paciente=${idPaciente}`)
                .then(response => response.text())
                .then(data => {
                    odontogramaContainer.innerHTML = data;
                })
                .catch(error => {
                    odontogramaContainer.innerHTML = '<p>Error al cargar el odontograma</p>';
                });
            */
        }

        // Cerrar modal al hacer clic en la X
        closeBtn.onclick = function() {
            modal.style.display = 'none';
        }

        // Cerrar modal al hacer clic fuera del contenido
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }

        // Función para cerrar modal
        function cerrarModal() {
            modal.style.display = 'none';
        }

        // Cerrar con tecla ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                cerrarModal();
            }
        });

        // Menú móvil
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const navLinks = document.querySelector('.nav-links');
        
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                navLinks.classList.toggle('active');
            });
        }
    </script>
</body>
</html>