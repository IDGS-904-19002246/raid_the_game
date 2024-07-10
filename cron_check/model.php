<?php
include 'database.php';
class ModelCronCheck
{
    function selectCheck($today){
        $mysqli = conectarDB();
        if ($mysqli->connect_error) {die("Error de conexión: " . $mysqli->connect_error);}

        $sql = "SELECT 
                ar.PersonID,
                ar.PersonName,
                json_arrayagg(
                    DATE_FORMAT(
                        FROM_UNIXTIME(ar.AttendanceDateTime / 1000), '%H:%i'
                        )
                    ) checkit
            from AttendanceRecordInfo ar
            WHERE FROM_UNIXTIME(ar.AttendanceDateTime / 1000) LIKE '{$today}%'
            GROUP BY ar.PersonID";

        $result = $mysqli->query($sql);

        if ($result && $result->num_rows == 0) {
            $mysqli->close();
            return json_decode('[]');
        }else{
            while ($row = $result->fetch_assoc()) {
                $row['checkit'] = json_decode($row['checkit']);
                $datos[] =$row;
            }
            $mysqli->close();
            return $datos;
        }
    }
    function CloseTo30($lista) {
        $tiempoMasCercano = null;
        // PHP_INT_MAX = Es Para Inicializar con un valor mas grande
        $minimaDiferencia = PHP_INT_MAX;
    
        foreach ($lista as $item) {
            if (is_array($item) || is_object($item)) {
                $tiempo = isset($item['time']) ? $item['time'] : (isset($item->time) ? $item->time : null);
                if ($tiempo !== null) {
                    $diferencia = abs(30 - $tiempo);
    
                    if ($diferencia < $minimaDiferencia) {
                        $minimaDiferencia = $diferencia;
                        $tiempoMasCercano = $item;
                    }
                }
            }
        }
    
        return $tiempoMasCercano;
    }
    function insertParo(
    $fk_id_resposable,$start,$end,
    $assistants,$type
    ){
        $mysqli = conectarDB();
        if ($mysqli->connect_error) {die("Error de conexión: " . $mysqli->connect_error);}
        $sql = "INSERT INTO tbl_paros (
                `fk_id_resposable`,`start`,`end`,
                `assistants`,`type`)
            VALUES(
                {$fk_id_resposable},'{$start}','{$end}',
                '{$assistants}','{$type}'
            )";
        
        $result = $mysqli->query($sql);
        $mysqli->close();
        return ($result === true) ? 1 : 0;        
    }
}
?>