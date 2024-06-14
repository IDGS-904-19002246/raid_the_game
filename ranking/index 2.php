<?php
include 'model.php';
$model = new Model();
$data = $model->select();
$top = $model->selectTop();

$week_data = $model->selectBy("'2024-06-05' AND '2024-06-09'");
$week = 0;
$weeks_optcions = array(
    "'2024-06-05' AND '2024-06-09'",
"'2024-06-09' AND '2024-06-16'",
"'2024-06-16' AND '2024-06-23'",
"'2024-06-23' AND '2024-06-30'",
"'2024-06-30' AND '2024-07-07'",
"'2024-07-07' AND '2024-07-14'",
"'2024-07-14' AND '2024-07-21'",
"'2024-07-21' AND '2024-07-28'"
);

// if ($_SERVER["REQUEST_METHOD"] == "POST") {

//     if ($_POST["action"] == 'insert') {
//         // echo $model->selectBy($_POST["ticket"]);
//         if ($model->selectBy($_POST["ticket"]) == 0) {
            
//             move_uploaded_file($_FILES['photo']['tmp_name'], 'assets/tickets_fotos/' . $_POST['ticket'].'.jpg');
//             date_default_timezone_set('America/Mexico_City');
//             $date = date('Y-m-d');
//             $response = $model->insert(
//                 $_POST["user_name"],
//                 $_POST["ticket"],
//                 $_POST["email"],
//                 $_POST["telephone"],
//                 $_POST["state"],
//                 $_POST["city"],
//                 $_POST["establishment"],
//                 ($_POST["ticket"].'.jpg'),
//                 $date
//             );
//             echo "1";            
//         }else {
//             echo "0";
//         }
//     }
// }
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['s'])) {
        if (in_array($_GET['s'], $weeks_optcions)) {
            $week_data = $model->selectBy($_GET['s']);
            $week = $_GET['s'];
        }
    }
}

include 'view.php';
?>