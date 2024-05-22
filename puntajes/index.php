<?php
include 'model.php';
$model = new Model();
$data = $model->select();
$top = $model->selectTop();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["action"] == 'search') {
        $data = $model->selectBy($_POST["nombre"]);
    }
}


include 'view.php';
?>