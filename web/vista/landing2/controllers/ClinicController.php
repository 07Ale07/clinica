<?php
require_once 'models/Procedure.php';
require_once 'models/Patient.php';
require_once 'models/Employee.php';
require_once 'models/SocialWork.php';

class ClinicController {
    public function index() {
        $procedureModel = new Procedure();
        $patientModel = new Patient();
        $employeeModel = new Employee();
        $socialWorkModel = new SocialWork();

        $procedures = $procedureModel->getAllProcedures();
        $patients = $patientModel->getThreePatients();
        $employees = $employeeModel->getThreeEmployees();
        $socialWorks = $socialWorkModel->getAllSocialWorks();

        require_once 'views/clinic_view.php';
    }
}
?>