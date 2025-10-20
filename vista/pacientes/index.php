<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Definir constantes de rutas
define('BASE_PATH', realpath(dirname(__FILE__)));
define('VIEWS_PATH', BASE_PATH . '/vista/');
define('CONTROLLERS_PATH', BASE_PATH . '/controlador/');
define('MODELS_PATH', BASE_PATH . '/modelo/');
define('PUBLIC_PATH', '/public/'); // Ruta pública desde la URL

// Verificar y cargar Router.php
$routerFile = CONTROLLERS_PATH . 'Router.php';
if (!file_exists($routerFile)) {
    die("<div style='color:red;'><h2>Error Crítico</h2>No se encontró Router.php en: $routerFile</div>");
}

require_once $routerFile;

try {
    $router = new Router();
    $router->route();
} catch (Exception $e) {
    die("<div style='color:red;'><h2>Error en la aplicación</h2>" . $e->getMessage() . "</div>");
}