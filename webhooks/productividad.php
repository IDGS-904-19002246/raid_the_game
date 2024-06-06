<?php include("../../seg.php");

//include("../../conexionElastix.php");
include("calendario.php");
include("UtileriasFecha.php");

echo"<link href=\"../../thema/style.css\" rel=\"stylesheet\" type=\"text/css\">";

$meses=array("","ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
$dias=array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
$diascortos=array("Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab");
////////////////////////Validacion de permisos de modulo

$este = $_SERVER['PHP_SELF'];
$arch=explode("/",$este);
$arch = array_reverse($arch);
$archivo=$arch[0];

$pid=$_GET['pid'];

$permisos=mysql_query("select * from dwork_modulos a inner join dwork_personal_modulos_permisos b where a.marchivo='$archivo' and a.modid = b.modid and b.pid = '$usuario'" ,$link );

if(mysql_num_rows($permisos)==0){    

echo "<br><br><br><br><br><center><font class=\"titconten\">No tienes Privilegios para hacer uso de este m&oacute;dulo</font></center>";

}else{

	$fechaInicio=$_GET['fechaInicio'];
	$fechaFin=$_GET['fechaFin'];

if($fechaInicio==''){
	
	$fechaInicio = date("Y-m-01");
	$fechaFin = date("Y-m-t");

}

$desde=$fechaInicio;
$hasta=$fechaFin;
$estemes=date("m");
$esteanio=date("Y");

$numdays = ((strtotime($hasta)-strtotime($desde))/86400);

$sacames=explode("-", $fechaInicio);
$mesint=(int) $sacames[1];
$mestxt=$meses[$mesint];
$mesrevision=$sacames[1];
$aniorevision=$sacames[0];
$diainicio=$sacames[2];

///////////////////////fin de validacion, hasta el final se cierra el else

$ruta="../../thema";
include("../../imprime_top.php");
echo"<br>";


$desc_modulo=mysql_query("select * from dwork_modulos where marchivo='$archivo'");

while($mod=mysql_fetch_array($desc_modulo)) { 

echo"
<table width=\"95%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
  <tr>
	 <td width=\"55\" rowspan=\"3\"><img src=\"$ruta/$mod[micono]\"></td>
     <td><font class=\"titconten\">$mod[mnombre] 2</td>
  </tr>
  <tr>
     <td><hr style=\"BORDER-RIGHT: solid; BORDER-TOP: solid; BORDER-LEFT: solid; COLOR: #FE9900; BORDER-BOTTOM: solid\" size=1 width=100%></td>
  </tr>
  <tr>
     <td><div align=\"justify\"><font class=\"titconten2\">$mod[mdescripcion]</font></div></td>
  </tr>
</table>";

$modulo=$mod[modid];

}
mysql_free_result($desc_modulo);


$elementos=count($files);

$personal=mysql_query("select * from dwork_personal where inactivo=0 ORDER BY pfechaalta", $link);
$cuantospers=mysql_num_rows($personal);

echo"<br><br>
<table width=\"95%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#C1D4F1\" align=\"center\">
<tr><td bgcolor=\"#FFFFFF\">MES ACTUAL: <b>$mestxt</b><br>
	
	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"5\" bgcolor=\"#C1D4F1\" align=\"center\">
  	<tr bgcolor=\"#C1D4F1\">";

        echo"<td align=\"center\" width=50>CLAVE</td>
		<td align=\"center\" class=\"tittabla\">Fecha Alta</td>
		<td align=\"center\" class=\"tittabla\">Nombre</td>
		<td align=\"center\" class=\"tittabla\">Inscritos</td>
		<td align=\"center\" class=\"tittabla\">Nuevas Vtas</td>
		<td align=\"center\" class=\"tittabla\">Percibido</td>";
//		<td align=\"center\" class=\"tittabla\">Llam totales</td>
//		<td align=\"center\" class=\"tittabla\">Llam productivas</td>";

echo"</tr>";

////while de proveedores

while($pr=mysql_fetch_array($personal)){

	$idpersonal=$pr['pid'];
	$Acumulado=0;
	$ComisionesRebajadas=0;

	if($num_fila%2 == 0){$bcolor="#EEF3FB"; }else{ $bcolor="#FFFFFF";}
	
	//////SACAR INSCRITOS
	$sql_inscritosMes=mysql_query("select * from dwork_alumnos_grupos where MONTH(fecha_altagpo) ='$estemes' and YEAR(fecha_altagpo)='$esteanio' and dequienes='$pr[pid]'", $link);
	$numInscritos=mysql_num_rows($sql_inscritosMes);
	
	/////VENDIDO $ TOTAL
	$abonadohastahoy=0;
	while($vd=mysql_fetch_array($sql_inscritosMes)){
		$sql_pagos=mysql_query("select sum(abcantidad) as abonado from dwork_alumnos_abonos where agid=$vd[agid]", $link);
		$pg=mysql_fetch_array($sql_pagos);
		$abonadohastahoy=$abonadohastahoy+$pg[abonado];
	}

	///PERCIBIDO TOTAL $ EN EL MES

	
	$sql_percibidoMes=mysql_query("select SUM(a.abcantidad) as acumulado, SUM(a.comisionRebajada) as comisionesrebajas from dwork_alumnos_abonos a inner join dwork_alumnos_grupos b on a.agid=b.agid where MONTH(a.abfecha)='$estemes' AND YEAR(a.abfecha)='$esteanio' and b.dequienes='$idpersonal'", $link);

	$per=mysql_fetch_array($sql_percibidoMes);

	$Acumulado=$per['acumulado'];
	$ComisionesRebajadas=$per['comisionesrebajas'];
	$percibidoTotal=$Acumulado-$ComisionesRebajadas;

	$nuevasVentas=$nuevasVentas+$abonadohastahoy;
	$percibidoReal=$percibidoReal+$percibidoTotal;
	
	///LLAMADAS TOTALES DEL ELASTIX $linkll
	$sql_llamadasTotales=mysql_query("select * from cdr where date(calldate) >='$fechaInicio' and date(calldate)<='$fechaFin' and dst like '$pr[extension]%'", $linkll);
	$llamadasElastiks=mysql_num_rows($sql_llamadasTotales);
	
	///LLAMADAS EFECTIVAS
	$sql_llamadasProductivas=mysql_query("select * from cdr where date(calldate) >='$fechaInicio' and date(calldate)<='$fechaFin' and dst like '$pr[extension]%'", $link);
	$llamadasProductivas=mysql_num_rows($sql_llamadasProductivas);
	
echo"<tr bgcolor='$bcolor' onMouseOver=\"this.bgColor='FF9966';\" onMouseOut=\"this.bgColor='$bcolor';\">";

echo"<td align=\"center\">$pr[pid]</td>";
echo"<td align=\"center\">$pr[pfechaalta]</td>";
echo"<td>$pr[pnombre] $pr[papellidos]</td>";
echo"<td align=\"center\">$numInscritos</td>";
echo"<td align=\"center\">$ "; echo number_format($abonadohastahoy,2); echo"</td>";
echo"<td align=\"center\">$ "; echo number_format($percibidoTotal,2); echo"</td>";
//echo"<td align=\"center\">$llamadasElastiks</td>";
//echo"<td align=\"center\">$llamadasProductivas</td>";

echo"</tr>";

$num_fila++;

     }
     

////fin de while
echo"<tr>";

	echo"<td></td>";
	echo"<td></td>";
	echo"<td></td>";
	echo"<td align=\"right\"><b>TOTALES</b></td>";
	echo"<td align=\"right\"><b>$ "; echo number_format($nuevasVentas,2); echo"</b></td>";
	echo"<td align=\"right\"><b>$ "; echo number_format($percibidoReal,2); echo"</b></td>";

echo"</tr>";




echo"</td></tr></table>";



////fin de contenido

echo"</td></tr></table>";


echo"
<br>
<form action=\"productividad.php\" method=\"GET\">
<input type=\"hidden\" name=\"usuario\" value=\"$usuario\">
<input type=\"hidden\" name=\"sesion\" value=\"$sesion\">
<table border=\"0\" cellspacing=\"5\" cellpadding=\"5\" align=\"center\">
<tr>
   <td align=\"right\">EJECUTIVO</td>
   <td align=\"right\"><select name=\"pid\">";
   $personal2=mysql_query("select * from dwork_personal where dip=4 and inactivo=0 ORDER BY pfechaalta", $link);   
   
   while($pr2=mysql_fetch_array($personal2)){
	echo"<option value=\"$pr2[pid]\">$pr2[pnombre] $pr2[papellidos]</option>";
   }
   
   echo"</select></td>
   <td align=\"right\">Fecha de Inicio</td>
   <td align=\"right\"><input type=\"text\" name=\"fechaInicio\" size=\"10\" id=\"1\" value=\"$fechaInicio\"
        ><input type=\"reset\" value=\" ... \"
        onclick=\"return showCalendar('1', '%Y-%m-%d');\" name=\"boton_1\"></td>
   <td align=\"right\">Fecha de Fin</td>
   <td align=\"right\"><input type=\"text\" name=\"fechaFin\" size=\"10\" id=\"2\" value=\"$fechaFin\"
        ><input type=\"reset\" value=\" ... \"
        onclick=\"return showCalendar('2', '%Y-%m-%d');\" name=\"boton_2\"></td>	
   <td><input type=\"submit\" value=\"REVISAR\"> * Usa periodos cortos</td>
</tr>
</table>
</form>
";


///////////DESGLOSE DETALLADO

if($pid!=''){
	
	$sql_trabajador=mysql_query("select * from dwork_personal where pid='$pid'",$link);
	$trab=mysql_fetch_array($sql_trabajador);
	
	$dip=$trab[dip];
	
	$sueldo=$trab[psueldo];
	$tiposueldo=$trab[psueldoTipo];
	$llamadasEfectivasaRealizar=$trab[llamadasEfectivasMes];
	$cuotaVentasMensual=$trab[cuotaVentas];
	$costodia=$trab[ppagohora];
	

	echo"<table border=\"0\" cellspacing=\"5\" cellpadding=\"5\" align=\"center\">
<tr>
   <td><b>EJECUTIVO $trab[pnombre] $trab[papellidos] DEL $fechaInicio - $fechaFin</b></td>
	</tr>
	</table><br>";

	include("productividad_ventas.php");
	include("productividad_semanal.php");
	
	//include("productividad_asistencias.php");
	//include("productividad_llamadas.php");
	//include("productividad_interesados.php");
	//include("productividad_agendados.php");
	//include("productividad_seguimientos.php");
	
	
}

}


mysql_free_result($permisos);


//IMPRIMIR

echo"
<br>
<table width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
<tr>
   <td align=\"right\">";
   
   include("../../imprime_foot.php");echo"
   </td>
</tr>
</table>
";


?>