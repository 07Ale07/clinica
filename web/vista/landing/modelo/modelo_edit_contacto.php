
<?php
// landing/modelo/modelo_edit_contacto.php
require_once '../conexion.php';
session_start();

// Verificar si el usuario está autenticado (deberías implementar tu propia lógica de autenticación)

// Función para obtener configuración actual de contacto
function getCurrentContactConfig($conexion) {
    $sql = "SELECT config_json FROM contact_configs WHERE status = 'aplicado' ORDER BY updated_at DESC LIMIT 1";
    $result = $conexion->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return json_decode($row['config_json'], true);
    }
    return getDefaultContactConfig();
}

// Configuración por defecto para contacto
function getDefaultContactConfig() {
    return [
        'contact_address' => 'Av. Principal #123, Col. Centro Ciudad, CP 28000',
        'contact_phones' => '(123) 456-7890' . PHP_EOL . '(123) 456-7891',
        'contact_emails' => 'info@dentalsmile.com' . PHP_EOL . 'citas@dentalsmile.com',
        'contact_hours' => "Lunes a Viernes: 9:00 - 18:00\nSábados: 9:00 - 13:00\nDomingos: Cerrado",
        'social_facebook' => '#',
        'social_instagram' => '#',
        'social_twitter' => '#',
        'social_youtube' => '#'
    ];
}

// Manejar solicitud POST para guardar cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save') {
    try {
        $config = [
            'contact_address' => $_POST['contact_address'] ?? '',
            'contact_phones' => $_POST['contact_phones'] ?? '',
            'contact_emails' => $_POST['contact_emails'] ?? '',
            'contact_hours' => $_POST['contact_hours'] ?? '',
            'social_facebook' => $_POST['social_facebook'] ?? '',
            'social_instagram' => $_POST['social_instagram'] ?? '',
            'social_twitter' => $_POST['social_twitter'] ?? '',
            'social_youtube' => $_POST['social_youtube'] ?? ''
        ];

        // Convertir a JSON
        $json = json_encode($config, JSON_UNESCAPED_UNICODE);
        if ($json === false) {
            throw new Exception('Error al codificar JSON: ' . json_last_error_msg());
        }

        // Insertar en la base de datos
        $sql = "INSERT INTO contact_configs (config_json, status) VALUES (?, 'espera')";
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            throw new Exception('Error al preparar la consulta: ' . $conexion->error);
        }
        $stmt->bind_param('s', $json);
        if (!$stmt->execute()) {
            throw new Exception('Error al ejecutar la consulta: ' . $stmt->error);
        }

        echo json_encode(['success' => true, 'message' => 'Cambios de contacto guardados en espera']);
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
        $sql = "UPDATE contact_configs SET status = 'espera' WHERE status = 'aplicado'";
        if (!$conexion->query($sql)) {
            throw new Exception('Error al desmarcar configuraciones previas: ' . $conexion->error);
        }

        $sql = "UPDATE contact_configs SET status = 'aplicado' WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            throw new Exception('Error al preparar la consulta: ' . $conexion->error);
        }
        $stmt->bind_param('i', $id);
        if (!$stmt->execute()) {
            throw new Exception('Error al ejecutar la consulta: ' . $stmt->error);
        }

        echo json_encode(['success' => true, 'message' => 'Cambios de contacto aplicados correctamente']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit();
}

// Cargar configuración actual para la vista
$currentConfig = getCurrentContactConfig($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Información de Contacto - DentalSmile</title>
    <link rel="stylesheet" href="../public/css/editor.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Editar Información de Contacto</h1>
        
        <form id="editContactForm">
            <h2>Información de Contacto</h2>
            
            <label>Dirección:
                <textarea name="contact_address" required><?php echo htmlspecialchars($currentConfig['contact_address']); ?></textarea>
            </label>
            
            <label>Teléfonos (separados por línea):
                <textarea name="contact_phones" required><?php echo htmlspecialchars($currentConfig['contact_phones']); ?></textarea>
            </label>
            
            <label>Emails (separados por línea):
                <textarea name="contact_emails" required><?php echo htmlspecialchars($currentConfig['contact_emails']); ?></textarea>
            </label>
            
            <label>Horario de Atención:
                <textarea name="contact_hours" required><?php echo htmlspecialchars($currentConfig['contact_hours']); ?></textarea>
            </label>
            
            <h2>Redes Sociales</h2>
            
            <label>Facebook URL:
                <input type="text" name="social_facebook" value="<?php echo htmlspecialchars($currentConfig['social_facebook']); ?>">
            </label>
            
            <label>Instagram URL:
                <input type="text" name="social_instagram" value="<?php echo htmlspecialchars($currentConfig['social_instagram']); ?>">
            </label>
            
            <label>Twitter URL:
                <input type="text" name="social_twitter" value="<?php echo htmlspecialchars($currentConfig['social_twitter']); ?>">
            </label>
            
            <label>YouTube URL:
                <input type="text" name="social_youtube" value="<?php echo htmlspecialchars($currentConfig['social_youtube']); ?>">
            </label>
            
            <button type="button" onclick="saveContactChanges()">Guardar en Espera</button>
        </form>

        <h2>Configuraciones en Espera</h2>
        <ul id="pendingList">
            <?php
            $sql = "SELECT id, created_at, config_json FROM contact_configs WHERE status = 'espera' ORDER BY created_at DESC";
            $result = $conexion->query($sql);
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $config = json_decode($row['config_json'], true);
                    $title = "Configuración de contacto - " . $row['created_at'];
                    echo "<li>ID: {$row['id']} - Creado: {$row['created_at']} <button onclick='applyContactChanges({$row['id']})'>Aplicar</button></li>";
                }
            } else {
                echo "<li>No hay configuraciones de contacto en espera.</li>";
            }
            ?>
        </ul>
        
        <div class="navigation-buttons">
            <a href="modelo_edit_controlador.php" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Volver al Panel de Control
            </a>
            <a href="../contacto.php" target="_blank" class="btn btn-secondary">
                <i class="fas fa-eye"></i> Ver Página de Contacto
            </a>
        </div>
    </div>

    <script>
    function saveContactChanges() {
        const formData = new FormData(document.getElementById('editContactForm'));
        formData.append('action', 'save');
        
        fetch('modelo_edit_contacto.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al guardar los cambios');
        });
    }
    
    function applyContactChanges(id) {
        const formData = new FormData();
        formData.append('action', 'apply');
        formData.append('id', id);
        
        fetch('modelo_edit_contacto.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al aplicar los cambios');
        });
    }
    </script>
</body>
</html>