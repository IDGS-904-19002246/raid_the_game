<?php
include 'database.php';
class Model
{
    function ToJson($text_url)
    {
        // RETIRAR CARACTERES URL
        $text = urldecode($text_url);
        $text = str_replace("&", "\n", $text);
        // // SEGMENTAR EL TEXTO EN LÍNEAS
        $lines = explode("\n", $text);
        $data = array();
        foreach ($lines as $l) {
            // DIVIDIR LA LINEA - > CLAVE VALOR
            list($key, $value) = explode("=", $l, 2);
            $key = trim($key);
            $value = trim($value);
            $value = str_replace(array('[', ']'), '', $value);

            // CONVERTIR LA CLAVE
            $part = explode('[', $key);
            $actual = &$data;

            // RECORRER CADA PARTE DE LA CLAVE
            foreach ($part as $p) {
                $p = rtrim($p, ']');

                // CREAR EL ARREGLO ASOCIATIVO SI NO EXISTE
                if (!isset($actual[$p])) {
                    $actual[$p] = array();
                }

                // CAMBIAR EL PUNTERO AL SIGUIENTE
                $actual = &$actual[$p];
            }

            // ASIGNAR EL VALOR A LA CLAVE FINAL
            if(substr($value, 0, 1) == '{' && substr($value, -1) == '}'){
                $actual = json_decode($value);
            }else{
                $actual = $value;
            }
            
            
        }
        return $data;
    }
    function getDate($time){
        return date('Y-m-d H:i:s', $time);
    }
    function getValueFromItem($list,$item_key,$name){
        foreach ($list as $l) {
            if ($l[$item_key] == $name) {
                return $l;
            }
        }
    }
    function selectCambio($idkommo){
        $mysqli = conectarDB();
        if ($mysqli->connect_error) {die("Error de conexión: " . $mysqli->connect_error);}
        $sql = "SELECT
                k.lead_nombre,k.fecha_asignacion
            FROM leads_kommo_cambios k WHERE k.idkommo = $idkommo
            ORDER BY k.id DESC LIMIT 1";

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
    // -------------------------------------------------------------
    function insertCambios(
        $idkommo,$lead_nombre,$pipeline,
        $etapa,$id_responsable,$fecha,
        $fuente,$fecha_asignacion
    ){
        $mysqli = conectarDB();
        if ($mysqli->connect_error) {die("Error de conexión: " . $mysqli->connect_error);}

        $sql = "INSERT INTO leads_kommo_cambios (
            `idkommo`,`lead_nombre`,`pipeline`,
            `etapa`,`id_responsable`,`fecha`,
            `fuente`,`fecha_asignacion`
        )VALUES(
            ".$idkommo.",
            '".$lead_nombre."',
            ".$pipeline.",

            ".$etapa.",
            ".$id_responsable.",
            '".$fecha."',

            '".$fuente."',
            '".$fecha_asignacion."'
        )";

        if ($mysqli->query($sql) != 1) {echo '<script>console.log('.$mysqli->error.')</script>';}
        $mysqli->close();
    }
    function insertNotas(
        $idkommo,$lead_nombre,$actividad,
        $id_responsable,$fecha,$fecha_asignacion
    ){
        $mysqli = conectarDB();
        if ($mysqli->connect_error) {die("Error de conexión: " . $mysqli->connect_error);}

        $sql = "INSERT INTO leads_kommo_notas (
            `idkommo`,`lead_nombre`,`actividad`,
            `id_responsable`,`fecha`,`fecha_asignacion`
        )VALUES(
            ".$idkommo.",
            '".$lead_nombre."',
            '".$actividad."',

            ".$id_responsable.",
            '".$fecha."',
            '".$fecha_asignacion."'
        )";

        if ($mysqli->query($sql) != 1) {echo '<script>console.log('.$mysqli->error.')</script>';}
        $mysqli->close();
    }
    function insertTareas(
        $idkommo,$lead_nombre,$actividad,
        $id_responsable,$fecha,$fecha_asignacion,
        $idtipo
    ){
        $mysqli = conectarDB();
        if ($mysqli->connect_error) {die("Error de conexión: " . $mysqli->connect_error);}

        $sql = "INSERT INTO leads_kommo_tareas (
            `idkommo`,`lead_nombre`,`actividad`,
	        `id_responsable`,`fecha`,`fecha_asignacion`,
            `idtipo`
        )VALUES(
            ".$idkommo.",
            '".$lead_nombre."',
            '".$actividad."',

            ".$id_responsable.",
            '".$fecha."',
            '".$fecha_asignacion."',

            ".$idtipo."
        )";

        if ($mysqli->query($sql) != 1) {echo '<script>console.log('.$mysqli->error.')</script>';}
        $mysqli->close();
    }
    // -------------------------------------------------------------
    function insertConversaciones(
        $idkommo,$lead_nombre,$actividad,
	    $fecha_asignacion
    ){
        $mysqli = conectarDB();
        if ($mysqli->connect_error) {die("Error de conexión: " . $mysqli->connect_error);}

        $sql = "INSERT INTO leads_kommo_conversaciones(
            `idkommo`,`lead_nombre`,`actividad`,
            `fecha_asignacion`
        ) VALUES (
            $idkommo,
            '$lead_nombre',
            '$actividad',
	        '$fecha_asignacion'
        )";

        if ($mysqli->query($sql) != 1) {echo '<script>console.log('.$mysqli->error.')</script>';}
        $mysqli->close();
    }
}
?>