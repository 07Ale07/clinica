<?php
require_once(__DIR__ . '/../modelo/inventario_modelo.php');

$materiales = obtenerMateriales();
$categorias = obtenerCategorias();
$proveedores = obtenerProveedores();
$lotes = obtenerLotes();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DentalSmile - Sistema de Inventario</title>
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
        <p><i class="fas fa-boxes"></i> Sistema de Gestión de Inventario - DentalSmile</p>
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
            <h1><i class="fas fa-warehouse"></i> Gestión de Inventario</h1>
        </div>
    </header>

    <div class="container">
        <!-- Sección de Materiales -->
        <section class="section">
            <h2 class="section-title">Materiales Activos</h2>
            
            <div class="action-buttons">
                <button class="btn" onclick="openModal('materialModal')">
                    <i class="fas fa-plus"></i> Agregar Material
                </button>
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Unidad</th>
                            <th>Stock Mínimo</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($mat = $materiales->fetch_assoc()): ?>
                            <tr>
                                <td data-label="Nombre"><?= $mat['nombre'] ?></td>
                                <td data-label="Categoría"><?= $mat['categoria'] ?></td>
                                <td data-label="Unidad"><?= $mat['unidad_medida'] ?></td>
                                <td data-label="Stock Mínimo"><?= $mat['stock_minimo'] ?></td>
                                <td data-label="Descripción"><?= $mat['descripcion'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <hr>

        <!-- Sección de Lotes -->
        <section class="section">
            <h2 class="section-title">Lotes de materiales</h2>
            
            <div class="action-buttons">
                <button class="btn" onclick="openModal('loteModal')">
                    <i class="fas fa-plus"></i> Agregar Lote
                </button>
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Material</th>
                            <th>Proveedor</th>
                            <th>Lote</th>
                            <th>Compra</th>
                            <th>Vencimiento</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Ubicación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($l = $lotes->fetch_assoc()): ?>
                            <tr>
                                <td data-label="Material"><?= $l['material'] ?></td>
                                <td data-label="Proveedor"><?= $l['proveedor'] ?></td>
                                <td data-label="Lote"><?= $l['numero_lote'] ?></td>
                                <td data-label="Compra"><?= $l['fecha_compra'] ?></td>
                                <td data-label="Vencimiento"><?= $l['fecha_vencimiento'] ?></td>
                                <td data-label="Cantidad"><?= $l['cantidad_actual'] ?></td>
                                <td data-label="Precio">$<?= $l['precio_compra'] ?></td>
                                <td data-label="Ubicación"><?= $l['almacenado_en'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <!-- Modal para Material -->
    <div id="materialModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('materialModal')">&times;</span>
            <h2 class="section-title">Agregar Nuevo Material</h2>
            
            <form method="POST" action="../controlador/inventario_controlador.php">
                <input type="hidden" name="accion" value="crear_material">
                
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="id_categoria">Categoría:</label>
                    <select id="id_categoria" name="id_categoria" class="form-control" required>
                        <?php 
                        mysqli_data_seek($categorias, 0);
                        while ($cat = $categorias->fetch_assoc()): ?>
                            <option value="<?= $cat['id_categoria'] ?>"><?= $cat['categoria'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="unidad_medida">Unidad de Medida:</label>
                    <input type="text" id="unidad_medida" name="unidad_medida" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="stock_minimo">Stock Mínimo:</label>
                    <input type="number" id="stock_minimo" name="stock_minimo" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" class="form-control" rows="3"></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('materialModal')">Cancelar</button>
                    <button type="submit" class="btn"><i class="fas fa-save"></i> Guardar Material</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para Lote -->
    <div id="loteModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('loteModal')">&times;</span>
            <h2 class="section-title">Agregar Nuevo Lote</h2>
            
            <form method="POST" action="../controlador/inventario_controlador.php">
                <input type="hidden" name="accion" value="crear_lote">
                
                <div class="form-group">
                    <label for="id_material">Material:</label>
                    <select id="id_material" name="id_material" class="form-control" required>
                        <?php
                        mysqli_data_seek($materiales, 0);
                        while ($m = $materiales->fetch_assoc()): ?>
                            <option value="<?= $m['id_material'] ?>"><?= $m['nombre'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="id_proveedor">Proveedor:</label>
                    <select id="id_proveedor" name="id_proveedor" class="form-control" required>
                        <?php 
                        mysqli_data_seek($proveedores, 0);
                        while ($p = $proveedores->fetch_assoc()): ?>
                            <option value="<?= $p['id_proveedor'] ?>"><?= $p['nombre'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="numero_lote">Número de Lote:</label>
                    <input type="text" id="numero_lote" name="numero_lote" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="fecha_compra">Fecha de Compra:</label>
                    <input type="date" id="fecha_compra" name="fecha_compra" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="fecha_vencimiento">Fecha de Vencimiento:</label>
                    <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="cantidad_inicial">Cantidad Inicial:</label>
                    <input type="number" id="cantidad_inicial" name="cantidad_inicial" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="precio_compra">Precio de Compra:</label>
                    <input type="number" step="0.01" id="precio_compra" name="precio_compra" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="almacenado_en">Ubicación/Almacén:</label>
                    <input type="text" id="almacenado_en" name="almacenado_en" class="form-control">
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('loteModal')">Cancelar</button>
                    <button type="submit" class="btn"><i class="fas fa-save"></i> Guardar Lote</button>
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