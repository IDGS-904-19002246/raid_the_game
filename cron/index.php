<?php
include 'model.php';
$ModelCron = new ModelCron();
date_default_timezone_set('America/Mexico_City');

echo json_encode($ModelCron->selectPersonal());

?>