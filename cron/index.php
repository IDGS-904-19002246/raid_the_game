<?php
include 'model.php';
$ModelCron = new ModelCron();
date_default_timezone_set('America/Mexico_City');

//SUMA UNA DIA
$hoy0 = date('Y-m-d');
$hoy = strtotime($hoy0 . "+1 day");

$personal_list = $ModelCron->selectPersonal();
$suma = $ModelCron->selectPersonalSum()[0]['total'];
$count = 0;

while ($count <= ($suma - 1)) {

    for ($i = 0; $i < count($personal_list); $i++) {
        if ($count <= ($suma - 1)) {
            if ($personal_list[$i]['asignacionDiaria'] >= 1) {
                echo $personal_list[$i]['pnombre'] . " tareas {$count}/{$suma}". '<br>';
                // UPDATE
                $cron = $ModelCron->selectCron();
                $json = '{
                    "id":"' . $cron[0]['idkommo'] . '",
                    "status_id": 69303179,
                    "pipeline_id": 8859767,
                    "loss_reason_id": null,
                    "price": 0,
                    "responsible_user_id":'.$personal_list[$i]['idKommo'].',

                    "custom_fields_values":[
                        {
                            "field_id": 936898,
                            "field_name": "Fecha de inicio",
                            "field_type": "date",
                            "values": [{"value": ' . strtotime($cron[0]['fecha_inicio'] . "+1 day") . '}]
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
                    
                $ModelCron->updateCron($cron[0]['id'],$hoy0);
                $ModelCron->updateCronAPI($cron[0]['idkommo'], $json);

                $personal_list[$i]['asignacionDiaria']--;
                $count++;
            }
        }
    }



}


// foreach ($personal_list as $P) {
//     echo "TAREAS PARA {$P['pnombre']} <br>";
//     $list = $ModelCron->selectCron($P['asignacionDiaria']);
//     foreach ($list as $l) {

//         // echo json_encode($l).'<hr>';
//         echo json_encode($l['id'].' - '.$l['idkommo'] .' - '.$l['lead_nombre']).'<br>';

//         // UPDATE
//         $ModelCron->updateCron($l['id']);
//         $json = '{
//             "id":"' . $l['idkommo'] . '",
//             "status_id": 69303179,
//             "pipeline_id": 8859767,
//             "loss_reason_id": null,
//             "price": 0,
//             "custom_fields_values":[
//                 {
//                     "field_id": 936898,
//                     "field_name": "Fecha de inicio",
//                     "field_type": "date",
//                     "values": [{"value": ' . strtotime($l['fecha_inicio']."+1 day") . '}]
//                 },
//                 {
//                     "field_id": 936900,
//                     "field_name": "Horario",
//                     "field_type": "select",
//                     "values": [{"value": "'.$l['horario'].'"}]
//                 },
//                 {
//                     "field_id": 934468,
//                     "field_name": "% de Comisión",
//                     "field_code": null,
//                     "field_type": "numeric",
//                     "values": [{"value": "'.$l['porcentaje_comision'].'"}]
//                 },
//                 {
//                     "field_id": 936758,
//                     "field_name": "Fecha de Asignacion",
//                     "field_type": "date",
//                     "values": [{"value": '.$hoy.'}]
//                 },
//                 {
//                     "field_id": 936842,
//                     "field_name": "Nivel de Interés",
//                     "field_code": null,
//                     "field_type": "select",
//                     "values": [{"value": null}]
//                 },
//                 {
//                     "field_id": 937428,
//                     "field_name": "Tipo de propuesta",
//                     "field_code": null,
//                     "field_type": "select",
//                     "values": [{"value": null}]
//                 },

//                 {
//                     "field_id": 934470,
//                     "field_name": "Descuento aplicado",
//                     "field_code": null,
//                     "field_type": "select",
//                     "values": [{"value":null}]
//                 }


//                     ]}';

//         $ModelCron->updateCronAPI($l['idkommo'], $json);
//     }
// }

// $fecha_actual = date('Y-m-d H:i:s');
// // CONVIERTE LA FECHA ACTUAL A UN TIMESTAMP
// $timestamp = strtotime($fecha_actual);
// // IMPRIME EL TIMESTAMP
// echo $timestamp;
?>

<!-- 

 "status_id": 69303179,
        "pipeline_id": 8859767,
        "loss_reason_id": null

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



<!-- 
{
    "id": 5765922,
    "name": "Marcelo Velarde Porras Porras",
    "price": 0,
    "responsible_user_id": 10471703,
    "group_id": 0,
    "status_id": 143,
    "pipeline_id": 7810667,
    "loss_reason_id": 18764247,
    "created_by": 0,
    "updated_by": 0,
    "created_at": 1709579763,
    "updated_at": 1713970855,
    "closed_at": 1709739580,
    "closest_task_at": null,
    "is_deleted": false,
    "custom_fields_values": [
        {
            "field_id": 926914,
            "field_name": "WhatsApp Verificado",
            "field_code": null,
            "field_type": "text",
            "values": [
                {
                    "value": "TRUE"
                }
            ]
        },
        {
            "field_id": 747418,
            "field_name": "Participantes",
            "field_code": null,
            "field_type": "text",
            "values": [
                {
                    "value": "1"
                }
            ]
        },
        {
            "field_id": 747666,
            "field_name": "pgr",
            "field_code": null,
            "field_type": "text",
            "values": [
                {
                    "value": "Diplomado en Creación Digital"
                }
            ]
        },
        {
            "field_id": 862832,
            "field_name": "Fuente",
            "field_code": null,
            "field_type": "text",
            "values": [
                {
                    "value": "pagina web movil"
                }
            ]
        },
        {
            "field_id": 747664,
            "field_name": "Programa",
            "field_code": null,
            "field_type": "select",
            "values": [
                {
                    "value": "Diplomado en Creación Digital",
                    "enum_id": 656296,
                    "enum_code": null
                }
            ]
        }
    ],
    "score": null,
    "account_id": 32067039,
    "labor_cost": null,
    "_links": {
        "self": {
            "href": "https://auladisermx.kommo.com/api/v4/leads/5765922?with=contacts&page=1&limit=250"
        }
    },
    "_embedded": {
        "tags": [
            {
                "id": 61124,
                "name": "FBD",
                "color": null
            }
        ],
        "companies": [],
        "contacts": [
            {
                "id": 7140816,
                "is_main": true,
                "_links": {
                    "self": {
                        "href": "https://auladisermx.kommo.com/api/v4/contacts/7140816?with=contacts&page=1&limit=250"
                    }
                }
            }
        ]
    }
} -->