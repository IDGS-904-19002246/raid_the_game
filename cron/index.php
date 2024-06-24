<?php
include 'model.php';
$ModelCron = new ModelCron();
date_default_timezone_set('America/Mexico_City');

//SUMA UNA DIA
$hoy0 = date('Y-m-d');
// $hoy = strtotime($hoy0."+1 day");
$hoy = strtotime($hoy0);

$personal_list = $ModelCron->selectPersonal();
$suma = $ModelCron->selectPersonalSum()[0]['total'];
$count = 0;

for ($i = 0; $i < count($personal_list); $i++) {
    
    if($ModelCron->getToday($personal_list[$i]['pid'], $hoy0) != 0){
        
        if($personal_list[$i]['asignacionDiaria'] <= $ModelCron->selectPersonalCount($personal_list[$i]['idUsuarioKommo'],$hoy0)[0]['total'] ){
            echo $personal_list[$i]['pnombre'] . " Limite de leads alcanzado <br>";
        }else{
            $cron = $ModelCron->selectCron();
            $json = '{
                "id":"' . $cron[0]['idkommo'] . '",
                "status_id": 70172479,
                "pipeline_id": 7810667,
                "loss_reason_id": null,
                "responsible_user_id":'.$personal_list[$i]['idUsuarioKommo'].',
                "price": 0,

                "custom_fields_values":[
                    {
                        "field_id": 937586,
                        "field_name": "Responsable en Asignación",
                        "field_type": "text",
                        "values": [{"value": "'.$personal_list[$i]['nombreKommo'].'"}]
                    },
                    {
                        "field_id": 936898,
                        "field_name": "Fecha de inicio",
                        "field_type": "date",
                        "values": [{"value": ' . strtotime($cron[0]['fecha_inicio']) . '}]
                    },
                    {
                        "field_id": 936900,
                        "field_name": "Horario",
                        "field_type": "select",
                        "values": [{"value": "' . $cron[0]['horario'] . '"}]
                    },
                    {
                        "field_id": 934468,
                        "field_name": "% de Comisión",
                        "field_code": null,
                        "field_type": "numeric",
                        "values": [{"value": "' . $cron[0]['porcentaje_comision'] . '"}]
                    },
                    {
                        "field_id": 936758,
                        "field_name": "Fecha de Asignacion",
                        "field_type": "date",
                        "values": [{"value": ' . $hoy . '}]
                    },
                    {
                        "field_id": 936842,
                        "field_name": "Nivel de Interés",
                        "field_code": null,
                        "field_type": "select",
                        "values": [{"value": null}]
                    },
                    {
                        "field_id": 937428,
                        "field_name": "Tipo de propuesta",
                        "field_code": null,
                        "field_type": "select",
                        "values": [{"value": null}]
                    },
                    {
                        "field_id": 934470,
                        "field_name": "Descuento aplicado",
                        "field_code": null,
                        "field_type": "select",
                        "values": [{"value":null}]
                    }


                ]}';
                
            // $ModelCron->updateCron($cron[0]['id'],$hoy0,$personal_list[$i]['idUsuarioKommo']);
            // $ModelCron->updateCronAPI($cron[0]['idkommo'], $json);

            echo $personal_list[$i]['pnombre'] ." se le asigno -> {$cron[0]['idkommo']}<br>";

        }
    }
}
// tengo un lector facial de la marca dahua conectada a un pc usando smartpss lite y quiero enviar los datos del lector a un servidor, es necesario usar smartpss lite para comunicar el lector facial al servidor
// Genera una quiery o script de php donde pueda saber cuantas columnas tienen las tablas de mi bade de datos

// $fecha_actual = date('Y-m-d H:i:s');
// // CONVIERTE LA FECHA ACTUAL A UN TIMESTAMP
// $timestamp = strtotime($fecha_actual);
// // IMPRIME EL TIMESTAMP
// echo $timestamp;
?>

<!-- 

"status_id": VALORES FIJOS
"pipeline_id": VALORES FIJOS
"loss_reason_id": VALORES FIJOS (null)

DB -> KOMMO TO JSON
    `id` -> 
    `asignado` ->               
    
    `idkommo` ->                id
    `lead_nombre` ->            name 
    `pipeline` -> 8859767
    `etapa` -> Llamar
    `programa` ->               custom_fields_values[]field_name[]value
    `programa_anterior` ->      custom_fields_values.
    `fecha_inicio` ->           custom_fields_values
    `horario` ->                custom_fields_values
    `fuente` ->                 custom_fields_values[0]Fuente
    `porcentaje_comision` ->    custom_fields_values
    `nivel_interes` ->              custom_fields_values
    `idorden` -> no enviar
    "loss_reason_id": null/blanco,
-->
