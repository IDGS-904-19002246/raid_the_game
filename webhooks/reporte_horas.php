<?php
function conectarDB($ip, $user, $pass, $db)
{
    // $mysqli = new mysqli("74.208.39.15", "adcontrol_kommo_leads", "1dz0u3K%0", "adcontrol_kommo_leads");
    $mysqli = new mysqli($ip, $user, $pass, $db);
    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }
    $mysqli->set_charset("utf8");
    return $mysqli;
}
$mysqli = conectarDB("74.208.39.15", "adcontrol_kommo_leads", "1dz0u3K%0", "adcontrol_kommo_leads");
$mysqlis = conectarDB("104.254.245.234", "adcontrol", '491n$iuZ1', "scontrol2019");
date_default_timezone_set('America/Mexico_City');
// setlocale(LC_TIME, 'es_ES.UTF-8');
// DATOS GLOBALES
$today = date('Y-m-d');
$MyAsesor = 0;
$data = array();

// function compararPorFecha($a, $b)
// {
//     return strtotime($a['date']) - strtotime($b['date']);
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['MyAsesor'] != 0) {
        $today = $_POST['MyDate'];
        $MyAsesor = $_POST['MyAsesor'];
        $internal = $_POST['MyExtension'];
        // $sql = "SELECT 
        //     ca.fecha,
        //     DATE_FORMAT(ca.fecha, '%H:%i') hora
        //     FROM leads_kommo_cambios ca
        //     WHERE ca.id_responsable = {$MyAsesor} AND ca.fecha LIKE '{$today}%'
        //     ORDER BY ca.fecha DESC";

        $sql = "SELECT
                ca.idkommo,
                ca.fecha,
                DATE_FORMAT(ca.fecha, '%H:%i') hora,
                DATE_FORMAT(ca.fecha, '%H:%i:00') hora1,
                ca.lead_nombre,
                'cambios' actividad
            FROM leads_kommo_cambios ca  WHERE ca.id_responsable = {$MyAsesor} AND ca.fecha LIKE '{$today}%'
            UNION ALL
            SELECT
                n.idkommo,
                n.fecha,
                DATE_FORMAT(n.fecha, '%H:%i') hora,
                DATE_FORMAT(n.fecha, '%H:%i:00') hora1,
                n.lead_nombre,
                'notas' actividad
            FROM leads_kommo_notas n WHERE n.id_responsable = {$MyAsesor} AND n.fecha LIKE '{$today}%'
            UNION ALL
            SELECT
                t.idkommo,
                t.fecha,
                DATE_FORMAT(t.fecha, '%H:%i') hora,
                DATE_FORMAT(t.fecha, '%H:%i:00') hora1,
                t.lead_nombre,
                'tarea' actividad
            FROM leads_kommo_tareas t WHERE t.id_responsable = {$MyAsesor} AND t.fecha LIKE '{$today}%'
            UNION ALL
            SELECT
                0,
                ll.call_date,
                DATE_FORMAT(ll.call_date, '%H:%i') hora,
                DATE_FORMAT(ll.call_date, '%H:%i:00') hora1,
                ll.caller_id,
                'llamadas' actividad
            FROM leads_zadarma_llamadas ll WHERE ll.call_date LIKE '{$today}%' AND ll.internal = {$internal}";

        $result = $mysqli->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            usort($data, function ($a, $b) {
                return strtotime($b['fecha']) - strtotime($a['fecha']);
            });
            // echo json_encode($data);

        }
    }
}


// $sql = "SELECT 
//     DATE_FORMAT(ca.fecha, '%H:%i') hora
//     FROM leads_kommo_cambios ca
//     WHERE ca.id_responsable = 10471703 AND ca.fecha LIKE '2024-06-24%'
//     ORDER BY ca.fecha DESC ";
// // -- LIMIT 30";
// $datos = array();
// $result = $mysqli->query($sql);
// if ($result) {
//     while ($row = $result->fetch_assoc()) {
//         $datos[] = $row;
//     }
// }

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <style>
        * {
            font-family: Arial;
            font-size: 12px;
        }

        .MyTh {
            border: #3e2b0e solid 1px;
            background-color: #3e2b0e !important;
            color: white !important;
        }

        .MyTr.odd td {
            background-color: #EEF3FB !important;
        }

        .MyTr.even td {
            background-color: #FFFFFF !important;
        }

        table.dataTable thead .sorting {
            filter: invert(100%) !important;
        }
        .table td {
            box-shadow: none;
            border: #C1D4F1 solid 1px;
        }
    </style>
</head>

<body class="p-4">
    <!-- ENCABEZADO -->
    <div class="px-4">
        <div class="w-100">
            <form class="row w-100 m-0" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form">
                <input type="hidden" name="MyExtension" value="" id="MyExtension">
                <div class="col-sm-2 p-1">
                    <input class="form-control form-control-sm bg-light" type="text" value="ASESOR:" readonly disabled>
                </div>
                <div class="col-sm-4 p-1">
                    <select class="form-control form-control-sm" aria-describedby="MyAsesorHelp" id="MyAsesor"
                        name="MyAsesor">
                        <option value="0" extension="0">Ninguno</option>
                        <?php if ($mysqlis->connect_error): ?>
                        <?php else:
                            $sql2 = "SELECT p.idKommo, p.pnombre, p.idUsuarioKommo, p.extension from dwork_personal p WHERE p.idUsuarioKommo IS NOT null AND p.dip=4 AND p.inactivo=0";
                            $result2 = $mysqlis->query($sql2);
                            if ($result2):
                                while ($row2 = $result2->fetch_assoc()): ?>
                                    <option value="<?php echo $row2['idUsuarioKommo']; ?>" <?php echo ($MyAsesor == $row2['idUsuarioKommo'] ? 'selected' : 'no'); ?>
                                        extension="<?php echo $row2['extension']; ?>"><?php echo $row2['pnombre']; ?></option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-sm-2 p-1">
                    <input class="form-control form-control-sm bg-light" type="text" value="FECHA:" readonly disabled>
                </div>
                <div class="col-sm-2 p-1">
                    <input class="form-control form-control-sm bg-light" type="date" name="MyDate"
                        value="<?php echo $today; ?>" required>
                </div>

                <div class="col-sm-2 p-1">
                <div class="d-flex flex-row-reverse">
                    <!-- <div class="align-self-center text-center"> -->
                        <button type="button" id="MySubmit" class="btn btn-sm btn-primary w-75">Obtener Reporte</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <!-- TABLA -->
    <div class="p-4 w-100 ">
        <div class="overflow-auto">
            <table id="MyTable" class="table table-striped py-4 overflow-auto">
                <thead>
                    <tr class="text-center align-middle">
                        <th class="MyTh">#</th>
                        <th class="MyTh">ID Kommo</th>
                        <th class="MyTh">Nombre del Lead</th>
                        <th class="MyTh">Actividad</th>
                        <th class="MyTh">Hora</th>
                        <th class="MyTh" style="width:150px !important;">Tiempo desde la ultima<br>actividad (min)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < count($data); $i++): ?>
                        <tr class="MyTr">
                            <td><?php echo $i+1; ?></td>
                            <td><?php echo ($data[$i]['idkommo'] != '0') ? $data[$i]['idkommo'] : 'Llamada'; ?></td>
                            <td><?php echo $data[$i]['lead_nombre']; ?></td>
                            <td><?php echo $data[$i]['actividad']; ?></td>
                            <td><?php echo $data[$i]['hora']; ?></td>
                            <td><?php
                                
                            if($i+1 == count($data)){
                                echo '';
                            }else{
                                $date0 = strtotime($data[$i]['hora1']);
                                $date1 = strtotime($data[$i + 1]['hora1']);
                                $time = $date0 - $date1;
                                echo $time / 60;

                                
                                // echo $data[$i]['hora1'] .'<br>';
                                // echo $data[$i+1]['hora1'] .'<br>';
                                
                                // if ($time <= 3600) {
                                    
                                // } else {
                                //     echo round($time / 3600, 1);
                                // }
                            }
                            ?></td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- SECCION DE FIRMAS -->
    <div class="px-4" style="margin-top:150px;">
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-4 pl-4">
                <div class="bg-dark pt-1"></div>
                <span class="m-2" style="font-size: .875rem;">FIRMA ASESOR</span>
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-4">
                <div class="bg-dark pt-1"></div>
                <span class="m-2" style="font-size: .875rem;">FIRMA SUPERVISOR</span>
            </div>
            <div class="col-sm-1"></div>
        </div>
    </div>
    <!-- <table class="table table-striped bg-danger">
        <thead>
            <tr>
                <th scope="col">index</th>
                <th scope="col">hora</th>
                <th scope="col">min desda la ultima actualizacion</th>
            </tr>
        </thead>
        <tbody>
            ?php for ($i = 0; $i < count($datos) - 1; $i++): ?>
                <tr>
                    <td>?php echo $i; ?></td>
                    <td>?php echo $datos[$i]['hora']; ?></td>
                    <td>?php
                    $date0 = strtotime($datos[$i]['hora']);
                    $date1 = strtotime($datos[$i + 1]['hora']);
                    echo ($date0 - $date1) / 60 . ' min';

                    ?></td>
                </tr>
            ?php endfor; ?>
        </tbody>
        
    </table> -->
    <!-- ?php
        // $date1 = strtotime('2024-06-24 13:30:18');
        $date0 = strtotime('13:30:18');
        $date1 = strtotime('15:30:18');
        echo date('H:m:s',($date1-$date0));
        ?> -->

</body>
<script>
    $(document).ready(function () {
        $('#MyTable').DataTable({
            language: { "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json" },
            columnDefs: [{ type: 'num', targets: 5 } ]
            // searching: false,
            // paging: false,
            // info: false
        });

    });
    var select = document.getElementById('MyAsesor');
    var select2 = document.getElementById('MySubmit');
    select2.addEventListener('click', function (e) {
        var selectedOption = select.options[select.selectedIndex];
        $('#MyExtension').val(selectedOption.getAttribute('extension'));
        $('#form').submit();
    });
</script>