<?php

class PhamacyInformation {

    public static function getPharmacy($patientID = null) {

        return $sql = "SELECT  
                        pid1.identifier AS pepid,
                        DATE(encounter.encounter_datetime) AS visitdate,
                        CASE
                         WHEN 
                         (SELECT 
                           `name` 
                         FROM
                           concept_name 
                         WHERE `concept_id` = ob.value_coded 
                           AND `locale` = 'en' 
                           AND `locale_preferred` = 1 
                         GROUP BY concept_id) = 'DRV/r-DTG + 1-2 NRTIs' 
                         THEN 'AZT-3TC-NVP' 
                         ELSE 
                         (SELECT 
                           `name` 
                         FROM
                           concept_name 
                         WHERE `concept_id` = ob.value_coded 
                           AND `locale` = 'en' 
                           AND `locale_preferred` = 1 
                         GROUP BY concept_id) 
                       END AS drugname1,
                        (SELECT 
                           concept_id 
                         FROM
                           concept_name 
                         WHERE `concept_id` = ob.value_coded 
                           AND `locale` = 'en' 
                           AND `locale_preferred` = 1 
                         GROUP BY concept_id) AS concept_id,
                       (SELECT 
                         `value_numeric` 
                       FROM
                         obs 
                       WHERE `concept_id` = 159368 
                         AND `obs_group_id` = ob2.`obs_id` 
                         ) AS regduration1,
                     (SELECT 
                           `name` 
                         FROM
                           concept_name 
                         WHERE `concept_id` = ob3.value_coded 
                           AND `locale` = 'en' 
                           AND `locale_preferred` = 1 
                         GROUP BY concept_id) AS pregyn,
                         (SELECT 
                         `value_numeric` 
                       FROM
                         obs 
                       WHERE `concept_id` = 160856 
                         AND `obs_group_id` = ob2.`obs_id` 
                         ) AS quantitypres,
                         (SELECT 
                         `value_numeric` 
                       FROM
                         obs 
                       WHERE `concept_id` = 1443 
                         AND `obs_group_id` = ob2.`obs_id` 
                         ) AS quantitydisp,
                         (SELECT 
                           `name` 
                         FROM
                           concept_name 
                         WHERE `concept_id` = ob4.value_coded 
                           AND `locale` = 'en' 
                           AND `locale_preferred` = 1 
                         GROUP BY concept_id) AS frequency,
                         (SELECT 
                           `name` 
                         FROM
                           concept_name 
                         WHERE `concept_id` = ob5.value_coded 
                           AND `locale` = 'en' 
                           AND `locale_preferred` = 1 
                         GROUP BY concept_id) AS drugdose1,
                        GROUP_CONCAT(DISTINCT CONCAT((SELECT 
                           `name` 
                         FROM
                           concept_name 
                         WHERE `concept_id` = ob6.value_coded 
                           AND `locale` = 'en' 
                           AND `locale_preferred` = 1
                         GROUP BY concept_id))) AS oidrug,
                        GROUP_CONCAT(DISTINCT CONCAT((SELECT 
                             CASE  
                         WHEN `value_coded` = 166050 THEN '40mg'
                         WHEN `value_coded` = 166137 THEN '80mg'
                         WHEN `value_coded` = 165076 THEN '100mg'
                         WHEN `value_coded` = 165068 THEN '120mg'
                         WHEN `value_coded` = 165075 THEN '150mg'
                         WHEN `value_coded` = 165635 THEN '200mg'
                         WHEN `value_coded` = 165074 THEN '300mg'
                         WHEN `value_coded` = 165060 THEN '480mg'
                         WHEN `value_coded` = 165062 THEN '960mg'
                         END
                       FROM
                         obs 
                       WHERE `concept_id` = 165725 
                         AND `obs_group_id` = ob7.`obs_id` 
                         GROUP BY obs_group_id
                         ))) AS oiqty,
                        GROUP_CONCAT(DISTINCT CONCAT((SELECT 
                             `value_numeric`
                       FROM
                         obs 
                       WHERE `concept_id` = 159368 
                         AND `obs_group_id` = ob7.`obs_id` 
                         GROUP BY obs_group_id
                         ))) AS oiduration,
                         GROUP_CONCAT(DISTINCT CONCAT((SELECT 
                           `name` 
                         FROM
                           concept_name 
                         WHERE `concept_id` = ob8.value_coded 
                           AND `locale` = 'en' 
                           AND `locale_preferred` = 1
                         GROUP BY concept_id))) AS tbdrug,
                        GROUP_CONCAT(DISTINCT CONCAT((SELECT 
                             CASE  
                         WHEN `value_coded` = 162401 THEN 'Kit'
                         WHEN `value_coded` = 165075 THEN '150mg'
                         WHEN `value_coded` = 165062 THEN '960mg'
                         END
                       FROM
                         obs 
                       WHERE `concept_id` = 165725 
                         AND `obs_group_id` = ob9.`obs_id` 
                         GROUP BY obs_group_id
                         ))) AS tbqty,
                        GROUP_CONCAT(DISTINCT CONCAT((SELECT 
                             CASE  
                         WHEN `value_coded` = 165721 THEN '2 BD'
                         WHEN `value_coded` = 165722 THEN '3ce/week'
                         WHEN `value_coded` = 160870 THEN 'Four times daily'
                         WHEN `value_coded` = 160862 THEN 'Once daily'
                         WHEN `value_coded` = 160858 THEN 'Twice daily'
                         END
                       FROM
                         obs 
                       WHERE `concept_id` = 165723 
                         AND `obs_group_id` = ob9.`obs_id` 
                         GROUP BY obs_group_id
                         ))) AS tbduration
                       FROM  encounter 
                       LEFT JOIN patient ON(encounter.patient_id=patient.patient_id AND patient.voided=0 AND encounter.voided=0)
                       LEFT JOIN  obs ob ON(ob.encounter_id=encounter.encounter_id) AND ob.concept_id IN(164506,164513,165702,164507,164514)
                       LEFT JOIN  obs ob2 ON(ob2.encounter_id=encounter.encounter_id) AND ob2.concept_id IN(162240)
                       LEFT JOIN  obs ob3 ON(ob3.encounter_id=encounter.encounter_id) AND ob3.concept_id IN(165050)
                       LEFT JOIN  obs ob4 ON(ob4.encounter_id=encounter.encounter_id) AND ob4.concept_id IN(165723)
                       LEFT JOIN  obs ob5 ON(ob5.encounter_id=encounter.encounter_id) AND ob5.concept_id IN(165725)
                       LEFT JOIN  obs ob6 ON(ob6.encounter_id=encounter.encounter_id) AND ob6.concept_id IN(165727)
                       LEFT JOIN  obs ob7 ON(ob7.encounter_id=encounter.encounter_id) AND ob7.concept_id IN(165726)
                       LEFT JOIN  obs ob8 ON(ob8.encounter_id=encounter.encounter_id) AND ob8.concept_id IN(165304)  
                       LEFT JOIN  obs ob9 ON(ob9.encounter_id=encounter.encounter_id) AND ob9.concept_id IN(165728)
                       LEFT JOIN patient_identifier pid1 ON(pid1.patient_id=encounter.patient_id AND pid1.identifier_type=4)
                       LEFT JOIN form ON(encounter.form_id=form.form_id AND encounter.voided=0)
                      WHERE encounter.form_id IN(27) AND encounter.voided=0
                      AND pid1.identifier LIKE '%-%' 
                      AND LENGTH(pid1.identifier) > 9
                      AND patient.patient_id = ".$patientID."
                      GROUP BY patient.patient_id,encounter.encounter_id,DATE(encounter.encounter_datetime);";
    }
    
    public static function pharmacyDictionary($concepid){
        
        
        $drugCode = [
        '160124'=> "1a",//"AZT-3TC-EFV"
        '1652'=> "1b",//"AZT-3TC-NVP"
        '104565'=> "1c",//"TDF-FTC-EFV"
        '164854'=> "1d",//"TDF-FTC-NVP"
        '164505'=> "1e", //"TDF-3TC-EFV"
        '162565'=> "1f",//"TDF-3TC-NVP"
        '817'=> "1g", //"AZT-3TC-ABC" same as ABC/3TC/AZT
        '165522'=> "1h", //"AZT-3TC-TDF” same as TDF-3TC-AZT
        '162563'=> "1l", //"ABC-3TC-EFV"
        '165681'=> "1m", //"TDF-3TC-DTG"
        '165686'=> "1n", //"TDF-3TC-EFV400"
        '165682'=> "1o", //"TDF-FTC-DTG"
        '165687'=> "1p", //"TDF-FTC-EFV400"
        '165523'=> "2a", //"TDF-FTC-LPV/r"
        '162201'=> "2b",//"TDF-3TC-LPV/r"
        '165524'=> "2c", //"TDF-FTC-ATV/r"
        '164512'=> "2d",//"TDF-3TC-ATV/r"
        '162561'=> "2e",//"AZT-3TC-LPV/r"
        '164511'=> "2f",//"AZT-3TC-ATV/r"
        '165530'=> "2h",//"AZT-TDF-3TC-LPV/r"
        '165537'=> "2i",//"TDF-AZT-3TC-ATV/r"
        '165688'=> "3a ",//"DRV/r-DTG + 1-2 NRTIs"
        '160124'=> "4a",//"AZT-3TC-EFV"
        '1652'=> "4b",//"AZT-3TC-NVP"
        '162563'=> "4c",//"ABC-3TC-EFV"
        '162199'=> "4d",//"ABC-3TC-NVP"
        '817'=> "4e",//"AZT-3TC-ABC" Same as ABC-3TC-AZT
        '792'=> "4f",//"d4T-3TC-NVP"
        '166074'=> "4g", // Nelson Added Concept in NigeriaMRS and mapped it here as code already exist on NDR.
        '165691'=> "4h", //ABC-3TC-DTG
        '165693'=> "4i", //ABC-3TC-EFV400
        '162200'=> "4j", //ABC-3TC-LPV/r
        '165692'=> "4k", //ABC-FTC-DTG
        '165694'=> "4l", //ABC-FTC-EFV400
        '165690'=> "4m", //ABC-FTC-NVP
        '162561'=> "4n", //AZT-3TC-LPV/r
        '165695'=> "4o",//AZT-3TC-RAL
        '165681'=> "4p", //TDF-3TC-DTG
        '164505'=> "4q", //TDF-3TC-EFV// Add PrescribedRegimenCode and Code Description in NDR
        '165686'=> "4r", //TDF-3TC-EFV400
        '162565'=> "4s", // TDF-3TC-NVP
        '165682'=> "4t", // TDF-FTC-DTG
        '104565'=> "4u", //TDF-FTC-EFV
        '165687'=> "4v", // TDF-FTC-EFV400
        '164854'=> "4w",// TDF-FTC-NVP
        '162200'=> "5a",//"ABC-3TC-LPV/r"
        '162561'=> "5b",//"AZT-3TC-LPV/r"
        '162560'=> "5c",//"d4T-3TC-LPV/r"
        '165526'=> "5e",//"ABC-3TC-ddi"
        '165696'=> "5g",//ABC-3TC-RAL
        '164511'=> "5h", // AZT-3TC-ATV/r
        '165695'=> "5i",  //AZT-3TC-RAL
        '164512'=> "5j", //TDF-3TC-ATV/r
        '162201'=> "5k",//TDF-3TC-LPV/r
        '165698'=> "6a", //DRV/r + 2 NRTIs + 2 NNRTI
        '165700'=> "6b", //DRV/r +2NRTIs
        '165688'=> "6c", //DRV/r-DTG + 1-2 NRTIs
        '165701'=> "6d", //DRV/r-RAL + 1-2NRTIs
        '165697'=> "6e", //DTG+2 NRTIs
        '165699'=> "6f", //RAL + 2 NRTIs
        '86663'=> "9a",//"AZT" Concept ID didnt match. So'=> Changed concept id from 26 to 86663 as defined In NMRS
        '78643'=> "9b",//3TC Concept ID didnt match. So'=> changed ID from 27 to 78643 as defined In NMRS
        '80586'=> "9c",//"NVP" Concept ID didnt match. So'=> Changed concept id from 28 to 80586 as defined in NMRS
        '630'=> "9d",//"AZT-3TC" Concept ID didnt match. So'=> Changed concept id from 29 to 630 as defined on NMRS
        '165544'=> "9e",//"AZT-NVP" Concept ID didnt match. So'=> Changed concept id from 30 to 165544 as defined in NMRS
        '104567'=> "9f",//"FTC-TDF" Concept ID didnt match. So'=> Changed concept id from 31 to 104567 as defined in NMRS
        '161363'=> "9g",//"3TC-d4T"  Concept ID didnt match. So'=> Changed concept id from 32 to 104567 as defined in NMRS
        '166075'=> "9h", //"3TC-d4T" Changed the code desc from 3TC-4DT to 3TC-NVP and Created new concept for it on NMRS and replaced the initial Concpet Id of 33 to 166075
        '161364'=> "Unknown NDR Code APINSs Instance",//TDF/3TC Missing Drug Combination without NDR Code
        '165631'=> "Missing NDR Code from IHVN Instance", //Dolutegravir
        '1674'=> "Missing NDR Code frm IHVN Instance",//RIFAMPICIN/ISONIAZID/PYRAZINAMIDE/ETHAMBUTOL PROPHYLAXIS
        ];
        
        if (array_key_exists($concepid, $drugCode)) {
            return  $drugCode[$concepid];
        }
        return  "4n";     

    }

}

?>