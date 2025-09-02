<?php
// landing/modelo/modelo_edit_index.php
require_once '../conexion.php';
session_start();


// Función para obtener configuración actual
function getCurrentConfig($conexion) {
    $sql = "SELECT config_json FROM landing_configs WHERE status = 'aplicado' ORDER BY updated_at DESC LIMIT 1";
    $result = $conexion->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return json_decode($row['config_json'], true);
    }
    return getDefaultConfig();
}

// Configuración por defecto
function getDefaultConfig() {
    return [
        'header_title' => 'DentalSmile',
        'menu_items' => ['Inicio', 'Quiénes Somos', 'Servicios', 'Contacto', 'Ubicación'],
        'hero_title' => 'Tu sonrisa es nuestra prioridad',
        'hero_description' => 'Profesionales dedicados a cuidar de tu salud dental con los más altos estándares de calidad',
        'hero_button1' => 'Solicitar Cita',
        'hero_button2' => 'Nuestros Servicios',
        'services_title' => 'Nuestros Servicios',
        'services' => [
            ['image' => '', 'title' => 'Blanqueamiento Dental', 'description' => 'Recupera el blanco natural de tus dientes con nuestro tratamiento profesional.', 'icon' => 'fas fa-tooth'],
            ['image' => '', 'title' => 'Ortodoncia', 'description' => 'Corrige la alineación de tus dientes con nuestros tratamientos de ortodoncia.', 'icon' => 'fas fa-teeth'],
            ['image' => '', 'title' => 'Limpieza Dental', 'description' => 'Elimina el sarro y mantén tus dientes libres de bacterias con nuestra limpieza profesional.', 'icon' => 'fas fa-toothbrush'],
            ['image' => '', 'title' => 'Implantes Dentales', 'description' => 'Recupera la funcionalidad y estética de tu sonrisa con implantes de la más alta calidad.', 'icon' => 'fas fa-teeth-open']
        ],
        'about_title' => 'Expertos en salud dental',
        'about_description' => 'En DentalSmile llevamos más de 15 años cuidando de las sonrisas de nuestros pacientes. Contamos con tecnología de última generación y un equipo de profesionales altamente cualificados.',
        'about_button' => 'Conoce más sobre nosotros',
        'about_image' => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80',
        'testimonials_title' => 'Lo que dicen nuestros pacientes',
        'testimonials' => [
            ['quote' => '"El mejor tratamiento dental que he recibido. Profesionales y un trato excelente."', 'name' => 'María González', 'since' => 'Paciente desde 2018'],
            ['quote' => '"Me realizaron un blanqueamiento dental y los resultados fueron increíbles. ¡Totalmente recomendable!"', 'name' => 'Carlos Rodríguez', 'since' => 'Paciente desde 2020'],
            ['quote' => '"Llevo a mis hijos desde hace años y siempre contentos con el trato recibido. Grandes profesionales."', 'name' => 'Ana Martínez', 'since' => 'Paciente desde 2015']
        ],
        'cta_title' => '¿Necesitas una consulta?',
        'cta_description' => 'Solicita tu cita ahora y recibe una evaluación completa sin compromiso',
        'cta_button' => 'Contactar ahora',
        'footer_title' => 'DentalSmile',
        'footer_description' => 'Tu clínica dental de confianza donde cuidamos de tu sonrisa con los más altos estándares de calidad.',
        'footer_links' => ['Inicio', 'Quiénes Somos', 'Servicios', 'Contacto'],
        'footer_address' => 'Av. Principal #123, Ciudad',
        'footer_phone' => '(123) 456-7890',
        'footer_email' => 'info@dentalsmile.com',
        'footer_hours' => "Lunes - Viernes: 9:00 - 18:00\nSábado: 9:00 - 13:00\nDomingo: Cerrado",
        'footer_copyright' => '© 2023 DentalSmile - Todos los derechos reservados'
    ];
}

// Manejar solicitud POST para guardar cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save') {
    try {
        $config = [
            'header_title' => $_POST['header_title'] ?? '',
            'menu_items' => array_filter(array_map('trim', explode(',', $_POST['menu_items'] ?? ''))),
            'hero_title' => $_POST['hero_title'] ?? '',
            'hero_description' => $_POST['hero_description'] ?? '',
            'hero_button1' => $_POST['hero_button1'] ?? '',
            'hero_button2' => $_POST['hero_button2'] ?? '',
            'services_title' => $_POST['services_title'] ?? '',
            'services' => [],
            'about_title' => $_POST['about_title'] ?? '',
            'about_description' => $_POST['about_description'] ?? '',
            'about_button' => $_POST['about_button'] ?? '',
            'about_image' => $_POST['about_image'] ?? '',
            'testimonials_title' => $_POST['testimonials_title'] ?? '',
            'testimonials' => [],
            'cta_title' => $_POST['cta_title'] ?? '',
            'cta_description' => $_POST['cta_description'] ?? '',
            'cta_button' => $_POST['cta_button'] ?? '',
            'footer_title' => $_POST['footer_title'] ?? '',
            'footer_description' => $_POST['footer_description'] ?? '',
            'footer_links' => array_filter(array_map('trim', explode(',', $_POST['footer_links'] ?? ''))),
            'footer_address' => $_POST['footer_address'] ?? '',
            'footer_phone' => $_POST['footer_phone'] ?? '',
            'footer_email' => $_POST['footer_email'] ?? '',
            'footer_hours' => $_POST['footer_hours'] ?? '',
            'footer_copyright' => $_POST['footer_copyright'] ?? ''
        ];

        // Manejar servicios
        for ($i = 0; $i < 4; $i++) {
            $config['services'][] = [
                'image' => $_POST["services_{$i}_image"] ?? '',
                'title' => $_POST["services_{$i}_title"] ?? '',
                'description' => $_POST["services_{$i}_description"] ?? '',
                'icon' => $_POST["services_{$i}_icon"] ?? ''
            ];
        }

        // Manejar testimonios
        for ($i = 0; $i < 3; $i++) {
            $config['testimonials'][] = [
                'quote' => $_POST["testimonials_{$i}_quote"] ?? '',
                'name' => $_POST["testimonials_{$i}_name"] ?? '',
                'since' => $_POST["testimonials_{$i}_since"] ?? ''
            ];
        }

        // Convertir a JSON
        $json = json_encode($config, JSON_UNESCAPED_UNICODE);
        if ($json === false) {
            throw new Exception('Error al codificar JSON: ' . json_last_error_msg());
        }

        // Insertar en la base de datos
        $sql = "INSERT INTO landing_configs (config_json, status) VALUES (?, 'espera')";
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            throw new Exception('Error al preparar la consulta: ' . $conexion->error);
        }
        $stmt->bind_param('s', $json);
        if (!$stmt->execute()) {
            throw new Exception('Error al ejecutar la consulta: ' . $stmt->error);
        }

        echo json_encode(['success' => true, 'message' => 'Cambios guardados en espera']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit();
}

// Manejar solicitud POST para aplicar cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'apply') {
    try {
        $id = intval($_POST['id']);
        $sql = "UPDATE landing_configs SET status = 'espera' WHERE status = 'aplicado'";
        if (!$conexion->query($sql)) {
            throw new Exception('Error al desmarcar configuraciones previas: ' . $conexion->error);
        }

        $sql = "UPDATE landing_configs SET status = 'aplicado' WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            throw new Exception('Error al preparar la consulta: ' . $conexion->error);
        }
        $stmt->bind_param('i', $id);
        if (!$stmt->execute()) {
            throw new Exception('Error al ejecutar la consulta: ' . $stmt->error);
        }

        echo json_encode(['success' => true, 'message' => 'Cambios aplicados correctamente']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit();
}

// Cargar configuración actual para la vista
$currentConfig = getCurrentConfig($conexion);
require_once '../vistas/edit_index.php';
?>