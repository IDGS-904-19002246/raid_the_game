<?php
include 'model.php';
$model = new Model();



$json = $model->ToJson(file_get_contents('web_tareas.txt'));
echo json_encode($json);
$leads = $json['task']['add'][0];

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

    $cambio = $model->selectCambio($leads['element_id']);
    if (count($cambio) >= 1) {
        $model->insertTareas(
            // $idkommo,$lead_nombre,$actividad,
            $leads['element_id'],$cambio[0]['lead_nombre'],$leads['text'],
            // $id_responsable,$fecha,$fecha_asignacion
            $leads['responsible_user_id'],$model->getDate($leads['created_at']),$cambio[0]['fecha_asignacion'],
            // $idtipo
            $leads['task_type']
        );
    }

}

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
// 	$jsonString = file_get_contents("php://input");
// 	$myFile = "tareas.json";
// 	file_put_contents($myFile, json_encode($jsonString));
// }

?>