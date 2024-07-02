SELECT distinct * FROM leads_kommo_cambios ca WHERE 
ca.id_responsable = 11528779 AND 
ca.fecha_asignacion LIKE '2024-06-28%' AND 
ca.fecha LIKE '2024-06-28%';

SELECT JSON_OBJECTAGG(f, c) AS interesados FROM (
	        SELECT DATE(t.fecha) f 
			  -- , COUNT( DISTINCT t.idkommo) c
            FROM leads_kommo_cambios t
            WHERE (t.fecha BETWEEN
'2024-06-24' AND '2024-06-29'
)AND t.id_responsable = 11528779 AND t.etapa = 69303183
            GROUP BY DATE(t.fecha)
        ) AS interesados;


SELECT DISTINCT t.idkommo
FROM leads_kommo_cambios t
WHERE (t.fecha BETWEEN'2024-06-24' AND '2024-06-29')
AND t.id_responsable = 11528779 AND t.etapa = 69303183
GROUP BY DATE(t.fecha)
-- ----------------------------------------

SELECT DATE (fecha), COUNT(*) AS conteo
FROM (
    SELECT ca.idkommo ,
	 MAX(ca.fecha) AS fecha, 
	 ca.lead_nombre
    FROM leads_kommo_cambios ca
    WHERE (ca.fecha_asignacion BETWEEN '2024-06-28' AND '2024-06-29')
		and DATE(ca.fecha_asignacion) = DATE (ca.fecha)
		AND ca.id_responsable = 10471703 AND ca.etapa = 69303183
    GROUP BY ca.idkommo
) AS ultima_fecha
GROUP BY DATE (fecha)
ORDER BY fecha;

-- CONSULTA FINAL ----------------------------------------------------
SELECT JSON_OBJECTAGG(f, c) AS interesados FROM (
SELECT DATE(fecha) f, COUNT(*) c FROM (

	SELECT
		ca.idkommo ,
		MAX(ca.fecha) AS fecha
	FROM leads_kommo_cambios ca WHERE
	(ca.fecha_asignacion BETWEEN @fecha1 AND @fecha2)
	and DATE(ca.fecha_asignacion) = DATE (ca.fecha)
	-- AND ca.id_responsable = 2 AND ca.etapa = 69303183
	GROUP BY ca.idkommo

) AS ultima_fecha
GROUP BY DATE(fecha)

) AS interesados;






|nombre|fecha|nota|
|juan|2024-06-20|NO|
|jose|2024-06-21|NO|
|jose|2024-06-24|NO|
|juan|2024-06-20|si|
|ana|2024-06-25|si|

|2024-06-20|1|
|2024-06-21|0|
|2024-06-24|1|
|2024-06-25|1|