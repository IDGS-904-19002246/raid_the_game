<?php
include 'model.php';

$model = new Model();
$data = $model->selectBy(0);
$week = 0;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['s'])) {
        if (is_numeric($_GET['s'])) {
            $data = $model->selectBy($_GET['s']);
            $week = $_GET['s'];
        }
    }
}


include 'view.php';
?>