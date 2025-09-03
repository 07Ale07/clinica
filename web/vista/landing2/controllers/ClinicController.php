<?php
require_once 'models/Procedure.php';
require_once 'models/Patient.php';
require_once 'models/Employee.php';
require_once 'models/SocialWork.php';
require_once 'models/PerformedProcedure.php'; // <-- nuevo modelo

class ClinicController {
    public function index() {
        $procedureModel = new Procedure();
        $patientModel = new Patient();
        $employeeModel = new Employee();
        $socialWorkModel = new SocialWork();
        $performedProcedureModel = new PerformedProcedure(); // <-- instancia

        $procedures = $procedureModel->getAllProcedures();
        $patients = $patientModel->getThreePatients();
        $employees = $employeeModel->getThreeEmployees();
        $socialWorks = $socialWorkModel->getAllSocialWorks();
        $performedProcedures = $performedProcedureModel->getAllPerformedProcedures(); // <-- datos

        require_once 'views/clinic_view.php';
    }
}
?>
