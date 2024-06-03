<?php
include 'model.php';
$model = new Model();



$json = $model->ToJson(file_get_contents('web_notas.txt'));
echo json_encode($json);
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
    // echo json_encode($json);
    $leads = $json['leads']['note'][0]['note'];

    $cambio = $model->selectCambio($leads['element_id']);
    if (count($cambio) >= 1) {
        $model->insertNotas(
            // $idkommo,$lead_nombre,$actividad,
            $leads['element_id'],$cambio[0]['lead_nombre'],$leads['text'],
            // $id_responsable,$fecha,$fecha_asignacion
            $leads['created_by'],$model->getDate($leads['created_at']),$cambio[0]['fecha_asignacion']
        );
    }
}

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
// 	$jsonString = file_get_contents("php://input");
// 	$myFile = "notas.json";
// 	file_put_contents($myFile, json_encode($jsonString));
// }
?>