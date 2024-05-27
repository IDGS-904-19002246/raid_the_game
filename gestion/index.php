<?php
include 'model.php';
$model = new Model();
$data = $model->select();
// $top = $model->selectTop();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $model->updateVefication($_POST['id'],$_POST['new']);
    $data = $model->select();

    $email = $_POST['email'];

    if ($_POST['new'] == '2') {
        $message = ($_POST['msg'] =='' ? 'Lamentablemente su ticket no fue aceptado para participar': $_POST['msg']);
    }
    if ($_POST['new'] == '1') {
        $link = 'https://expertosraid.com/juego/index.php?ticket='.$_POST['ticket'];
        $message = 'Ya se puede jugar, acceda al siguiente enlace';
    }

    echo $message;
    
}


include 'view.php';
?>