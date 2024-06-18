SELECT
	ccc.idkommo,
   c.lead_nombre,
	c.contacto_nombre,
   ccc.idKommoResponsable id_responsable,
   c.programa,
	json_array( (SELECT e.etapa FROM leads_kommo_embudos_etapas e WHERE e.id_etapa = c.etapa LIMIT 1) ) etapa,
	(SELECT COUNT(*) FROM leads_kommo_cambios c2 WHERE c2.idkommo = c.idkommo AND c2.fecha LIKE CONCAT(@today,'%')) cambios,
	(SELECT COUNT(*) FROM leads_kommo_tareas t WHERE t.idkommo = c.idkommo AND t.fecha LIKE CONCAT(@today,'%')) tareas,
	(SELECT COUNT(*) FROM leads_kommo_notas n WHERE n.idkommo = c.idkommo AND n.fecha LIKE CONCAT(@today,'%')) notas,
	(SELECT COUNT(*) FROM leads_zadarma_llamadas l WHERE
		REPLACE(l.destination,'+','') = REPLACE(c.telefono, '+','') AND
		l.call_date like CONCAT(@today,'%') AND l.disposition = 'answered' AND l.duration >=15
		) llamadas
		 
FROM leads_kommo_cron ccc
LEFT JOIN
    (
    	 -- idkommo, lead_nombre, programa,
--	 SELECT*FROM leads_kommo_cambios GROUP BY idkommo
					SELECT sub.* FROM (SELECT *,
						ROW_NUMBER() OVER (PARTITION BY idkommo ORDER BY fecha DESC) AS rn
					FROM leads_kommo_cambios) sub WHERE sub.rn = 1
		) c
ON c.idkommo = ccc.idkommo
WHERE ccc.fecha_asignado LIKE CONCAT(@today,'%') AND ccc.idKommoResponsable = 11456403;
    
--    ---------------------------------------------------------------
    
    SELECT sub.*
FROM (
    SELECT *,
           ROW_NUMBER() OVER (PARTITION BY idkommo ORDER BY fecha DESC) AS rn
    FROM leads_kommo_cambios
) sub
WHERE sub.rn = 1;

SELECT COUNT(*)
FROM leads_kommo_cambios
WHERE idkommo = 10018926
