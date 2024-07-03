-- FUNCIONA 100%
SELECT sub.* FROM (
	SELECT *,
		ROW_NUMBER() OVER (PARTITION BY ta.fk_id ORDER BY ta.fecha DESC) AS rn
	FROM tabla1 ta
	-- WHERE sub.rn = 1 AND sub.fk_id =2
) sub
WHERE sub.rn = 2
-- AND sub.fk_id =2;

-- -------------------------------------------------------------------------

-- FUNCIONA PERO EL NOMBRE NO ES EL QUE CORRESPONDE CON LA FECHA(si siempre es el mismo no importa)
SELECT
	MAX(ta.id),ta.fk_id, MAX(nombre), MAX(ta.fecha) fecha
FROM tabla1 ta
GROUP BY ta.fk_id;
--	MUCHA SUBQUERY PERO FUNCIONA
SELECT
    ta.fk_id,
    MAX(ta.fecha) AS fecha_maxima,
    (SELECT nombre 
     FROM tabla1 
     WHERE fk_id = ta.fk_id 
       AND fecha = MAX(ta.fecha)
    ) AS nombre_correspondiente
FROM tabla1 ta
GROUP BY ta.fk_id;

