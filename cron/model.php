<?php
include 'database.php';
class ModelCron
{
    function selectPersonal(){
        $mysqli = conectarDB_AD();
        if ($mysqli->connect_error) {die("Error de conexión: " . $mysqli->connect_error);}

        $sql = "SELECT 
                p.idKommo,
                p.pnombre,
                p.asignacionDiaria
            FROM dwork_personal p
            WHERE p.idKommo IS NOT NULL LIMIT 2";

        $datos = array();
        $result = $mysqli->query($sql);

        if ($result && $result->num_rows == 0) {
            $mysqli->close();
            return json_decode('[]');
        }else{
            while ($row = $result->fetch_assoc()) {$datos[] = $row;}
            $mysqli->close();
            return $datos;
        }
    }
    function selectPersonalSum(){
        $mysqli = conectarDB_AD();
        if ($mysqli->connect_error) {die("Error de conexión: " . $mysqli->connect_error);}

        $sql = "SELECT 
                sum(p.asignacionDiaria) total
            FROM dwork_personal p
            WHERE p.idKommo IS NOT NULL LIMIT 2";

        $datos = array();
        $result = $mysqli->query($sql);

        if ($result && $result->num_rows == 0) {
            $mysqli->close();
            return json_decode('[]');
        }else{
            while ($row = $result->fetch_assoc()) {$datos[] = $row;}
            $mysqli->close();
            return $datos;
        }
    }
    function selectCron(){
        $mysqli = conectarDB();
        if ($mysqli->connect_error) {die("Error de conexión: " . $mysqli->connect_error);}
        // $sql = "SELECT * FROM leads_kommo_cron cr ORDER BY cr.idorden ASC LIMIT 1";
        $sql = "SELECT * FROM leads_kommo_cron cr
            WHERE cr.asignado = 0 ORDER BY cr.idorden ASC LIMIT 1";

        $result = $mysqli->query($sql);
        $data = array();
        if ($result && $result->num_rows == 0) {
            $mysqli->close();
            return json_decode('[]');
        }else{
            while ($row = $result->fetch_assoc()) {$data[] = $row;}
            $mysqli->close();
            return $data;
        }
    }
    function updateCron($id, $fecha){
        $mysqli = conectarDB();
        if ($mysqli->connect_error) {die("Error de conexión: " . $mysqli->connect_error);}
        $sql = "UPDATE leads_kommo_cron cr SET
            cr.asignado = 1,
            cr.fecha_asignado = '".$fecha."'

            WHERE cr.id = ".$id;
        
        $result = $mysqli->query($sql);
        $mysqli->close();
        return ($result === true) ? 1 : 0;        
    }
    function updateCronAPI($id,$json){
        $url = 'https://auladisermx.kommo.com/api/v4/leads/'.$id;
        $headers = array('Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImQxZmI1MzBkNTBkNmZhZDQxZmQyZDZjNmJkOGZkN2NhNDQ5MmQ0NzFhMzM1YjE0MzM4NmE2MzYxZTYyNTYxNzBkOTkyYmRmYWJjNDY4MjU2In0.eyJhdWQiOiJjZWNiNDFkNi05MzJkLTQyMmItOWU4Mi03MzUwODI0OWQ5MTYiLCJqdGkiOiJkMWZiNTMwZDUwZDZmYWQ0MWZkMmQ2YzZiZDhmZDdjYTQ0OTJkNDcxYTMzNWIxNDMzODZhNjM2MWU2MjU2MTcwZDk5MmJkZmFiYzQ2ODI1NiIsImlhdCI6MTcxNzQzMzAyMywibmJmIjoxNzE3NDMzMDIzLCJleHAiOjE4NzUxMzkyMDAsInN1YiI6IjEwNDcxNzAzIiwiZ3JhbnRfdHlwZSI6IiIsImFjY291bnRfaWQiOjMyMDY3MDM5LCJiYXNlX2RvbWFpbiI6ImtvbW1vLmNvbSIsInZlcnNpb24iOjIsInNjb3BlcyI6WyJjcm0iLCJmaWxlcyIsImZpbGVzX2RlbGV0ZSIsIm5vdGlmaWNhdGlvbnMiLCJwdXNoX25vdGlmaWNhdGlvbnMiXSwiaGFzaF91dWlkIjoiOGUxNjRhNWQtMjYwNS00ZjhhLTlmNzctZDFiMjQ2ZGZmMzBjIn0.mxOi-0rmySCuWGCFEYoSxL1k1rmAcXxTKED3JfMLcGPA3MPeIIqvSBKMI67GZpvhXYrtpKIB4wh6O_GQYEZnaJWfFwiuUztWNe2FdJp8BphSRGYarCYPPR-JBFoh8QO2tyQZlguJK86cpzLcdpE-KJ-PsZiiDQ8NZr86azAnzt2zpphGhr4MwKxx-YMO3MW271trt_zJ3D6MDlKrJaRc86Ac9rQkNhBBoAdDsZ2xHBQZl_jb3BrsBijsquQUATSN2MnbDPPA9YZyJ3t5VWUHw390vYvd7grhBspQauVMxTuqm0thtLRgMt5NPWcje8soNTjr4oefrCLJVQZbD9Z5FQ');

        // INICIALIZA UNA SESIÓN CURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // INDICAR DATOS Y METODO
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH'); // Establece el método PATCH
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // REALIZA LA SOLICITUD GET
        $response = curl_exec($ch);
        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200) {
            curl_close($ch);
            return json_decode($response, true);
        }else{
            curl_close($ch);
            return [];
        }
    }
    
}
?>