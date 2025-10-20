<?php
    require_once __DIR__ . '/../modelo/empleados_modelo.php';
    $empleado = new Empleado();
    $empleados = $empleado->obtenerEmpleadosConPersonas();
    $cargos = $empleado->obtenerCargos();

    $empleadoEditar = null;
    if (isset($_GET['editar'])) {
        $empleadoEditar = $empleado->obtenerEmpleadoPorId($_GET['editar']);
    }
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DentalSmile - Sistema de Empleados</title>
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

            .btn-danger {
                background: var(--coral);
            }

            .btn-danger:hover {
                background: #ff5252;
            }

            .btn-warning {
                background: var(--gold);
                color: #333;
            }

            .btn-warning:hover {
                background: #ffc107;
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

            .btn-success {
                background: #28a745;
                color: white;
            }

            .btn-success:hover {
                background: #218838;
            }

            .btn-sm {
                padding: 0.4rem 0.8rem;
                font-size: 0.85rem;
            }

            /* Buscador */
            .search-container {
                margin: 1.5rem 0;
                display: flex;
                justify-content: center;
            }

            .search-box {
                position: relative;
                width: 100%;
                max-width: 500px;
            }

            .search-input {
                width: 100%;
                padding: 0.8rem 1rem 0.8rem 2.5rem;
                border: 2px solid var(--gray-200);
                border-radius: 50px;
                font-size: 1rem;
                transition: all 0.3s ease;
            }

            .search-input:focus {
                outline: none;
                border-color: var(--accent-color);
                box-shadow: 0 0 0 3px rgba(0, 212, 170, 0.2);
            }

            .search-icon {
                position: absolute;
                left: 1rem;
                top: 50%;
                transform: translateY(-50%);
                color: var(--gray-600);
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

            .table-danger {
                background-color: rgba(255, 107, 107, 0.1);
            }

            /* Badges de estado */
            .badge {
                padding: 0.4rem 0.8rem;
                border-radius: 50px;
                font-size: 0.8rem;
                font-weight: 600;
            }

            .badge-permanente {
                background-color: #d4edda;
                color: #155724;
            }

            .badge-temporal {
                background-color: #fff3cd;
                color: #856404;
            }

            .badge-honorarios {
                background-color: #d1ecf1;
                color: #0c5460;
            }

            .badge-pasantia {
                background-color: #d6d8d9;
                color: #383d41;
            }

            .badge-activo {
                background-color: #d4edda;
                color: #155724;
            }

            .badge-inactivo {
                background-color: #f8d7da;
                color: #721c24;
            }

            /* Imagen de empleado */
            .employee-photo {
                width: 60px;
                height: 60px;
                object-fit: cover;
                border-radius: 50%;
                border: 2px solid var(--accent-color);
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

            .form-row {
                display: flex;
                gap: 1rem;
            }

            .form-col {
                flex: 1;
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

                .form-row {
                    flex-direction: column;
                    gap: 0;
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

                .btn-group {
                    display: flex;
                    flex-direction: column;
                    gap: 0.3rem;
                }

                .btn-group .btn {
                    width: 100%;
                }
            }
        </style>
    </head>
    <body>
        <!-- Barra superior -->
        <div class="top-banner">
            <p><i class="fas fa-users"></i> Sistema de Gestión de Empleados - DentalSmile</p>
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
                <h1><i class="fas fa-user-tie"></i> Gestión de Empleados</h1>
            </div>
        </header>

        <div class="container">
            <!-- Sección de Empleados -->
            <section class="section">
                <h2 class="section-title">Empleados (Odontólogos incluidos)</h2>
                
                <div class="action-buttons">
                    <button class="btn" onclick="openModal('empleadoModal')">
                        <i class="fas fa-plus"></i> Nuevo Empleado
                    </button>

                    <a href="../controlador/generar_pdf_empleado.php" target="_blank" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> Exportar a PDF
                    </a>
                </div>

                <!-- Buscador -->
                <div class="search-container">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="searchInput" class="search-input" placeholder="Buscar empleados...">
                    </div>
                </div>
                
                <div class="table-container">
                    <table id="employeesTable">
                        <thead>
                            <tr>
                                <th>Legajo</th>
                                <th>Nombre</th>
                                <th>DNI</th>
                                <th>Contrato</th>
                                <th>Interno</th>
                                <th>Cargo</th>
                                <th>Foto</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            mysqli_data_seek($empleados, 0);
                            while ($row = $empleados->fetch_assoc()): 
                                $badgeClass = "badge-" . $row['tipo_contrato'];
                                $estadoClass = $row['activo'] ? "badge-activo" : "badge-inactivo";
                                $estadoTexto = $row['activo'] ? "Activo" : "Inactivo";
                            ?>
                                <tr class="<?= $row['activo'] ? '' : 'table-danger' ?>">
                                    <td data-label="Legajo"><?= $row['numero_legajo'] ?></td>
                                    <td data-label="Nombre"><?= $row['nombre'] . " " . $row['apellido'] ?></td>
                                    <td data-label="DNI"><?= $row['DNI'] ?></td>
                                    <td data-label="Contrato"><span class="badge <?= $badgeClass ?>"><?= $row['tipo_contrato'] ?></span></td>
                                    <td data-label="Interno"><?= $row['telefono_interno'] ?></td>
                                    <td data-label="Cargo"><?= $row['cargo'] ?></td>
                                    <td data-label="Foto">
                                        <?php if ($row['foto']): ?>
                                            <img src="../Uploads/<?= $row['foto'] ?>" class="employee-photo">
                                        <?php else: ?>
                                            <i class="fas fa-user-circle" style="font-size: 2rem; color: var(--gray-600);"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="Estado"><span class="badge <?= $estadoClass ?>"><?= $estadoTexto ?></span></td>
                                    <td data-label="Acciones">
                                        <div class="btn-group">
                                            <?php if ($row['activo']): ?>
                                                <a href="../controlador/empleados.php?accion=desactivar&id=<?= $row['id_empleado'] ?>" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-ban"></i> Desactivar
                                                </a>
                                            <?php else: ?>
                                                <a href="../controlador/empleados.php?accion=activar&id=<?= $row['id_empleado'] ?>" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i> Activar
                                                </a>
                                            <?php endif; ?>
                                            <button class="btn btn-primary btn-sm" onclick="openEditModal(<?= $row['id_empleado'] ?>)">
                                                <i class="fas fa-edit"></i> Editar
                                            </button>
                                            <!-- Botón PDF para empleado individual -->
                                            <a href='../controlador/pdf_empleado.php?id_empleado=<?= $row['id_empleado'] ?>' 
                                               class='btn btn-info btn-sm' 
                                               target='_blank'
                                               title="Descargar PDF del empleado">
                                               <i class="fas fa-download"></i> PDF
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <!-- Modal para Nuevo Empleado -->
        <div id="empleadoModal" class="modal">
            <div class="modal-content">
                <span class="close-modal" onclick="closeModal('empleadoModal')">&times;</span>
                <h2 class="section-title">Registrar Nuevo Empleado</h2>
                
                <form method="POST" enctype="multipart/form-data" action="../controlador/empleados.php">
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="legajo">Legajo:</label>
                                <input type="text" id="legajo" name="legajo" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label for="dni">DNI:</label>
                                <input type="number" id="dni" name="dni" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label for="apellido">Apellido:</label>
                                <input type="text" id="apellido" name="apellido" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="contrato">Tipo de Contrato:</label>
                                <select id="contrato" name="contrato" class="form-control" required>
                                    <option value="permanente">Permanente</option>
                                    <option value="temporal">Temporal</option>
                                    <option value="honorarios">Honorarios</option>
                                    <option value="pasantia">Pasantía</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label for="interno">Teléfono Interno:</label>
                                <input type="text" id="interno" name="interno" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="cargo">Cargo:</label>
                                <select id="cargo" name="cargo" class="form-control" required>
                                    <option value="">Seleccione un cargo</option>
                                    <?php 
                                    mysqli_data_seek($cargos, 0);
                                    while ($cargo = $cargos->fetch_assoc()): ?>
                                        <option value="<?= $cargo['id_cargo'] ?>"><?= $cargo['cargo'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label for="foto">Foto:</label>
                                <input type="file" id="foto" name="foto" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeModal('empleadoModal')">Cancelar</button>
                        <button type="submit" name="agregar" class="btn"><i class="fas fa-save"></i> Guardar Empleado</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal para Editar Empleado -->
        <div id="editEmpleadoModal" class="modal">
            <div class="modal-content">
                <span class="close-modal" onclick="closeModal('editEmpleadoModal')">&times;</span>
                <h2 class="section-title">Editar Empleado</h2>
                
                <form method="POST" enctype="multipart/form-data" action="../controlador/empleados.php">
                    <input type="hidden" id="edit_id_empleado" name="id_empleado">
                    
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="edit_legajo">Legajo:</label>
                                <input type="text" id="edit_legajo" name="legajo" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label for="edit_dni">DNI:</label>
                                <input type="number" id="edit_dni" name="dni" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="edit_nombre">Nombre:</label>
                                <input type="text" id="edit_nombre" name="nombre" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label for="edit_apellido">Apellido:</label>
                                <input type="text" id="edit_apellido" name="apellido" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="edit_contrato">Tipo de Contrato:</label>
                                <select id="edit_contrato" name="contrato" class="form-control" required>
                                    <option value="permanente">Permanente</option>
                                    <option value="temporal">Temporal</option>
                                    <option value="honorarios">Honorarios</option>
                                    <option value="pasantia">Pasantía</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label for="edit_interno">Teléfono Interno:</label>
                                <input type="text" id="edit_interno" name="interno" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="edit_cargo">Cargo:</label>
                                <select id="edit_cargo" name="cargo" class="form-control" required>
                                    <option value="">Seleccione un cargo</option>
                                    <?php 
                                    mysqli_data_seek($cargos, 0);
                                    while ($cargo = $cargos->fetch_assoc()): ?>
                                        <option value="<?= $cargo['id_cargo'] ?>"><?= $cargo['cargo'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label for="edit_foto">Foto:</label>
                                <input type="file" id="edit_foto" name="foto" class="form-control">
                                <div id="current-photo" class="mt-2"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeModal('editEmpleadoModal')">Cancelar</button>
                        <button type="submit" name="editar" class="btn"><i class="fas fa-save"></i> Actualizar Empleado</button>
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

            // Buscador
            document.getElementById('searchInput').addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                const table = document.getElementById('employeesTable');
                const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
                
                for (let i = 0; i < rows.length; i++) {
                    const cells = rows[i].getElementsByTagName('td');
                    let found = false;
                    
                    for (let j = 0; j < cells.length; j++) {
                        const cellText = cells[j].textContent || cells[j].innerText;
                        if (cellText.toLowerCase().indexOf(searchTerm) > -1) {
                            found = true;
                            break;
                        }
                    }
                    
                    rows[i].style.display = found ? '' : 'none';
                }
            });

            // Función para abrir modal de edición
            function openEditModal(empleadoId) {
                // Aquí deberías hacer una petición AJAX para obtener los datos del empleado
                // Por ahora, redirigimos a la página con el parámetro de edición
                window.location.href = 'empleados_vista.php?editar=' + empleadoId;
            }

            // Si hay un empleado para editar, abrir el modal automáticamente
            <?php if ($empleadoEditar): ?>
            window.onload = function() {
                // Llenar el formulario de edición con los datos del empleado
                document.getElementById('edit_id_empleado').value = '<?= $empleadoEditar['id_empleado'] ?>';
                document.getElementById('edit_legajo').value = '<?= $empleadoEditar['numero_legajo'] ?>';
                document.getElementById('edit_nombre').value = '<?= $empleadoEditar['nombre'] ?>';
                document.getElementById('edit_apellido').value = '<?= $empleadoEditar['apellido'] ?>';
                document.getElementById('edit_dni').value = '<?= $empleadoEditar['DNI'] ?>';
                document.getElementById('edit_contrato').value = '<?= $empleadoEditar['tipo_contrato'] ?>';
                document.getElementById('edit_interno').value = '<?= $empleadoEditar['telefono_interno'] ?>';
                document.getElementById('edit_cargo').value = '<?= $empleadoEditar['id_cargo'] ?>';
                
                // Mostrar la foto actual si existe
                <?php if ($empleadoEditar['foto']): ?>
                    document.getElementById('current-photo').innerHTML = 
                        '<p>Foto actual:</p><img src="../Uploads/<?= $empleadoEditar['foto'] ?>" width="80" class="mt-2">';
                <?php endif; ?>
                
                openModal('editEmpleadoModal');
            };
            <?php endif; ?>
        </script>
    </body>
    </html>