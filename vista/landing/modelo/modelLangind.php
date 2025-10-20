<?php
class LandingModel {
    private $conn;

    public function __construct($conexion) {
        $this->conn = $conexion;
    }

    // Obtener procedimientos destacados
    public function getProcedimientosDestacados($limit = 4) {
        $query = "SELECT id_procedimiento, descripcion, costo 
                  FROM procedimientos 
                  ORDER BY id_procedimiento ASC 
                  LIMIT ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $procedimientos = [];
        while ($row = $result->fetch_assoc()) {
            $procedimientos[] = $row;
        }
        
        return $procedimientos;
    }

    // Obtener pacientes destacados
    public function getPacientesDestacados($limit = 3) {
        $query = "SELECT p.id_paciente, per.nombre, per.apellido, p.fecha_registro, p.tipo 
                  FROM pacientes p
                  INNER JOIN personas per ON p.id_persona = per.id_persona
                  WHERE p.activo = 1
                  ORDER BY p.fecha_registro DESC 
                  LIMIT ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $pacientes = [];
        while ($row = $result->fetch_assoc()) {
            $pacientes[] = $row;
        }
        
        return $pacientes;
    }

    // Obtener empleados destacados
    public function getEmpleadosDestacados($limit = 3) {
        $query = "SELECT e.id_empleado, e.numero_legajo, per.nombre, per.apellido, e.tipo_contrato 
                  FROM empleados e
                  INNER JOIN personas per ON e.id_persona = per.id_persona
                  ORDER BY e.id_empleado ASC 
                  LIMIT ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $empleados = [];
        while ($row = $result->fetch_assoc()) {
            $empleados[] = $row;
        }
        
        return $empleados;
    }

    // Obtener obras sociales
    public function getObrasSociales() {
        $query = "SELECT id_obra_social, nombre, codigo_nacional, telefono 
                  FROM obra_sociales 
                  WHERE activo = 1
                  ORDER BY nombre ASC";
        
        $result = $this->conn->query($query);
        
        $obrasSociales = [];
        while ($row = $result->fetch_assoc()) {
            $obrasSociales[] = $row;
        }
        
        return $obrasSociales;
    }

    // Obtener configuración
    public function getConfiguracion() {
        $sql = "SELECT config_json FROM landing_configs WHERE status = 'aplicado' ORDER BY updated_at DESC LIMIT 1";
        $result = $this->conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return json_decode($row['config_json'], true);
        }
        
        // Configuración por defecto
        return [
            'header_title' => 'DentalSmile',
            'menu_items' => ['Inicio', 'Quiénes Somos', 'Servicios', 'Contacto', 'Ubicación'],
            'hero_title' => 'Tu sonrisa es nuestra prioridad',
            'hero_description' => 'Profesionales dedicados a cuidar de tu salud dental con los más altos estándares de calidad',
            'hero_button1' => 'Solicitar Cita',
            'hero_button2' => 'Nuestros Servicios',
            'services_title' => 'Nuestros Servicios',
            'services' => [
                ['title' => 'Blanqueamiento Dental', 'description' => 'Recupera el blanco natural de tus dientes con nuestro tratamiento profesional.', 'icon' => 'fas fa-tooth'],
                ['title' => 'Ortodoncia', 'description' => 'Corrige la alineación de tus dientes con nuestros tratamientos de ortodoncia.', 'icon' => 'fas fa-teeth'],
                ['title' => 'Limpieza Dental', 'description' => 'Elimina el sarro y mantén tus dientes libres de bacterias con nuestra limpieza profesional.', 'icon' => 'fas fa-toothbrush'],
                ['title' => 'Implantes Dentales', 'description' => 'Recupera la funcionalidad y estética de tu sonrisa con implantes de la más alta calidad.', 'icon' => 'fas fa-teeth-open']
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
}
?>