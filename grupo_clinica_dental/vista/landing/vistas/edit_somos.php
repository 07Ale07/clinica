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
                                <p><?php echo htmlspecialchars($emp['especialidad']); ?></p>
                                <button class="add-btn" type="button" onclick="addToSelected(<?php echo $emp['id_empleado']; ?>)">Agregar</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div id="selected-team">
                    <h3>Empleados Seleccionados (Arrastre para ordenar)</h3>
                    <!-- Cargados dinámicamente por JS -->
                </div>
            </div>
            <input type="hidden" name="selected_team" id="selected-team-input" value='<?php echo json_encode($currentConfig['team']); ?>'>
            <button type="button" class="save-btn" onclick="saveChanges()">Guardar Cambios</button>
        </form>

        <h2>Configuraciones en Espera</h2>
        <ul id="pendingList">
            <?php
            $sql = "SELECT id, created_at, config_json FROM somos_configs WHERE status = 'espera' ORDER BY created_at DESC";
            $result = $conexion->query($sql);
            if ($result && $result->num_rows > 0) {
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

        // Cargar empleados seleccionados
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

        // Agregar a seleccionados
        function addToSelected(id) {
            if (!selectedTeam.includes(id)) {
                selectedTeam.push(id);
                loadSelected();
            }
        }

        // Eliminar de seleccionados
        function removeFromSelected(id) {
            selectedTeam = selectedTeam.filter(sid => sid != id);
            loadSelected();
        }

        // Actualizar input hidden
        function updateHiddenInput() {
            $('#selected-team-input').val(JSON.stringify(selectedTeam));
        }

        // Búsqueda en tiempo real
        $('#search-available').on('keyup', function() {
            const search = $(this).val().toLowerCase();
            $('#available-list .team-card').each(function() {
                const name = $(this).find('h4').text().toLowerCase();
                $(this).toggle(name.includes(search));
            });
        });

        // Drag-and-drop con SortableJS
        new Sortable(document.getElementById('selected-team'), {
            animation: 150,
            onEnd: function(evt) {
                const newOrder = Array.from($('#selected-team .team-card')).map(card => $(card).data('id'));
                selectedTeam = newOrder;
                updateHiddenInput();
            }
        });

        // Guardar cambios
        function saveChanges() {
            const formData = new FormData(document.getElementById('editForm'));
            formData.append('action', 'save');
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    try {
                        const res = JSON.parse(response);
                        if (res.success) {
                            alert('Cambios guardados en espera.');
                            location.reload();
                        } else {
                            alert('Error: ' + res.message);
                        }
                    } catch (e) {
                        alert('Error al procesar la respuesta: ' + e.message);
                    }
                },
                error: function() {
                    alert('Error al enviar la solicitud.');
                }
            });
        }

        // Aplicar configuración
        function applyChanges(id) {
            $.post(window.location.href, { action: 'apply', id: id }, function(response) {
                try {
                    const res = JSON.parse(response);
                    if (res.success) {
                        alert('Configuración aplicada.');
                        location.reload();
                    } else {
                        alert('Error: ' + res.message);
                    }
                } catch (e) {
                    alert('Error al procesar la respuesta: ' + e.message);
                }
            });
        }

        // Inicializar
        loadSelected();
    </script>
    <script src="../public/js/editor.js"></script>
</body>
</html>