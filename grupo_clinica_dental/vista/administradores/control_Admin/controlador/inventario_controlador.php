<?php
require_once(__DIR__ . '/../modelo/inventario_modelo.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'crear_material') {
        insertarMaterial($_POST['id_categoria'], $_POST['nombre'], $_POST['descripcion'], $_POST['unidad_medida'], $_POST['stock_minimo']);
    }

    if ($accion === 'crear_lote') {
        insertarLote($_POST['id_material'], $_POST['id_proveedor'], $_POST['numero_lote'],
                     $_POST['fecha_compra'], $_POST['fecha_vencimiento'], $_POST['cantidad_inicial'],
                     $_POST['precio_compra'], $_POST['almacenado_en']);
    }

    header("Location: ../public/index.php");
    exit();
}
