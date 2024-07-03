<?php
function conectarDB($ip, $user, $pass, $db)
{
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
// DATOS GLOBALES
$today = date('Y-m-d');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $today = $_POST['MyDate'];
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
    <!-- TITULO -->
    <div class="px-4">
        <div class="d-flex flex-row">
            <img src="f.png" alt="" class="d-inlineblock" style="width:52px; height:52px;">
            <div class="flex-fill px-2">
                <label class="text-uppercase font-weight-bold" style="color: #539ADB;font-size: 14px;font-weight: bold;">Title</label>
                <div class="my-2" style="border: #FF9900 solid;padding-top: 1px;"></div>
                <label class="text-uppercase" style="color: #FF6600;">sub</label>
            </div>
        </div>
    </div> 
    <!-- ENCABEZADO -->
    <div class="px-4">
        <div class="w-100">
            <form class="row w-100 m-0" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form">
                <div class="col-sm-6"></div>

                <div class="col-sm-2 p-1">
                    <input class="form-control form-control-sm bg-light" type="text" value="FECHA:" readonly disabled>
                </div>
                <div class="col-sm-2 p-1">
                    <input class="form-control form-control-sm bg-light" type="date" name="MyDate"
                        value="<?php echo $today; ?>" required>
                </div>

                <div class="col-sm-2 p-1">
                    <button type="submit" id="MySubmit" class="btn btn-sm btn-primary w-100">Obtener Reporte</button>
                </div>
            </form>
        </div>
    </div>
    <br><br>
    <!-- TABLA -->
    <div class="p-4 w-100 ">
        <div class="overflow-auto">
            <table id="MyTable" class="table table-striped py-4 overflow-auto">
                <thead>
                    <tr class="text-center align-middle">
                        <th class="MyTh">#</th>
                        <th class="MyTh w-50">Nombre</th>
                        <th class="MyTh" style="width:100px;">Total de Registro</th>
                        <th class="MyTh">Primer Registro</th>
                        <th class="MyTh">Lista de Registro</th>
                        <th class="MyTh">Ultimo Registro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!$mysqlis->connect_error):
                        $result = $mysqli->query(
                            "SELECT
                                ar.PersonID, ar.PersonName,
                                MAX(DATE_FORMAT( FROM_UNIXTIME(ar.AttendanceDateTime / 1000), '%H:%i')) MA,
                                MIN(DATE_FORMAT(FROM_UNIXTIME(ar.AttendanceDateTime / 1000), '%H:%i')) MI,
                                JSON_ARRAY(DATE_FORMAT(FROM_UNIXTIME(ar.AttendanceDateTime / 1000), '%H:%i'))Dates,
                                COUNT(*) Total
                            FROM AttendanceRecordInfo ar WHERE FROM_UNIXTIME(ar.AttendanceDateTime / 1000) LIKE '{$today}%'
                            GROUP BY ar.PersonID ORDER BY ar.AttendanceDateTime DESC"
                        );
                        if ($result):
                            while ($row = $result->fetch_assoc()): ?>
                                <tr class="align-middle">
                                    <td><?php echo $row['PersonID']; ?></td>
                                    <td><?php echo $row['PersonName']; ?></td>
                                    <td><?php echo $row['Total']; ?></td>
                                    <td><?php echo $row['MI']; ?></td>
                                    <td><?php
                                    $Dates = json_decode($row['Dates']);
                                    foreach ($Dates as $D): ?>
                                            <label class="d-block"> - <?php echo $D; ?></label>
                                        <?php endforeach;
                                    ?>
                                    </td>
                                    <td><?php echo $row['MA']; ?></td>
                                </tr>
                            <?php endwhile; endif; endif; ?>
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
    $(document).ready(function () {
        $('#MyTable').DataTable({
            language: { "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json" }
            // searching: false, paging: false, info: false
        });
    });
</script>