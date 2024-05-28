SELECT

GROUP_CONCAT(concat(p.user_name,' ')) 'names',
COUNT(p.ticket) 'nticket',
p.email,
SUM(p.score) AS 'max_score'

FROM tbl_puntajes p
WHERE WEEK(p.date) = WEEK(CURDATE()) - 1

GROUP BY p.email
ORDER BY max_score DESC;

UPDATE tbl_puntajes p SET
p.ticket_verificado 0,
p.`status` = 0
WHERE p.id !=0;
