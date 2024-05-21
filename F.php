<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {    
    $mysqli = conectarDB();
    $postData = file_get_contents("php://input");
    $jsonData = json_decode($postData, true);

    // $sql_no_repeat = "SELECT * FROM tbl_puntajes WHERE ticket = '".$jsonData['ticket']."'";
    // $result_no_repeat = $mysqli->query($sql_no_repeat);
    // if ($result_no_repeat->num_rows == 0) {

    $sql = "UPDATE tbl_puntajes SET
        status = 1,
        score = ".$jsonData['score'].",
        date = '".date('Y-m-d')."'
        WHERE ticket = '".$jsonData['ticket']."'";
    
    $result = $mysqli->query($sql);
    if ($mysqli->query($sql) == 1) {
        echo 'TO BIEN';
    } else {
        echo 'TO MAL';
        echo $mysqli->error;
    }
    $mysqli->close();
    // }
    // else {
    //     echo 'NO BIEN';
    // }
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['ticket'])) {
        $mysqli = conectarDB();
        $sql_no_repeat = "SELECT * FROM tbl_puntajes WHERE ticket = '".$_GET['ticket']."' AND status = 1";
        $result_no_repeat = $mysqli->query($sql_no_repeat);
        if ($result_no_repeat->num_rows == 0) {
            echo 1;
        }else{
            echo 0;
        }
        $mysqli->close();
    }else {
        echo 0;
    }  
}




?>