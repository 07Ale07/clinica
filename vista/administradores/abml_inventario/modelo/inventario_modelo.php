<?php
require_once(__DIR__ . '/../conexion.php');

// Categorías
function obtenerCategorias() {
    global $enlace;
    return $enlace->query("SELECT * FROM categorias_material");
}

// Materiales
function obtenerMateriales() {
    global $enlace;
    return $enlace->query("
        SELECT m.*, c.categoria 
        FROM materiales m 
        JOIN categorias_material c ON m.id_categoria = c.id_categoria
        WHERE m.activo = 1
    ");
}

function insertarMaterial($id_categoria, $nombre, $descripcion, $unidad, $stock_minimo) {
    global $enlace;
    $stmt = $enlace->prepare("INSERT INTO materiales (id_categoria, nombre, descripcion, unidad_medida, stock_minimo) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssi", $id_categoria, $nombre, $descripcion, $unidad, $stock_minimo);
    $stmt->execute();
}

// Proveedores
function obtenerProveedores() {
    global $enlace;
    return $enlace->query("SELECT * FROM proveedores");
}

// Lotes
function obtenerLotes() {
    global $enlace;
    return $enlace->query("
        SELECT l.*, m.nombre AS material, p.nombre AS proveedor
        FROM lotes l
        JOIN materiales m ON l.id_material = m.id_material
        JOIN proveedores p ON l.id_proveedor = p.id_proveedor
    ");
}

function insertarLote($id_material, $id_proveedor, $numero_lote, $fecha_compra, $fecha_vencimiento, $cantidad_inicial, $precio_compra, $almacenado_en) {
    global $enlace;
    $stmt = $enlace->prepare("INSERT INTO lotes 
        (id_material, id_proveedor, numero_lote, fecha_compra, fecha_vencimiento, cantidad_inicial, cantidad_actual, precio_compra, almacenado_en) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisssiids", $id_material, $id_proveedor, $numero_lote, $fecha_compra, $fecha_vencimiento, $cantidad_inicial, $cantidad_inicial, $precio_compra, $almacenado_en);
    $stmt->execute();
}
