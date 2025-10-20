<?php
class CargoEmpleadoController {
    private $model;

    public function __construct($db) {
        $this->model = new CargoEmpleadoModel($db);
    }

    public function index() {
        $asignaciones = $this->model->getAll();
        include 'views/cargo_empleados/index.php';
    }

    public function crear() {
        $empleados = $this->model->getEmpleados();
        $cargos = $this->model->getCargos();

        if ($_POST) {
            $data = [
                'id_empleado' => $_POST['id_empleado'],
                'id_cargo' => $_POST['id_cargo'],
                'activo' => isset($_POST['activo']) ? 1 : 0
            ];

            // Validar si ya existe la asignación
            if ($this->model->checkExistingAssignment($data['id_empleado'], $data['id_cargo'])) {
                $error = "Este empleado ya tiene asignado este cargo";
            } else {
                if ($this->model->create($data)) {
                    header("Location: index.php?controller=cargo_empleados&action=index&success=1");
                } else {
                    $error = "Error al crear la asignación";
                }
            }
        }
        include 'views/cargo_empleados/crear.php';
    }

    public function editar($id) {
        $asignacion = $this->model->getById($id);
        $empleados = $this->model->getEmpleados();
        $cargos = $this->model->getCargos();

        if ($_POST) {
            $data = [
                'id_empleado' => $_POST['id_empleado'],
                'id_cargo' => $_POST['id_cargo'],
                'activo' => isset($_POST['activo']) ? 1 : 0
            ];

            // Validar si ya existe la asignación (excluyendo el actual)
            if ($this->model->checkExistingAssignment($data['id_empleado'], $data['id_cargo'], $id)) {
                $error = "Este empleado ya tiene asignado este cargo";
            } else {
                if ($this->model->update($id, $data)) {
                    header("Location: index.php?controller=cargo_empleados&action=index&success=2");
                } else {
                    $error = "Error al actualizar la asignación";
                }
            }
        }
        include 'views/cargo_empleados/editar.php';
    }

    public function desactivar($id) {
        if ($this->model->deactivate($id)) {
            header("Location: index.php?controller=cargo_empleados&action=index&success=3");
        }
    }

    public function activar($id) {
        if ($this->model->activate($id)) {
            header("Location: index.php?controller=cargo_empleados&action=index&success=4");
        }
    }
}
?>