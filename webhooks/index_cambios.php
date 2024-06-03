<?php
include 'model.php';
include 'model_api.php';
$model = new Model();
$model_api = new ApiModel();


$json = $model->ToJson(file_get_contents('web_cambios.txt'));
echo json_encode($json);
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
    $model->
    insertCambios(
        // $idkommo,$lead_nombre,$pipeline,
        $leads['id'],$leads['name'],$leads['pipeline_id'],
        // $etapa,$id_responsable,$fecha,
        $leads['status_id'],$leads['responsible_user_id'],$model->getDate($leads['date_create']),
        // $fuente,$fecha_asignacion
        $model->getValueFromItem($leads['custom_fields'], 'name','Fuente')['values'][0]['value'],
        $model->getDate($model->getValueFromItem($leads['custom_fields'], 'name','Fecha de Asignación')['values'][0])
    );
}


?>