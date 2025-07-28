<?php
require_once __DIR__ . '/../modelo/TurnoModel.php';

class TurnoController {
    private $model;

    public function __construct() {
        $this->model = new TurnoModel();
    }

    public function consultarTurno($dni) {
        return $this->model->consultarTurnoPorDni($dni);
    }
}
?>