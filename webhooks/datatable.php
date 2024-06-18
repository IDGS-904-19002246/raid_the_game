<?php
function conectarDB($ip, $user, $pass, $db)
{
    // $mysqli = new mysqli("74.208.39.15", "adcontrol_kommo_leads", "1dz0u3K%0", "adcontrol_kommo_leads");
    $mysqli = new mysqli($ip, $user, $pass, $db);
    if ($mysqli->connect_error) {die("Error de conexión: " . $mysqli->connect_error);}
    $mysqli->set_charset("utf8");
    return $mysqli;
}
$mysqli = conectarDB("74.208.39.15", "adcontrol_kommo_leads", "1dz0u3K%0", "adcontrol_kommo_leads");
$mysqlis = conectarDB("104.254.245.234", "adcontrol", '491n$iuZ1', "scontrol2019");
date_default_timezone_set('America/Mexico_City');
$today = date('Y-m-d');
$MyAsesor = 0;
$result_to_chart = array();
$dataPoints = array(
    array("label" => 'Asignados', "y" => 0),
    array("label" => 'Llamar', "y" => 0),
    array("label" => 'Interesados', "y" => 0),
    array("label" => 'Sin Interes', "y" => 0),
    array("label" => 'Propuesta', "y" => 0)
);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['MyDate'])) {
        $today = $_POST['MyDate'];
    }
    if (isset($_POST['MyAsesor'])) {
        $MyAsesor = $_POST['MyAsesor'];
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
        body {
            font-family: Arial;
            font-size: 12px;
        }

        .MyTr.odd td {
            background-color: #EEF3FB !important;
        }

        .MyTr.even td {
            background-color: #FFFFFF !important;
        }

        .MyTh {
            border: #3e2b0e solid 1px;
            background-color: #3e2b0e !important;
            color: white !important;
            /* background-color: #C1D4F1 !important; */
        }
        .MyTh2 {
            border: #3e2b0e solid 1px;
            background-color: #c1d4f1 !important;
            /* background-color: #C1D4F1 !important; */
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

<body>

    <?php if ($mysqli->connect_error): ?>
        <tr class="odd">
            <td valign="top" colspan="8" class="dataTables_empty">Error de conexión</td>
        </tr>
    <?php else:
        $filtro = '';
        if($MyAsesor !=0){$filtro = 'AND c.id_responsable ='.$MyAsesor;}
        $sql = "SELECT
            c.idkommo,
            c.lead_nombre,
            c.contacto_nombre,
            c.id_responsable,
            c.programa,
            json_arrayagg( DISTINCT (SELECT e.etapa FROM leads_kommo_embudos_etapas e WHERE e.id_etapa = c.etapa) ) etapa,
            (SELECT COUNT(*) FROM leads_kommo_cambios c2 WHERE c2.idkommo = c.idkommo AND c2.fecha LIKE CONCAT('{$today}','%')) cambios,
            (SELECT COUNT(*) FROM leads_kommo_tareas t WHERE t.idkommo = c.idkommo AND t.fecha LIKE CONCAT('{$today}','%')) tareas,
            (SELECT COUNT(*) FROM leads_kommo_notas n WHERE n.idkommo = c.idkommo AND n.fecha LIKE CONCAT('{$today}','%')) notas,
            (SELECT COUNT(*) FROM leads_zadarma_llamadas l WHERE
                REPLACE(l.destination,'+','') = REPLACE(c.telefono, '+','') AND
                l.call_date like CONCAT('{$today}','%') AND l.disposition = 'answered' AND l.duration >=15
                ) llamadas

            FROM leads_kommo_cambios c
            WHERE c.fecha LIKE CONCAT('{$today}','%') ".$filtro."
            GROUP BY c.idkommo";

        $result = $mysqli->query($sql);
        if ($result):
            while ($row = $result->fetch_assoc()):
                $result_to_chart[] = $row; ?>

            <?php endwhile; ?>
        <?php endif; ?>
    <?php endif; ?>

    <div class="p-4">
        <h6 class="border border-dark text-center m-0">
            <div class="border border-dark">FORMATO PLAN DE TRABAJO DIARIO</div>
        </h6>
        <div class="border border-dark w-100">
            <form class="row w-100 m-0" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                <div class="col-sm-2 border border-dark p-1">
                    <input class="form-control form-control-sm bg-light" type="text" value="ASESOR:" readonly disabled>
                </div>
                <div class="col-sm-5 border border-dark p-1">
                    <select class="form-control form-control-sm" aria-describedby="MyAsesorHelp" id="MyAsesor"
                        name="MyAsesor">
                        <option value="0">Ninguno</option>
                        <?php if ($mysqlis->connect_error): ?>
                            <h4>Error de conexión </h4>
                        <?php else:
                            $sql2 = "SELECT p.idKommo, p.pnombre, p.idUsuarioKommo from dwork_personal p WHERE p.dip=4 AND p.inactivo=0";
                            $result2 = $mysqlis->query($sql2);
                            if ($result2):
                                while ($row2 = $result2->fetch_assoc()): ?>
                                    <option value="<?php echo $row2['idUsuarioKommo']; ?>" <?php echo ($MyAsesor==$row2['idUsuarioKommo']?'selected':'no'); ?>><?php echo $row2['pnombre']; ?></option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-sm-2 border border-dark p-1">
                    <input class="form-control form-control-sm bg-light" type="text" value="FECHA REVISION:" readonly disabled>
                </div>
                <div class="col-sm-2 border border-dark p-1">
                    <input type="date" class="form-control form-control-sm" aria-describedby="DateHelp" id="MyDate" name="MyDate" value="<?php echo $today; ?>" required>
                </div>
                <div class="col-sm-1 border border-dark p-1">
                    <div class="align-self-center text-center">
                        <button type="submit" class="btn btn-sm btn-primary w-75">Ir al dia</button>
                    </div>
                </div>

            </form>
        </div>

        <!-- <form class="row " method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="col-sm-5 px-4 py-2">
                <div class="form-group">
                    <label for="MyDate">Resultados de Asignación del Dia</label>
                    <input type="date" class="form-control form-control-sm" aria-describedby="DateHelp" id="MyDate"
                        name="MyDate" value="<?php echo $today; ?>" required>
                    <small id="DateHelp" class="form-text text-muted">Fecha para reportar</small>
                </div>
            </div>
            <div class="col-sm-5 px-4 py-2">
                <div class="form-group">
                    <label for="MyAsesor">Asesor</label>
                    <select class="form-control form-control-sm" aria-describedby="MyAsesorHelp" id="MyAsesor"
                        name="MyAsesor">
                        <option value="0" select>Ninguno</option>
                        <?php if ($mysqlis->connect_error): ?>
                            <h4>Error de conexión </h4>
                        <?php else:
                            $sql2 = "SELECT p.idKommo, p.pnombre from dwork_personal p WHERE p.dip=4 AND p.inactivo=0";
                            $result2 = $mysqlis->query($sql2);
                            if ($result2):
                                while ($row2 = $result2->fetch_assoc()): ?>
                                    <option value="<?php echo $row2['idKommo']; ?>"><?php echo $row2['pnombre']; ?></option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </select>
                    <small id="MyAsesorHelp" class="form-text text-muted">Personal para obtener datos</small>
                </div>
            </div>
            <div class="col-sm-2 px-4 py-2 align-self-center text-center">
                <button type="submit" class="btn btn-sm btn-primary w-75">Ir al dia</button>
            </div>
        </form> -->
    </div>

    <div class="row p-4 w-100">
        <!-- <h4 class="text-center">KPIS</h4> -->
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['MyAsesor']) && !is_null($result_to_chart)) {
                if ($_POST['MyAsesor'] != 0) {
                    foreach ($result_to_chart as $row) {
                        if ($row['id_responsable'] == $_POST['MyAsesor']) {
                            $R = json_decode($row['etapa']);
                            foreach ($R as $r) {
                                if ($r != null) {
                                    foreach ($dataPoints as &$item) {
                                        if ($item['label'] === $r) {
                                            $item['y']++;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $dataPoints[0]['y'] = $dataPoints[1]['y']+$dataPoints[2]['y']+$dataPoints[3]['y']+$dataPoints[4]['y'];
                }
            }
        }
        ?>
        <div class="col-sm-3">
            <div class="py-4">
                <table id="MyTable2" class="table">
                    <thead>
                        <tr>
                            <th class="text-center MyTh2" colspan="2">GLOBALES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dataPoints as $data): ?>
                            <tr class="MyTr">
                                <td class="text-center"><?php echo $data['label']; ?></td>
                                <td class="text-center"><?php echo $data['y']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-sm-9">
            <div id="chartContainer" style="height:250px;"></div>
        </div>
    </div>

    <div class="row p-4 w-100">
        <div class="col-sm-12 p-4 overflow-auto">
            <table id="MyTable" class="table table-striped py-4 overflow-auto">
                <thead>
                    <tr class="text-center">
                        <th class="MyTh">NO.</th>
                        <th class="MyTh">LEAD</th>
                        <th class="MyTh">CONTACTO</th>
                        <th class="MyTh">PROGRAMA</th>
                        <th class="MyTh">ETAPA</th>
                        <th class="MyTh">CAMBIOS</th>
                        <th class="MyTh">TAREAS</th>
                        <th class="MyTh">NOTAS</th>
                        <th class="MyTh">LLAMADAS</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- --------------------------------------------------------------------------------------------------------- -->
                    <?php foreach ($result_to_chart as $row): ?>
                        <?php if($row['etapa'] != '["Clasificacion BD"]'): ?>
                        <?php endif;?>
                        <tr class="MyTr">
                            <td class=""><?php echo $row['idkommo']; ?></td>
                            <td class=""><?php echo $row['lead_nombre']; ?></td>
                            <td class=""><?php echo $row['contacto_nombre']; ?></td>
                            <td class=""><?php echo $row['programa']; ?></td>
                            <td class=""><?php
                                $R = json_decode($row['etapa']);
                                echo end($R) != 'null' ? end($R) : '';
                            ?></td>
                            <td class=""><?php echo $row['cambios']; ?></td>
                            <td class=""><?php echo $row['tareas']; ?></td>
                            <td class=""><?php echo $row['notas']; ?></td>
                            <td class=""><?php echo $row['llamadas']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <br>

                    <!-- --------------------------------------------------------------------------------------------------------- -->

                    <!-- ?php if ($mysqli->connect_error): ?>
                        <tr class="odd">
                            <td valign="top" colspan="8" class="dataTables_empty">Error de conexión</td>
                        </tr>
                    ?php else:
                        $sql = "SELECT
                            c.idkommo,
                            c.lead_nombre,c.contacto_nombre,
                            c.id_responsable,
                            json_arrayagg( DISTINCT (SELECT e.etapa FROM leads_kommo_embudos_etapas e WHERE e.id_etapa = c.etapa) ) etapa,
                            (SELECT COUNT(*) FROM leads_kommo_cambios c2 WHERE c2.idkommo = c.idkommo AND c2.fecha LIKE CONCAT('{$today}','%')) cambios,
                            (SELECT COUNT(*) FROM leads_kommo_tareas t WHERE t.idkommo = c.idkommo AND t.fecha LIKE CONCAT('{$today}','%')) tareas,
                            (SELECT COUNT(*) FROM leads_kommo_notas n WHERE n.idkommo = c.idkommo AND n.fecha LIKE CONCAT('{$today}','%')) notas,
                            (SELECT COUNT(*) FROM leads_zadarma_llamadas l WHERE
                                REPLACE(l.destination,'+','') = REPLACE(c.telefono, '+','') AND
                                l.call_date like CONCAT('{$today}','%') AND l.disposition = 'answered' AND l.duration >=15
                                ) llamadas

                            FROM leads_kommo_cambios c
                            WHERE c.fecha LIKE CONCAT('{$today}','%')
                            GROUP BY c.idkommo";

                        $result = $mysqli->query($sql);
                        if ($result):
                            while ($row = $result->fetch_assoc()):
                                $result_to_chart[] = $row; ?>
                                <tr class="MyTr">
                                    <td class="text-center">?php echo $row['idkommo']; ?></td>
                                    <td class="text-center">?php echo $row['lead_nombre']; ?></td>
                                    <td class="text-center">?php echo $row['contacto_nombre']; ?></td>
                                    <td class="text-center">?php
                                    $R = json_decode($row['etapa']);
                                    foreach ($R as $r) {
                                        echo $r;
                                    }
                                    ?></td>
                                    <td class="text-center">?php echo $row['cambios']; ?></td>
                                    <td class="text-center">?php echo $row['tareas']; ?></td>
                                    <td class="text-center">?php echo $row['notas']; ?></td>
                                    <td class="text-center">?php echo $row['llamadas']; ?></td>
                                </tr>
                            ?php endwhile; ?>
                        ?php endif; ?>
                    ?php endif; ?> -->
                    <!-- --------------------------------------------------------------------------------------------------------- -->
                </tbody>
                <tfoot>
                    <tr class="mt-5">
                        <th colspan="5" style="text-align:right">Conteo: </th>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                        <td class="text-center">4</td>
                        <td class="text-center">4</td>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>
    <div class="row p-4">
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

</body>

<script>
    $(document).ready(function () {
        $('#MyTable').DataTable({
            "language": { "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json" },
            layout: {
                topStart: {
                    buttons: [
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="fa fa-file-pdf-o"></i>',
                            titleAttr: 'PDF'
                        }
                    ]
                }
            },
            footerCallback: function (row, data, start, end, display) {
                let api = this.api();

                let intVal = function (i) { return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0; };

                changes = api.column(5, { page: 'current' }).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                tasks = api.column(6, { page: 'current' }).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                notes = api.column(7, { page: 'current' }).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                calls = api.column(8, { page: 'current' }).data().reduce((a, b) => intVal(a) + intVal(b), 0);

                api.column(5).footer().innerHTML = changes;
                api.column(6).footer().innerHTML = tasks;
                api.column(7).footer().innerHTML = notes;
                api.column(8).footer().innerHTML = calls;
            }
            // searching: false,paging: false,info: false
        });
        $('#MyTable2').DataTable({ searching: false, paging: false, info: false, dom: 't' });
    });

    window.onload = function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            data: [{
                type: "column",
                indexLabel: "{y}",
                indexLabelPlacement: "inside",
                indexLabelFontColor: "white",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
    }
</script>