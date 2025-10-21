<?php 
// Incluir header con la ruta correcta
?>

<div class="container mt-4">
    <h2>Editar Cargo</h2>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="cargo">Cargo:</label>
                    <input type="text" class="form-control" id="cargo" name="cargo" 
                           value="<?php echo htmlspecialchars($cargo['cargo'] ?? ''); ?>" required>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="puede_liquidar_honorarios">Puede liquidar honorarios:</label>
                    <div class="form-check mt-2">
                        <input type="checkbox" class="form-check-input" id="puede_liquidar_honorarios" 
                               name="puede_liquidar_honorarios" value="1" 
                               <?php echo ($cargo['puede_liquidar_honorarios'] ?? 0) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="puede_liquidar_honorarios">Sí</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea class="form-control" id="descripcion" name="descripcion" 
                      rows="4"><?php echo htmlspecialchars($cargo['descripcion'] ?? ''); ?></textarea>
        </div>
        
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
            <button type="submit" class="btn btn-primary me-md-2">
                <i class="fas fa-save me-2"></i>Actualizar Cargo
            </button>
            <a href="./index.php?controller=cargos&action=index" class="btn btn-secondary">
                <i class="fas fa-times me-2"></i>Cancelar
            </a>
        </div>
    </form>
</div>

