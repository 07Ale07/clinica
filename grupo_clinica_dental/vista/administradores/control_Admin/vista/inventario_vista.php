<?php
require_once(__DIR__ . '/../modelo/inventario_modelo.php');

$materiales = obtenerMateriales();
$categorias = obtenerCategorias();
$proveedores = obtenerProveedores();
$lotes = obtenerLotes();
?>

<h2>Materiales Activos</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>Nombre</th>
        <th>Categoría</th>
        <th>Unidad</th>
        <th>Stock Mínimo</th>
        <th>Descripción</th>
    </tr>
    <?php while ($mat = $materiales->fetch_assoc()): ?>
        <tr>
            <td><?= $mat['nombre'] ?></td>
            <td><?= $mat['categoria'] ?></td>
            <td><?= $mat['unidad_medida'] ?></td>
            <td><?= $mat['stock_minimo'] ?></td>
            <td><?= $mat['descripcion'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<h3>Agregar nuevo material</h3>
<form method="POST" action="../controlador/inventario_controlador.php">
    <input type="hidden" name="accion" value="crear_material">
    <label>Nombre: <input type="text" name="nombre" required></label><br>
    <label>Categoría:
        <select name="id_categoria" required>
            <?php while ($cat = $categorias->fetch_assoc()): ?>
                <option value="<?= $cat['id_categoria'] ?>"><?= $cat['categoria'] ?></option>
            <?php endwhile; ?>
        </select>
    </label><br>
    <label>Unidad: <input type="text" name="unidad_medida" required></label><br>
    <label>Stock mínimo: <input type="number" name="stock_minimo" required></label><br>
    <label>Descripción:<br>
        <textarea name="descripcion" rows="2" cols="40"></textarea>
    </label><br>
    <button type="submit">Guardar Material</button>
</form>

<hr>

<h2>Lotes de materiales</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>Material</th>
        <th>Proveedor</th>
        <th>Lote</th>
        <th>Compra</th>
        <th>Vencimiento</th>
        <th>Cantidad</th>
        <th>Precio</th>
        <th>Ubicación</th>
    </tr>
    <?php while ($l = $lotes->fetch_assoc()): ?>
        <tr>
            <td><?= $l['material'] ?></td>
            <td><?= $l['proveedor'] ?></td>
            <td><?= $l['numero_lote'] ?></td>
            <td><?= $l['fecha_compra'] ?></td>
            <td><?= $l['fecha_vencimiento'] ?></td>
            <td><?= $l['cantidad_actual'] ?></td>
            <td>$<?= $l['precio_compra'] ?></td>
            <td><?= $l['almacenado_en'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<h3>Agregar nuevo lote</h3>
<form method="POST" action="../controlador/inventario_controlador.php">
    <input type="hidden" name="accion" value="crear_lote">

    <label>Material:
        <select name="id_material" required>
            <?php
            mysqli_data_seek($materiales, 0);
            while ($m = $materiales->fetch_assoc()): ?>
                <option value="<?= $m['id_material'] ?>"><?= $m['nombre'] ?></option>
            <?php endwhile; ?>
        </select>
    </label><br>

    <label>Proveedor:
        <select name="id_proveedor" required>
            <?php while ($p = $proveedores->fetch_assoc()): ?>
                <option value="<?= $p['id_proveedor'] ?>"><?= $p['nombre'] ?></option>
            <?php endwhile; ?>
        </select>
    </label><br>

    <label>Número de lote: <input type="text" name="numero_lote" required></label><br>
    <label>Fecha compra: <input type="date" name="fecha_compra" required></label><br>
    <label>Fecha vencimiento: <input type="date" name="fecha_vencimiento"></label><br>
    <label>Cantidad inicial: <input type="number" name="cantidad_inicial" required></label><br>
    <label>Precio compra: <input type="number" step="0.01" name="precio_compra" required></label><br>
    <label>Ubicación: <input type="text" name="almacenado_en"></label><br>

    <button type="submit">Guardar Lote</button>
</form>
