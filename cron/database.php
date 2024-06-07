<?php
function conectarDB($host,$user,$pass,$db) {
    // DB->PLESK
    // $mysqli = new mysqli("localhost", "adcontrol", "Ev7*5q2a9", "adcontrol");
    $mysqli = new mysqli($host,$user,$pass,$db);

    // DB->LOCAL
    // $mysqli = new mysqli("localhost", "root", "", "db_juegos");
    // Verificar conexión
    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }

    return $mysqli;
}
?>