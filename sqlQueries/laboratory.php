<?php

class Laboratorynformation {

    public static function getLaboratory($patientID = null) {

        return $sql = "
                    SELECT  
                       pid1.identifier AS pepid,
                       DATE(encounter.encounter_datetime) AS visitdate,
                       'Viral Load' AS 'tests',
                       ob.value_numeric AS  'results',
                       DATE(MAX(IF(obs.concept_id= 162078,  obs.value_datetime, NULL))) AS `orderdate` ,  
                       DATE(MAX(IF(obs.concept_id= 165414, obs.value_datetime, NULL))) AS `reportdate`,
                       DATE(MAX(IF(obs.concept_id= 164984,  obs.value_datetime, NULL))) AS `checkdate` 
                      FROM  encounter 
                      LEFT JOIN patient ON(encounter.patient_id=patient.patient_id AND patient.voided=0 AND encounter.voided=0)
                      LEFT JOIN  obs ON(obs.encounter_id=encounter.encounter_id)
                      LEFT JOIN  obs ob ON(ob.encounter_id=encounter.encounter_id)
                      LEFT JOIN patient_identifier pid1 ON(pid1.patient_id=encounter.patient_id AND pid1.identifier_type=4)
                      LEFT JOIN form ON(encounter.form_id=form.form_id AND encounter.voided=0)
                      LEFT JOIN users ON(encounter.creator=users.user_id)
                      LEFT JOIN concept_name cn1 ON(cn1.concept_id=obs.value_coded AND cn1.locale='en' AND cn1.locale_preferred=1)
                     WHERE encounter.form_id IN(21) AND encounter.voided=0
                     AND pid1.identifier LIKE '%-%' 
                      AND LENGTH(pid1.identifier) > 9
                      AND ob.concept_id =856
                      GROUP BY patient.patient_id,encounter.encounter_id,DATE(encounter.encounter_datetime)
                    UNION 
                    SELECT  
                       pid1.identifier AS CD4_PepfarID,
                       DATE(encounter.encounter_datetime) AS CD4_VisitDate,
                       'CD4' AS 'tests',
                       ob.value_numeric AS  CD4_results',
                       DATE(MAX(IF(obs.concept_id= 162078,  obs.value_datetime, NULL))) AS `CD4_DateOrdered` ,  
                       DATE(MAX(IF(obs.concept_id= 165414, obs.value_datetime, NULL))) AS `CD4_DateReported`,
                       DATE(MAX(IF(obs.concept_id= 164984,  obs.value_datetime, NULL))) AS `CD4_DateChecked` 
                      FROM  encounter 
                      LEFT JOIN patient ON(encounter.patient_id=patient.patient_id AND patient.voided=0 AND encounter.voided=0)
                      LEFT JOIN  obs ON(obs.encounter_id=encounter.encounter_id)
                      LEFT JOIN  obs ob ON(ob.encounter_id=encounter.encounter_id)
                      LEFT JOIN patient_identifier pid1 ON(pid1.patient_id=encounter.patient_id AND pid1.identifier_type=4)
                      LEFT JOIN form ON(encounter.form_id=form.form_id AND encounter.voided=0)
                      LEFT JOIN users ON(encounter.creator=users.user_id)
                      LEFT JOIN concept_name cn1 ON(cn1.concept_id=obs.value_coded AND cn1.locale='en' AND cn1.locale_preferred=1)
                     WHERE encounter.form_id IN(21) AND encounter.voided=0
                     AND pid1.identifier LIKE '%-%' 
                      AND LENGTH(pid1.identifier) > 9
                      AND ob.concept_id =5497
                      GROUP BY patient.patient_id,encounter.encounter_id,DATE(encounter.encounter_datetime)
                      UNION 
                    SELECT  
                       pid1.identifier AS WBC_PepfarID,
                       DATE(encounter.encounter_datetime) AS WBC_VisitDate,
                       'WBC' AS 'tests',
                       ob.value_numeric AS  'WBC_results',
                       DATE(MAX(IF(obs.concept_id= 162078,  obs.value_datetime, NULL))) AS `WBC_DateOrdered` ,  
                       DATE(MAX(IF(obs.concept_id= 165414, obs.value_datetime, NULL))) AS `WBC_DateReported`,
                       DATE(MAX(IF(obs.concept_id= 164984,  obs.value_datetime, NULL))) AS `WBC_DateChecked` 
                      FROM  encounter 
                      LEFT JOIN patient ON(encounter.patient_id=patient.patient_id AND patient.voided=0 AND encounter.voided=0)
                      LEFT JOIN  obs ON(obs.encounter_id=encounter.encounter_id)
                      LEFT JOIN  obs ob ON(ob.encounter_id=encounter.encounter_id)
                      LEFT JOIN patient_identifier pid1 ON(pid1.patient_id=encounter.patient_id AND pid1.identifier_type=4)
                      LEFT JOIN form ON(encounter.form_id=form.form_id AND encounter.voided=0)
                      LEFT JOIN users ON(encounter.creator=users.user_id)
                      LEFT JOIN concept_name cn1 ON(cn1.concept_id=obs.value_coded AND cn1.locale='en' AND cn1.locale_preferred=1)
                     WHERE encounter.form_id IN(21) AND encounter.voided=0
                     AND pid1.identifier LIKE '%-%' 
                      AND LENGTH(pid1.identifier) > 9
                      AND ob.concept_id =678
                      GROUP BY patient.patient_id,encounter.encounter_id,DATE(encounter.encounter_datetime)
                      UNION 
                    SELECT  
                       pid1.identifier AS Lymphocytes_PepfarID,
                       DATE(encounter.encounter_datetime) AS Lymphocytes_VisitDate,
                       'Lymphocytes' AS 'tests',
                       ob.value_numeric AS  'Lymphocytes_results',
                       DATE(MAX(IF(obs.concept_id= 162078,  obs.value_datetime, NULL))) AS `Lymphocytes_DateOrdered` ,  
                       DATE(MAX(IF(obs.concept_id= 165414, obs.value_datetime, NULL))) AS `Lymphocytes_DateReported`,
                       DATE(MAX(IF(obs.concept_id= 164984,  obs.value_datetime, NULL))) AS `Lymphocytes_DateChecked` 
                      FROM  encounter 
                      LEFT JOIN patient ON(encounter.patient_id=patient.patient_id AND patient.voided=0 AND encounter.voided=0)
                      LEFT JOIN  obs ON(obs.encounter_id=encounter.encounter_id)
                      LEFT JOIN  obs ob ON(ob.encounter_id=encounter.encounter_id)
                      LEFT JOIN patient_identifier pid1 ON(pid1.patient_id=encounter.patient_id AND pid1.identifier_type=4)
                      LEFT JOIN form ON(encounter.form_id=form.form_id AND encounter.voided=0)
                      LEFT JOIN users ON(encounter.creator=users.user_id)
                      LEFT JOIN concept_name cn1 ON(cn1.concept_id=obs.value_coded AND cn1.locale='en' AND cn1.locale_preferred=1)
                     WHERE encounter.form_id IN(21) AND encounter.voided=0
                     AND pid1.identifier LIKE '%-%' 
                      AND LENGTH(pid1.identifier) > 9
                      AND ob.concept_id =1319
                      GROUP BY patient.patient_id,encounter.encounter_id,DATE(encounter.encounter_datetime)
                    UNION 
                    SELECT  
                       pid1.identifier AS Monocytes_PepfarID,
                       DATE(encounter.encounter_datetime) AS Monocytes_VisitDate,
                       'Monocytes' AS 'tests',
                       ob.value_numeric AS  'Monocytes_results',
                       DATE(MAX(IF(obs.concept_id= 162078,  obs.value_datetime, NULL))) AS `Monocytes_DateOrdered` ,  
                       DATE(MAX(IF(obs.concept_id= 165414, obs.value_datetime, NULL))) AS `Monocytes_DateReported`,
                       DATE(MAX(IF(obs.concept_id= 164984,  obs.value_datetime, NULL))) AS `Monocytes_DateChecked` 
                      FROM  encounter 
                      LEFT JOIN patient ON(encounter.patient_id=patient.patient_id AND patient.voided=0 AND encounter.voided=0)
                      LEFT JOIN  obs ON(obs.encounter_id=encounter.encounter_id)
                      LEFT JOIN  obs ob ON(ob.encounter_id=encounter.encounter_id)
                      LEFT JOIN patient_identifier pid1 ON(pid1.patient_id=encounter.patient_id AND pid1.identifier_type=4)
                      LEFT JOIN form ON(encounter.form_id=form.form_id AND encounter.voided=0)
                      LEFT JOIN users ON(encounter.creator=users.user_id)
                      LEFT JOIN concept_name cn1 ON(cn1.concept_id=obs.value_coded AND cn1.locale='en' AND cn1.locale_preferred=1)
                     WHERE encounter.form_id IN(21) AND encounter.voided=0
                     AND pid1.identifier LIKE '%-%' 
                      AND LENGTH(pid1.identifier) > 9
                      AND ob.concept_id =1023
                      GROUP BY patient.patient_id,encounter.encounter_id,DATE(encounter.encounter_datetime)
                    UNION 
                    SELECT  
                       pid1.identifier AS PCVHb_PepfarID,
                       DATE(encounter.encounter_datetime) AS PCVHb_VisitDate,
                       'PCV/Hb' AS 'tests',
                       ob.value_numeric AS  'PCVHb_results',
                       DATE(MAX(IF(obs.concept_id= 162078,  obs.value_datetime, NULL))) AS `PCVHb_DateOrdered` ,  
                       DATE(MAX(IF(obs.concept_id= 165414, obs.value_datetime, NULL))) AS `PCVHb_DateReported`,
                       DATE(MAX(IF(obs.concept_id= 164984,  obs.value_datetime, NULL))) AS `PCVHb_DateChecked` 
                      FROM  encounter 
                      LEFT JOIN patient ON(encounter.patient_id=patient.patient_id AND patient.voided=0 AND encounter.voided=0)
                      LEFT JOIN  obs ON(obs.encounter_id=encounter.encounter_id)
                      LEFT JOIN  obs ob ON(ob.encounter_id=encounter.encounter_id)
                      LEFT JOIN patient_identifier pid1 ON(pid1.patient_id=encounter.patient_id AND pid1.identifier_type=4)
                      LEFT JOIN form ON(encounter.form_id=form.form_id AND encounter.voided=0)
                      LEFT JOIN users ON(encounter.creator=users.user_id)
                      LEFT JOIN concept_name cn1 ON(cn1.concept_id=obs.value_coded AND cn1.locale='en' AND cn1.locale_preferred=1)
                     WHERE encounter.form_id IN(21) AND encounter.voided=0
                     AND pid1.identifier LIKE '%-%' 
                      AND LENGTH(pid1.identifier) > 9
                      AND ob.concept_id IN(1015,165395)
                      GROUP BY patient.patient_id,encounter.encounter_id,DATE(encounter.encounter_datetime)
                    UNION 
                    SELECT  
                       pid1.identifier AS Platelets_PepfarID,
                       DATE(encounter.encounter_datetime) AS Platelets_VisitDate,
                       'Platelets' AS 'tests',
                       ob.value_numeric AS  'Platelets_results',
                       DATE(MAX(IF(obs.concept_id= 162078,  obs.value_datetime, NULL))) AS `Platelets_DateOrdered` ,  
                       DATE(MAX(IF(obs.concept_id= 165414, obs.value_datetime, NULL))) AS `Platelets_DateReported`,
                       DATE(MAX(IF(obs.concept_id= 164984,  obs.value_datetime, NULL))) AS `Platelets_DateChecked` 
                      FROM  encounter 
                      LEFT JOIN patient ON(encounter.patient_id=patient.patient_id AND patient.voided=0 AND encounter.voided=0)
                      LEFT JOIN  obs ON(obs.encounter_id=encounter.encounter_id)
                      LEFT JOIN  obs ob ON(ob.encounter_id=encounter.encounter_id)
                      LEFT JOIN patient_identifier pid1 ON(pid1.patient_id=encounter.patient_id AND pid1.identifier_type=4)
                      LEFT JOIN form ON(encounter.form_id=form.form_id AND encounter.voided=0)
                      LEFT JOIN users ON(encounter.creator=users.user_id)
                      LEFT JOIN concept_name cn1 ON(cn1.concept_id=obs.value_coded AND cn1.locale='en' AND cn1.locale_preferred=1)
                     WHERE encounter.form_id IN(21) AND encounter.voided=0
                     AND pid1.identifier LIKE '%-%' 
                      AND LENGTH(pid1.identifier) > 9
                      AND ob.concept_id =729
                      GROUP BY patient.patient_id,encounter.encounter_id,DATE(encounter.encounter_datetime)
                    UNION 
                    SELECT  
                       pid1.identifier AS Creatinine_PepfarID,
                       DATE(encounter.encounter_datetime) AS Creatinine_VisitDate,
                       'Creatinine' AS 'tests',
                       ob.value_numeric AS  'Creatinine_results',
                       DATE(MAX(IF(obs.concept_id= 162078,  obs.value_datetime, NULL))) AS `Creatinine_DateOrdered` ,  
                       DATE(MAX(IF(obs.concept_id= 165414, obs.value_datetime, NULL))) AS `Creatinine_DateReported`,
                       DATE(MAX(IF(obs.concept_id= 164984,  obs.value_datetime, NULL))) AS `Creatinine_DateChecked` 
                      FROM  encounter 
                      LEFT JOIN patient ON(encounter.patient_id=patient.patient_id AND patient.voided=0 AND encounter.voided=0)
                      LEFT JOIN  obs ON(obs.encounter_id=encounter.encounter_id)
                      LEFT JOIN  obs ob ON(ob.encounter_id=encounter.encounter_id)
                      LEFT JOIN patient_identifier pid1 ON(pid1.patient_id=encounter.patient_id AND pid1.identifier_type=4)
                      LEFT JOIN form ON(encounter.form_id=form.form_id AND encounter.voided=0)
                      LEFT JOIN users ON(encounter.creator=users.user_id)
                      LEFT JOIN concept_name cn1 ON(cn1.concept_id=obs.value_coded AND cn1.locale='en' AND cn1.locale_preferred=1)
                     WHERE encounter.form_id IN(21) AND encounter.voided=0
                     AND pid1.identifier LIKE '%-%' 
                      AND LENGTH(pid1.identifier) > 9
                      AND ob.concept_id =164364
                      GROUP BY patient.patient_id,encounter.encounter_id,DATE(encounter.encounter_datetime)
                    UNION 
                    SELECT  
                       pid1.identifier AS ALTSGPT_PepfarID,
                       DATE(encounter.encounter_datetime) AS ALTSGPT_VisitDate,
                       'ALT/SGPT' AS 'tests',
                       ob.value_numeric AS  'ALTSGPT_results',
                       DATE(MAX(IF(obs.concept_id= 162078,  obs.value_datetime, NULL))) AS `ALTSGPT_DateOrdered` ,  
                       DATE(MAX(IF(obs.concept_id= 165414, obs.value_datetime, NULL))) AS `ALTSGPT_DateReported`,
                       DATE(MAX(IF(obs.concept_id= 164984,  obs.value_datetime, NULL))) AS `ALTSGPT_DateChecked` 
                      FROM  encounter 
                      LEFT JOIN patient ON(encounter.patient_id=patient.patient_id AND patient.voided=0 AND encounter.voided=0)
                      LEFT JOIN  obs ON(obs.encounter_id=encounter.encounter_id)
                      LEFT JOIN  obs ob ON(ob.encounter_id=encounter.encounter_id)
                      LEFT JOIN patient_identifier pid1 ON(pid1.patient_id=encounter.patient_id AND pid1.identifier_type=4)
                      LEFT JOIN form ON(encounter.form_id=form.form_id AND encounter.voided=0)
                      LEFT JOIN users ON(encounter.creator=users.user_id)
                      LEFT JOIN concept_name cn1 ON(cn1.concept_id=obs.value_coded AND cn1.locale='en' AND cn1.locale_preferred=1)
                     WHERE encounter.form_id IN(21) AND encounter.voided=0
                     AND pid1.identifier LIKE '%-%' 
                      AND LENGTH(pid1.identifier) > 9
                      AND ob.concept_id =654
                      GROUP BY patient.patient_id,encounter.encounter_id,DATE(encounter.encounter_datetime)
                    UNION 
                    SELECT  
                       pid1.identifier AS Na_PepfarID,
                       DATE(encounter.encounter_datetime) AS Na_VisitDate,
                       'Na+' AS 'tests',
                       ob.value_numeric AS  'Na_results',
                       DATE(MAX(IF(obs.concept_id= 162078,  obs.value_datetime, NULL))) AS `Na_DateOrdered` ,  
                       DATE(MAX(IF(obs.concept_id= 165414, obs.value_datetime, NULL))) AS `Na_DateReported`,
                       DATE(MAX(IF(obs.concept_id= 164984,  obs.value_datetime, NULL))) AS `Na_DateChecked` 
                      FROM  encounter 
                      LEFT JOIN patient ON(encounter.patient_id=patient.patient_id AND patient.voided=0 AND encounter.voided=0)
                      LEFT JOIN  obs ON(obs.encounter_id=encounter.encounter_id)
                      LEFT JOIN  obs ob ON(ob.encounter_id=encounter.encounter_id)
                      LEFT JOIN patient_identifier pid1 ON(pid1.patient_id=encounter.patient_id AND pid1.identifier_type=4)
                      LEFT JOIN form ON(encounter.form_id=form.form_id AND encounter.voided=0)
                      LEFT JOIN users ON(encounter.creator=users.user_id)
                      LEFT JOIN concept_name cn1 ON(cn1.concept_id=obs.value_coded AND cn1.locale='en' AND cn1.locale_preferred=1)
                     WHERE encounter.form_id IN(21) AND encounter.voided=0
                     AND pid1.identifier LIKE '%-%' 
                      AND LENGTH(pid1.identifier) > 9
                      AND ob.concept_id =1132
                      GROUP BY patient.patient_id,encounter.encounter_id,DATE(encounter.encounter_datetime)
                    UNION 
                    SELECT  
                       pid1.identifier AS K_PepfarID,
                       DATE(encounter.encounter_datetime) AS K_VisitDate,
                       'K+' AS 'tests',
                       ob.value_numeric AS  'K_results',
                       DATE(MAX(IF(obs.concept_id= 162078,  obs.value_datetime, NULL))) AS `K_DateOrdered` ,  
                       DATE(MAX(IF(obs.concept_id= 165414, obs.value_datetime, NULL))) AS `K_DateReported`,
                       DATE(MAX(IF(obs.concept_id= 164984,  obs.value_datetime, NULL))) AS `K_DateChecked` 
                      FROM  encounter 
                      LEFT JOIN patient ON(encounter.patient_id=patient.patient_id AND patient.voided=0 AND encounter.voided=0)
                      LEFT JOIN  obs ON(obs.encounter_id=encounter.encounter_id)
                      LEFT JOIN  obs ob ON(ob.encounter_id=encounter.encounter_id)
                      LEFT JOIN patient_identifier pid1 ON(pid1.patient_id=encounter.patient_id AND pid1.identifier_type=4)
                      LEFT JOIN form ON(encounter.form_id=form.form_id AND encounter.voided=0)
                      LEFT JOIN users ON(encounter.creator=users.user_id)
                      LEFT JOIN concept_name cn1 ON(cn1.concept_id=obs.value_coded AND cn1.locale='en' AND cn1.locale_preferred=1)
                     WHERE encounter.form_id IN(21) AND encounter.voided=0
                     AND pid1.identifier LIKE '%-%' 
                      AND LENGTH(pid1.identifier) > 9
                      AND ob.concept_id =1133
                      GROUP BY patient.patient_id,encounter.encounter_id,DATE(encounter.encounter_datetime)
                    UNION 
                    SELECT  
                       pid1.identifier AS FastingGlucose_PepfarID,
                       DATE(encounter.encounter_datetime) AS FastingGlucose_VisitDate,
                       'Fasting Glucose' AS 'tests',
                       ob.value_numeric AS  'FastingGlucose_results',
                       DATE(MAX(IF(obs.concept_id= 162078,  obs.value_datetime, NULL))) AS `FastingGlucose_DateOrdered` ,  
                       DATE(MAX(IF(obs.concept_id= 165414, obs.value_datetime, NULL))) AS `FastingGlucose_DateReported`,
                       DATE(MAX(IF(obs.concept_id= 164984,  obs.value_datetime, NULL))) AS `FastingGlucose_DateChecked` 
                      FROM  encounter 
                      LEFT JOIN patient ON(encounter.patient_id=patient.patient_id AND patient.voided=0 AND encounter.voided=0)
                      LEFT JOIN  obs ON(obs.encounter_id=encounter.encounter_id)
                      LEFT JOIN  obs ob ON(ob.encounter_id=encounter.encounter_id)
                      LEFT JOIN patient_identifier pid1 ON(pid1.patient_id=encounter.patient_id AND pid1.identifier_type=4)
                      LEFT JOIN form ON(encounter.form_id=form.form_id AND encounter.voided=0)
                      LEFT JOIN users ON(encounter.creator=users.user_id)
                      LEFT JOIN concept_name cn1 ON(cn1.concept_id=obs.value_coded AND cn1.locale='en' AND cn1.locale_preferred=1)
                     WHERE encounter.form_id IN(21) AND encounter.voided=0
                     AND pid1.identifier LIKE '%-%' 
                      AND LENGTH(pid1.identifier) > 9
                      AND ob.concept_id =160053
                      GROUP BY patient.patient_id,encounter.encounter_id,DATE(encounter.encounter_datetime)
                    UNION 
                    SELECT  
                       pid1.identifier AS TotalCholesterol_PepfarID,
                       DATE(encounter.encounter_datetime) AS TotalCholesterol_VisitDate,
                       'Total Cholesterol' AS 'tests',
                       ob.value_numeric AS  'TotalCholesterol_results',
                       DATE(MAX(IF(obs.concept_id= 162078,  obs.value_datetime, NULL))) AS `TotalCholesterol_DateOrdered` ,  
                       DATE(MAX(IF(obs.concept_id= 165414, obs.value_datetime, NULL))) AS `TotalCholesterol_DateReported`,
                       DATE(MAX(IF(obs.concept_id= 164984,  obs.value_datetime, NULL))) AS `TotalCholesterol_DateChecked` 
                      FROM  encounter 
                      LEFT JOIN patient ON(encounter.patient_id=patient.patient_id AND patient.voided=0 AND encounter.voided=0)
                      LEFT JOIN  obs ON(obs.encounter_id=encounter.encounter_id)
                      LEFT JOIN  obs ob ON(ob.encounter_id=encounter.encounter_id)
                      LEFT JOIN patient_identifier pid1 ON(pid1.patient_id=encounter.patient_id AND pid1.identifier_type=4)
                      LEFT JOIN form ON(encounter.form_id=form.form_id AND encounter.voided=0)
                      LEFT JOIN users ON(encounter.creator=users.user_id)
                      LEFT JOIN concept_name cn1 ON(cn1.concept_id=obs.value_coded AND cn1.locale='en' AND cn1.locale_preferred=1)
                     WHERE encounter.form_id IN(21) AND encounter.voided=0
                     AND pid1.identifier LIKE '%-%' 
                      AND LENGTH(pid1.identifier) > 9
                      AND ob.concept_id =1006
                      GROUP BY patient.patient_id,encounter.encounter_id,DATE(encounter.encounter_datetime)
                    UNION 
                    SELECT  
                       pid1.identifier AS ASTSGOT_PepfarID,
                       DATE(encounter.encounter_datetime) AS ASTSGOT_VisitDate,
                       'AST/SGOT' AS 'tests',
                       ob.value_numeric AS  'ASTSGOT_results',
                       DATE(MAX(IF(obs.concept_id= 162078,  obs.value_datetime, NULL))) AS `ASTSGOT_DateOrdered` ,  
                       DATE(MAX(IF(obs.concept_id= 165414, obs.value_datetime, NULL))) AS `ASTSGOT_DateReported`,
                       DATE(MAX(IF(obs.concept_id= 164984,  obs.value_datetime, NULL))) AS `ASTSGOT_DateChecked` 
                      FROM  encounter 
                      LEFT JOIN patient ON(encounter.patient_id=patient.patient_id AND patient.voided=0 AND encounter.voided=0)
                      LEFT JOIN  obs ON(obs.encounter_id=encounter.encounter_id)
                      LEFT JOIN  obs ob ON(ob.encounter_id=encounter.encounter_id)
                      LEFT JOIN patient_identifier pid1 ON(pid1.patient_id=encounter.patient_id AND pid1.identifier_type=4)
                      LEFT JOIN form ON(encounter.form_id=form.form_id AND encounter.voided=0)
                      LEFT JOIN users ON(encounter.creator=users.user_id)
                      LEFT JOIN concept_name cn1 ON(cn1.concept_id=obs.value_coded AND cn1.locale='en' AND cn1.locale_preferred=1)
                     WHERE encounter.form_id IN(21) AND encounter.voided=0
                     AND pid1.identifier LIKE '%-%' 
                      AND LENGTH(pid1.identifier) > 9
                      AND ob.concept_id =653
                      GROUP BY patient.patient_id,encounter.encounter_id,DATE(encounter.encounter_datetime)
                    UNION 
                    SELECT  
                       pid1.identifier AS TotalBilirubin_PepfarID,
                       DATE(encounter.encounter_datetime) AS TotalBilirubin_VisitDate,
                       'Total Bilirubin' AS 'tests',
                       ob.value_numeric AS  'TotalBilirubin_results',
                       DATE(MAX(IF(obs.concept_id= 162078,  obs.value_datetime, NULL))) AS `TotalBilirubin_DateOrdered` ,  
                       DATE(MAX(IF(obs.concept_id= 165414, obs.value_datetime, NULL))) AS `TotalBilirubin_DateReported`,
                       DATE(MAX(IF(obs.concept_id= 164984,  obs.value_datetime, NULL))) AS `TotalBilirubin_DateChecked` 
                      FROM  encounter 
                      LEFT JOIN patient ON(encounter.patient_id=patient.patient_id AND patient.voided=0 AND encounter.voided=0)
                      LEFT JOIN  obs ON(obs.encounter_id=encounter.encounter_id)
                      LEFT JOIN  obs ob ON(ob.encounter_id=encounter.encounter_id)
                      LEFT JOIN patient_identifier pid1 ON(pid1.patient_id=encounter.patient_id AND pid1.identifier_type=4)
                      LEFT JOIN form ON(encounter.form_id=form.form_id AND encounter.voided=0)
                      LEFT JOIN users ON(encounter.creator=users.user_id)
                      LEFT JOIN concept_name cn1 ON(cn1.concept_id=obs.value_coded AND cn1.locale='en' AND cn1.locale_preferred=1)
                     WHERE encounter.form_id IN(21) AND encounter.voided=0
                     AND pid1.identifier LIKE '%-%' 
                      AND LENGTH(pid1.identifier) > 9
                      AND ob.concept_id =655
                      GROUP BY patient.patient_id,encounter.encounter_id,DATE(encounter.encounter_datetime)
                    UNION 
                    SELECT  
                       pid1.identifier AS CD4Percent_PepfarID,
                       DATE(encounter.encounter_datetime) AS CD4Percent_VisitDate,
                       'CD4%' AS 'tests',
                       ob.value_numeric AS  'CD4Percent_results',
                       DATE(MAX(IF(obs.concept_id= 162078,  obs.value_datetime, NULL))) AS `CD4Percent_DateOrdered` ,  
                       DATE(MAX(IF(obs.concept_id= 165414, obs.value_datetime, NULL))) AS `CD4Percent_DateReported`,
                       DATE(MAX(IF(obs.concept_id= 164984,  obs.value_datetime, NULL))) AS `CD4Percent_DateChecked` 
                      FROM  encounter 
                      LEFT JOIN patient ON(encounter.patient_id=patient.patient_id AND patient.voided=0 AND encounter.voided=0)
                      LEFT JOIN  obs ON(obs.encounter_id=encounter.encounter_id)
                      LEFT JOIN  obs ob ON(ob.encounter_id=encounter.encounter_id)
                      LEFT JOIN patient_identifier pid1 ON(pid1.patient_id=encounter.patient_id AND pid1.identifier_type=4)
                      LEFT JOIN form ON(encounter.form_id=form.form_id AND encounter.voided=0)
                      LEFT JOIN users ON(encounter.creator=users.user_id)
                      LEFT JOIN concept_name cn1 ON(cn1.concept_id=obs.value_coded AND cn1.locale='en' AND cn1.locale_preferred=1)
                     WHERE encounter.form_id IN(21) AND encounter.voided=0
                     AND pid1.identifier LIKE '%-%' 
                      AND LENGTH(pid1.identifier) > 9
                      AND ob.concept_id =730
                      GROUP BY patient.patient_id,encounter.encounter_id,DATE(encounter.encounter_datetime)
                    UNION 
                    SELECT  
                       pid1.identifier AS Polymorph_PepfarID,
                       DATE(encounter.encounter_datetime) AS Polymorph_VisitDate,
                       'Polymorph' AS 'tests',
                       ob.value_numeric AS  'Polymorph_results',
                       DATE(MAX(IF(obs.concept_id= 162078,  obs.value_datetime, NULL))) AS `Polymorph_DateOrdered` ,  
                       DATE(MAX(IF(obs.concept_id= 165414, obs.value_datetime, NULL))) AS `Polymorph_DateReported`,
                       DATE(MAX(IF(obs.concept_id= 164984,  obs.value_datetime, NULL))) AS `Polymorph_DateChecked` 
                      FROM  encounter 
                      LEFT JOIN patient ON(encounter.patient_id=patient.patient_id AND patient.voided=0 AND encounter.voided=0)
                      LEFT JOIN  obs ON(obs.encounter_id=encounter.encounter_id)
                      LEFT JOIN  obs ob ON(ob.encounter_id=encounter.encounter_id)
                      LEFT JOIN patient_identifier pid1 ON(pid1.patient_id=encounter.patient_id AND pid1.identifier_type=4)
                      LEFT JOIN form ON(encounter.form_id=form.form_id AND encounter.voided=0)
                      LEFT JOIN users ON(encounter.creator=users.user_id)
                      LEFT JOIN concept_name cn1 ON(cn1.concept_id=obs.value_coded AND cn1.locale='en' AND cn1.locale_preferred=1)
                     WHERE encounter.form_id IN(21) AND encounter.voided=0
                     AND pid1.identifier LIKE '%-%' 
                      AND LENGTH(pid1.identifier) > 9
                      AND ob.concept_id =1022
                      GROUP BY patient.patient_id,encounter.encounter_id,DATE(encounter.encounter_datetime)
                    UNION 
                    SELECT  
                       pid1.identifier AS Eosinophils_PepfarID,
                       DATE(encounter.encounter_datetime) AS Polymorph_VisitDate,
                       'Eosinophils' AS 'tests',
                       ob.value_numeric AS  'Polymorph_results',
                       DATE(MAX(IF(obs.concept_id= 162078,  obs.value_datetime, NULL))) AS `Polymorph_DateOrdered` ,  
                       DATE(MAX(IF(obs.concept_id= 165414, obs.value_datetime, NULL))) AS `Polymorph_DateReported`,
                       DATE(MAX(IF(obs.concept_id= 164984,  obs.value_datetime, NULL))) AS `Polymorph_DateChecked` 
                      FROM  encounter 
                      LEFT JOIN patient ON(encounter.patient_id=patient.patient_id AND patient.voided=0 AND encounter.voided=0)
                      LEFT JOIN  obs ON(obs.encounter_id=encounter.encounter_id)
                      LEFT JOIN  obs ob ON(ob.encounter_id=encounter.encounter_id)
                      LEFT JOIN patient_identifier pid1 ON(pid1.patient_id=encounter.patient_id AND pid1.identifier_type=4)
                      LEFT JOIN form ON(encounter.form_id=form.form_id AND encounter.voided=0)
                      LEFT JOIN users ON(encounter.creator=users.user_id)
                      LEFT JOIN concept_name cn1 ON(cn1.concept_id=obs.value_coded AND cn1.locale='en' AND cn1.locale_preferred=1)
                     WHERE encounter.form_id IN(21) AND encounter.voided=0
                     AND pid1.identifier LIKE '%-%' 
                      AND LENGTH(pid1.identifier) > 9
                      AND ob.concept_id =1024
                      GROUP BY patient.patient_id,encounter.encounter_id,DATE(encounter.encounter_datetime)
                    UNION 
                    SELECT  
                       pid1.identifier AS Basophils_PepfarID,
                       DATE(encounter.encounter_datetime) AS Basophils_VisitDate,
                       'Basophils' AS 'tests',
                       ob.value_numeric AS  'Basophils_results',
                       DATE(MAX(IF(obs.concept_id= 162078,  obs.value_datetime, NULL))) AS `Basophils_DateOrdered` ,  
                       DATE(MAX(IF(obs.concept_id= 165414, obs.value_datetime, NULL))) AS `Basophils_DateReported`,
                       DATE(MAX(IF(obs.concept_id= 164984,  obs.value_datetime, NULL))) AS `Basophils_DateChecked` 
                      FROM  encounter 
                      LEFT JOIN patient ON(encounter.patient_id=patient.patient_id AND patient.voided=0 AND encounter.voided=0)
                      LEFT JOIN  obs ON(obs.encounter_id=encounter.encounter_id)
                      LEFT JOIN  obs ob ON(ob.encounter_id=encounter.encounter_id)
                      LEFT JOIN patient_identifier pid1 ON(pid1.patient_id=encounter.patient_id AND pid1.identifier_type=4)
                      LEFT JOIN form ON(encounter.form_id=form.form_id AND encounter.voided=0)
                      LEFT JOIN users ON(encounter.creator=users.user_id)
                      LEFT JOIN concept_name cn1 ON(cn1.concept_id=obs.value_coded AND cn1.locale='en' AND cn1.locale_preferred=1)
                     WHERE encounter.form_id IN(21) AND encounter.voided=0
                     AND pid1.identifier LIKE '%-%' 
                      AND LENGTH(pid1.identifier) > 9
                      AND ob.concept_id =1025
                      GROUP BY patient.patient_id,encounter.encounter_id,DATE(encounter.encounter_datetime)
                    UNION 
                    SELECT  
                       pid1.identifier AS AlkPhosphatase_PepfarID,
                       DATE(encounter.encounter_datetime) AS AlkPhosphatase_VisitDate,
                       'Alk. Phosphatase' AS 'tests',
                       ob.value_numeric AS  'AlkPhosphatase_results',
                       DATE(MAX(IF(obs.concept_id= 162078,  obs.value_datetime, NULL))) AS `AlkPhosphatase_DateOrdered` ,  
                       DATE(MAX(IF(obs.concept_id= 165414, obs.value_datetime, NULL))) AS `AlkPhosphatase_DateReported`,
                       DATE(MAX(IF(obs.concept_id= 164984,  obs.value_datetime, NULL))) AS `AlkPhosphatase_DateChecked` 
                      FROM  encounter 
                      LEFT JOIN patient ON(encounter.patient_id=patient.patient_id AND patient.voided=0 AND encounter.voided=0)
                      LEFT JOIN  obs ON(obs.encounter_id=encounter.encounter_id)
                      LEFT JOIN  obs ob ON(ob.encounter_id=encounter.encounter_id)
                      LEFT JOIN patient_identifier pid1 ON(pid1.patient_id=encounter.patient_id AND pid1.identifier_type=4)
                      LEFT JOIN form ON(encounter.form_id=form.form_id AND encounter.voided=0)
                      LEFT JOIN users ON(encounter.creator=users.user_id)
                      LEFT JOIN concept_name cn1 ON(cn1.concept_id=obs.value_coded AND cn1.locale='en' AND cn1.locale_preferred=1)
                     WHERE encounter.form_id IN(21) AND encounter.voided=0
                     AND pid1.identifier LIKE '%-%' 
                      AND LENGTH(pid1.identifier) > 9
                      AND ob.concept_id =785
                      GROUP BY patient.patient_id,encounter.encounter_id,DATE(encounter.encounter_datetime)
                    UNION 
                    SELECT  
                       pid1.identifier AS LDL_PepfarID,
                       DATE(encounter.encounter_datetime) AS LDL_VisitDate,
                       'LDL' AS 'tests',
                       ob.value_numeric AS  'LDL_results',
                       DATE(MAX(IF(obs.concept_id= 162078,  obs.value_datetime, NULL))) AS `LDL_DateOrdered` ,  
                       DATE(MAX(IF(obs.concept_id= 165414, obs.value_datetime, NULL))) AS `LDL_DateReported`,
                       DATE(MAX(IF(obs.concept_id= 164984,  obs.value_datetime, NULL))) AS `LDL_DateChecked` 
                      FROM  encounter 
                      LEFT JOIN patient ON(encounter.patient_id=patient.patient_id AND patient.voided=0 AND encounter.voided=0)
                      LEFT JOIN  obs ON(obs.encounter_id=encounter.encounter_id)
                      LEFT JOIN  obs ob ON(ob.encounter_id=encounter.encounter_id)
                      LEFT JOIN patient_identifier pid1 ON(pid1.patient_id=encounter.patient_id AND pid1.identifier_type=4)
                      LEFT JOIN form ON(encounter.form_id=form.form_id AND encounter.voided=0)
                      LEFT JOIN users ON(encounter.creator=users.user_id)
                      LEFT JOIN concept_name cn1 ON(cn1.concept_id=obs.value_coded AND cn1.locale='en' AND cn1.locale_preferred=1)
                     WHERE encounter.form_id IN(21) AND encounter.voided=0
                     AND pid1.identifier LIKE '%-%' 
                      AND LENGTH(pid1.identifier) > 9
                      AND ob.concept_id =1008
                      GROUP BY patient.patient_id,encounter.encounter_id,DATE(encounter.encounter_datetime)
                    UNION 
                    SELECT  
                       pid1.identifier AS LDL_PepfarID,
                       DATE(encounter.encounter_datetime) AS Pregnancy_VisitDate,
                       'Pregnancy' AS 'tests',
                       ob.value_numeric AS  'Pregnancy_results',
                       DATE(MAX(IF(obs.concept_id= 162078,  obs.value_datetime, NULL))) AS `Pregnancy_DateOrdered` ,  
                       DATE(MAX(IF(obs.concept_id= 165414, obs.value_datetime, NULL))) AS `Pregnancy_DateReported`,
                       DATE(MAX(IF(obs.concept_id= 164984,  obs.value_datetime, NULL))) AS `Pregnancy_DateChecked` 
                      FROM  encounter 
                      LEFT JOIN patient ON(encounter.patient_id=patient.patient_id AND patient.voided=0 AND encounter.voided=0)
                      LEFT JOIN  obs ON(obs.encounter_id=encounter.encounter_id)
                      LEFT JOIN  obs ob ON(ob.encounter_id=encounter.encounter_id)
                      LEFT JOIN patient_identifier pid1 ON(pid1.patient_id=encounter.patient_id AND pid1.identifier_type=4)
                      LEFT JOIN form ON(encounter.form_id=form.form_id AND encounter.voided=0)
                      LEFT JOIN users ON(encounter.creator=users.user_id)
                      LEFT JOIN concept_name cn1 ON(cn1.concept_id=obs.value_coded AND cn1.locale='en' AND cn1.locale_preferred=1)
                     WHERE encounter.form_id IN(21) AND encounter.voided=0
                     AND pid1.identifier LIKE '%-%' 
                      AND LENGTH(pid1.identifier) > 9
                      AND ob.concept_id =45
                      GROUP BY patient.patient_id,encounter.encounter_id,DATE(encounter.encounter_datetime)";
    }

    public static function laboratoryDictionary($concepid) {


        $labCode = [
        ];
    }

}

?>