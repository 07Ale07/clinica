<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

$method = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];
$input = json_decode(file_get_contents("php://input"), true);

require('conexion.php');
$ruta = $_GET['ruta'] ?? '';


// Ruta: POST /login
if ($method === 'POST' && preg_match('/\/login$/', $requestUri)) {
    $usuario = $input['usuario'] ?? null;
    $clave = $input['clave'] ?? null;

    if (!$usuario || !$clave) {
        http_response_code(400);
        echo json_encode(['error' => 'Faltan datos']);
        exit;
    }

    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = ? AND pasword = ? LIMIT 1");
    $stmt->bind_param("ss", $usuario, $clave);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        http_response_code(401);
        echo json_encode(['error' => 'Credenciales incorrectas']);
        exit;
    }

    $row = $result->fetch_assoc();
    echo json_encode(['success' => true, 'nombre' => $row['usuario']]);
    exit;
}

// Ruta: GET /usuarios
if ($method === 'GET' && preg_match('/\/usuarios$/', $requestUri || $ruta === 'usuarios')) {
    $sql = "SELECT id_usuario, usuario, pasword FROM usuarios";
    $result = $conexion->query($sql);

    if (!$result) {
        http_response_code(500);
        echo json_encode(['error' => 'Error en la consulta']);
        exit;
    }

    $usuarios = [];
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }

    echo json_encode($usuarios);
    exit;
}

// Si no coincide con ninguna ruta
http_response_code(404);
echo json_encode(['error' => 'Ruta no encontrada']);
