<?php
function conectarDB() {
    // DB->PLESK
    // $mysqli = new mysqli("localhost", "adcontrol", "Ev7*5q2a9", "adcontrol");
    // DB->LOCAL
    $mysqli = new mysqli("localhost", "root", "", "db_juegos");

    // Verificar conexión
    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }

    return $mysqli;
}
?>