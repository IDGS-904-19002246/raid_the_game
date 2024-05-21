<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if ($_GET['action']=='high') {
        $mysqli = conectarDB();
        $sql = "SELECT score FROM tbl_puntajes ORDER by score DESC LIMIT 1";
        $result = $mysqli->query($sql);
        if ($result) {
            $fila = $result->fetch_assoc();
            echo $fila['score'];
        }else {
            echo '0';
        }
        $mysqli->close();
    }
    if ($_GET['action']=='last') {
        $mysqli = conectarDB();
        $sql = "SELECT score FROM tbl_puntajes ORDER by date DESC LIMIT 1";
        $result = $mysqli->query($sql);
        if ($result) {
            $fila = $result->fetch_assoc();
            echo $fila['score'];
        }else {
            echo '0';
        }
        $mysqli->close();
    }  
}




?>