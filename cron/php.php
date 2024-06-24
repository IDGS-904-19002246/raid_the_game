
<?php 
include 'database.php';
$mysqli = conectarDB();
if ($mysqli->connect_error) {die("Error de conexión: " . $mysqli->connect_error);}

$sql = "SELECT 
    DATE_FORMAT(ca.fecha, '%H:%i') hora
    FROM leads_kommo_cambios ca
    WHERE ca.id_responsable = 10471703 AND ca.fecha LIKE '2024-06-24%'
    ORDER BY ca.fecha DESC ";
    // -- LIMIT 30";

    $datos = array();
    $result = $mysqli->query($sql);
    if ($result){
        while ($row = $result->fetch_assoc()) {
            $datos[] = $row;
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    

<table class="table table-striped bg-danger">
	<!-- <row>
		<field name="fecha">?php
            $date = date_create('2024-06-24 13:30:18');
            echo date_format($date, 'H:i:s');

        ?></field>
	</row> -->
    <thead>
        <tr>
            <th scope="col">index</th>
            <th scope="col">hora</th>
            <th scope="col">min desda la ultima actualizacion</th>
        </tr>
    </thead>
    <tbody>
    <!-- ------------------------------------------------------------------------------------------------- -->
    <?php for ($i=0; $i < count($datos)-1; $i++):?>
        <tr>
            <td><?php echo $i;?></td>
            <td><?php echo $datos[$i]['hora'];?></td>
            <td><?php
                $date0 =  strtotime($datos[$i]['hora']);
                $date1 =  strtotime($datos[$i+1]['hora']);
                echo ($date0-$date1)/60 . ' min';

                // echo $datos[$i]['hora'];
                ?></td>
        </tr>
    <?php endfor;?>
    </tbody>
    <!-- ------------------------------------------------------------------------------------------------- -->
    <!-- ?php
    // $date1 = strtotime('2024-06-24 13:30:18');
    $date0 = strtotime('13:30:18');
    $date1 = strtotime('15:30:18');
    echo date('H:m:s',($date1-$date0));
    ?> -->
    
	<!--  -->
</table>


</body>
</html>