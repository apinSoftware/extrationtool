<?php

include('sqlQueries/pharmacy.php');
include('sqlQueries/ecounter.php');
include('sqlQueries/laboratory.php');
class IndividualReport {

    public static function patientDemographics($IndividualReport, $patient, $facility) {

        $PatientDemographics = $IndividualReport->addChild("PatientDemographics");
        $PatientDemographics->addChild("PatientIdentifier", $patient['IDNumber']);
        /////////add treatment facility
        $TreatmentFacility = $PatientDemographics->addChild("TreatmentFacility");
        $TreatmentFacility->addChild("FacilityName", $facility['facilityName']);
        $TreatmentFacility->addChild("FacilityID", $facility['facn']);
        $TreatmentFacility->addChild("FacilityTypeCode", "FAC");
        ///////////////////add OtherPatientIdentifiers //////////////////////////
        $OtherPatientIdentifiers = $PatientDemographics->addChild("OtherPatientIdentifiers");
        $Identifier = $OtherPatientIdentifiers->addChild("Identifier");
        $Identifier->addChild("IDNumber", $patient['IDNumber']);
        $Identifier->addChild("IDTypeCode", "PN");
        $PatientDemographics->addChild("PatientDateOfBirth", $patient['PatientDateOfBirth']);

        $PatientDemographics->addChild("PatientSexCode", $patient['PatientSexCode']);
        $PatientDemographics->addChild("PatientDeceasedIndicator", $patient['PatientDeceasedIndicator']);
        //$PatientDemographics->addChild("PatientPrimaryLanguageCode", "");
        $PatientDemographics->addChild("PatientEducationLevelCode", $patient['PatientEducationLevelCode']);
        $PatientDemographics->addChild("PatientOccupationCode", $patient['PatientOccupationCode']);
        $PatientDemographics->addChild("PatientMaritalStatusCode", $patient['PatientMaritalStatusCode']);
        $PatientDemographics->addChild("StateOfNigeriaOriginCode", $patient['state']);

        return $PatientDemographics;
    }

    public static function condition($condition, $patient, $facility, $connection) {

        $condition->addChild("ConditionCode", $patient['ConditionCode']);
        self::addProgramArea($patient, $condition);
        self::addCommonQuestions($patient, $condition,  $facility);
        self::addConditionSpecificQuestions($patient, $condition,  $facility);
        //$Encounters = $Condition->addChild("Encounters");
        //$this->addEncounters($patient, $Encounters);
        //$this->addLaboratoryReport($patient, $Condition);
        self::addAllRegimen($patient, $condition, $connection);
        return $condition;
    }

    public static  function addProgramArea($patient, $condition) {

        $ProgramArea = $condition->addChild("ProgramArea");
        $ProgramArea->addChild("ProgramAreaCode", "HIV");
        $PatientAddress = $condition->addChild("PatientAddress");
        $PatientAddress->addChild("AddressTypeCode", "H");
        $PatientAddress->addChild("WardVillage", $patient['WardVillage']);
        $PatientAddress->addChild("Town", $patient['town']);
        $PatientAddress->addChild("LGACode", $patient['LGACode']);
        $PatientAddress->addChild("StateCode", $patient['state']);
        $PatientAddress->addChild("CountryCode", "NGA");
        $PatientAddress->addChild("PostalCode", "");
        $PatientAddress->addChild("OtherAddressInformation", "");
    }

    public static function addCommonQuestions($patient, $condition, $facility) {
        $CommonQuestions = $condition->addChild("CommonQuestions");
        $CommonQuestions->addChild("HospitalNumber", $patient['IDNumber']);
        $DiagnosisFacility = $CommonQuestions->addChild("DiagnosisFacility");
        $DiagnosisFacility->addChild("FacilityName", $facility['facilityName']);
        $DiagnosisFacility->addChild("FacilityID",$facility["DATIMID"]);
        $DiagnosisFacility->addChild("FacilityTypeCode", "FAC");
        $CommonQuestions->addChild("DateOfFirstReport", $patient['DateOfFirstReport']);
        $CommonQuestions->addChild("DiagnosisDate", $patient['DateOfFirstReport']);
        $CommonQuestions->addChild("PatientDieFromThisIllness", $patient['PatientDeceasedIndicator']);
        $CommonQuestions->addChild("PatientAge", $patient['PatientAge']);
    }

    public static function addConditionSpecificQuestions($patient, $condition, $facility) {

        $conditionSpecificQuestions = $condition->addChild("ConditionSpecificQuestions");
        $HIVQuestions = $conditionSpecificQuestions->addChild("HIVQuestions");
        $HIVQuestions->addChild("CareEntryPoint", $patient['CareEntryPoint']);
        $HIVQuestions->addChild("FirstConfirmedHIVTestDate", $patient['FirstConfirmedHIVTestDate']);
        $HIVQuestions->addChild("FirstHIVTestMode", $patient['FirstHIVTestMode']);
        $HIVQuestions->addChild("WhereFirstHIVTest", $patient['WhereFirstHIVTest']);
        $HIVQuestions->addChild("PriorArt", $patient['PriorArt']);
        $HIVQuestions->addChild("MedicallyEligibleDate", $patient['MedicallyEligibleDate']);
        $HIVQuestions->addChild("ReasonMedicallyEligible", $patient['ReasonMedicallyEligible']);
        $HIVQuestions->addChild("InitialAdherenceCounselingCompletedDate", $patient['InitialAdherenceCounselingCompletedDate']);
        $FirstARTRegimen = $HIVQuestions->addChild("FirstARTRegimen");
        self::addFirstArtRegime($patient, $FirstARTRegimen, $HIVQuestions);
    }

    public static function addFirstArtRegime($patient, $FirstARTRegimen, $HIVQuestions) {

        $FirstARTRegimen->addChild("Code", $patient['CODE']);
        $FirstARTRegimen->addChild("CodeDescTxt", $patient['CodeDescTxt']);
        $HIVQuestions->addChild("ARTStartDate", $patient['ARTStartDate']);
        $HIVQuestions->addChild("WHOClinicalStageARTStart", $patient['WHOClinicalStageARTStart']);
        $HIVQuestions->addChild("WeightAtARTStart", $patient['WeightAtARTStart']);
        $HIVQuestions->addChild("FunctionalStatusStartART", $patient['FunctionalStatusStartART']);
        $HIVQuestions->addChild("CD4AtStartOfART", $patient['CD4AtStartOfART']);
        $HIVQuestions->addChild("PatientHasDied", $patient['PatientDeceasedIndicator']);
        $HIVQuestions->addChild("EnrolledInHIVCareDate", $patient['EnrolledInHIVCareDate']);
        $HIVQuestions->addChild("InitialTBStatus", $patient['InitialTBStatus']);
    }

    public static function addEncounters($patient, $Encounters, $connection) {
        
    
        $encounterSql = EncounterInformation::getEncounters($patient['patient_id']);
        $ecounterRes = mysqli_query($connection, $encounterSql);
        $ecounterResults = mysqli_fetch_all($ecounterRes, MYSQLI_ASSOC);
        foreach ($ecounterResults as $enc) {
            $HIVEncounter = $Encounters->addChild("HIVEncounter");
            $HIVEncounter->addChild("VisitID", $enc['VisitIDEnc']);
            $HIVEncounter->addChild("VisitDate", $enc['VisitDateEnc']);
            $HIVEncounter->addChild("DurationOnArt", $enc['DurationOnArt']);
            $HIVEncounter->addChild("Weight", $enc['Weight']);
            $HIVEncounter->addChild("BloodPressure", $enc['BloodPressure']);
            $HIVEncounter->addChild("PatientFamilyPlanningCode", "FP");
            $HIVEncounter->addChild("PatientFamilyPlanningMethodCode", $enc['PatientFamilyPlanningMethodCode']);
            $HIVEncounter->addChild("FunctionalStatus", $enc['FunctionalStatus']);
            $HIVEncounter->addChild("WHOClinicalStage", $enc['WHOClinicalStage']);
            $HIVEncounter->addChild("TBStatus", $enc['TBStatus']);

            $ARVDrugRegimen = $HIVEncounter->addChild("ARVDrugRegimen");
            $ARVDrugRegimen->addChild("Code", $enc['CodeRegEnc']);
            $ARVDrugRegimen->addChild("CodeDescTxt", $enc['CodeDescTxtRegEnc']);
            $CotrimoxazoleDose = $HIVEncounter->addChild("CotrimoxazoleDose");
            $CotrimoxazoleDose->addChild("Code", $enc['CodeCTX']);
            $CotrimoxazoleDose->addChild("CodeDescTxt", $row_enc['CodeDescTxtCTX']);

            $HIVEncounter->addChild("CD4", $enc['cd4value']);
            $HIVEncounter->addChild("CD4TestDate", $enc['VisitDateEnc']);
            $HIVEncounter->addChild("NextAppointmentDate", $enc['NextAppointmentDate']);
        }
    }

    public static function addLaboratoryReport($patientData, $condition, $connection) {
        
        $labSql = Laboratorynformation::getLaboratory($patient['patient_id']);
        $labRes = mysqli_query($connection, $labSql);
        $labResults = mysqli_fetch_all($labRes, MYSQLI_ASSOC);
          foreach ($labResults as $lb) {
            $LaboratoryReport = $Condition->addChild("LaboratoryReport");
            $LaboratoryReport->addChild("VisitID", $lb['VisitID']);
            $LaboratoryReport->addChild("VisitDate", $lb['VisitDate']);
            $LaboratoryReport->addChild("LaboratoryTestIdentifier", $lb['LaboratoryTestIdentifier']);
            $LaboratoryReport->addChild("CollectionDate", $lb['VisitDate']);
            $LaboratoryReport->addChild("CollectionDate", $lb['CollectionDate']);
            $LaboratoryReport->addChild("BaselineRepeatCode", $lb['BaselineRepeatCode']);
            $LaboratoryReport->addChild("ARTStatusCode", $lb['ARTStatusCode']);
            $LaboratoryOrderAndResult = $LaboratoryReport->addChild("LaboratoryOrderAndResult");
            $LaboratoryOrderAndResult->addChild("OrderedTestDate", $lb['VisitDate']);
            $LaboratoryResultedTest = $LaboratoryOrderAndResult->addChild("LaboratoryResultedTest");
            $LaboratoryResultedTest->addChild("Code", $lb['CODE']);
            $LaboratoryResultedTest->addChild("CodeDescTxt", $lb['CodeDescTxt']);
            $LaboratoryResult = $LaboratoryOrderAndResult->addChild("LaboratoryResult");
            $AnswerNumeric = $LaboratoryResult->addChild("AnswerNumeric");
            $AnswerNumeric->addChild("Value1", htmlspecialchars($lb['Value1']));
            $LaboratoryOrderAndResult->addChild("ResultedTestDate", $lb['VisitDate']);
            $LaboratoryReport->addChild("Clinician", htmlspecialchars($lb['Clinician']));
            $LaboratoryReport->addChild("ReportedBy", htmlspecialchars($lb['ReportedBy']));
            $LaboratoryReport->addChild("CheckedBy", htmlspecialchars($lb['checkedby']));
          }
    }

    public static function addAllRegimen($patient, $Condition,$connection) {
        
        $pharmacySql = PhamacyInformation::getPharmacy($patient['patient_id']);
        $pharmacyRes = mysqli_query($connection, $pharmacySql);
        $pharmacyResults = mysqli_fetch_all($pharmacyRes, MYSQLI_ASSOC);
        
        var_dump($pharmacyResults);
        exit;
        
        foreach ($pharmacyResults as $ph) {
            if(!empty($ph['drugname1'])){
                $Regimen = $Condition->addChild("Regimen");
                $Regimen->addChild("VisitID", $ph['VisitIDpharm']);
                $Regimen->addChild("VisitDate", $ph['visitdate']);
                $PrescribedRegimen = $Regimen->addChild("PrescribedRegimen");   
                $PrescribedRegimen->addChild("Code", PhamacyInformation::getPharmacy($ph['concept_id']));
                $PrescribedRegimen->addChild("CodeDescTxt", $ph['drugname1']);
                $Regimen->addChild("PrescribedRegimenTypeCode", "ART");
                $Regimen->addChild("PrescribedRegimenLineCode", $ph['PrescribedRegimenLineCode']);
                $Regimen->addChild("PrescribedRegimenDuration", $ph['regduration1']);
                $Regimen->addChild("PrescribedRegimenDispensedDate",$ph['visitdate']);
                $Regimen->addChild("DateRegimenStarted", $ph['DateRegimenStarted']);
                $Regimen->addChild("DateRegimenStartedDD", $ph['DateRegimenStartedDD']);
                $Regimen->addChild("DateRegimenStartedMM",$ph['DateRegimenStartedMM']);
                $Regimen->addChild("DateRegimenStartedYYYY", $ph['DateRegimenStartedYYYY']);
                $Regimen->addChild("PrescribedRegimenInitialIndicator", "false");
                $Regimen->addChild("PrescribedRegimenCurrentIndicator", "false");
                $Regimen->addChild("TypeOfPreviousExposureCode", "N");
                $Regimen->addChild("SubstitutionIndicator", $ph['SubstitutionIndicator']);
                $Regimen->addChild("SwitchIndicator", $ph['SwitchIndicator']);
            }
            
               if(!empty($ph['oidrug'])){
                $Regimen = $Condition->addChild("Regimen");
                $Regimen->addChild("VisitID", $ph['VisitIDpharm']);
                $Regimen->addChild("VisitDate", $ph['visitdate']);
                $PrescribedRegimen = $Regimen->addChild("PrescribedRegimen");   
                $PrescribedRegimen->addChild("Code", PhamacyInformation::getPharmacy($ph['concept_id']));
                $PrescribedRegimen->addChild("CodeDescTxt", $ph['oidrug']);
                $Regimen->addChild("PrescribedRegimenTypeCode", "CTX");
                $Regimen->addChild("PrescribedRegimenLineCode", $ph['PrescribedRegimenLineCode']);
                $Regimen->addChild("PrescribedRegimenDuration", $ph['regduration1']);
                $Regimen->addChild("PrescribedRegimenDispensedDate",$ph['visitdate']);
                $Regimen->addChild("DateRegimenStarted", $ph['DateRegimenStarted']);
                $Regimen->addChild("DateRegimenStartedDD", $ph['DateRegimenStartedDD']);
                $Regimen->addChild("DateRegimenStartedMM",$ph['DateRegimenStartedMM']);
                $Regimen->addChild("DateRegimenStartedYYYY", $ph['DateRegimenStartedYYYY']);
                $Regimen->addChild("PrescribedRegimenInitialIndicator", "false");
                $Regimen->addChild("PrescribedRegimenCurrentIndicator", "false");
                $Regimen->addChild("TypeOfPreviousExposureCode", "N");
                $Regimen->addChild("SubstitutionIndicator", $ph['SubstitutionIndicator']);
                $Regimen->addChild("SwitchIndicator", $ph['SwitchIndicator']);
            }
            
            if(!empty($ph['tbdrug'])){
                $Regimen = $Condition->addChild("Regimen");
                $Regimen->addChild("VisitID", $ph['VisitIDpharm']);
                $Regimen->addChild("VisitDate", $ph['visitdate']);
                $PrescribedRegimen = $Regimen->addChild("PrescribedRegimen");   
                $PrescribedRegimen->addChild("Code", PhamacyInformation::getPharmacy($ph['concept_id']));
                $PrescribedRegimen->addChild("CodeDescTxt", $ph['tbdrug']);
                $Regimen->addChild("PrescribedRegimenTypeCode", "TB");
                $Regimen->addChild("PrescribedRegimenLineCode", $ph['PrescribedRegimenLineCode']);
                $Regimen->addChild("PrescribedRegimenDuration", $ph['regduration1']);
                $Regimen->addChild("PrescribedRegimenDispensedDate",$ph['visitdate']);
                $Regimen->addChild("DateRegimenStarted", $ph['DateRegimenStarted']);
                $Regimen->addChild("DateRegimenStartedDD", $ph['DateRegimenStartedDD']);
                $Regimen->addChild("DateRegimenStartedMM",$ph['DateRegimenStartedMM']);
                $Regimen->addChild("DateRegimenStartedYYYY", $ph['DateRegimenStartedYYYY']);
                $Regimen->addChild("PrescribedRegimenInitialIndicator", "false");
                $Regimen->addChild("PrescribedRegimenCurrentIndicator", "false");
                $Regimen->addChild("TypeOfPreviousExposureCode", "N");
                $Regimen->addChild("SubstitutionIndicator", $ph['SubstitutionIndicator']);
                $Regimen->addChild("SwitchIndicator", $ph['SwitchIndicator']);
            }
        }
    }

}

?>