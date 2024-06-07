<?php
include 'model.php';
$ModelCron = new ModelCron();
date_default_timezone_set('America/Mexico_City');

$personal_list = $ModelCron->selectPersonal();

foreach ($personal_list as $P) {
    for ($i=0; $i < $P['asignacionDiaria']; $i++) { 
        // echo $P['idKommo']. '<br>';
        echo json_encode($ModelCron->selectCron()) . '<br>';
    }
}

// echo json_encode($ModelCron->selectPersonal());

?>