<?php
// Incluir el modelo
require_once 'model_landing.php';

// Obtener conexión (asumiendo que $conexion ya existe)
// Si no, incluir aquí el archivo de conexión

// Crear instancia del modelo
$model = new LandingModel($conexion);

// Obtener todos los datos necesarios
$config = $model->getConfiguracion();
$datos = [
    'procedimientos' => $model->getProcedimientosDestacados(),
    'pacientes' => $model->getPacientesDestacados(),
    'empleados' => $model->getEmpleadosDestacados(),
    'obrasSociales' => $model->getObrasSociales()
];

// Incluir la vista
require_once 'view_landing.php';
?>