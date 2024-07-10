<?php
include 'model.php';
$ModelCronCheck = new ModelCronCheck();
date_default_timezone_set('America/Mexico_City');
$today = '2024-07-05';

$check_list = $ModelCronCheck->selectCheck($today);
foreach ($check_list as $checks) {
    if(count($checks['checkit']) >= 4){
        
        // echo $checks['PersonName'].'<br>';
        for ($i=0; $i < count($checks['checkit'])-1 ; $i++) { 
            $hour0 = strtotime($checks['checkit'][$i].':00');
            $hour1 = strtotime($checks['checkit'][$i+1].':00');
            $time = ($hour1 - $hour0)/ 60;
            // COMVERTIR HORAS EN OBJETOS
            $checks['checkit'][$i] = [
                'start'=> $checks['checkit'][$i],
                'end'=> $checks['checkit'][$i+1],
                'time'=> $time
            ];
        }
        // ELIMINA HORA DE SALIDA SUELTA
        array_pop($checks['checkit']);
        // ELIMNA PEDIODOS ENTRE ENTRADA Y SALIDA 
        array_splice($checks['checkit'], 0, 1);
        array_pop($checks['checkit']);
        // ELEMENTO QUE MAS SE ASERCA A 30 MIN (HORA DE COMER)
        $item_to_inset = $ModelCronCheck->CloseTo30($checks['checkit']);

        $assistants = array_map('intval', array($checks['PersonID']));
        if($item_to_inset){
            echo $ModelCronCheck->insertParo(
                $checks['PersonID'],
                $today.' '.$item_to_inset['start'].':00',
                $today.' '.$item_to_inset['end'].':00',
                json_encode($assistants),
                'Hora de Comida'
            ).'<br>';
        }
        // echo '------------------------------<br>';
    }else{
        // echo $checks['PersonName']. ' No salio a comer <br>';
        // echo '------------------------------<br>';
    }
}


?>