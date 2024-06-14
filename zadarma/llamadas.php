<?php
include 'model_llamada.php';
$model = new Model_llamada();


$json = $model->ToJson(file_get_contents('llamada_1.txt'));
echo json_encode($json);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json = $model->ToJson(file_get_contents("php://input"));

    if($json['event']=='NOTIFY_OUT_END'){
        $model->insertLlamada(
            $json['call_start'],$json['caller_id'],$json['internal'],
            $json['destination'],$json['duration'],$json['status_code'],
            $json['calltype'],$json['disposition']
        );
    }
    
}

?>