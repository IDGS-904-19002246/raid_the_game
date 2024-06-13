<?php
include '../../database.php';
class Model
{

    public function select()
    {
        $mysqli = conectarDB();
        if ($mysqli->connect_error) {
            die("Error de conexión: " . $mysqli->connect_error);
        }
        $sql = "SELECT * FROM d0_tbl_puntajes";

        $result = $mysqli->query($sql);

        $datos = array();
        while ($row = $result->fetch_assoc()) {
            $datos[] = $row;
        }
        $mysqli->close();
        return $datos;
    }

    public function selectBy($var) {
        $mysqli = conectarDB();
        if ($mysqli->connect_error) {die("Error de conexión: " . $mysqli->connect_error);}
        $sql = "SELECT
            SUBSTRING_INDEX(GROUP_CONCAT(concat(p.user_name,' ')), ',', 1) AS 'names',
            SUBSTRING_INDEX(GROUP_CONCAT(concat(p.telephone,' ')), ',', 1) AS 'telephones',
            -- GROUP_CONCAT(concat(p.user_name,' ')) 'names',
            COUNT(p.ticket) 'nticket',
            p.email,
            SUM(p.score) AS 'max_score'
            
            FROM d0_tbl_puntajes p
            WHERE p.date BETWEEN ".$var."
            
            GROUP BY p.email
            ORDER BY max_score DESC 
        ";
        $datos = array();

        $result = $mysqli->query($sql);

        if ($result && $result->num_rows == 0) {
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

    public function updateVefication($id,$new)
    {
        $mysqli = conectarDB();
        if ($mysqli->connect_error) {die("Error de conexión: " . $mysqli->connect_error);}
        $sql = "UPDATE d0_tbl_puntajes SET
                ticket_verificado = ".$new."
            WHERE id=".$id;

        $result = $mysqli->query($sql);
        if ($mysqli->query($sql) == 1) {
            echo '1';
        } else {
            echo '0';
            echo '<script>console.log('.$mysqli->error.')</script>';
        }
        $mysqli->close();
    }

}
?>