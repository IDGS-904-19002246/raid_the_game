-- SELECT CONCAT('tabla1.', nombre) AS nombre, precio FROM tabla1
-- UNION ALL
-- SELECT CONCAT('tabla2.', nombre) AS nombre, precio FROM tabla2;




SELECT
	ca.idkommo,
	ca.fecha,
	DATE_FORMAT(ca.fecha, '%h:%i:%s %p') hora,
	ca.lead_nombre,
	'cambios' actividad
FROM leads_kommo_cambios ca 
WHERE ca.id_responsable = 10471703 AND ca.fecha LIKE '2024-06-24%'

UNION ALL

SELECT
	n.idkommo,
	n.fecha,
	DATE_FORMAT(n.fecha, '%h:%i %p') hora,
	n.lead_nombre,
	'notas' actividad
FROM leads_kommo_notas n
WHERE n.id_responsable = 10471703 AND n.fecha LIKE '2024-06-24%'

UNION ALL

SELECT
	0,
	ll.call_date,
	DATE_FORMAT(ll.call_date, '%h:%i %p') hora,
	ll.caller_id,
	'llamadas' actividad
FROM leads_zadarma_llamadas ll
WHERE ll.call_date LIKE '2024-06-24%' AND ll.internal = 202

-- LIMIT 100


;
