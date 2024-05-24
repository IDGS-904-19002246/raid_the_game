<?php
include '../database.php';
class Model
{


    public function selectBy($var)
    {
        $mysqli = conectarDB();
        if ($mysqli->connect_error) {die("Error de conexión: " . $mysqli->connect_error);}

        $sql = "SELECT
                SUM(p.score) AS 'total',
                (
                    SELECT json_arrayagg(JSON_OBJECT(
                        'id',pp.id,
                        'user_name',pp.user_name,
                        'ticket',pp.ticket,
                        'score',pp.score,
                        'date',pp.date
                    ))
                    FROM tbl_puntajes pp
                    WHERE pp.email = '".$var."' OR pp.telephone = '".$var."'
                ) 'data'
            FROM tbl_puntajes p
            WHERE p.email = '".$var."' OR p.telephone = '".$var."'";

        $result = $mysqli->query($sql);

        $datos = array();
        while ($row = $result->fetch_assoc()) {
            $datos['total'] = $row['total'];
            $datos['data'] = json_decode($row['data'], true);
        }
        $mysqli->close();
        return $datos;
    }

}
?>