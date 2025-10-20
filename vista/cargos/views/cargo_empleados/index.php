
<div class="container mt-4">
    <h2>Gestión de Asignación de Cargos</h2>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php
            switch ($_GET['success']) {
                case 1: echo "Asignación creada exitosamente"; break;
                case 2: echo "Asignación actualizada exitosamente"; break;
                case 3: echo "Asignación desactivada exitosamente"; break;
                case 4: echo "Asignación activada exitosamente"; break;
            }
            ?>
        </div>
    <?php endif; ?>

    <a href="index.php?controller=cargo_empleados&action=crear" class="btn btn-primary mb-3">
        <i class="fas fa-plus me-2"></i>Nueva Asignación
    </a>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Empleado</th>
                <th>Cargo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $asignaciones->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo $row['id_cargo_empleados']; ?></td>
                <td><?php echo htmlspecialchars($row['empleado_nombre'] ?? 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($row['nombre_cargo'] ?? 'N/A'); ?></td>
                <td>
                    <span class="badge bg-<?php echo $row['activo'] ? 'success' : 'danger'; ?>">
                        <?php echo $row['activo'] ? 'Activo' : 'Inactivo'; ?>
                    </span>
                </td>
                <td>
                    <a href="index.php?controller=cargo_empleados&action=editar&id=<?php echo $row['id_cargo_empleados']; ?>" 
                       class="btn btn-warning btn-sm" title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                    <?php if ($row['activo']): ?>
                        <a href="index.php?controller=cargo_empleados&action=desactivar&id=<?php echo $row['id_cargo_empleados']; ?>" 
                           class="btn btn-danger btn-sm" title="Desactivar" onclick="return confirm('¿Está seguro?')">
                            <i class="fas fa-times"></i>
                        </a>
                    <?php else: ?>
                        <a href="index.php?controller=cargo_empleados&action=activar&id=<?php echo $row['id_cargo_empleados']; ?>" 
                           class="btn btn-success btn-sm" title="Activar" onclick="return confirm('¿Está seguro?')">
                            <i class="fas fa-check"></i>
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

