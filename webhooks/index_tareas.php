<?php
include 'model.php';
include 'model_api.php';
$model = new Model();
$model_api = new ApiModel();
date_default_timezone_set('America/Mexico_City');


// $json = $model->ToJson(file_get_contents('web_tareas.txt'));
// echo json_encode($json);
// $leads = $json['task']['add'][0];

// $cambio = $model->selectCambio($leads['element_id'])[0];
// echo $cambio['lead_nombre'];
// echo $cambio['fecha_asignacion'];

// echo "idkommo - > ".$leads['element_id']."<br>";
// echo "lead_nombre - > "."desde SQL"."<br>";
// echo "actividad - > ".$leads['text']."<br>";
// echo "id_responsable - > ".$leads['responsible_user_id']."<br>";
// echo "fecha - > ".$model->getDate($leads['created_at'])."<br>";
// echo "fecha_asignacion - > "."Desde SQL"."<br>";
// echo "task_type - > ".$leads['task_type']."<br>";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json = $model->ToJson(file_get_contents("php://input"));
    $leads = $json['task']['add'][0];

    $contacts = $model_api->getLeads($leads['element_id']);
    $contact = array('id'=>null,'name'=>null,'email'=>null,'phone'=>null);
    if (count($contacts) != 0) {
        $contact = $model_api->getContact($contacts[0]['id']);
        $contact = array(
            'id'=>$contact['id'],
            'name'=>$contact['name'],
            'email'=>$model->getValueFromItem($contact['custom_fields_values'], 'field_name', 'Email')['values'][0]['value'],
            'phone'=>$model->getValueFromItem($contact['custom_fields_values'], 'field_name', 'Phone')['values'][0]['value']
        );   
    }

    $cambio = $model->selectCambio($leads['element_id']);
    if (count($cambio) >= 1) {
        $model->insertTareas(
            // $idkommo,$lead_nombre,$actividad,
            $leads['element_id'],$cambio[0]['lead_nombre'],$leads['text'],
            // $id_responsable,$fecha,$fecha_asignacion
            $leads['responsible_user_id'],date('Y-m-d H:i:s'),$cambio[0]['fecha_asignacion'],
            // $model->getDate($leads['created_at'])
            
            // $idtipo
            $leads['task_type'],
            // $id_contacto,$contacto_nombre,$correo,$telefono,
            $contact['id'],$contact['name'],$contact['email'],$contact['phone']
        );
    }

}

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
// 	$jsonString = file_get_contents("php://input");
// 	$myFile = "tareas.json";
// 	file_put_contents($myFile, json_encode($jsonString));
// }

?>