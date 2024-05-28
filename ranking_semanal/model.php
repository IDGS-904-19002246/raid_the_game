<?php
include '../database.php';
class Model
{
    public function selectBy($var) {
        $mysqli = conectarDB();
        if ($mysqli->connect_error) {die("Error de conexión: " . $mysqli->connect_error);}
        $sql = "SELECT
            GROUP_CONCAT(concat(p.user_name,' ')) 'names',
            COUNT(p.ticket) 'nticket',
            p.email,
            SUM(p.score) AS 'max_score'
            
            FROM tbl_puntajes p
            WHERE WEEK(p.date) = WEEK(CURDATE()) - '".$var."'
            
            GROUP BY p.email
            ORDER BY max_score DESC 
        ";
        $datos = array();
        $result = $mysqli->query($sql);

        if (!$result->fetch_assoc()) {
            $mysqli->close();

            return json_decode('[]');
        }else{
            while ($row = $result->fetch_assoc()) {
            $datos[] = $row;
        }
        $mysqli->close();
        return $datos;
        }
        
    }
}
?>