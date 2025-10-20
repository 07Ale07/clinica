<?php
// landing/edit_somos.php

// Enable error reporting for development (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../conexion.php';
session_start();

// Verify database connection
if ($conexion->connect_error) {
    error_log("Database connection error: " . $conexion->connect_error);
    die("Error connecting to the database. Please try again later.");
}

// Get current configuration
function getCurrentConfig($conexion) {
    $sql = "SELECT config_json FROM somos_configs WHERE status = 'aplicado' ORDER BY updated_at DESC LIMIT 1";
    $result = $conexion->query($sql);
    
    if (!$result) {
        error_log("SQL error in getCurrentConfig: " . $conexion->error);
        return getDefaultConfig();
    }
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $config = json_decode($row['config_json'], true);
        if ($config === null) {
            error_log("JSON decode error in getCurrentConfig: " . json_last_error_msg());
            return getDefaultConfig();
        }
        return $config;
    }
    error_log("No applied configuration found in somos_configs, using default.");
    return getDefaultConfig();
}

// Default configuration
function getDefaultConfig() {
    return [
        'header_title' => 'DentalSmile',
        'menu_items' => ['Inicio', 'Quiénes Somos', 'Servicios', 'Contacto', 'Ubicación'],
        'about_title' => 'Quiénes Somos',
        'about_subtitle' => 'Conoce más sobre nuestra historia, valores y equipo profesional',
        'history_title' => 'Nuestra Historia',
        'history_description' => 'DentalSmile nació en 2008 con la visión de crear un centro dental donde la excelencia médica se combine con un trato humano y personalizado. Desde nuestros humildes comienzos con apenas dos consultorios, hemos crecido hasta convertirnos en una clínica de referencia en la ciudad. Nuestro fundador, el Dr. Javier Martínez, imaginó un espacio donde los pacientes se sintieran cómodos y seguros, rompiendo con el estereotipo de que ir al dentista debe ser una experiencia traumática.',
        'values_title' => 'Nuestros Valores',
        'values' => [
            ['icon' => 'fas fa-user-md', 'title' => 'Profesionalidad', 'description' => 'Contamos con dentistas altamente cualificados y en constante formación para ofrecer los tratamientos más avanzados.'],
            ['icon' => 'fas fa-heart', 'title' => 'Compromiso', 'description' => 'Nos comprometemos con cada paciente de manera individual, buscando siempre la mejor solución para sus necesidades.'],
            ['icon' => 'fas fa-shield-alt', 'title' => 'Seguridad', 'description' => 'Cumplimos con todos los protocolos de esterilización y seguridad para garantizar tratamientos seguros y confiables.'],
            ['icon' => 'fas fa-hands-helping', 'title' => 'Empatía', 'description' => 'Comprendemos las preocupaciones de nuestros pacientes y trabajamos para hacer de su visita una experiencia agradable.']
        ],
        'team' => [], // Array of employee details (image, name, role, description)
        'team_title' => 'Nuestro Equipo',
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

// Get all active odontologists
function getAllEmpleados($conexion) {
    $sql = "SELECT e.id_empleado, p.nombre, p.apellido, c.cargo, e.foto
            FROM empleados e 
            INNER JOIN personas p ON e.id_persona = p.id_persona
            INNER JOIN cargo_empleados ce ON e.id_empleado = ce.id_empleado 
            INNER JOIN cargos c ON ce.id_cargo = c.id_cargo 
            WHERE c.id_cargo = 1";
    $result = $conexion->query($sql);
    
    if (!$result) {
        error_log("SQL error in getAllEmpleados: " . $conexion->error);
        return [];
    }
    
    $empleados = [];
    while ($row = $result->fetch_assoc()) {
        // Generate default description based on cargo
        $row['descripcion'] = "Profesional dedicado de DentalSmile, especializado en {$row['cargo']}.";
        $empleados[] = $row;
    }
    return $empleados;
}

// Handle POST request to save changes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save') {
    header('Content-Type: application/json');
    try {
        $config = getCurrentConfig($conexion);
        $selected_team_ids = json_decode($_POST['selected_team'] ?? '[]', true);
        if ($selected_team_ids === null) {
            throw new Exception('Invalid team data format');
        }

        // Fetch employee details for selected IDs
        $team = [];
        if (!empty($selected_team_ids)) {
            $placeholders = implode(',', array_fill(0, count($selected_team_ids), '?'));
            $sql = "SELECT e.id_empleado, p.nombre, p.apellido, c.cargo, e.foto
                    FROM empleados e 
                    INNER JOIN personas p ON e.id_persona = p.id_persona
                    INNER JOIN cargo_empleados ce ON e.id_empleado = ce.id_empleado 
                    INNER JOIN cargos c ON ce.id_cargo = c.id_cargo 
                    WHERE e.id_empleado IN ($placeholders)";
            $stmt = $conexion->prepare($sql);
            if (!$stmt) {
                throw new Exception('Error preparing employee query: ' . $conexion->error);
            }
            $stmt->bind_param(str_repeat('i', count($selected_team_ids)), ...$selected_team_ids);
            if (!$stmt->execute()) {
                throw new Exception('Error executing employee query: ' . $stmt->error);
            }
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $team[] = [
                    'image' => $row['foto'] ?? '',
                    'name' => $row['nombre'] . ' ' . $row['apellido'],
                    'role' => $row['cargo'],
                    'description' => "Profesional dedicado de DentalSmile, especializado en {$row['cargo']}."
                ];
            }
        }
        $config['team'] = $team;

        $json = json_encode($config, JSON_UNESCAPED_UNICODE);
        if ($json === false) {
            throw new Exception('Error encoding JSON: ' . json_last_error_msg());
        }

        $sql = "INSERT INTO somos_configs (config_json, status) VALUES (?, 'espera')";
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            throw new Exception('Error preparing insert query: ' . $conexion->error);
        }
        $stmt->bind_param('s', $json);
        if (!$stmt->execute()) {
            throw new Exception('Error executing insert query: ' . $stmt->error);
        }

        echo json_encode(['success' => true, 'message' => 'Changes saved in pending state']);
    } catch (Exception $e) {
        error_log('Error in save: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error saving changes: ' . $e->getMessage()]);
    }
    exit();
}

// Handle POST request to apply changes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'apply') {
    header('Content-Type: application/json');
    try {
        $id = intval($_POST['id']);
        $conexion->query("UPDATE somos_configs SET status = 'espera' WHERE status = 'aplicado'");
        $sql = "UPDATE somos_configs SET status = 'aplicado' WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            throw new Exception('Error preparing update query: ' . $conexion->error);
        }
        $stmt->bind_param('i', $id);
        if (!$stmt->execute()) {
            throw new Exception('Error executing update query: ' . $stmt->error);
        }
        echo json_encode(['success' => true, 'message' => 'Configuration applied']);
    } catch (Exception $e) {
        error_log('Error in apply: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error applying changes: ' . $e->getMessage()]);
    }
    exit();
}

// Load data for the view
$currentConfig = getCurrentConfig($conexion);
$allEmpleados = getAllEmpleados($conexion);

// Convert team data to array of IDs for the form
$selected_team_ids = array_map(function($member) use ($allEmpleados) {
    foreach ($allEmpleados as $emp) {
        if ($emp['nombre'] . ' ' . $emp['apellido'] === $member['name'] && $emp['cargo'] === $member['role']) {
            return $emp['id_empleado'];
        }
    }
    return null;
}, $currentConfig['team']);
$selected_team_ids = array_filter($selected_team_ids); // Remove nulls
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Equipo - Quiénes Somos</title>
    <link rel="stylesheet" href="../public/css/editor.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <style>
        .team-section { display: flex; gap: 20px; flex-wrap: wrap; }
        .team-card { border: 1px solid #ddd; border-radius: 8px; padding: 15px; margin: 10px; width: 200px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: transform 0.3s; background: #fff; }
        .team-card:hover { transform: scale(1.05); }
        .team-card img { width: 100%; height: 120px; object-fit: cover; border-radius: 8px; }
        .team-card h4 { margin: 10px 0 5px; font-size: 16px; }
        .team-card p { margin: 0; font-size: 14px; color: #666; }
        .team-card button { background: #f44336; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; margin-top: 10px; }
        .add-btn { background: #4caf50; }
        .search-input { margin-bottom: 10px; padding: 8px; width: 100%; border: 1px solid #ddd; border-radius: 4px; }
        #selected-team { min-height: 200px; background: #f9f9f9; padding: 10px; border: 1px dashed #ccc; border-radius: 8px; }
        #available-team, #selected-team { flex: 1; min-width: 300px; }
        button.save-btn { background: #2196f3; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Equipo - Página Quiénes Somos</h1>
        <form id="editForm">
            <h2>Gestión del Equipo</h2>
            <div class="team-section">
                <div id="available-team">
                    <h3>Empleados Disponibles</h3>
                    <input type="text" id="search-available" class="search-input" placeholder="Buscar empleado por nombre o apellido...">
                    <div id="available-list">
                        <?php foreach ($allEmpleados as $emp): ?>
                            <div class="team-card" data-id="<?php echo $emp['id_empleado']; ?>">
                                <?php if (!empty($emp['foto'])): ?>
                                    <img src="<?php echo htmlspecialchars($emp['foto']); ?>" alt="<?php echo htmlspecialchars($emp['nombre'] . ' ' . $emp['apellido']); ?>">
                                <?php else: ?>
                                    <img src="../public/images/placeholder.jpg" alt="Sin foto">
                                <?php endif; ?>
                                <h4><?php echo htmlspecialchars($emp['nombre'] . ' ' . $emp['apellido']); ?></h4>
                                <p><?php echo htmlspecialchars($emp['cargo']); ?></p>
                                <button class="add-btn" type="button" onclick="addToSelected(<?php echo $emp['id_empleado']; ?>)">Agregar</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div id="selected-team">
                    <h3>Empleados Seleccionados (Arrastre para ordenar)</h3>
                    <!-- Loaded dynamically by JS -->
                </div>
            </div>
            <input type="hidden" name="selected_team" id="selected-team-input" value='<?php echo json_encode($selected_team_ids); ?>'>
            <button type="button" class="save-btn" onclick="saveChanges()">Guardar Cambios</button>
        </form>

        <h2>Configuraciones en Espera</h2>
        <ul id="pendingList">
            <?php
            $sql = "SELECT id, created_at, config_json FROM somos_configs WHERE status = 'espera' ORDER BY created_at DESC";
            $result = $conexion->query($sql);
            if (!$result) {
                error_log("SQL error in pending configs: " . $conexion->error);
                echo "<li>Error loading pending configurations.</li>";
            } elseif ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $config = json_decode($row['config_json'], true);
                    $title = isset($config['header_title']) ? htmlspecialchars($config['header_title']) : 'Sin título';
                    echo "<li>ID: {$row['id']} - Creado: {$row['created_at']} - Título: {$title} <button onclick='applyChanges({$row['id']})'>Aplicar</button></li>";
                }
            } else {
                echo "<li>No hay configuraciones en espera.</li>";
            }
            ?>
        </ul>
    </div>

    <script>
        let selectedTeam = JSON.parse($('#selected-team-input').val() || '[]');
        const allEmpleados = <?php echo json_encode($allEmpleados); ?>;

        // Load selected employees
        function loadSelected() {
            $('#selected-team').html('<h3>Empleados Seleccionados (Arrastre para ordenar)</h3>');
            selectedTeam.forEach(id => {
                const emp = allEmpleados.find(e => e.id_empleado == id);
                if (emp) {
                    $('#selected-team').append(`
                        <div class="team-card" data-id="${id}">
                            <img src="${emp.foto || '../public/images/placeholder.jpg'}" alt="${emp.nombre} ${emp.apellido}">
                            <h4>${emp.nombre} ${emp.apellido}</h4>
                            <p>${emp.cargo}</p>
                            <button type="button" onclick="removeFromSelected(${id})">Eliminar</button>
                        </div>
                    `);
                }
            });
            updateHiddenInput();
        }

        // Add to selected
        function addToSelected(id) {
            if (!selectedTeam.includes(id)) {
                selectedTeam.push(id);
                loadSelected();
            }
        }

        // Remove from selected
        function removeFromSelected(id) {
            selectedTeam = selectedTeam.filter(sid => sid != id);
            loadSelected();
        }

        // Update hidden input
        function updateHiddenInput() {
            $('#selected-team-input').val(JSON.stringify(selectedTeam));
        }

        // Real-time search
        $('#search-available').on('keyup', function() {
            const search = $(this).val().toLowerCase();
            $('#available-list .team-card').each(function() {
                const name = $(this).find('h4').text().toLowerCase();
                $(this).toggle(name.includes(search));
            });
        });

        // Drag-and-drop with SortableJS
        new Sortable(document.getElementById('selected-team'), {
            animation: 150,
            onEnd: function(evt) {
                const newOrder = Array.from($('#selected-team .team-card')).map(card => $(card).data('id'));
                selectedTeam = newOrder;
                updateHiddenInput();
            }
        });

        // Save changes
        function saveChanges() {
            const formData = new FormData(document.getElementById('editForm'));
            formData.append('action', 'save');
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('Changes saved in pending state.');
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error sending request: ' + error);
                }
            });
        }

        // Apply configuration
        function applyChanges(id) {
            if (confirm('¿Estás seguro de que deseas aplicar esta configuración?')) {
                $.post(window.location.href, { action: 'apply', id: id }, function(response) {
                    if (response.success) {
                        alert('Configuration applied.');
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                }, 'json').fail(function(xhr, status, error) {
                    alert('Error sending request: ' + error);
                });
            }
        }

        // Initialize
        loadSelected();
    </script>
</body>
</html>