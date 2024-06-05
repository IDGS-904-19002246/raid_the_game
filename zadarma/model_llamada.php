<?php
include 'database.php';
class Model_llamada
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
            if (substr($value, 0, 1) == '{' && substr($value, -1) == '}') {
                $actual = json_decode($value);
            } else {
                $actual = $value;
            }
        }
        return $data;
    }

    function insertLlamada(
        $call_date,$caller_id,$internal,
        $destination,$duration,$status_code,
        $call_type,$disposition
    ){
        $mysqli = conectarDB();
        if ($mysqli->connect_error) {die("Error de conexión: " . $mysqli->connect_error);}

        $sql = "INSERT INTO leads_zadarma_llamadas (
            `call_date`,`caller_id`,`internal`,
            `destination`,`duration`,`status_code`,
            `call_type`,`disposition`         
        )VALUES(
            '".$call_date."',
            '".$caller_id."',
            ".$internal.",

            '".$destination."',
            ".$duration.",
            ".$status_code.",

            '".$call_type."',
            '".$disposition."'
        )";

        if ($mysqli->query($sql) != 1) {echo '<script>console.log('.$mysqli->error.')</script>';}
        $mysqli->close();
    }
}

// DB.LLAMADAS -> JSON

// `call_date` -> call_start
// `caller_id` -> caller_id
// `internal` -> internal
// `destination` -> destination
// `duration` -> duration
// `status_code` -> status_code
// `call_type` -> calltype
// `disposition` -> disposition
?>