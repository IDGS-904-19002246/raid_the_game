<?php

// 69303187
// 142
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

// echo date_format($lun,'Y-m-d');
// echo date_format($lun,"d/M/y");

$meets = json_decode('{}',true);
$inscritos = json_decode('{}',true);
$llamadas = json_decode('{}',true);
$MyAsesor = 0;
$MyCedula = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['MyAsesor']) && isset($_POST['MyCedula'])) {
        $MyAsesor = $_POST['MyAsesor'];
        $MyCedula = $_POST['MyCedula'];
        $extension = $_POST['extension'];
        // MEETS
        $sql = "SELECT JSON_OBJECTAGG(f, c) AS meet FROM (
            SELECT DATE(t.fecha) f,COUNT(*) c
            FROM leads_kommo_tareas t
            WHERE (t.fecha BETWEEN '".date_format($lun,'Y-m-d')."' AND '".date_format($vie,'Y-m-d')."')
            AND t.id_responsable = ".$MyAsesor." GROUP BY DATE(t.fecha)
            ) AS meet";
        $result = $mysqli->query($sql);
        if ($result){$meets = json_decode($result->fetch_assoc()['meet']??'{}', true);}

        // INSCRITOS
        $sql = "SELECT JSON_OBJECTAGG(f, cc) AS inscritos FROM (
	        SELECT DATE(c.fecha) f,COUNT(*) cc
            FROM leads_kommo_cambios c
            WHERE (c.fecha BETWEEN '".date_format($lun,'Y-m-d')."' AND '".date_format($vie,'Y-m-d')."')
            AND c.id_responsable = ".$MyAsesor." AND c.etapa = 142
            GROUP BY DATE(c.fecha)
        ) AS inscritos";
        $result = $mysqli->query($sql);
        if ($result){$inscritos = json_decode($result->fetch_assoc()['inscritos']??'{}', true);}
        //LLAMADAS EFECTIVAS
        $sql = "SELECT JSON_OBJECTAGG(f, c) AS llamadas FROM (
            SELECT DATE(ll.call_date) f,COUNT(*) c
            FROM leads_zadarma_llamadas ll
            WHERE (ll.call_date BETWEEN '".date_format($lun,'Y-m-d')."' AND '".date_format($vie,'Y-m-d')."')
            AND ll.duration >= 20 AND ll.internal = ".$extension."
            GROUP BY DATE(ll.call_date)
        ) AS llamadas";
        $result = $mysqli->query($sql);
        if ($result){$llamadas = json_decode($result->fetch_assoc()['llamadas']??'{}', true);}
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
        .MyTd{
            /* border-bottom: #C1D4F1 solid 3px; */
            border-bottom: black solid 1px;
            background-color: #C1D4F1;
        }

        .MyTh {
            /* border: #3e2b0e solid 1px; */
            border: black solid 1px;
            /* background-color: #3e2b0e !important; */
            background-color: #C1D4F1 !important;
            /* color: white !important; */
            /* background-color: #C1D4F1 !important; */
        }
        .MyThDate{
            writing-mode: sideways-lr;
            padding: 10px;
            width: 3em;
            text-align: center;
        }
        /* .MyTh2 {
            border: #3e2b0e solid 1px;
            background-color: #c1d4f1 !important;
            // background-color: #C1D4F1 !important; 
        } */

        table.dataTable thead .sorting {
            filter: invert(100%) !important;
        }

        .table td {
            box-shadow: none;
            border: black solid 1px;
            /* border: #C1D4F1 solid 1px; */
        }
    </style>
</head>

<body class="p-4">
    <!-- ENCABEZADO -->
    <div class="px-4">
        <h6 class="border border-dark text-center m-0">
            <div class="border border-dark p-1">FORMATO PLAN DE TRABAJO SEMANAL</div>
        </h6>
        <div class="border border-dark w-100">
            <form class="row w-100 m-0" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="extension" value="" id="MyExtension">
                <div class="col-sm-2 border border-dark p-1">
                    <input class="form-control form-control-sm bg-light" type="text" value="ASESOR:" readonly disabled>
                </div>
                <div class="col-sm-4 border border-dark p-1">
                    <select class="form-control form-control-sm" aria-describedby="MyAsesorHelp" id="MyAsesor"
                        name="MyAsesor">
                        <option value="0" extension="0">Ninguno</option>
                        <?php if ($mysqlis->connect_error): ?>
                        <?php else:
                            $sql2 = "SELECT p.idKommo, p.pnombre, p.idUsuarioKommo, p.extension from dwork_personal p WHERE p.dip=4 AND p.inactivo=0";
                            $result2 = $mysqlis->query($sql2);
                            if ($result2):
                                while ($row2 = $result2->fetch_assoc()): ?>
                                    <option value="<?php echo $row2['idUsuarioKommo']; ?>" <?php echo ($MyAsesor==$row2['idUsuarioKommo']?'selected':'no'); ?>
                                        extension="<?php echo $row2['extension']; ?>"
                                        ><?php echo $row2['pnombre']; ?></option> 
                                <?php endwhile; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-sm-2 border border-dark p-1">
                    <input class="form-control form-control-sm bg-light" type="text" value="CEDULA:" readonly disabled>
                </div>
                <div class="col-sm-2 border border-dark p-1">
                    <input type="text" class="form-control form-control-sm" aria-describedby="DateHelp" id="MyCedula" name="MyCedula" value="LEON GUANAJUATO" required>
                </div>
                <div class="col-sm-2 border border-dark p-1">
                    <div class="align-self-center text-center">
                        <button type="submit" class="btn btn-sm btn-primary w-75">Obtener Reporte</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <!-- ?php echo json_encode($meets['clave'] == null ?? 'no hay nada' );?> -->
    <!-- TABLA -->
    <div class="px-4 w-100">
        <div class="col-sm-12 overflow-auto">
            <table id="MyTable" class="table table-striped overflow-auto">
                <thead>
                    <tr class="text-center align-middle">
                        <th class="MyTh" colspan="2" style="width:30%;">ACTIVIDAD</th>
                        <th class="MyTh">TIEMPO</th>
                        
                        <th class="MyTh MyThDate" ><?php echo date_format($lun,'d M y');?></th>
                        <th class="MyTh MyThDate" ><?php echo date_format($mar,'d M y');?></th>
                        <th class="MyTh MyThDate" ><?php echo date_format($mie,'d M y');?></th>
                        <th class="MyTh MyThDate" ><?php echo date_format($jue,'d M y');?></th>
                        <th class="MyTh MyThDate" ><?php echo date_format($vie,'d M y');?></th>

                        <th class="MyTh" style="width:10%;">TOTAL</th>
                        <th class="MyTh" style="width:10%;">TASA DE CONVERSION</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- PROSPECTOS ASIGNADOS -->
                    <tr>
                        <td class="text-center align-middle">1</td>
                        <td class="align-middle">PROSPECTOS ASIGNADOS</td>

                        <td class="align-middle MyTd" style="background-color: #C1D4F1;">PLANEADO</td>
                        <td class="text-center align-middle" style="background-color: #C1D4F1;">100</td>
                        <td class="text-center align-middle" style="background-color: #C1D4F1;">100</td>
                        <td class="text-center align-middle" style="background-color: #C1D4F1;">100</td>
                        <td class="text-center align-middle" style="background-color: #C1D4F1;">100</td>
                        <td class="text-center align-middle" style="background-color: #C1D4F1;">100</td>
                        <td class="text-center align-middle" style="background-color: #C1D4F1;">500</td>
                        <td></td>
                    </tr>
                    <!-- INTERESADOS NUEVOS -->
                    <tr>
                        <td class="text-center align-middle">2</td>
                        <td class="align-middle">INTERESADOS NUEVOS</td>
                        <!-- ------------------------------------------------------------------ -->
                        <td class="p-0">
                            <div class="p-2 MyTd">OBJETIVO</div>
                            <div class="p-2 MyTd">RESULTADO</div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">10</div>
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">10</div>
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">10</div>
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">10</div>
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">10</div>
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">10</div>
                            <div class="p-2"></div>
                        </td>
                        <!-- ------------------------------------------------------------------ -->
                        <td class="text-center align-middle">50</td>
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
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">5</div>
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">5</div>
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">5</div>
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">5</div>
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">5</div>
                            <div class="p-2"></div>
                        </td>
                        <!-- ------------------------------------------------------------------ -->
                        <td class="text-center align-middle">25</td>
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
                            <div class="p-2"><?php echo ($inscritos[date_format($lun,'Y-m-d')] ?? 0) ?></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">1</div>
                            <div class="p-2"><?php echo ($inscritos[date_format($mar,'Y-m-d')] ?? 0) ?></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">1</div>
                            <div class="p-2"><?php echo ($inscritos[date_format($mie,'Y-m-d')] ?? 0) ?></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">1</div>
                            <div class="p-2"><?php echo ($inscritos[date_format($jue,'Y-m-d')] ?? 0) ?></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">1</div>
                            <div class="p-2"><?php echo ($inscritos[date_format($vie,'Y-m-d')] ?? 0) ?></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">1</div>
                            <div class="p-2"><?php echo array_sum($inscritos);?></div>
                        </td>
                        <!-- ------------------------------------------------------------------ -->
                        <td class="text-center align-middle">25</td>
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
                            <div class="p-2"><?php echo ($meets[date_format($lun,'Y-m-d')] ?? 0) ?></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">6</div>
                            <div class="p-2"><?php echo ($meets[date_format($mar,'Y-m-d')] ?? 0) ?></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">6</div>
                            <div class="p-2"><?php echo ($meets[date_format($mie,'Y-m-d')] ?? 0) ?></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">6</div>
                            <div class="p-2"><?php echo ($meets[date_format($jue,'Y-m-d')] ?? 0) ?></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">6</div>
                            <div class="p-2"><?php echo ($meets[date_format($vie,'Y-m-d')] ?? 0) ?></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">6</div>
                            <div class="p-2"><?php echo array_sum($meets);?></div>
                        </td>
                        <!-- ------------------------------------------------------------------ -->
                        <td class="text-center align-middle">30</td>
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
                            <div class="p-2"><?php echo ($llamadas[date_format($lun,'Y-m-d')] ?? 0) ?></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">60</div>
                            <div class="p-2"><?php echo ($llamadas[date_format($mar,'Y-m-d')] ?? 0) ?></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">60</div>
                            <div class="p-2"><?php echo ($llamadas[date_format($mie,'Y-m-d')] ?? 0) ?></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">60</div>
                            <div class="p-2"><?php echo ($llamadas[date_format($jue,'Y-m-d')] ?? 0) ?></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">60</div>
                            <div class="p-2"><?php echo ($llamadas[date_format($vie,'Y-m-d')] ?? 0) ?></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">60</div>
                            <div class="p-2"><?php echo array_sum($llamadas);?></div>
                        </td>
                        <!-- ------------------------------------------------------------------ -->
                        <td class="text-center align-middle">600</td>
                    </tr>
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
                            <div class="p-2"></div>
                        </td>
                        <td class="text-center align-middle">600</td>
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
    // $('#MyAsesor')[0]
    var select = document.getElementById('MyAsesor')
    select.addEventListener('change',function(e){
        var selectedOption = select.options[select.selectedIndex];
        $('#MyExtension').val(selectedOption.getAttribute('extension'));
    });

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
            // footerCallback: function (row, data, start, end, display) {
            //     let api = this.api();

            //     let intVal = function (i) { return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0; };

            //     changes = api.column(5, { page: 'current' }).data().reduce((a, b) => intVal(a) + intVal(b), 0);
            //     tasks = api.column(6, { page: 'current' }).data().reduce((a, b) => intVal(a) + intVal(b), 0);
            //     notes = api.column(7, { page: 'current' }).data().reduce((a, b) => intVal(a) + intVal(b), 0);
            //     calls = api.column(8, { page: 'current' }).data().reduce((a, b) => intVal(a) + intVal(b), 0);

            //     api.column(5).footer().innerHTML = changes;
            //     api.column(6).footer().innerHTML = tasks;
            //     api.column(7).footer().innerHTML = notes;
            //     api.column(8).footer().innerHTML = calls;
            // }
            searching: false,paging: false,info: false,ordering: false
        });
        // $('#MyTable2').DataTable({ searching: false, paging: false, info: false, dom: 't' });
    });
</script>