<?php
include 'model.php';
include 'model_api.php';
$model = new Model();
$model_api = new ApiModel();
date_default_timezone_set('America/Mexico_City');

// $json = $model->ToJson(file_get_contents('web_notas.txt'));
// echo json_encode($json);

// $nota = $json['leads']['note'][0]['note'];

// $cambio = $model->selectCambio($nota['element_id'])[0];

// echo "idkommo -> ".$nota['element_id'];
// echo "<br>";
// echo "lead_nombre -> ".$cambio['lead_nombre'];
// echo "<br>";
// echo "actividad -> ".$nota['text'];
// echo "<br>";
// echo "id_responsable -> ".$nota['created_by'];
// echo "<br>";
// echo "fecha -> ".$model->getDate($nota['created_at']);
// echo "<br>";
// echo "fecha_asignacion -> ".$cambio['fecha_asignacion'];



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json = $model->ToJson(file_get_contents("php://input"));
    $leads = $json['leads']['note'][0]['note'];

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
        $model->insertNotas(
            // $idkommo,$lead_nombre,$actividad,
            $leads['element_id'],$cambio[0]['lead_nombre'],$leads['text'],
            // $id_responsable,$fecha,$fecha_asignacion
            $leads['created_by'],date('Y-m-d H:i:s'),$cambio[0]['fecha_asignacion'],
            // $model->getDate($leads['created_at'])

            // $id_contacto,$contacto_nombre,$correo,$telefono,
            $contact['id'],$contact['name'],$contact['email'],$contact['phone']
        );
    }
}

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
// 	$jsonString = file_get_contents("php://input");
// 	$myFile = "notas.json";
// 	file_put_contents($myFile, json_encode($jsonString));
// }
?>