SET @today = '2024-06-12';
-- SELECT 
	-- c.idkommo,c.lead_nombre,c.programa,
	-- json_arrayagg( DISTINCT (SELECT e.etapa FROM leads_kommo_embudos_etapas e WHERE e.id_etapa = c.etapa) ) etapa
    --        FROM leads_kommo_cambios c
  --          WHERE c.fecha LIKE CONCAT(@today,'%')
--            GROUP BY c.idkommo


SELECT
c.idkommo,
json_arrayagg( DISTINCT (SELECT e.etapa FROM leads_kommo_embudos_etapas e WHERE e.id_etapa = c.etapa) ) etapa,
c.fecha_asignacion
FROM leads_kommo_cambios c
WHERE c.id_responsable = 10471703 AND c.fecha_asignacion BETWEEN '2024-06-10%' AND '2024-06-13%'
GROUP BY c.idkommo
ORDER BY c.idkommo;



