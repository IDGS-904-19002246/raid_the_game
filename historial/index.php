<?php
include 'model.php';
$model = new Model();
$data = json_decode('{"total":0, "data":[]}',true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["action"] == 'search') {
        $data = $model->selectBy($_POST['var']);
        // echo json_encode($model->selectBy($_POST['var']));
    }
}


include 'view.php';
?>