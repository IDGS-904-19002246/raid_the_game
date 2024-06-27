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

// // setlocale(LC_TIME, 'es_ES.UTF-8');
// // DATOS GLOBALES
$today = date('Y-m-d');
// PERSONAL
$personal = array();
$results = $mysqlis->query("SELECT p.pid, p.idKommo, p.pnombre, p.nombreKommo from dwork_personal p WHERE  p.dip=4 AND p.inactivo=0");
if ($results) {
    while ($row = $results->fetch_assoc()) {
        $personal[] = $row;
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
    <!-- BOOTSTRAP SELECT-->

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

        .MyTr.odd td,
        .odd {
            background-color: #EEF3FB !important;
        }

        .MyTr.even td,
        .even {
            background-color: #FFFFFF !important;
        }

        table.dataTable thead .sorting {
            filter: invert(100%) !important;
        }

        .table td,
        .MyFalseTable>div {
            box-shadow: none;
            border: #C1D4F1 solid 1px;
        }
    </style>
</head>


<body class="p-4">
    <div class="row w-100 m-0">
        <!-- FORM -->
        <div class="col-sm-4 p-4">
            <h2 class="text-center">Formulario</h2>
            <form action="" class="MyFalseTable">

                <div class="col-sm-12 p-2 d-flex justify-content-between odd">
                    <label class="p-1">Creado por: </label>
                    <select class="form-control form-control-sm w-50 border border-dark">
                        <?php foreach ($personal as $p): ?>
                            <option value="<?php echo $p['pid']; ?>"><?php echo $p['nombreKommo']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-sm-12 p-2 d-flex justify-content-between even">
                    <label class="p-1">Involucrados: </label>


                    
                    <div class="form-control form-control-sm w-50 border border-dark choices-multiple" >
                        <ul >
                        <?php foreach($personal as $p):?>
                            <li value="<?php echo $p['pid']; ?>">
                                <input type="checkbox" class="p-2 m-1">
                                <?php echo $p['nombreKommo']; ?>
                            </li>
                        <?php endforeach;?>
                        </ul>
                    </div>
                </div>

                <div class="col-sm-12 p-2 d-flex justify-content-between odd">
                    <label class="p-1">Hora Inicio: </label>
                    <input class="form-control form-control-sm bg-light w-25 border border-dark" type="time" value="">
                    <label class="p-1">Hora Fin: </label>
                    <input class="form-control form-control-sm bg-light w-25 border border-dark" type="time" value="">
                </div>

                <div class="col-sm-12 p-2 even">
                    <label class="p-1">Descripción el asunto/motivo: </label><br>
                    <textarea class="w-100" name="" id=""></textarea>
                </div>

                <div class="col-sm-12 p-2 d-flex justify-content-end odd ">
                    <button class="btn btn-sm btn-success" type="button">Guardar</button>
                </div>
            </form>
        </div>
        <!-- TABLE -->
        <div class="col-sm-8 p-4 bg-warning">
            <h2 class="text-center">Lista de paros</h2>
            <table id="MyTable" class="table table-striped py-4 overflow-auto" style="border: none;">
                <thead>
                    <tr class="text-center align-middle">
                        <th class="MyTh">#</th>
                        <th class="MyTh">ID Kommo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($mysqlis->connect_error): ?>
                    <?php else:
                        $sql = "SELECT*FROM tbl_paros p WHERE '{$today}' BETWEEN date(p.`start`) AND date(p.`end`)";
                        $result = $mysqli->query($sql);
                        if ($result):
                            while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['fk_id_resposable']; ?></td>
                                </tr>
                            <?php endwhile; endif; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<script>


    $('#MyTable').DataTable({
        language: { "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json" },
        // columnDefs: [{ type: 'num', targets: 5 } ]
        // searching: false,
        // paging: false,
        // info: false
    });

</script>