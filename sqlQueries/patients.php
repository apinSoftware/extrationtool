<?php

class PatientInformation {

    public static function getPatients($id = null) {

        return $sql = "SELECT DISTINCT `patient_id`,
                        `identifier` AS IDNumber , 
                        `gender` AS PatientSexCode, 
                        `birthdate` AS PatientDateOfBirth, 
                        `dead` AS PatientDeceasedIndicator, 
                        `death_date`,
                        '' AS  PatientEducationLevelCode,
                        '' AS PatientOccupationCode,
                        '' AS PatientMaritalStatusCode,
                        '' AS ConditionCode,
                        '' AS WardVillage,
                        '' AS town,
                        '' AS state,
                        '' AS LGACode,
                        identifier AS HospitalNumber,
                        '' AS DateOfFirstReport,
                        '' AS DiagnosisDate,
                        '' AS PatientAge,
                        '' AS CareEntryPoint,
                        '' AS FirstConfirmedHIVTestDate,
                        '' AS FirstHIVTestMode,
                        '' AS WhereFirstHIVTest,
                        '' AS ReasonMedicallyEligible,
                        '' AS InitialAdherenceCounselingCompletedDate,
                        '' AS CODE,
                        '' AS CodeDescTxt,
                        '' AS CodeRegEnc,
                        '' AS CodeDescTxtRegEnc,
                        '' AS ARTStartDate,
                        '' AS WHOClinicalStageARTStart,
                        '' AS WeightAtARTStart,
                        '' AS FunctionalStatusStartART,
                        '' AS CD4AtStartOfART,
                        '' AS EnrolledInHIVCareDate,
                        '' AS PriorArt,
                        '' AS MedicallyEligibleDate,
                        '' AS InitialTBStatus 
                        FROM  `patient_identifier`  pid
                        JOIN `person` ON  person.`person_id` =  pid.`patient_id`
                        WHERE `preferred` = 1 AND `patient_id` = 9 limit 100 ";
    }

}

?>