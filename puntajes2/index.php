<?php
include 'model.php';
$model = new Model();
$data = $model->select();
$top = $model->selectTop();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST["action"] == 'insert') {
        // echo $model->selectBy($_POST["ticket"]);
        if ($model->selectBy($_POST["ticket"]) == 0) {
            
            move_uploaded_file($_FILES['photo']['tmp_name'], 'assets/tickets_fotos/' . $_POST['ticket'].'.jpg');
            date_default_timezone_set('America/Mexico_City');
            $date = date('Y-m-d');
            $response = $model->insert(
                $_POST["user_name"],
                $_POST["ticket"],
                $_POST["email"],
                $_POST["telephone"],
                $_POST["state"],
                $_POST["city"],
                $_POST["establishment"],
                ($_POST["ticket"].'.jpg'),
                $date
            );
            echo "1";            
        }else {
            echo "0";
        }
    }
}


include 'view.php';
?>