<?php
require_once 'config/database.php';
require_once 'controllers/ClinicController.php';

$controller = new ClinicController();
$controller->index();
?>