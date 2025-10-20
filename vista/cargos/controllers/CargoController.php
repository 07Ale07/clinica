<?php
// Incluir el modelo con ruta correcta
require_once './models/CargoModel.php';

class CargoController {
    private $model;

    public function __construct($db) {
        $this->model = new CargoModel($db);
    }

    public function index() {
        $cargos = $this->model->getAll();
        // Ruta CORRECTA para la vista
        include './views/cargos/index.php';
    }

    public function crear() {
        if ($_POST) {
            $data = [
                'cargo' => $_POST['cargo'],
                'descripcion' => $_POST['descripcion'],
                'puede_liquidar_honorarios' => isset($_POST['puede_liquidar_honorarios']) ? 1 : 0
            ];

            if ($this->model->create($data)) {
                header("Location: ../../index.php?controller=cargos&action=index&success=1");
            } else {
                $error = "Error al crear el cargo";
            }
        }
        include './views/cargos/crear.php';
    }

    public function editar($id) {
        $cargo = $this->model->getById($id);

        if ($_POST) {
            $data = [
                'cargo' => $_POST['cargo'],
                'descripcion' => $_POST['descripcion'],
                'puede_liquidar_honorarios' => isset($_POST['puede_liquidar_honorarios']) ? 1 : 0
            ];

            if ($this->model->update($id, $data)) {
                header("Location: ../../index.php?controller=cargos&action=index&success=2");
            } else {
                $error = "Error al actualizar el cargo";
            }
        }
        include './views/cargos/editar.php';
    }

    public function desactivar($id) {
        if ($this->model->deactivate($id)) {
            header("Location: ../../index.php?controller=cargos&action=index&success=3");
        }
    }

    public function activar($id) {
        if ($this->model->activate($id)) {
            header("Location: ../../index.php?controller=cargos&action=index&success=4");
        }
    }
}
?>