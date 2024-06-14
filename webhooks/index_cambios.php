<?php
include 'model.php';
include 'model_api.php';
$model = new Model();
$model_api = new ApiModel();
date_default_timezone_set('America/Mexico_City');


$json = $model->ToJson(file_get_contents('web_cambios.txt'));
$leads = $json['leads']['update'][0];
echo json_encode($leads);

// $contacts = $model_api->getLeads($leads['id']);

// $contact = array('id'=>null,'name'=>null,'email'=>null,'phone'=>null);

// if (count($contacts) != 0) {
//     $contact = $model_api->getContact($contacts[0]['id']);

//     $contact = array(
//         'id'=>$contact['id'],
//         'name'=>$contact['name'],
//         'email'=>$model->getValueFromItem($contact['custom_fields_values'], 'field_name', 'Email')['values'][0]['value'],
//         'phone'=>$model->getValueFromItem($contact['custom_fields_values'], 'field_name', 'Phone')['values'][0]['value']
//     );   
// }




// echo $model->getValueFromItem($contacto['custom_fields_values'],'field_name','Phone')['values'][0]['value'] ?? '- - -';

// 2686084 

// $contacto = $model_api->getContact(2234590);
// echo $contacto['id']. '<br>';
// echo $contacto['name']. '<br>';
// echo $model->getValueFromItem($contacto['custom_fields_values'],'field_name','Email')['values'][0]['value'] ?? '- - -';
// echo '<br>';
// echo $model->getValueFromItem($contacto['custom_fields_values'],'field_name','Phone')['values'][0]['value'] ?? '- - -';







// $leads = $json['leads']['update'][0];

// echo '<br> idkommo: '.$leads['id'];
// echo '<br> lead_nombre: '.$leads['name'];
// echo '<br> pipeline: '.$leads['pipeline_id'];
// echo '<br> etapa: '.$leads['status_id'];
// echo '<br> id_responsable: '.$leads['responsible_user_id'];
// echo '<br> fecha: '.$model->getDate($leads['date_create']);


// echo '-----------------------------------------<br>';
// echo '<br> fecha_asignacion: '.$model->getValueFromItem($leads['custom_fields'], 'name','Fuente')['values'][0]['value'];

// echo '<br> fuente: '.
//     $model->getDate(
//     $model->getValueFromItem($leads['custom_fields'], 'name','Fecha de Asignación')['values'][0]
//     );


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json = $model->ToJson(file_get_contents("php://input"));
    $leads = $json['leads']['update'][0];

    $contacts = $model_api->getLeads($leads['id']);
    echo json_encode($contacts);
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


    $model->
        insertCambios(
            // $idkommo,$lead_nombre,$pipeline,
            $leads['id'],
            $leads['name'],
            $leads['pipeline_id'],
            // $etapa,$id_responsable,$fecha,
            $leads['status_id'],
            $leads['responsible_user_id'],
            date('Y-m-d H:i:s'),
            // $model->getDate($leads['date_create']),
            // $fuente,$fecha_asignacion
            $model->getValueFromItem($leads['custom_fields'], 'name', 'Fuente')['values'][0]['value'],
            $model->getDate($model->getValueFromItem($leads['custom_fields'], 'name', 'Fecha de Asignación')['values'][0]),

            // $id_contacto,$contacto_nombre,$correo,$telefono,
            $contact['id'],$contact['name'],$contact['email'],$contact['phone']
        );
}


?>