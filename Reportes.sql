-- SELECT c.id, REPLACE(c.telefono, '+','') tel
-- FROM leads_kommo_cambios c
-- ORDER BY c.id DESC LIMIT 10;

SET @fecha = '2024-06-05';
SELECT
-- DISTINCT
	c.idkommo,
	c.lead_nombre,c.contacto_nombre,
	json_arrayagg( DISTINCT (SELECT e.etapa FROM leads_kommo_embudos_etapas e WHERE e.id_etapa = c.etapa) ) atapa,
	(SELECT COUNT(*) FROM leads_kommo_cambios c2 WHERE c2.idkommo = c.idkommo AND c2.fecha LIKE CONCAT(@fecha,'%')) cambios,
	(SELECT COUNT(*) FROM leads_kommo_tareas t WHERE t.idkommo = c.idkommo AND t.fecha LIKE CONCAT(@fecha,'%')) tareas,
	(SELECT COUNT(*) FROM leads_kommo_notas n WHERE n.idkommo = c.idkommo AND n.fecha LIKE CONCAT(@fecha,'%')) notas,
	(SELECT COUNT(*) FROM leads_zadarma_llamadas l WHERE
		REPLACE(l.destination,'+','') = REPLACE(c.telefono, '+','') AND
		l.call_date like CONCAT(@fecha,'%') AND l.disposition = 'answered' AND l.duration >=15
		) llamadas

FROM leads_kommo_cambios c
WHERE c.fecha LIKE CONCAT(@fecha,'%')
GROUP BY c.idkommo;















