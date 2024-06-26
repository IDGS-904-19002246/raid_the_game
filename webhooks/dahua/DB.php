<?php
// 172.5.2.217
// 192.168.1.128
// $mysqli = new mysqli("192.168.1.128", "admin", "Mavis2020@");
// $mysqli = new mysqli($ip, $user, $pass, $db);
$sql= "SELECT
            *
            FROM dwork_alumnos_grupos t
            WHERE (t.fecha_altagpo BETWEEN
            '" . date_format($lun, 'Y-m-d') . "' AND '" . date_format($sab, 'Y-m-d') . "') AND
            t.dequienes = {$pid} GROUP BY DATE(t.fecha_altagpo)";

function getToday($id, $fecha)
{
    global $mysqli;
    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }
    $sql = "SELECT COUNT(*) total
        from AttendanceRecordInfo ar
        WHERE FROM_UNIXTIME(ar.AttendanceDateTime / 1000) LIKE '{$fecha}%' AND ar.PersonID = {$id}";
    // WHERE DATE_FORMAT(FROM_UNIXTIME(ar.AttendanceDateTime / 1000), '%Y-%m-%d') = '{$fecha}';
    $result = $mysqli->query($sql);
    if ($result) {
        $mysqli->close();
        return $result->fetch_assoc()['total'];
    } else {
        $mysqli->close();
        return 0;
    }
}

function conectarDB($ip, $user, $pass, $db)
{
    $mysqli = new mysqli($ip, $user, $pass, $db);
    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }
    $mysqli->set_charset("utf8");
    return $mysqli;
}





$mysqli = conectarDB("74.208.39.15", "adcontrol_kommo_leads", "1dz0u3K%0", "adcontrol_kommo_leads");
echo getToday(1000284, '2024-06-24');

$val1 = 'f';
$val2 = '4';
$sql = "SELECT * FROM leads l WHERE l.`name` LIKE {$val2} and l.id = 1";

?>


<!-- 
$url = 'http://{direccion_del_lector}/api/endpoint'; // Reemplaza con la URL correcta del API del lector
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Añade opciones adicionales según la documentación de Dahua, como headers, autenticación, etc.
$response = curl_exec($ch);
if ($response === false) {
    echo 'Error en la solicitud: ' . curl_error($ch);
} else {
    echo 'Respuesta del servidor: ' . $response;
}
curl_close($ch);
-->