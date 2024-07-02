<?php

// 69303187
// 142
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

setlocale(LC_TIME, 'es_ES.UTF-8');
$base = new DateTime('last monday');

// WEEK
$lun = date_create($base->format('Y-m-d'));
$base->modify('+1 day');
$mar = date_create($base->format('Y-m-d'));
$base->modify('+1 day');
$mie = date_create($base->format('Y-m-d'));
$base->modify('+1 day');
$jue = date_create($base->format('Y-m-d'));
$base->modify('+1 day');
$vie = date_create($base->format('Y-m-d'));
$base->modify('+1 day');
$sab = date_create($base->format('Y-m-d'));

// echo date_format($lun,'Y-m-d');
// echo date_format($lun,"d/M/y");
$anioActual = date('Y');
$fecha = new DateTime("$anioActual-01-01");
$diaSemana = $fecha->format('N');
if ($diaSemana != 1) {$fecha->modify('next monday');}

$weeks = array();
while($base >= $fecha){
    $l = date_format($fecha, 'd M');
    // $fecha->format('Y-m-d');
    $v = $fecha->modify('next friday');
    $new = [
        'lunes'=>$l,
        'viernes'=>date_format($v, 'd M')
        // $v->format('Y-m-d')
    ];
    array_push($weeks, $new);
    $fecha->modify('next monday');
}


$asignados = json_decode('{}', true);

$meets = json_decode('{}', true);
$inscritos = json_decode('{}', true);
$llamadas = json_decode('{}', true);
$interesados = json_decode('{}', true);
$prospectos = json_decode('{}', true);
$ingreso = 0;
$MyAsesor = 0;
$MyCedula = '';
$weeksback = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['weeksback'])) {
        if ($_POST['weeksback'] != 0 && $_POST['weeksback'] != null) {
            $base = $base->sub(new DateInterval('P' . $_POST['weeksback'] . 'W'));
            $lun = date_create($base->format('Y-m-d'));
            $base->modify('+1 day');
            $mar = date_create($base->format('Y-m-d'));
            $base->modify('+1 day');
            $mie = date_create($base->format('Y-m-d'));
            $base->modify('+1 day');
            $jue = date_create($base->format('Y-m-d'));
            $base->modify('+1 day');
            $vie = date_create($base->format('Y-m-d'));
            $base->modify('+1 day');
            $sab = date_create($base->format('Y-m-d'));
            $weeksback = $_POST['weeksback'];
        }
    }
    if (isset($_POST['MyAsesor']) && isset($_POST['MyCedula'])) {
        $MyAsesor = $_POST['MyAsesor'];
        $MyCedula = $_POST['MyCedula'];
        $extension = (isset($_POST['extension']) ? $_POST['extension'] : 0);
        $pid = (isset($_POST['pid']) ? $_POST['pid'] : 0);

        $start = date_format($lun, 'Y-m-d');
        $end = date_format($sab, 'Y-m-d');

        // TOTAL DE ASIGNADOS 
        $sql = "SELECT JSON_OBJECTAGG(f, c) AS asignados FROM (
                SELECT
                    cr.fecha_asignado f,COUNT( DISTINCT cr.idkommo) c
                FROM leads_kommo_cron cr
                WHERE cr.idKommoResponsable = {$MyAsesor} 
                AND (cr.fecha_asignado BETWEEN '{$start}' AND '{$end}')
                GROUP BY cr.fecha_asignado
            ) AS asignados";
        $result = $mysqli->query($sql);
        if ($result) {
            $asignados = json_decode($result->fetch_assoc()['asignados'] ?? '{}', true);
        }

        
        // INSCRITOS
        $sql= "SELECT
            DATE(t.fecha_altagpo) f,COUNT(DISTINCT t.agid) c
            FROM dwork_alumnos_grupos t
            WHERE (t.fecha_altagpo BETWEEN '{$start}' AND '{$end}') AND
            t.dequienes = {$pid} GROUP BY DATE(t.fecha_altagpo)";
        $result = $mysqlis->query($sql);
        if ($result) {
            while($row = $result->fetch_assoc()){
                $inscritos[$row['f']] = $row['c'];
            }
        }
        // MEETS
        $sql = "SELECT JSON_OBJECTAGG(f, cc) AS meets FROM (
            SELECT DATE(c.fecha) f,COUNT(DISTINCT c.idkommo) cc
            FROM leads_kommo_tareas c
            WHERE (c.fecha BETWEEN '{$start}' AND '{$end}')
            AND c.id_responsable = {$MyAsesor} AND c.idtipo = 2
            GROUP BY DATE(c.fecha)
        ) AS meets";
        $result = $mysqli->query($sql);
        if ($result) {
            $meets = json_decode($result->fetch_assoc()['meets'] ?? '{}', true);
        }
        //LLAMADAS EFECTIVAS
        $sql = "SELECT JSON_OBJECTAGG(f, c) AS llamadas FROM (
            SELECT DATE(ll.call_date) f,COUNT(distinct ll.destination) c
            FROM leads_zadarma_llamadas ll
            WHERE (ll.call_date BETWEEN '" . date_format($lun, 'Y-m-d') . "' AND '" . date_format($sab, 'Y-m-d') . "')
            AND ll.duration >= 20 AND ll.internal = " . $extension . "
            GROUP BY DATE(ll.call_date)
        ) AS llamadas";
        $result = $mysqli->query($sql);
        if ($result) {
            $llamadas = json_decode($result->fetch_assoc()['llamadas'] ?? '{}', true);
        }
        // INTERESADOS
        $sql = "SELECT JSON_OBJECTAGG(f, c) AS interesados FROM (
	        SELECT DATE(t.fecha) f,COUNT( DISTINCT t.idkommo) c
            FROM leads_kommo_cambios t
            WHERE (t.fecha BETWEEN '" . date_format($lun, 'Y-m-d') . "' AND '" . date_format($sab, 'Y-m-d') . "')
            AND date(t.fecha) = DATE(t.fecha_asignacion)
            AND t.id_responsable = " . $MyAsesor . " AND t.etapa = 69303183
            GROUP BY DATE(t.fecha)
        ) AS interesados";
        $result = $mysqli->query($sql);
        if ($result) {
            $interesados = json_decode($result->fetch_assoc()['interesados'] ?? '{}', true);
        }
        // PROSPECTOS
        $sql = "SELECT JSON_OBJECTAGG(f, c) AS prospectos FROM (
	        SELECT DATE(t.created_at) f,COUNT( DISTINCT t.idkommo) c
            FROM leads_kommo_agregados t
            WHERE (t.created_at BETWEEN '" . date_format($lun, 'Y-m-d') . "' AND '" . date_format($sab, 'Y-m-d') . "')
            AND t.created_user_id = " . $MyAsesor . "
            GROUP BY DATE(t.created_at)
        ) AS prospectos";
        $result = $mysqli->query($sql);
        if ($result) {
            $prospectos = json_decode($result->fetch_assoc()['prospectos'] ?? '{}', true);
        }
        // INGRESO
        $sql = "SELECT sum(a.abcantidad) as cobrado
            from dwork_alumnos_abonos a
            inner join dwork_alumnos_grupos b on a.agid=b.agid
            where b.dequienes=2 and 
                a.abfecha BETWEEN '" . date_format($lun, 'Y-m-d') . "' AND '" . date_format($sab, 'Y-m-d') . "'";
        $result = $mysqlis->query($sql);
        if ($result) {
            $ingreso = $result->fetch_assoc()['cobrado'] ?? 0;
        }
    }
}

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
    <!-- CHART - canvasjs.com -->
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <style>
        * {
            font-family: Arial !important;
            font-size: 12px !important;
        }

        .MyTh {
            font-size: 12px !important;
            font-weight: bold !important;
            background-color: #C1D4F1 !important;
        }

        .MyTd {
            background-color: #EEF3FB !important;
        }
        .MyTdButton {
            border-bottom: #C1D4F1 solid 2px;
        }

        .MyThDate {
            writing-mode: sideways-lr;
            padding: 10px;
            width: 3em;
            text-align: center;
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
        <h6 class="border border-dark text-center m-0">
            <div class="border border-dark p-1" style="font-size: 1.5rem !important;">FORMATO PLAN DE TRABAJO SEMANAL
            </div>
        </h6>
        <div class="border border-dark w-100">
            <form class="row w-100 m-0" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form">
                <input type="hidden" name="extension" value="" id="MyExtension">
                <input type="hidden" name="pid" value="" id="MyPid">
                <div class="col-sm-2 border border-dark p-1">
                    <input class="form-control form-control-sm bg-light" type="text" value="ASESOR:" readonly disabled>
                </div>
                <div class="col-sm-2 border border-dark p-1">
                    <select class="form-control form-control-sm" aria-describedby="MyAsesorHelp" id="MyAsesor"
                        name="MyAsesor">
                        <option value="0" extension="0">Ninguno</option>
                        <?php if ($mysqlis->connect_error): ?>
                        <?php else:
                            $sql2 = "SELECT p.pid, p.idKommo, p.pnombre, p.idUsuarioKommo, p.extension from dwork_personal p WHERE p.dip=4 AND p.inactivo=0";
                            $result2 = $mysqlis->query($sql2);
                            if ($result2):
                                while ($row2 = $result2->fetch_assoc()): ?>
                                    <option
                                        value="<?php echo $row2['idUsuarioKommo']; ?>"
                                        extension="<?php echo $row2['extension']; ?>"
                                        pid="<?php echo $row2['pid']; ?>"
                                        <?php echo ($MyAsesor == $row2['idUsuarioKommo'] ? 'selected' : 'no'); ?>
                                        ><?php echo $row2['pnombre']; ?></option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <!-- <div class="col-sm-2 border border-dark p-1">
                    <div class="d-flex ">
                        <label for="" class="px-2">Semanas atras</label>
                        <input class="form-control form-control-sm bg-light w-25" type="number"
                            value="?php echo $weeksback ?? 0; ?>" name="weeksback" min="0">
                    </div>
                </div> -->
                <!-- <div class="col-sm-2 border border-dark p-1">
                    <input class="form-control form-control-sm bg-light" type="text" value="CEDULA:" readonly disabled>
                </div>
                <div class="col-sm-2 border border-dark p-1">
                    <input type="text" class="form-control form-control-sm" aria-describedby="DateHelp" id="MyCedula"
                        name="MyCedula" value="LEON GUANAJUATO" required>
                </div> -->
                <div class="col-sm-1 border border-dark p-1">
                    <div class="align-self-center text-center">
                        <button type="button" id="MySubmit" class="btn btn-sm btn-primary w-75">Obtener Reporte</button>
                    </div>
                </div>

                <div class="col-sm-4 border border-dark p-1">
                    <select class="form-control form-control-sm" name="weeksback" >
                        <?php for($i = count($weeks) - 2; $i >= 0; $i--):?>
                            <option value=<?php echo count($weeks) - $i - 2; ?> ><?php
                                echo 'Lunes '. $weeks[$i]['lunes'].' - Viernes '. $weeks[$i]['viernes'];
                                ?></option>    
                        <?php endfor;?>
                    </select>
                </div>

            </form>
        </div>
    </div>
    <!-- TABLA -->
    <div class="px-4 w-100">
        <div class="col-sm-12 overflow-auto">
            <table id="MyTable" class="table table-striped overflow-auto">
                <thead>
                    <tr class="text-center align-middle">
                        <th class="MyTh" colspan="2" style="width:20%;">ACTIVIDAD</th>
                        <th class="MyTh" style="width:20%;">TIEMPO</th>

                        <th class="MyTh MyThDate"><?php echo date_format($lun, 'd M y'); ?></th>
                        <th class="MyTh MyThDate"><?php echo date_format($mar, 'd M y'); ?></th>
                        <th class="MyTh MyThDate"><?php echo date_format($mie, 'd M y'); ?></th>
                        <th class="MyTh MyThDate"><?php echo date_format($jue, 'd M y'); ?></th>
                        <th class="MyTh MyThDate"><?php echo date_format($vie, 'd M y'); ?></th>

                        <th class="MyTh" style="width:10%;">TOTAL</th>
                        <th class="MyTh" style="width:10%;">TASA DE CONVERSION</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- PROSPECTOS ASIGNADOS -->
                    <tr>
                        <td class="text-center align-middle">1</td>
                        <td class="align-middle">PROSPECTOS ASIGNADOS</td>

                        <td class="MyTd align-middle">PLANEADO</td>
                        <td class="MyTd align-middle text-center">
                            <?php echo isset($asignados[date_format($lun, 'Y-m-d')]) ? $asignados[date_format($lun, 'Y-m-d')] : 0; ?>
                        </td>
                        <td class="MyTd align-middle text-center">
                            <?php echo isset($asignados[date_format($mar, 'Y-m-d')]) ? $asignados[date_format($mar, 'Y-m-d')] : 0; ?>
                        </td>
                        <td class="MyTd align-middle text-center">
                            <?php echo isset($asignados[date_format($mie, 'Y-m-d')]) ? $asignados[date_format($mie, 'Y-m-d')] : 0; ?>
                        </td>
                        <td class="MyTd align-middle text-center">
                            <?php echo isset($asignados[date_format($jue, 'Y-m-d')]) ? $asignados[date_format($jue, 'Y-m-d')] : 0; ?>
                        </td>
                        <td class="MyTd align-middle text-center">
                            <?php echo isset($asignados[date_format($vie, 'Y-m-d')]) ? $asignados[date_format($vie, 'Y-m-d')] : 0; ?>
                        </td>
                        <td class="MyTd align-middle text-center"><?php echo array_sum($asignados); ?></td>
                        <td></td>
                    </tr>
                    <!-- INTERESADOS NUEVOS -->
                    <tr>
                        <td class="text-center align-middle">2</td>
                        <td class="align-middle">INTERESADOS NUEVOS</td>
                        <!-- ------------------------------------------------------------------ -->
                        <td class="p-0">
                            <div class="p-2 MyTd MyTdButton">OBJETIVO</div>
                            <div class="p-2 MyTd">RESULTADO</div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">10</div>
                            <div class="p-2">
                                <?php echo isset($inscritos[date_format($lun, 'Y-m-d')]) ? $inscritos[date_format($lun, 'Y-m-d')] : 0; ?>
                            </div>
                            <!-- ?php echo ($inscritos[date_format($lun, 'Y-m-d')] ?? 0) ?> -->
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">10</div>
                            <div class="p-2">
                                <?php echo isset($inscritos[date_format($mar, 'Y-m-d')]) ? $inscritos[date_format($mar, 'Y-m-d')] : 0; ?>
                                <!-- ?php echo ($inscritos[date_format($mar, 'Y-m-d')] ?? 0) ?> -->
                            </div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">10</div>
                            <div class="p-2">
                                <?php echo isset($inscritos[date_format($mie, 'Y-m-d')]) ? $inscritos[date_format($mie, 'Y-m-d')] : 0; ?>
                                <!-- ?php echo ($inscritos[date_format($mie, 'Y-m-d')] ?? 0) ?> -->
                            </div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">10</div>
                            <div class="p-2">
                                <?php echo isset($inscritos[date_format($jue, 'Y-m-d')]) ? $inscritos[date_format($jue, 'Y-m-d')] : 0; ?>
                                <!-- ?php echo ($inscritos[date_format($jue, 'Y-m-d')] ?? 0) ?> -->
                            </div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">10</div>
                            <div class="p-2">
                                <?php echo isset($inscritos[date_format($vie, 'Y-m-d')]) ? $inscritos[date_format($vie, 'Y-m-d')] : 0; ?>
                                <!-- ?php echo ($inscritos[date_format($vie, 'Y-m-d')] ?? 0) ?> -->
                            </div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">50</div>
                            <div class="p-2"><?php echo array_sum($inscritos); ?></div>
                        </td>
                        <!-- ------------------------------------------------------------------ -->
                        <td class="text-center align-middle">
                            <span class="sum"><?php echo round(array_sum($inscritos) * 100 / 50, 1); ?></span>
                            <span>%</span>
                        </td>
                    </tr>
                    <!-- NUEVOS PROSPECTOS FRIOS -->
                    <tr>
                        <td class="text-center align-middle">3</td>
                        <td class="align-middle">NUEVOS PROSPECTOS FRIOS</td>
                        <!-- ------------------------------------------------------------------ -->
                        <td class="p-0">
                            <div class="p-2 MyTd">OBJETIVO</div>
                            <div class="p-2 MyTd">RESULTADO</div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">5</div>
                            <div class="p-2">
                                <?php echo isset($prospectos[date_format($lun, 'Y-m-d')]) ? $prospectos[date_format($lun, 'Y-m-d')] : 0; ?>
                                <!-- ?php echo ($prospectos[date_format($lun, 'Y-m-d')] ?? 0) ?> -->
                            </div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">5</div>
                            <div class="p-2">
                                <?php echo isset($prospectos[date_format($mar, 'Y-m-d')]) ? $prospectos[date_format($mar, 'Y-m-d')] : 0; ?>
                                <!-- ?php echo ($prospectos[date_format($mar, 'Y-m-d')] ?? 0) ?> -->
                            </div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">5</div>
                            <div class="p-2">
                                <?php echo isset($prospectos[date_format($mie, 'Y-m-d')]) ? $prospectos[date_format($mie, 'Y-m-d')] : 0; ?>
                                <!-- ?php echo ($prospectos[date_format($mie, 'Y-m-d')] ?? 0) ?> -->
                            </div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">5</div>
                            <div class="p-2">
                                <?php echo isset($prospectos[date_format($jue, 'Y-m-d')]) ? $prospectos[date_format($jue, 'Y-m-d')] : 0; ?>
                                <!-- ?php echo ($prospectos[date_format($jue, 'Y-m-d')] ?? 0) ?> -->
                            </div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">5</div>
                            <div class="p-2">
                                <?php echo isset($prospectos[date_format($vie, 'Y-m-d')]) ? $prospectos[date_format($vie, 'Y-m-d')] : 0; ?>
                                <!-- ?php echo ($prospectos[date_format($vie, 'Y-m-d')] ?? 0) ?> -->
                            </div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">25</div>
                            <div class="p-2"><?php echo array_sum($prospectos); ?></div>
                        </td>
                        <!-- ------------------------------------------------------------------ -->
                        <td class="text-center align-middle">
                            <span class="sum"><?php echo round(array_sum($prospectos) * 100 / 25, 1); ?></span>
                            <span>%</span>
                        </td>
                    </tr>
                    <!-- INSCRITOS -->
                    <tr>
                        <td class="text-center align-middle">4</td>
                        <td class="align-middle">INSCRITOS</td>
                        <!-- ------------------------------------------------------------------ -->
                        <td class="p-0">
                            <div class="p-2 MyTd">OBJETIVO</div>
                            <div class="p-2 MyTd">RESULTADO</div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">1</div>
                            <div class="p-2">
                                <?php echo isset($inscritos[date_format($lun, 'Y-m-d')]) ? $inscritos[date_format($lun, 'Y-m-d')] : 0; ?>
                                <!-- ?php echo ($inscritos[date_format($lun, 'Y-m-d')] ?? 0) ?> -->
                            </div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">1</div>
                            <div class="p-2">
                                <?php echo isset($inscritos[date_format($mar, 'Y-m-d')]) ? $inscritos[date_format($mar, 'Y-m-d')] : 0; ?>
                                <!-- ?php echo ($inscritos[date_format($mar, 'Y-m-d')] ?? 0) ?> -->
                            </div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">1</div>
                            <div class="p-2">
                                <?php echo isset($inscritos[date_format($mie, 'Y-m-d')]) ? $inscritos[date_format($mie, 'Y-m-d')] : 0; ?>
                                <!-- ?php echo ($inscritos[date_format($mie, 'Y-m-d')] ?? 0) ?> -->
                            </div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">1</div>
                            <div class="p-2">
                                <?php echo isset($inscritos[date_format($jue, 'Y-m-d')]) ? $inscritos[date_format($jue, 'Y-m-d')] : 0; ?>
                                <!-- ?php echo ($inscritos[date_format($jue, 'Y-m-d')] ?? 0) ?> -->
                            </div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">1</div>
                            <div class="p-2">
                                <?php echo isset($inscritos[date_format($vie, 'Y-m-d')]) ? $inscritos[date_format($vie, 'Y-m-d')] : 0; ?>
                                <!-- ?php echo ($inscritos[date_format($vie, 'Y-m-d')] ?? 0) ?> -->
                            </div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">5</div>
                            <div class="p-2"><?php echo array_sum($inscritos); ?></div>
                        </td>
                        <!-- ------------------------------------------------------------------ -->
                        <td class="text-center align-middle">
                            <span class="sum"><?php echo round(array_sum($inscritos) * 100 / 5, 1); ?></span>
                            <span>%</span>
                        </td>
                    </tr>
                    <!-- MEETS -->
                    <tr>
                        <td class="text-center align-middle">5</td>
                        <td class="align-middle">MEETS</td>
                        <!-- ------------------------------------------------------------------ -->
                        <td class="p-0">
                            <div class="p-2 MyTd">OBJETIVO</div>
                            <div class="p-2 MyTd">RESULTADO</div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">6</div>
                            <div class="p-2">
                                <?php echo isset($meets[date_format($lun, 'Y-m-d')]) ? $meets[date_format($lun, 'Y-m-d')] : 0; ?>
                                <!-- ?php echo ($meets[date_format($lun, 'Y-m-d')] ?? 0) ?> -->
                            </div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">6</div>
                            <div class="p-2">
                                <?php echo isset($meets[date_format($mar, 'Y-m-d')]) ? $meets[date_format($mar, 'Y-m-d')] : 0; ?>
                                <!-- ?php echo ($meets[date_format($mar, 'Y-m-d')] ?? 0) ?> -->
                            </div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">6</div>
                            <div class="p-2">
                                <?php echo isset($meets[date_format($mie, 'Y-m-d')]) ? $meets[date_format($mie, 'Y-m-d')] : 0; ?>
                                <!-- ?php echo ($meets[date_format($mie, 'Y-m-d')] ?? 0) ?> -->
                            </div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">6</div>
                            <div class="p-2">
                                <?php echo isset($meets[date_format($jue, 'Y-m-d')]) ? $meets[date_format($jue, 'Y-m-d')] : 0; ?>
                                <!-- ?php echo ($meets[date_format($jue, 'Y-m-d')] ?? 0) ?> -->
                            </div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">6</div>
                            <div class="p-2">
                                <?php echo isset($meets[date_format($vie, 'Y-m-d')]) ? $meets[date_format($vie, 'Y-m-d')] : 0; ?>
                                <!-- ?php echo ($meets[date_format($vie, 'Y-m-d')] ?? 0) ?> -->
                            </div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">30</div>
                            <div class="p-2"><?php echo array_sum($meets); ?></div>
                        </td>
                        <!-- ------------------------------------------------------------------ -->
                        <td class="text-center align-middle">
                            <span class="sum"><?php echo round(array_sum($meets) * 100 / 30, 1); ?></span>
                            <span>%</span>
                        </td>
                    </tr>
                    <!-- LLAMADAS EFECTIVAS -->
                    <tr>
                        <td class="text-center align-middle">6</td>
                        <td class="align-middle">LLAMADAS EFECTIVAS</td>
                        <!-- ------------------------------------------------------------------ -->
                        <td class="p-0">
                            <div class="p-2 MyTd">OBJETIVO</div>
                            <div class="p-2 MyTd">RESULTADO</div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">60</div>
                            <div class="p-2">
                                <?php echo isset($llamadas[date_format($lun, 'Y-m-d')]) ? $llamadas[date_format($lun, 'Y-m-d')] : 0; ?>
                                <!-- ?php echo ($llamadas[date_format($lun, 'Y-m-d')] ?? 0) ?> -->
                            </div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">60</div>
                            <div class="p-2">
                                <?php echo isset($llamadas[date_format($mar, 'Y-m-d')]) ? $llamadas[date_format($mar, 'Y-m-d')] : 0; ?>
                                <!-- ?php echo ($llamadas[date_format($mar, 'Y-m-d')] ?? 0) ?> -->
                            </div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">60</div>
                            <div class="p-2">
                                <?php echo isset($llamadas[date_format($mie, 'Y-m-d')]) ? $llamadas[date_format($mie, 'Y-m-d')] : 0; ?>
                                <!-- ?php echo ($llamadas[date_format($mie, 'Y-m-d')] ?? 0) ?> -->
                            </div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">60</div>
                            <div class="p-2">
                                <?php echo isset($llamadas[date_format($jue, 'Y-m-d')]) ? $llamadas[date_format($jue, 'Y-m-d')] : 0; ?>
                                <!-- ?php echo ($llamadas[date_format($jue, 'Y-m-d')] ?? 0) ?> -->
                            </div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">60</div>
                            <div class="p-2">
                                <?php echo isset($llamadas[date_format($vie, 'Y-m-d')]) ? $llamadas[date_format($vie, 'Y-m-d')] : 0; ?>
                                <!-- ?php echo ($llamadas[date_format($vie, 'Y-m-d')] ?? 0) ?> -->
                            </div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">300</div>
                            <div class="p-2"><?php echo array_sum($llamadas); ?></div>
                        </td>
                        <!-- ------------------------------------------------------------------ -->
                        <td class="text-center align-middle">
                            <span class="sum"><?php echo round(array_sum($llamadas) * 100 / 300, 1); ?></span>
                            <span>%</span>
                        </td>
                    </tr>
                    <!-- INGRESO NETO -->
                    <tr>
                        <td class="text-center align-middle">7</td>
                        <td class="align-middle">INGRESO NETO</td>
                        <td class="p-0">
                            <div class="p-2 MyTd">OBJETIVO</div>
                            <div class="p-2 MyTd">RESULTADO</div>
                        </td>
                        <td class="p-0" colspan="5">
                            <div class="p-2 MyTd">.</div>
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0">
                            <div class="p-2 MyTd">$ 20,000.00</div>
                            <div class="p-2">
                                <span>$</span>
                                <span class="ingreso"><?php echo $ingreso; ?></span>
                            </div>
                        </td>
                        <td class="text-center align-middle" id="ingreso"></td>
                    </tr>
                    <!-- --------------------------------------------------------------------------------------------------------- -->
                    <br>
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

</body>

<script>

    function sum() {
        // t = 0;
        // $('.ingreso').each(function() {t += parseFloat($(this).text()) });

        $('#ingreso').text(
            (parseInt($('.ingreso').text()) * 100 / 20000).toFixed(2) + ' %'
        );
    }
    sum();
    // $('#MyAsesor')[0]
    var select = document.getElementById('MyAsesor');
    var select2 = document.getElementById('MySubmit');
    select2.addEventListener('click', function (e) {
        var selectedOption = select.options[select.selectedIndex];
        $('#MyExtension').val(selectedOption.getAttribute('extension'));
        $('#MyPid').val(selectedOption.getAttribute('pid'));
        $('#form').submit();
    });

    $(document).ready(function () {
        $('#MyTable').DataTable({
            language: { "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json" },
            searching: false, paging: false, info: false, ordering: false
        });
    });
</script>