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
    $sql ="SELECT*FROM f";
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

    <div class="px-4">
        <h6 class="border border-dark text-center m-0">
            <div class="border border-dark p-1">FORMATO PLAN DE TRABAJO SEMANAL</div>
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
                    <input class="form-control form-control-sm bg-light" type="text" value="CEDULA:" readonly disabled>
                </div>
                <div class="col-sm-2 border border-dark p-1">
                    <input type="text" class="form-control form-control-sm" aria-describedby="DateHelp" id="MyDate" name="MyDate" value="LEON GUANAJUATO" required>
                </div>
                <div class="col-sm-1 border border-dark p-1">
                    <div class="align-self-center text-center">
                        <button type="submit" class="btn btn-sm btn-primary w-75">Ir al dia</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="px-4 w-100">
        <div class="col-sm-12 overflow-auto">
            <table id="MyTable" class="table table-striped overflow-auto">
                <thead>
                    <tr class="text-center align-middle">
                        <th class="MyTh" colspan="2" style="width:20%;">ACTIVIDAD</th>
                        <th class="MyTh">TIEMPO</th>

                        <th class="MyTh" style="writing-mode: sideways-lr;">17 Jun 24</th>
                        <th class="MyTh" style="writing-mode: sideways-lr;">18 Jun 24</th>
                        <th class="MyTh" style="writing-mode: sideways-lr;">19 Jun 24</th>
                        <th class="MyTh" style="writing-mode: sideways-lr;">20 Jun 24</th>
                        <th class="MyTh" style="writing-mode: sideways-lr;">21 Jun 24</th>

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
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">1</div>
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">1</div>
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">1</div>
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">1</div>
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">1</div>
                            <div class="p-2"></div>
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
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">6</div>
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">6</div>
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">6</div>
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">6</div>
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">6</div>
                            <div class="p-2"></div>
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
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">60</div>
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">60</div>
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">60</div>
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">60</div>
                            <div class="p-2"></div>
                        </td>
                        <td class="p-0 text-center">
                            <div class="p-2 MyTd">60</div>
                            <div class="p-2"></div>
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