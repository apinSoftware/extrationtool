<?php

include('ndrfactory/ndrConverter.php');
include('sqlQueries/patients.php');
include('utils.php');

class MainController {

    private $connection;

    function __construct() {
        $this->connect_db();
        $this->rows = null;
        $this->states = null;
        $this->dashboardStats = null;
        $this->encountersRes = null;
        $this->labRes = null;
        $this->pharmacy = null;
    }

    public function connect_db() {
        $this->connection = mysqli_connect('localhost', 'root', 'Nu66et', 'nigeriamrs');
        if (mysqli_connect_error()) {
            die("Database Connection Failed" . mysqli_connect_error() . mysqli_connect_errno());
        }
    }

    public function connect_db_out() {
        return mysqli_connect('localhost', 'root', 'Nu66et', 'openmrs');
        if (mysqli_connect_error()) {
            die("Database Connection Failed" . mysqli_connect_error() . mysqli_connect_errno());
        }
    }

    public function generateNDR() {
        //List<Patient> patients = Context.getPatientService().getAllPatients();		
        		
        $facility = Utils::createFacility("FAC"); 
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $patientSql = PatientInformation::getPatients();
        $res = mysqli_query($this->connection, $patientSql);
        $patients = mysqli_fetch_all($res, MYSQLI_ASSOC);

        try {

            foreach ($patients as $key => $patient) {
                try {
                    //Started Export for patient with id: "+ patient.getId()
                    NDRConverter::createContainer($patient, $facility, $this->connection);
                } catch (Exception $ex) {
                    echo "hj";
                }
            }
        } catch (Exception $ex) {
            echo "hj";
        }
    }

}

$mainController = new MainController();
?>