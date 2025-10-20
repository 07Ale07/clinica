<?php
// Incluir todos los archivos necesarios (rutas relativas)
require_once 'config/database.php';
require_once 'models/CargoModel.php';
require_once 'models/CargoEmpleadoModel.php';
require_once 'controllers/CargoController.php';
require_once 'controllers/CargoEmpleadoController.php';

$database = new Database();
$db = $database->getConnection();

// Obtener controller y action de la URL
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'cargos';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Routing
if ($controller == 'cargos') {
    $cargoController = new CargoController($db);
    
    switch ($action) {
        case 'index':
            $cargoController->index();
            break;
        case 'crear':
            $cargoController->crear();
            break;
        case 'editar':
            $id = isset($_GET['id']) ? $_GET['id'] : die('ID requerido');
            $cargoController->editar($id);
            break;
        case 'desactivar':
            $id = isset($_GET['id']) ? $_GET['id'] : die('ID requerido');
            $cargoController->desactivar($id);
            break;
        case 'activar':
            $id = isset($_GET['id']) ? $_GET['id'] : die('ID requerido');
            $cargoController->activar($id);
            break;
        default:
            $cargoController->index();
            break;
    }
} elseif ($controller == 'cargo_empleados') {
    $cargoEmpleadoController = new CargoEmpleadoController($db);
    
    switch ($action) {
        case 'index':
            $cargoEmpleadoController->index();
            break;
        case 'crear':
            $cargoEmpleadoController->crear();
            break;
        case 'editar':
            $id = isset($_GET['id']) ? $_GET['id'] : die('ID requerido');
            $cargoEmpleadoController->editar($id);
            break;
        case 'desactivar':
            $id = isset($_GET['id']) ? $_GET['id'] : die('ID requerido');
            $cargoEmpleadoController->desactivar($id);
            break;
        case 'activar':
            $id = isset($_GET['id']) ? $_GET['id'] : die('ID requerido');
            $cargoEmpleadoController->activar($id);
            break;
        default:
            $cargoEmpleadoController->index();
            break;
    }
} else {
    // Redirigir a cargos por defecto
    header("Location: index.php?controller=cargos&action=index");
    exit();
}
?>