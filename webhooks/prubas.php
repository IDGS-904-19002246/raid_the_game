<?php
function conectarDB($ip, $user, $pass, $db){
    $mysqli = new mysqli($ip, $user, $pass, $db);
    if ($mysqli->connect_error) {die("Error de conexión: " . $mysqli->connect_error);}
    $mysqli->set_charset("utf8");
    return $mysqli;
}
$mysqlis = conectarDB("104.254.245.234", "adcontrol", '491n$iuZ1', "scontrol2019");
date_default_timezone_set('America/Mexico_City');

?>

<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td>Mes: </td>
        <td><input type="year" min="1980" max="2024"></td>
        <td>Año: </td>
        <td><input type="year" min="1980" max="2024"></td>
        <td>Grupos Terminados: </td>
        <td>
            <!-- onChange="MM_jumpMenu('parent.frames['contenido']',this,0)" -->
            <select name="grterminados">
                <option value="" disabled>Selecciona</option>
                <?php if (!$mysqlis->connect_error):
                $sql = "SELECT
                        gr.gid,
                        pr.pnombre,
                        (SELECT hd.hodesc FROM dwork_horarios_dias hd WHERE hd.hoid = gr.hoid LIMIT 1) hodesc,
                        (SELECT hh.hohdesc FROM dwork_horarios_horas hh WHERE hh.hohid = gr.hohid LIMIT 1) hohdesc 
                    FROM dwork_empresa_grupos gr INNER JOIN dwork_empresa_productos pr 
                    ON gr.pid=pr.pid
                    WHERE gr.gstatus=2 AND gr.gf_termino LIKE '2024-06%'
                    ORDER BY gr.gf_termino DESC";

                $result = $mysqlis->query($sql);
                    if ($result):
                        while ($row = $result->fetch_assoc()): ?>
                        <option value=""><?php echo $row['gid'].' - '.$row['pnombre'] . '('.$row['hodesc'].' '.$row['hohdesc'].')';?></option>
                <?php endwhile;endif;endif; ?>


            </select>
        </td>
</table>




<!-- $gruposterminados=mysql_query("SELECT
                        gr.gid,
                        pr.pnombre,
                        (SELECT hd.hodesc FROM dwork_horarios_dias hd WHERE hd.hoid = gr.hoid LIMIT 1) hodesc,
                        (SELECT hh.hohdesc FROM dwork_horarios_horas hh WHERE hh.hohid = gr.hohid LIMIT 1) hohdesc 
                    FROM dwork_empresa_grupos gr INNER JOIN dwork_empresa_productos pr 
                    ON gr.pid=pr.pid
                    WHERE gr.gstatus=2 
                    ORDER BY gr.gf_termino DESC",$link);
while($grt=mysql_fetch_array($gruposterminados)){
	echo"<option $sel1 value=\"enviosolicitudes.php?usuario=$usuario&sesion=$sesion&gid=$grt[gid]\">
		$grt[gid] - $grt[pnombre] ($grt[hodesc] de $grt[hohdesc])</option>"; 
}-->