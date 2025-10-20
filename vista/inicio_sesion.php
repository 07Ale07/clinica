<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clínica Dental - Portal Profesional</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1a4b8c;
            --primary-dark: #0f3261;
            --secondary-color: #2c5aa0;
            --accent-color: #00d4aa;
            --accent-dark: #00b896;
            --light-blue: #e8f4f8;
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-300: #dee2e6;
            --gray-600: #6c757d;
            --gray-800: #343a40;
            --gold: #ffd166;
            --coral: #ff6b6b;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --shadow-hover: 0 15px 40px rgba(0, 0, 0, 0.12);
            --gradient: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            --gradient-accent: linear-gradient(135deg, var(--accent-color) 0%, #00b4d8 100%);
            --border-radius: 16px;
            --transition: all 0.3s ease;
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* Layout mejorado con imagen lateral */
        .login-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        .image-section {
            flex: 1;
            background: linear-gradient(rgba(26, 75, 140, 0.7), rgba(26, 75, 140, 0.7)), url('https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80') center/cover no-repeat;
            display: none;
            color: white;
            padding: 2rem;
            position: relative;
            flex-direction: column;
            justify-content: center;
        }

        @media (min-width: 992px) {
            .image-section {
                display: flex;
            }
        }

        .image-content {
            max-width: 500px;
            margin: 0 auto;
            text-align: center;
        }

        .image-content h2 {
            font-size: 2.2rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .image-content p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .features-list {
            list-style: none;
            text-align: left;
            margin-top: 2rem;
        }

        .features-list li {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .features-list i {
            margin-right: 10px;
            color: var(--accent-color);
            font-size: 1.2rem;
        }

        /* Contenedor de login mejorado */
        .login-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            background: var(--white);
            box-shadow: -5px 0 25px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        @media (min-width: 992px) {
            .login-container {
                flex: 0 0 50%;
                max-width: 600px;
            }
        }

        .logo {
            width: 90px;
            height: 90px;
            margin-bottom: 1.5rem;
            background: var(--gradient);
            border-radius: 50%;
            padding: 15px;
            box-shadow: var(--shadow);
        }

        .login-container h2 {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .subtitle {
            color: var(--gray-600);
            margin-bottom: 2.5rem;
            text-align: center;
            max-width: 350px;
        }

        /* Formulario mejorado */
        form {
            width: 100%;
            max-width: 400px;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.8rem;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-600);
            font-size: 1.1rem;
        }

        .input-group input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius);
            font-size: 1rem;
            transition: var(--transition);
            background: var(--gray-50);
        }

        .input-group input:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(0, 212, 170, 0.2);
            background: var(--white);
        }

        input[type="submit"] {
            width: 100%;
            padding: 1rem;
            border: none;
            border-radius: var(--border-radius);
            background: var(--gradient);
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: var(--shadow);
        }

        input[type="submit"]:hover {
            background: var(--primary-dark);
            box-shadow: var(--shadow-hover);
            transform: translateY(-2px);
        }

        /* Mensaje de error mejorado */
        .error-msg {
            background: #ffebee;
            color: #c62828;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #c62828;
            width: 100%;
            max-width: 400px;
            display: flex;
            align-items: center;
        }

        .error-msg i {
            margin-right: 10px;
        }

        /* Footer mejorado */
        footer {
            text-align: center;
            padding: 1.5rem;
            color: var(--gray-600);
            background: var(--gray-50);
            margin-top: auto;
            font-size: 0.9rem;
        }

        /* Elementos adicionales */
        .divider {
            display: flex;
            align-items: center;
            margin: 2rem 0;
            color: var(--gray-600);
            width: 100%;
            max-width: 400px;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: var(--gray-300);
        }

        .divider span {
            padding: 0 1rem;
            font-size: 0.9rem;
        }

        .social-login {
            display: flex;
            gap: 1rem;
            width: 100%;
            max-width: 400px;
            margin-bottom: 2rem;
        }

        .social-btn {
            flex: 1;
            padding: 0.8rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius);
            background: var(--white);
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .social-btn:hover {
            background: var(--gray-50);
            transform: translateY(-2px);
        }

        .social-btn img {
            width: 20px;
            height: 20px;
        }

        .forgot-password {
            display: block;
            text-align: right;
            margin-top: 1rem;
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .forgot-password:hover {
            color: var(--accent-color);
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="image-section">
            <div class="image-content">
                <h2>Bienvenido a Clínica Dental</h2>
                <p>Su sonrisa es nuestra prioridad. Ofrecemos los mejores servicios odontológicos con tecnología de punta y profesionales calificados.</p>
                
                <ul class="features-list">
                    <li><i class="fas fa-check-circle"></i> Atención personalizada</li>
                    <li><i class="fas fa-check-circle"></i> Equipo de última generación</li>
                    <li><i class="fas fa-check-circle"></i> Profesionales certificados</li>
                    <li><i class="fas fa-check-circle"></i> Ambientes modernos y acogedores</li>
                </ul>
            </div>
        </div>
        
        <div class="login-container">
            <img src="image.png" alt="Clínica Dental Logo" class="logo">
            <h2>Clínica Dental</h2>
            <p class="subtitle">Sistema de gestión odontológica profesional</p>

            <div class="error-msg" style="display: none;">
                <i class="fas fa-exclamation-circle"></i> Mensaje de error de ejemplo
            </div>

            <form action="../controlador/controller.php" method="POST">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="usuario" placeholder="Usuario" required>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="contrasena" placeholder="Contraseña" required>
                </div>
                
                <a href="#" class="forgot-password">¿Olvidó su contraseña?</a>
                
                <input type="submit" value="Iniciar Sesión">
            </form>

            <div class="divider">
                <span>O acceder con</span>
            </div>

            <div class="social-login">
                <button class="social-btn">
                    <i class="fab fa-google" style="color: #DB4437;"></i>
                </button>
                <button class="social-btn">
                    <i class="fab fa-microsoft" style="color: #0078D7;"></i>
                </button>
                <button class="social-btn">
                    <i class="fab fa-apple" style="color: #000;"></i>
                </button>
            </div>
        </div>
    </div>

    <footer>
        © 2023 Clínica Dental. Todos los derechos reservados.
    </footer>
</body>
</html>