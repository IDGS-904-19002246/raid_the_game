<?php

class ApiModel
{
    function getContact($id){
        $url = 'https://auladisermx.kommo.com/api/v4/contacts/'.$id;
        $headers = array('Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImQxZmI1MzBkNTBkNmZhZDQxZmQyZDZjNmJkOGZkN2NhNDQ5MmQ0NzFhMzM1YjE0MzM4NmE2MzYxZTYyNTYxNzBkOTkyYmRmYWJjNDY4MjU2In0.eyJhdWQiOiJjZWNiNDFkNi05MzJkLTQyMmItOWU4Mi03MzUwODI0OWQ5MTYiLCJqdGkiOiJkMWZiNTMwZDUwZDZmYWQ0MWZkMmQ2YzZiZDhmZDdjYTQ0OTJkNDcxYTMzNWIxNDMzODZhNjM2MWU2MjU2MTcwZDk5MmJkZmFiYzQ2ODI1NiIsImlhdCI6MTcxNzQzMzAyMywibmJmIjoxNzE3NDMzMDIzLCJleHAiOjE4NzUxMzkyMDAsInN1YiI6IjEwNDcxNzAzIiwiZ3JhbnRfdHlwZSI6IiIsImFjY291bnRfaWQiOjMyMDY3MDM5LCJiYXNlX2RvbWFpbiI6ImtvbW1vLmNvbSIsInZlcnNpb24iOjIsInNjb3BlcyI6WyJjcm0iLCJmaWxlcyIsImZpbGVzX2RlbGV0ZSIsIm5vdGlmaWNhdGlvbnMiLCJwdXNoX25vdGlmaWNhdGlvbnMiXSwiaGFzaF91dWlkIjoiOGUxNjRhNWQtMjYwNS00ZjhhLTlmNzctZDFiMjQ2ZGZmMzBjIn0.mxOi-0rmySCuWGCFEYoSxL1k1rmAcXxTKED3JfMLcGPA3MPeIIqvSBKMI67GZpvhXYrtpKIB4wh6O_GQYEZnaJWfFwiuUztWNe2FdJp8BphSRGYarCYPPR-JBFoh8QO2tyQZlguJK86cpzLcdpE-KJ-PsZiiDQ8NZr86azAnzt2zpphGhr4MwKxx-YMO3MW271trt_zJ3D6MDlKrJaRc86Ac9rQkNhBBoAdDsZ2xHBQZl_jb3BrsBijsquQUATSN2MnbDPPA9YZyJ3t5VWUHw390vYvd7grhBspQauVMxTuqm0thtLRgMt5NPWcje8soNTjr4oefrCLJVQZbD9Z5FQ');

        // INICIALIZA UNA SESIÓN CURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
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






// // Verifica si la solicitud fue exitosa (código de estado 200)
// $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
// if ($httpCode == 200) {
//     // Procesa los datos de la respuesta (los datos podrían estar en formato JSON)
//     $contactos = json_encode(json_decode($response, true));
//     // Haz algo con los datos de los contactos
//     print_r($contactos);
// } else {
//     // Maneja el caso en que la solicitud no fue exitosa
//     echo 'Error al consultar la lista de contactos: ' . $httpCode;
// }



?>
