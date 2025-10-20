
<div class="container mt-4">
    <h2>Gestión de Cargos</h2>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php
            switch ($_GET['success']) {
                case 1: echo "Cargo creado exitosamente"; break;
                case 2: echo "Cargo actualizado exitosamente"; break;
                case 3: echo "Cargo desactivado exitosamente"; break;
                case 4: echo "Cargo activado exitosamente"; break;
            }
            ?>
        </div>
    <?php endif; ?>

    <a href="index.php?controller=cargos&action=crear" class="btn btn-primary mb-3">Nuevo Cargo</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cargo</th>
                <th>Descripción</th>
                <th>Puede Liquidar Honorarios</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $cargos->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo $row['id_cargo']; ?></td>
                <td><?php echo htmlspecialchars($row['cargo']); ?></td>
                <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                <td><?php echo $row['puede_liquidar_honorarios'] ? 'Sí' : 'No'; ?></td>
                <td>
                    <a href="index.php?controller=cargos&action=editar&id=<?php echo $row['id_cargo']; ?>" 
                       class="btn btn-warning btn-sm">Editar</a>
                    <?php if ($row['activo']): ?>
                        <a href="index.php?controller=cargos&action=desactivar&id=<?php echo $row['id_cargo']; ?>" 
                           class="btn btn-danger btn-sm">Desactivar</a>
                    <?php else: ?>
                        <a href="index.php?controller=cargos&action=activar&id=<?php echo $row['id_cargo']; ?>" 
                           class="btn btn-success btn-sm">Activar</a>
                    <?php endif; ?>
                </td>

            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
                <button><a href="./views/cargo_empleados/index.php">cargo empleado</a></button>

</div>

