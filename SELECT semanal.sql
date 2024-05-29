SELECT

-- SUBSTRING_INDEX(GROUP_CONCAT(concat(p.user_name,' ')), ',', 1) AS 'names',
GROUP_CONCAT(concat(p.user_name,' '))  AS 'names',
COUNT(p.ticket) 'nticket',
p.email,
SUM(p.score) AS 'max_score'

FROM tbl_puntajes p
WHERE WEEK(p.date) = WEEK(CURDATE()) - 1

GROUP BY p.email
ORDER BY max_score DESC;

-- UPDATE tbl_puntajes p SET
-- p.ticket_verificado 0,
-- p.`status` = 0
-- WHERE p.id !=0;


Los expertos de Raid®. Promoción válida en la república mexicana del
5 de junio 2024 al 31 de julio 2024.

2024-06-05 and 2024-06-09
2024-06-09 and 2024-06-16
2024-06-16 and 2024-06-23
2024-06-23 and 2024-06-30
2024-06-30 and 2024-07-07
2024-07-07 and 2024-07-14
2024-07-14 and 2024-07-21
2024-07-21 and 2024-07-28


<option><a href="https://gestor.expertosraid.com/index.php?s="></a></option>

<option value="2024-06-05%20AND%202024-06-09">Junio 5 a Junio 9</option>
<option value="2024-06-09%20AND%202024-06-16">Junio 9 a Junio 16</option>
<option value="2024-06-16%20AND%202024-06-23">Junio 16 a Junio 23</option>
<option value="2024-06-23%20AND%202024-06-30">Junio 23 a Junio 30</option>
<option value="2024-06-30%20AND%202024-07-07">Junio 30 a Julio 07</option>
<option value="2024-07-07%20AND%202024-07-14">Julio 07 a Julio 14</option>
<option value="2024-07-14%20AND%202024-07-21">Julio 14 a Julio 21</option>
<option value="2024-07-21%20AND%202024-07-28">Julio 21 a Julio 28</option>


							