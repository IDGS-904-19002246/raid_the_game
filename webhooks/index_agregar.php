<?php
include 'model.php';
include 'model_api.php';
$model = new Model();
$model_api = new ApiModel();
date_default_timezone_set('America/Mexico_City');

$json = $model->ToJson(file_get_contents('web_agregar.txt'));
$lead = $json['leads']['add'][0];

// echo 'id: '.$lead["id"].'<br>';
// echo 'name: '.$lead["name"].'<br>';
// echo 'status_id: '.$lead["status_id"].'<br>';
// echo 'pipeline_id: '.$lead["pipeline_id"].'<br>';
// echo 'responsible_user_id: '.$lead["responsible_user_id"].'<br>';
// echo 'created_user_id: '.$lead["created_user_id"].'<br>';
// echo 'created_at: '.$model->getDate($lead["created_at"]).'<br>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json = $model->ToJson(file_get_contents("php://input"));
    $lead = $json['leads']['add'][0];
    $model->insertAgregar(
        $lead['id'],$lead['name'],$lead['status_id'],
        $lead['pipeline_id'],$lead['responsible_user_id'],$lead['created_user_id'],
        $model->getDate($lead['created_at'])
    );
}

?>