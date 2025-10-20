<?php include '../../layouts/header.php'; ?>

<div class="container mt-4">
    <h2>Editar Asignación de Cargo</h2>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="id_empleado">Empleado:</label>
                    <select class="form-control" id="id_empleado" name="id_empleado" required>
                        <option value="">Seleccionar empleado</option>
                        <?php 
                        $empleados->execute(); // Reiniciar el cursor
                        while ($empleado = $empleados->fetch(PDO::FETCH_ASSOC)): 
                        ?>
                            <option value="<?php echo $empleado['id_empleado']; ?>" 
                                <?php echo ($empleado['id_empleado'] == $asignacion['id_empleado']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($empleado['nombre']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="id_cargo">Cargo:</label>
                    <select class="form-control" id="id_cargo" name="id_cargo" required>
                        <option value="">Seleccionar cargo</option>
                        <?php 
                        $cargos->execute(); // Reiniciar el cursor
                        while ($cargo = $cargos->fetch(PDO::FETCH_ASSOC)): 
                        ?>
                            <option value="<?php echo $cargo['id_cargo']; ?>" 
                                <?php echo ($cargo['id_cargo'] == $asignacion['id_cargo']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cargo['cargo']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-check mb-3 mt-3">
            <input type="checkbox" class="form-check-input" id="activo" name="activo" 
                <?php echo $asignacion['activo'] ? 'checked' : ''; ?>>
            <label class="form-check-label" for="activo">Asignación activa</label>
        </div>
        
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-primary me-md-2">
                <i class="fas fa-save me-2"></i>Actualizar
            </button>
            <a href="index.php?controller=cargo_empleados&action=index" class="btn btn-secondary">
                <i class="fas fa-times me-2"></i>Cancelar
            </a>
        </div>
    </form>
</div>

<?php include '../../layouts/footer.php'; ?>