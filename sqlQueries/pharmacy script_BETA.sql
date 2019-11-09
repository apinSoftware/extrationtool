SELECT  
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
 GROUP BY patient.patient_id,encounter.encounter_id,DATE(encounter.encounter_datetime);

