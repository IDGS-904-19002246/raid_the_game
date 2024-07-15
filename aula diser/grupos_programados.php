<?php

$user_id = $_GET['usuario'];
$session = $_GET['sesion'];

$url = explode("/", "$_SERVER[PHP_SELF]");
$name_file = array_reverse($url)[0];

// CONTENIDO --------------------------------------------------------------------------------------------
function conectarDB($ip, $user, $pass, $db)
{
    $mysqli = new mysqli($ip, $user, $pass, $db);
    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }
    $mysqli->set_charset("utf8");
    return $mysqli;
}
$mysqlis = conectarDB("104.254.245.234", "adcontrol", '491n$iuZ1', "scontrol2019");
date_default_timezone_set('America/Mexico_City');
// PERMISO -----------------------------------------------
$permissions_sql = "SELECT *
    FROM dwork_modulos m
    INNER JOIN dwork_personal_modulos_permisos mp ON m.modid = mp.modid
    WHERE mp.pid = 1 AND m.marchivo = 'grupos_terminados.php'";
$permissions_result = $mysqlis->query($permissions_sql);
if ($permissions_result && $permissions_result->num_rows >= 1) {
    $MyDisplay = 'd-block';
    $MyMessage = '';
} else {
    $MyDisplay = 'd-none';
    $MyMessage = '<br><h2>No tiene permisos<h2>';
}
// TITULO ENCABEZADO -----------------------------------------------
$ruta = "../../thema";
$module = array();
$title_result = $mysqlis->query("select * from dwork_modulos where marchivo='grupos_terminados.php' limit 1");
if ($title_result) {
    $module = $title_result->fetch_assoc();
}
//-----------------------------------------------
$groups = array();
$MyProduct = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MyProduct = $_POST['MyProduct'];
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
        .MyBody * {
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
        #suggestions * {
            padding: 4px;
        }
        #suggestions:has(> *) {
            border: black solid 1px;
        }
    </style>
</head>

<!-- ENCABEZADO -->
<table width="95%" height="52px" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td width="55" rowspan="3"><img src="<?php echo $ruta . '/' . $module['micono']; ?>"></td>
        <td>
            <font class="titconten"
                style="font-family: Arial, Helvetica, sans-serif;color: #539ADB;font-size: 14px;font-weight: bold;text-transform: uppercase;">
                <?php echo $module['mnombre']; ?>
        </td>
    </tr>
    <tr>
        <td>
            <div style="border: #FF9900 solid;padding: 1px; margin:6px 0px;"></div>
        </td>
    </tr>
    <tr>
        <td>
            <div align="justify">
                <font class="titconten2"
                    style="font-family: Arial, Helvetica, sans-serif;color: #FF6600;font-size: 12px;font-weight: normal;text-transform: uppercase;">
                    <?php echo $module['mdescripcion'] ?>
                </font>
            </div>
        </td>
    </tr>
</table>
<div class="text-center">
    <?php echo $MyMessage; ?>
</div>
<div class="MyBody px-4 <?php echo $MyDisplay; ?>">
    <!-- BUSCADOR -->
    <div class="row p-4 w-100">
        <div class="col-sm-2" style="font-family: Arial, Helvetica, sans-serif;color: #539ADB;font-size: 14px;font-weight: bold;text-transform: uppercase;">Buscar por ID de Grupo:</div>
        <div class="col-sm-6 position-relative">
            <input id="search" type="text" class="form-control form-control-sm bg-light w-100">
            <div id="suggestions" class="position-absolute overflow-auto rounded z-1 bg-light w-100" style="max-height:250px;"></div>
        </div>
    </div>
    <!-- BOTTON AÑADIR -->
    <div class="row px-4 w-100">
        <div class="col-sm-10"></div>
        <div class="col-sm-2">
            <div class="col-sm-12 text-center">
                <a href="grupos_add.php?usuario=<?php echo $user_id;?>&sesion=<?php echo $session;?>"><img src="../../thema/grupos_add.gif" border="0"></a>
            </div>
            <div class="col-sm-12 text-center">
                <font class="agregar">[ <a class="link-underline-opacity-0 link-dark" href="grupos_add.php?usuario=<?php echo $user_id;?>&sesion=<?php echo $session;?>">AGREGAR GRUPO</a> ]</font>
            </div>
        </div>
    </div>

    <!-- TABLA -->
    <div class="p-4 w-100">
        <table id="MyTable" class="table table-striped py-4 overflow-auto">
            <thead>
                <tr class="text-center align-middle">
                    <th class="MyTh py-1">Grupo</th>
                    <th class="MyTh py-1">Sede</th>
                    <th class="MyTh py-1">Producto</th>
                    <th class="MyTh py-1">Asesor</th>
                    <th class="MyTh py-1">Fecha Inicio</th>
                    <th class="MyTh py-1">Fecha Fin</th>
                    <th class="MyTh py-1">Aula</th>
                    <th class="MyTh py-1">Horario</th>
                    <th class="MyTh py-1">Horas</th>
                    <th class="MyTh py-1">Costo</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$mysqlis->connect_error):
                    $sql = "SELECT
                            p.pid,g.gid,
                            (
                            SELECT (select se.sclave from auladiser_sedes se where se.sid= au.sedeid)
                            FROM dwork_empresa_aulas au WHERE au.auid = g.auid
                            ) sede,
                            p.pnombre,
                            DATE_FORMAT(g.gf_inicio, '%e de %b %y') gf_inicio_title,
                            DATE_FORMAT(g.gf_termino, '%e de %b %y') gf_termino_title,
                            g.gf_inicio,
                            g.gf_termino,
                            (SELECT au.audescripcion FROM dwork_empresa_aulas au WHERE au.auid = g.auid) aula,
                            CONCAT(hd.hodesc ,' de ',hh.hohdesc) horario,
                            g.gduracion,
                            g.gprecio
                            
                        FROM dwork_empresa_grupos g
                        INNER JOIN dwork_empresa_productos p ON g.pid = p.pid
                        INNER JOIN dwork_horarios_dias hd ON hd.hoid= g.hoid
                        INNER JOIN dwork_horarios_horas hh ON hh.hohid= g.hohid
                        WHERE gstatus = 0 ORDER BY g.gf_inicio ASC";
                    $result = $mysqlis->query($sql);
                    if ($result):
                        while ($row = $result->fetch_assoc()): ?>
                            <tr class="align-middle MyTr">
                                <td class="py-0"><?php echo $row['gid']; ?></td>
                                <td class="py-0"><?php echo $row['sede']; ?></td>
                                <td class="py-0"><?php echo $row['pnombre']; ?></td>
                                <td class="py-0"><?php
                                $gid = $row['gid'];
                                $asesor_sql = "SELECT
                                        a.asid, concat(a.asnombre,' ',a.asapellido_paterno,' ',a.asapellido_materno) asesor
                                    FROM dwork_empresa_asesores a INNER JOIN dwork_asesores_grupos b ON a.asid=b.asid
                                    WHERE b.gid={$gid} ORDER BY b.asgid ASC";
                                $result3 = $mysqlis->query($asesor_sql);
                                if ($result3):
                                    while ($row3 = $result3->fetch_assoc()): ?>
                                            <label>
                                                <a class="link-underline-opacity-0 link-dark"
                                                    href="../Asesores/pago_instructores_details.php?asid=<?php echo $row3['asid']; ?>&amp;gid=<?php echo $row['gid']; ?>"
                                                    onclick="return parent.GB_showCenter('INFORMACION DEL ASESOR', this.href, 500, 900)">
                                                    - <?php echo $row3['asesor']; ?>
                                                </a>
                                            </label>

                                        <?php endwhile; endif; ?>
                                </td>

                                <td class="py-0"><?php echo $row['gf_inicio']; ?></td>
                                <td class="py-0"><?php echo $row['gf_termino']; ?></td>
                                <td class="py-0"><?php echo $row['aula']; ?></td>
                                <td class="py-0"><?php echo $row['horario']; ?></td>
                                <td class="py-0 text-center"><?php echo $row['gduracion']; ?></td>
                                <td class="py-0 text-center"><?php echo $row['gprecio']; ?></td>
                            </tr>
                        <?php endwhile; endif; endif; ?>
            </tbody>

        </table>

    </div>
</div>
<script>
    $(document).ready(function () {
        $('#MyTable').DataTable({
            language: { "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json" },
            searching: false, paging: false, info: false,
            order: [[4, 'asc']]
        });
    });
    document.getElementById('search').addEventListener('input', function () {
        let query = this.value;
        if (query.length > 1) {
            fetch(`search.php?query=${query}`)
                .then(response => response.json())
                .then(data => {

                    let suggestionsBox = document.getElementById('suggestions');
                    suggestionsBox.innerHTML = '';
                    data.forEach(item => {
                        let suggestionItem = document.createElement('div');

                        let a = document.createElement('a');
                        a.href = `gruposcanc.php?usuario=<?php echo $user_id;?>&sesion=<?php echo $session;?>&gid=${item.gid}`;
                        a.classList.add('link-underline-opacity-0', 'link-dark');
                        a.textContent = `${item.gid} - ${item.pnombre} - ${item.horario}`;

                        suggestionItem.appendChild(a);
                        suggestionsBox.appendChild(suggestionItem);
                    });
                });
        } else {
            document.getElementById('suggestions').innerHTML = '';
        }
    });
</script>