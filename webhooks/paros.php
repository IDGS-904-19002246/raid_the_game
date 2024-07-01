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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }
    $id = $_POST['id'];
    $fk_id_resposable = $_POST['fk_id_resposable'];
    $start = $_POST['date'] . ' ' . $_POST['start'];
    $end = $_POST['date'] . ' ' . $_POST['end'];
    $reason = $_POST['reason'];
    if (isset($_POST['assistants'])) {
        // $array_numeros = array_map('intval', $array);
        $_assistants = array_map('intval',$_POST['assistants']);
        if (!in_array($fk_id_resposable, $_POST['assistants'] )) {
            $_assistants[] = $fk_id_resposable;
        }
        $assistants = json_encode($_assistants);
    } else {
        $assistants = '[]';
    }
    $type = $_POST['type'];

    if ($id == 0) {
        $sql_1 = "INSERT INTO tbl_paros
        (fk_id_resposable,start,end,reason,assistants,type)values
        ({$fk_id_resposable},'{$start}','{$end}','{$reason}','{$assistants}','{$type}')";
    } else {
        $sql_1 = "UPDATE tbl_paros SET
            fk_id_resposable = {$fk_id_resposable},
            start = '{$start}',
            end = '{$end}',
            reason = '{$reason}',
            assistants = '{$assistants}',
            type = '{$type}'
        WHERE id = {$id}";
    }
    $result = $mysqli->query($sql_1);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['MyDate'])) {
        $today = $_GET['MyDate'];
    }
}
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
    <!-- BOOTSTRAP ICONS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <style>
        @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css");

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

        .options:hover,
        .assistant:hover {
            background-color: #ccc;
        }
    </style>
</head>

<body class="p-4">
    <div class="row w-100 m-0">
        <!-- FORM -->
        <div class="modal fade" id="nuevo" tabindex="-1" aria-modal="true">
            <div class="modal-dialog modal-dialog-centered mw-900px">
                <div class="modal-content">

                    <div class="modal-header">
                        <h2 class="my_title">Añadir Paro</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"></div>
                    </div>

                    <div class="modal-body py-lg-10 px-lg-10">
                        <form class="MyFalseTable" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" class="my_input" name="id" value="0">

                            <div class="col-sm-12 p-2 d-flex justify-content-between even">
                                <label class="p-1">Creado por: </label>
                                <select class="form-control form-control-sm w-50 border border-dark my_input"
                                    name="fk_id_resposable" required>
                                    <?php foreach ($personal as $p): ?>
                                        <option value="<?php echo $p['pid']; ?>"><?php echo $p['nombreKommo']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-sm-12 p-2 d-flex justify-content-between odd">
                                <label class="p-1 w-25">Hora Inicio: </label>
                                <input class="form-control form-control-sm bg-light w-25 border border-dark my_input"
                                    type="time" name="start" required>
                                <label class="p-1">Hora Fin: </label>
                                <input class="form-control form-control-sm bg-light w-25 border border-dark my_input"
                                    type="time" name="end" required>
                            </div>

                            <div class="col-sm-12 p-2 d-flex justify-content-between even">
                                <label class="p-1 w-25">Tipo de pado: </label>
                                <select class="form-control form-control-sm w-25 border border-dark my_input"
                                    name="type" required>
                                    <option value="Junta">Junta</option>
                                    <option value="Improvisto">Improvisto</option>
                                </select>
                                <label class="p-1">Fecha: </label>
                                <input class="form-control form-control-sm bg-light w-25 border border-dark my_input"
                                    type="date" name="date" value="<?php echo $today; ?>" required>
                            </div>

                            <div class="col-sm-12 p-2 d-flex justify-content-between odd">
                                <label class="p-1 align-middle">Involucrados: <br><input id="check_all" type="checkbox"
                                        class="p-2 m-1">Seleccionar todos</label>

                                <div class="p-0 w-50 position-relative" id="select">
                                    <ul class="m-0 list-unstyled border border-dark p-1 rounded align-middle">
                                        <li>Asistentes</li>
                                    </ul>
                                    <ul
                                        class="m-0 list-unstyled border border-dark px-2 bg-light rounded w-100 position-absolute">
                                        <?php foreach ($personal as $p): ?>
                                            <li class="p-1 options rounded" style="display:none;">
                                                <input type="checkbox" class="p-2 m-1 my_input_list" name="assistants[]"
                                                    value=<?php echo $p['pid']; ?>>
                                                <?php echo $p['nombreKommo']; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-sm-12 p-2 even">
                                <label class="p-1">Descripción el asunto/motivo: </label><br>
                                <div class="p-2">
                                    <input class="w-100 my_input" name="reason" required>
                                </div>
                            </div>

                            <div class="col-sm-12 p-2 d-flex justify-content-end odd ">
                                <button class="btn btn-success mx-3" type="button" onclick="to_reset()">Reset</button>
                                <button class="btn btn-success" type="submit">Guardar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- <div class="col-sm-4 p-4"> -->
            <!-- <h2 class="text-center">Formulario</h2> -->
            <!-- <form class="MyFalseTable" method="POST" action="?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" class="my_input" name="id" value="0">

                <div class="col-sm-12 p-2 d-flex justify-content-between even">
                    <label class="p-1">Creado por: </label>
                    <select class="form-control form-control-sm w-50 border border-dark my_input"
                        name="fk_id_resposable" required>
                        ?php foreach ($personal as $p): ?>
                            <option value="?php echo $p['pid']; ?>">?php echo $p['nombreKommo']; ?></option>
                        ?php endforeach; ?>
                    </select>
                </div>

                <div class="col-sm-12 p-2 d-flex justify-content-between odd">
                    <label class="p-1 w-25">Hora Inicio: </label>
                    <input class="form-control form-control-sm bg-light w-25 border border-dark my_input" type="time"
                        name="start" required>
                    <label class="p-1">Hora Fin: </label>
                    <input class="form-control form-control-sm bg-light w-25 border border-dark my_input" type="time"
                        name="end" required>
                </div>

                <div class="col-sm-12 p-2 d-flex justify-content-between even">
                    <label class="p-1 w-25">Tipo de pado: </label>
                    <select class="form-control form-control-sm w-25 border border-dark my_input" name="type" required>
                        <option value="Junta">Junta</option>
                        <option value="Improvisto">Improvisto</option>
                    </select>
                    <label class="p-1">Fecha: </label>
                    <input class="form-control form-control-sm bg-light w-25 border border-dark my_input" type="date"
                        name="date" value="?php echo $today; ?>" required>
                </div>

                <div class="col-sm-12 p-2 d-flex justify-content-between odd">
                    <label class="p-1 align-middle">Involucrados: <br><input id="check_all" type="checkbox"
                            class="p-2 m-1">Seleccionar todos</label>

                    <div class="p-0 w-50 position-relative" id="select">
                        <ul class="m-0 list-unstyled border border-dark p-1 rounded align-middle">
                            <li>Asistentes</li>
                        </ul>
                        <ul class="m-0 list-unstyled border border-dark px-2 bg-light rounded w-100 position-absolute">
                            ?php foreach ($personal as $p): ?>
                                <li class="p-1 options rounded" style="display:none;">
                                    <input type="checkbox" class="p-2 m-1 my_input_list" name="assistants[]"
                                        value="?php echo $p['pid']; ?>">
                                    ?php echo $p['nombreKommo']; ?>
                                </li>
                            ?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <div class="col-sm-12 p-2 even">
                    <label class="p-1">Descripción el asunto/motivo: </label><br>
                    <div class="p-2">
                        <input class="w-100 my_input" name="reason" required>
                    </div>
                </div>

                <div class="col-sm-12 p-2 d-flex justify-content-end odd ">
                    <button class="btn btn-success mx-3" type="button" onclick="to_reset()">Reset</button>
                    <button class="btn btn-success" type="submit">Guardar</button>
                </div>
            </form> -->
        <!-- </div> -->
        <!-- TABLE -->
        <div class="col-sm-12 p-4">
            <div class="d-flex justify-content-between mb-4">
                <h2 class="w-50">Lista de paros</h2>
                <input class="form-control form-control-sm bg-light w-25" type="date" name="MyDate" id="MyDate"
                    value="<?php echo $today; ?>">
                <button type="button" class="btn btn-sm btn-primary px-4" onclick="GoTo()"><i
                        class="bi bi-arrow-right-circle-fill"></i></button>
                <button type="button" class="btn btn-sm btn-primary px-4" data-bs-toggle="modal"
                    data-bs-target="#nuevo" onclick="to_reset()">Añadir</button>
            </div>
            <hr class="py-4">
            <table id="MyTable" class="table table-striped py-4 overflow-auto" style="border: none;">
                <thead>
                    <tr class="text-center align-middle">
                        <th class="MyTh" style="width:64px !important;">#</th>
                        <th class="MyTh">Nombre</th>
                        <th class="MyTh">Razon</th>
                        <th class="MyTh" style="width:32px !important;">Hora Inicio</th>
                        <th class="MyTh" style="width:32px !important;">Hora Fin</th>
                        <th class="MyTh" style="width:128px !important;">Asistentes</th>
                        <th class="MyTh" style="width:64px !important;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($mysqlis->connect_error): ?>
                    <?php else:
                        $sql = "SELECT p.id,p.fk_id_resposable,p.reason,p.assistants,p.type,
                                DATE(p.start) date,
                                DATE_FORMAT(p.start, '%H:%i') start,
                                DATE_FORMAT(p.end, '%H:%i') end
                            FROM tbl_paros p WHERE '{$today}' BETWEEN date(p.start) AND date(p.end)
                        ";
                        $result = $mysqli->query($sql);
                        if ($result):
                            while ($row = $result->fetch_assoc()): ?>
                                <tr class="align-middle">
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php
                                    $id = $row['fk_id_resposable'];
                                    echo array_reduce($personal, function ($nombreEncontrado, $p) use ($id) {
                                        return $p['pid'] == $id ? $p['nombreKommo'] : $nombreEncontrado;
                                    }, ' - ');
                                    ?></td>
                                    <td><?php echo $row['reason']; ?></td>
                                    <td><?php echo $row['start']; ?></td>
                                    <td><?php echo $row['end']; ?></td>
                                    <td>
                                        <label class="d-block assistant p-2 rounded" data="<?php echo $row['id']; ?>">Ver
                                            asistentes</label>
                                        <label class="px-3" id="as_<?php echo $row['id']; ?>" style="display:none;">
                                            <?php
                                            $A = json_decode($row['assistants']);
                                            foreach ($A as $a):
                                                $nombreEncontrado = array_reduce($personal, function ($nombreEncontrado, $p) use ($a) {
                                                    return $p['pid'] == $a ? $p['nombreKommo'] : $nombreEncontrado;
                                                }, ' - ');
                                                echo '• ' . $nombreEncontrado . '<br>';
                                            endforeach;
                                            ?></label>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary p-1" data='<?php echo json_encode($row); ?>'
                                            onclick="to_edit(this)" data-bs-toggle="modal"
                                            data-bs-target="#nuevo"><i class="bi bi-pen-fill"></i></button>
                                        <!-- <button class="btn btn-sm btn-primary">F</button> -->
                                    </td>
                                </tr>
                            <?php endwhile; endif; endif; ?>
                </tbody>
            </table>
        </div>
        <!-- ------------------------------------------------------------ -->
        <!-- <div class="col-sm-12">
            <button type="button" class="btn btn-primary mx-5 btn-insert-modal" data-bs-toggle="modal"
                    data-bs-target="#nuevo">F
                    Grupo</button>
        </div> -->
        <!-- ------------------------------------------------------------ -->
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
            language: { "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json" },
            // columnDefs: [{ type: 'num', targets: 5 } ], searching: false,paging: false,info: false
        });

        $('#select').mouseenter(function () { $('.options').slideDown(50); });
        $('#select').mouseleave(function () { $('.options').slideUp(50); });

        $('.assistant').mouseenter(function (e) {
            $('#as_' + e.target.getAttribute('data')).slideDown(50);
        });
        $('.assistant').mouseleave(function (e) {
            $('#as_' + e.target.getAttribute('data')).slideUp(50);
        });
    });
    function GoTo() {
        window.location.href = 'http://localhost/webhooks/paros.php?MyDate=' + $('#MyDate').val();
    }
    function to_edit(btn) {
        const json = JSON.parse(btn.getAttribute('data'));
        const assistants = JSON.parse(json.assistants);
        $('#nuevo .my_title').text('Editar Paro');
        $('.my_input_list').prop('checked', false);
        assistants.forEach(a => { $(`.my_input_list[value="${a}"]`).prop('checked', true); });
        for (var j in json) {
            // console.log(j + ' - ' + json[j]);
            $(`.my_input[name="${j}"]`).val(json[j]);
        }
    }
    function to_reset() {
        $('#nuevo .my_title').text('Añadir Paro');
        
        $('#select .options>input[type="checkbox"]').prop('checked', false);

        $('#check_all').prop('checked', false);
        $('input[name="id"]').val(0);
        $('textarea[name="reason"]').val('');

        $('input[name="start"]').val('');
        $('input[name="end"]').val('');
        $('input[name="date"]').val('');
    }
    $("#check_all")[0].addEventListener('change', (e) => {
        $('#select .options>input[type="checkbox"]').prop('checked', e.currentTarget.checked);
    });


</script>