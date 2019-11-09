<?php

class EncounterInformation {

    public static function getEncounters($patientID = null) {

        return $sql = "SELECT  
                        patient.patient_id,
                           pid1.identifier AS pepid,
                           DATE(encounter.encounter_datetime) AS visitdate,
                           ob.`value_numeric` AS weight,
                           ob2.`value_numeric` AS height,
                           CONCAT(ob3.`value_numeric`,'/',ob4.`value_numeric`) AS bp,
                           (SELECT 
                              `name` 
                            FROM
                              concept_name 
                            WHERE `concept_id` = ob5.value_coded 
                              AND `locale` = 'en' 
                              AND `locale_preferred` = 1 
                            GROUP BY concept_id) AS tbstatus,
                            CASE
                            WHEN 
                            (SELECT 
                              `name` 
                            FROM
                              concept_name 
                            WHERE `concept_id` = ob6.value_coded 
                              AND `locale` = 'en' 
                              AND `locale_preferred` = 1 
                            GROUP BY concept_id) = 'DRV/r-DTG + 1-2 NRTIs' 
                            THEN 'AZT-3TC-NVP' 
                            ELSE 
                            (SELECT 
                              `name` 
                            FROM
                              concept_name 
                            WHERE `concept_id` = ob6.value_coded 
                              AND `locale` = 'en' 
                              AND `locale_preferred` = 1 
                            GROUP BY concept_id) 
                          END AS regimen,
                          DATE(ob7.`value_datetime`) AS nextapptdate
                          FROM  encounter 
                          LEFT JOIN patient ON(encounter.patient_id=patient.patient_id AND patient.voided=0 AND encounter.voided=0)
                          LEFT JOIN  obs ob ON(ob.encounter_id=encounter.encounter_id) AND ob.concept_id IN(5089)
                          LEFT JOIN  obs ob2 ON(ob2.encounter_id=encounter.encounter_id) AND ob2.concept_id IN(5090)
                          LEFT JOIN  obs ob3 ON(ob3.encounter_id=encounter.encounter_id) AND ob3.concept_id IN(5085)
                          LEFT JOIN  obs ob4 ON(ob4.encounter_id=encounter.encounter_id) AND ob4.concept_id IN(5086)
                          LEFT JOIN  obs ob5 ON(ob5.encounter_id=encounter.encounter_id) AND ob5.concept_id IN(1659)
                          LEFT JOIN  obs ob6 ON(ob6.encounter_id=encounter.encounter_id) AND ob6.concept_id IN(164506,164513,165702,164507,164514,165703)
                          LEFT JOIN  obs ob7 ON(ob7.encounter_id=encounter.encounter_id) AND ob7.concept_id IN(5096)
                          LEFT JOIN patient_identifier pid1 ON(pid1.patient_id=encounter.patient_id AND pid1.identifier_type=4)
                          LEFT JOIN form ON(encounter.form_id=form.form_id AND encounter.voided=0)
                         WHERE encounter.form_id IN(14) AND encounter.voided=0
                         AND pid1.identifier LIKE '%-%' 
                          AND LENGTH(pid1.identifier) > 9
                         GROUP BY patient.patient_id,encounter.encounter_id,DATE(encounter.encounter_datetime);";
    }

    public static function ecncounterDictionary($concepid) {


        $ecointerCode = [
        ];
    }

}

?>