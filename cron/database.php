<?php
function conectarDB() {
    // DB->PLESK
    $mysqli = new mysqli("74.208.39.15", "adcontrol_kommo_leads", "1dz0u3K%0", "adcontrol_kommo_leads");
    $mysqli->set_charset("utf8mb4");
    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }
    return $mysqli;
}
function conectarDB_AD() {
    // DB->PLESK
    $mysqli = new mysqli("104.254.245.234", "adcontrol", '491n$iuZ1', "scontrol2019");
    if ($mysqli->connect_error) {die("Error de conexión: " . $mysqli->connect_error);}
    return $mysqli;
}
?>