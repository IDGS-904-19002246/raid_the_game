<?php
function conectarDB() {
    // DB->PLESK
    // $mysqli = new mysqli("localhost", "adcontrol", "Ev7*5q2a9", "adcontrol");
    $mysqli = new mysqli("74.208.39.15", "adcontrol_kommo_leads", "1dz0u3K%0", "adcontrol_kommo_leads");

    // DB->LOCAL
    // $mysqli = new mysqli("localhost", "root", "", "db_juegos");
    // Verificar conexión
    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }

    return $mysqli;
}
?>