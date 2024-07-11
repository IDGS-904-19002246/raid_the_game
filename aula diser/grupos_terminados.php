<?php
$ruta="../../thema";
$desc_modulo=mysql_query("select * from dwork_modulos where marchivo='$archivo' limit 1");
while($mod=mysql_fetch_array($desc_modulo)):?>
<br>
<table width="95%" height="52px" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
	<td width="55" rowspan="3"><img src="<?php echo $ruta/$mod['micono'];?>"></td>
     <td><font class="titconten"
	 	style="font-family: Arial, Helvetica, sans-serif;color: #539ADB;font-size: 14px;font-weight: bold;text-transform: uppercase;">
         <?php echo $mod['mnombre'];?></td>
  </tr>
  <tr>
     <td>	 
	 	<div style="border: #FF9900 solid;padding: 1px; margin:6px 0px;"></div>
	 </td>
  </tr>
  <tr>
     <td><div align="justify"><font class="titconten2" style="font-family: Arial, Helvetica, sans-serif;color: #FF6600;font-size: 12px;font-weight: normal;text-transform: uppercase;">
     <?php echo $mod['mdescripcion']?></font></div></td>
  </tr>
</table><br>
<?php endwhile;
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

// $gid="$_GET[gid]";
$usuario = $_GET['usuario'];
$sesion = $_GET['sesion'];
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
            font-family: Arial;font-size: 12px;}

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

<div class="MyBody px-4">
    <!-- ENCABEZADO -->
    <form class="row p-4" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="col-sm-4">Selecciona el Producto</div>
        <div class="col-sm-4">
            <select name="MyProduct" class="form-control form-control-sm">
                <?php if (!$mysqlis->connect_error):
                $sql2 = "SELECT
                        DISTINCT b.pid, a.pnombre, a.ptid,
                        (SELECT pt.ptdescripcion FROM dwork_empresa_productos_tipos pt WHERE pt.ptid=a.ptid) ptdescripcion
	
                    FROM dwork_empresa_productos a
                    INNER JOIN dwork_empresa_grupos b ON a.pid=b.pid
                    WHERE a.pactivo=1 AND b.gstatus = 2
                    ORDER BY a.ptid, a.pid";
                $result2 = $mysqlis->query($sql2);
                if ($result2):
                    while ($row2 = $result2->fetch_assoc()): ?>
                    <option value=<?php echo $row2['pid']?>>
                        (<?php echo $row2['pid'];?>) <?php echo $row2['ptdescripcion'] .' - '. $row2['pnombre'];?>
                    </option>
                <?php endwhile;endif;endif;?>                    
            </select>
        </div>
        <div class="col-sm-4"><button class="btn btn-sm btn-primary" type="submit">Get</button></div>
    </form>
    <!-- TABLA -->
    <div class="p-4 w-100">
        <table id="MyTable" class="table table-striped py-4 overflow-auto">
            <thead>
                <tr class="text-center align-middle">
                    <th class="MyTh py-1">Grupo</th>
                    <th class="MyTh py-1">SEDE</th>
                    <th class="MyTh py-1">Aula</th>
                    <th class="MyTh py-1">Producto</th>
                    <th class="MyTh py-1">Asesor</th>
                    <th class="MyTh py-1">Fecha Inicio</th>
                    <th class="MyTh py-1">Fecha Fin</th>
                    <th class="MyTh py-1">Horario</th>
                    <th class="MyTh py-1"># alumnos</th>
                    <th class="MyTh py-1">Detalles</th>
                </tr>
            </thead>
            <tbody>
                <?php if($MyProduct != 0 and !$mysqlis->connect_error):
                    $sql = "SELECT
                            p.pid,g.gid,g.sedeclave,
                            (SELECT au.audescripcion FROM dwork_empresa_aulas au WHERE au.auid = g.auid) aula,
                            p.pnombre,
                            DATE_FORMAT(g.gf_inicio, '%e de %b %y') gf_inicio,
                            DATE_FORMAT(g.gf_termino, '%e de %b %y') gf_termino,
                            CONCAT(hd.hodesc ,' de ',hh.hohdesc) horario,
                            (SELECT COUNT(*) FROM dwork_alumnos_grupos ag WHERE ag.gid = g.gid) alumnos
                        FROM dwork_empresa_grupos g
                        INNER JOIN dwork_empresa_productos p ON g.pid = p.pid
                        INNER JOIN dwork_horarios_dias hd ON hd.hoid= g.hoid
                        INNER JOIN dwork_horarios_horas hh ON hh.hohid= g.hohid
                        WHERE gstatus = 2 and p.pid = {$MyProduct} ORDER BY g.gid DESC";
                    $result = $mysqlis->query($sql);
                    if ($result):
                        while ($row = $result->fetch_assoc()):?>
                        <tr class="align-middle MyTr">
                            <td class="py-0"><?php echo $row['gid'];?></td>
                            <td class="py-0"><?php echo $row['sedeclave'];?></td>
                            <td class="py-0"><?php echo $row['aula'];?></td>
                            <td class="py-0"><?php echo $row['pnombre'];?></td>
                            <td class="py-0"><?php
                                $gid = $row['gid'];
                                $asesor_sql ="SELECT
                                        a.asid, concat(a.asnombre,' ',a.asapellido_paterno,' ',a.asapellido_materno) asesor
                                    FROM dwork_empresa_asesores a INNER JOIN dwork_asesores_grupos b ON a.asid=b.asid
                                    WHERE b.gid={$gid} ORDER BY b.asgid ASC";
                                $result3 = $mysqlis->query($asesor_sql);
                                if ($result3):
                                    while ($row3 = $result3->fetch_assoc()):?>
                                    <label>
                                    <a href="../Asesores/pago_instructores_details.php?asid=<?php echo $row3['asid'];?>&amp;gid=<?php echo $row['gid'];?>" onclick="return parent.GB_showCenter('INFORMACION DEL ASESOR', this.href, 500, 900)">
                                        - <?php echo $row3['asesor']; ?>
                                    </a>
                                    </label>

                                    <?php endwhile;endif;?></td>

                            <td class="py-0"><?php echo $row['gf_inicio'];?></td>
                            <td class="py-0"><?php echo $row['gf_termino'];?></td>
                            <td class="py-0"><?php echo $row['horario'];?></td>
                            <td class="py-0 text-center"><?php echo $row['alumnos'];?></td>
                            <td class="py-0 text-center"><button class="btn p-0">
                                <a href="../Cobranza/cobranzaseg2.php?usuario=1000283&amp;sesion=1qvj3snjkc7cparh7eankgol51&amp;gid=<?php echo $row['gid'];?>"
                                onclick="return parent.GB_showCenter('DETALLES DEL GRUPO', this.href, 500, 900)"><img src="../../thema/ico_view.jpg" border="0"></a>
                            </button></td>
                        </tr>
                    <?php endwhile;endif;endif;?>                    
            </tbody>
            
        </table>

    </div>
</div>
<script>
    $(document).ready(function () {
        $('#MyTable').DataTable({
            language: { "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json" },
            searching: false, paging: false, info: false,
            order: [[0, 'desc']]
        });
    });
</script>