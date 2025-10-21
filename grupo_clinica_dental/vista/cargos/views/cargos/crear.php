
<div class="container mt-4">
    <h2>Crear Nuevo Cargo</h2>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="cargo">Cargo:</label>
            <input type="text" class="form-control" id="cargo" name="cargo" required>
        </div>
        
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
        </div>
        
        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="puede_liquidar_honorarios" name="puede_liquidar_honorarios">
            <label class="form-check-label" for="puede_liquidar_honorarios">Puede liquidar honorarios</label>
        </div>
        
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="index.php?controller=cargos&action=index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

