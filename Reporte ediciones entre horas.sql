SELECT
-- 	ca.idkommo,

DATE_FORMAT(ca.fecha, '%H:%i') hora
-- FORMAT(ca.fecha,'hh:mm')
	
FROM leads_kommo_cambios ca
WHERE ca.id_responsable = 10471703 AND
ca.fecha LIKE '2024-06-24%'
ORDER BY ca.fecha DESC

LIMIT 30;

SELECT*FROM leads_zadarma_llamadas ll
WHERE ll.call_date LIKE '2024-06-24%' AND
ll.internal = 202;
-- -------------------------------------

SELECT CONCAT('tabla1.', nombre) AS nombre, precio
FROM tabla1
UNION ALL
SELECT CONCAT('tabla2.', nombre) AS nombre, precio
FROM tabla2;



SELECT CONCAT('-',ca.fecha), ca.lead_nombre
FROM leads_kommo_cambios ca 
WHERE ca.id_responsable = 10471703 AND ca.fecha LIKE '2024-06-24%'
-- ORDER BY ca.fecha DESC
UNION ALL

SELECT CONCAT('+',ll.call_date),ll.caller_id
FROM leads_zadarma_llamadas ll
WHERE ll.call_date LIKE '2024-06-24%' AND
ll.internal = 202
LIMIT 100


;
