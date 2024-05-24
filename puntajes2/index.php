<?php
include 'model.php';
$model = new Model();
$data = $model->select();
// $top = $model->selectTop();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $model->updateVefication($_POST['id'],$_POST['new']);
    $data = $model->select();
}


include 'view.php';
?>