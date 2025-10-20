<?php
require_once __DIR__ . '/../modelo/empleados_modelo.php';
$empleado = new Empleado();

if (isset($_GET['accion'])) {
    $accion = $_GET['accion'];
    $id = $_GET['id'] ?? null;

    if ($accion === "activar" && $id) {
        $empleado->activarEmpleado($id);
    } elseif ($accion === "desactivar" && $id) {
        $empleado->desactivarEmpleado($id);
    }

    header("Location: ../vista/empleados_vista.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregar'])) {
        $legajo = $_POST['legajo'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $dni = $_POST['dni'];
        $contrato = $_POST['contrato'];
        $interno = $_POST['interno'];
        $cargo = $_POST['cargo'];

        $fotoNombre = null;
        if (!empty($_FILES['foto']['name'])) {
            $fotoNombre = time() . "_" . basename($_FILES["foto"]["name"]);
            $rutaDestino = __DIR__ . "/../uploads/" . $fotoNombre;
            move_uploaded_file($_FILES["foto"]["tmp_name"], $rutaDestino);
        }

        $empleado->agregarEmpleado($legajo, $nombre, $apellido, $dni, $contrato, $interno, $cargo, $fotoNombre);

        header("Location: ../vista/empleados_vista.php");
        exit;
    }

    if (isset($_POST['editar'])) {
        $id = $_POST['id_empleado'];
        $legajo = $_POST['legajo'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $dni = $_POST['dni'];
        $contrato = $_POST['contrato'];
        $interno = $_POST['interno'];
        $cargo = $_POST['cargo'];

        $fotoNombre = null;
        if (!empty($_FILES['foto']['name'])) {
            $fotoNombre = time() . "_" . basename($_FILES["foto"]["name"]);
            $rutaDestino = __DIR__ . "/../uploads/" . $fotoNombre;
            move_uploaded_file($_FILES["foto"]["tmp_name"], $rutaDestino);
        }

        $empleado->editarEmpleado($id, $legajo, $nombre, $apellido, $dni, $contrato, $interno, $cargo, $fotoNombre);

        header("Location: ../vista/empleados_vista.php");
        exit;
    }
}
