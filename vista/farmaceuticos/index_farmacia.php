<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'] . '/Clinica/web/controlador/medicamento_controlador.php');

$medicamentos = obtenerMedicamentos();
$informes = obtenerInformesFarmacia();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Farmacia</title>   
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/estilo.css">
</head>
<body>
    <div class="container">
        <h2>Gestión de Medicamentos</h2>
        <div class="seccion-acciones">
            <h3>Agregar Nuevo Medicamento</h3>
            <form action="/Clinica/web/controlador/medicamento_controlador.php" method="POST">
                <input type="hidden" name="accion" value="agregar">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" required>
                <label for="precio">Precio:</label>
                <input type="number" step="0.01" id="precio" name="precio" required>
                <label for="fecha_caducidad">Fecha de Caducidad:</label>
                <input type="date" id="fecha_caducidad" name="fecha_caducidad" required>
                <button type="submit">Agregar</button>
            </form>
        </div>
        <hr>
        
        <div class="seccion-stock-avanzada">
            <h3>Gestión de Stock Avanzada</h3>
            <div class="form-entrada-stock">
                <h4>Registrar Entrada de Stock</h4>
                <form action="/Clinica/web/controlador/medicamento_controlador.php" method="POST">
                    <input type="hidden" name="accion" value="entrada_stock">
                    <label for="med_entrada">Medicamento:</label>
                    <select name="id_medicamento" id="med_entrada" required>
                        <option value="">Seleccione un medicamento</option>
                        <?php foreach ($medicamentos as $med): ?>
                            <option value="<?php echo htmlspecialchars($med['id_medicamento']); ?>">
                                <?php echo htmlspecialchars($med['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label for="cant_entrada">Cantidad:</label>
                    <input type="number" id="cant_entrada" name="cantidad" required min="1">
                    <label for="motivo_entrada">Motivo:</label>
                    <input type="text" id="motivo_entrada" name="motivo" required>
                    <button type="submit">Registrar Entrada</button>
                </form>
            </div>
            
            <div class="alertas-farmacia">
                <h4>Alertas de Inventario</h4>
                <?php if (!empty($informes['bajo_stock'])): ?>
                    <p>🚨 **Medicamentos con Bajo Stock (menos de 10 unidades):**</p>
                    <ul>
                        <?php foreach ($informes['bajo_stock'] as $item): ?>
                            <li>**<?php echo htmlspecialchars($item['nombre']); ?>:** <?php echo htmlspecialchars($item['stock']); ?> unidades</li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if (!empty($informes['por_caducar'])): ?>
                    <p>📅 **Medicamentos Próximos a Caducar (en 30 días):**</p>
                    <ul>
                        <?php foreach ($informes['por_caducar'] as $item): ?>
                            <li>**<?php echo htmlspecialchars($item['nombre']); ?>:** Caduca el <?php echo htmlspecialchars($item['fecha_caducidad']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if (empty($informes['bajo_stock']) && empty($informes['por_caducar'])): ?>
                    <p>No hay alertas de inventario en este momento.</p>
                <?php endif; ?>
            </div>
        </div>

        <hr>

        <div class="seccion-medicamentos">
            <h3>Inventario de Medicamentos</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Stock</th>
                        <th>Precio</th>
                        <th>Caducidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($medicamentos as $medicamento): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($medicamento['id_medicamento']); ?></td>
                            <td><?php echo htmlspecialchars($medicamento['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($medicamento['stock']); ?></td>
                            <td>$<?php echo htmlspecialchars($medicamento['precio']); ?></td>
                            <td><?php echo htmlspecialchars($medicamento['fecha_caducidad']); ?></td>
                            <td>
                                <button onclick="editarMedicamento(<?php echo $medicamento['id_medicamento']; ?>, '<?php echo htmlspecialchars($medicamento['nombre']); ?>', <?php echo $medicamento['stock']; ?>, <?php echo $medicamento['precio']; ?>, '<?php echo htmlspecialchars($medicamento['fecha_caducidad']); ?>')">Modificar</button>
                                <form action="/Clinica/web/controlador/medicamento_controlador.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="accion" value="eliminar">
                                    <input type="hidden" name="id" value="<?php echo $medicamento['id_medicamento']; ?>">
                                    <button type="submit" onclick="return confirm('¿Estás seguro de que quieres eliminar este medicamento?');">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <hr>

        <div class="seccion-historial">
            <h3>Historial de Movimientos de Stock</h3>
            <table>
                <thead>
                    <tr>
                        <th>Medicamento</th>
                        <th>Cantidad</th>
                        <th>Tipo</th>
                        <th>Fecha</th>
                        <th>Motivo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($informes['movimientos'])): ?>
                        <?php foreach ($informes['movimientos'] as $movimiento): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($movimiento['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($movimiento['cantidad']); ?></td>
                                <td><?php echo htmlspecialchars($movimiento['tipo_movimiento']); ?></td>
                                <td><?php echo htmlspecialchars($movimiento['fecha_movimiento']); ?></td>
                                <td><?php echo htmlspecialchars($movimiento['motivo']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5">No hay movimientos de stock registrados.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div id="form-modificar" style="display:none;">
            <h3>Modificar Medicamento</h3>
            <form action="/Clinica/web/controlador/medicamento_controlador.php" method="POST">
                <input type="hidden" name="accion" value="modificar">
                <input type="hidden" id="mod-id" name="id">
                <label for="mod-nombre">Nombre:</label>
                <input type="text" id="mod-nombre" name="nombre" required>
                <label for="mod-stock">Stock:</label>
                <input type="number" id="mod-stock" name="stock" required>
                <label for="mod-precio">Precio:</label>
                <input type="number" step="0.01" id="mod-precio" name="precio" required>
                <label for="mod-fecha_caducidad">Fecha de Caducidad:</label>
                <input type="date" id="mod-fecha_caducidad" name="fecha_caducidad" required>
                <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </div>
    <script>
        function editarMedicamento(id, nombre, stock, precio, fecha_caducidad) {
            document.getElementById('form-modificar').style.display = 'block';
            document.getElementById('mod-id').value = id;
            document.getElementById('mod-nombre').value = nombre;
            document.getElementById('mod-stock').value = stock;
            document.getElementById('mod-precio').value = precio;
            document.getElementById('mod-fecha_caducidad').value = fecha_caducidad;
        }
    </script>
</body>
</html>