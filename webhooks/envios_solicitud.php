<?php include("../../seg.php");
echo"<link href=\"../../thema/style.css\" rel=\"stylesheet\" type=\"text/css\">";


$usuario="$_GET[usuario]";
$sesion="$_GET[sesion]";
$gid="$_GET[gid]";
$sede="$sedeClave";

$sql_lasede=mysql_query("select * from auladiser_sedes where sclave='$sede'", $link);
$em=mysql_fetch_array($sql_lasede);

$logo="logo_dmedia.jpg";
$razonsocial=$em[srazonsocial];
$nombrecomercial="AULADISER.COM";

///////////////////////////

$ruta="../../thema";
$este=$_SERVER['PHP_SELF'];
$arch=explode("/",$este);
$arch2 = array_reverse($arch);
$archivo=$arch2[0];
$arch3=explode("_",$arch2);
$archivo="$arch3[0].php";

$anio=date("Y");
$mes=date("m");
$dia=date("d");
$hoy="$anio-$mes-$dia";
$dianum=date('w');

$dias = array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado');
$diahoy = $dias[date('w')];



echo"<br>
<table width=\"95%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
  <tr>
	<td width=\"55\" rowspan=\"3\"><img src=\"$ruta/enviosolicitudes.jpg\"></td>

     <td><font class=\"titconten\">REPORTE DE DIPLOMAS Y EVALUACIONES &nbsp;&nbsp;($diahoy, $dia de $mestxt de $anio)</td>
  </tr>
  <tr>
     <td><hr style=\"BORDER-RIGHT: solid; BORDER-TOP: solid; BORDER-LEFT: solid; COLOR: #FE9900; BORDER-BOTTOM: solid\" size=1 width=100%></td>
  </tr>
  <tr>
     <td><div align=\"justify\"><font class=\"titconten2\">REPORTE DE EVALUACIONES Y GENERACION DE DIPLOMAS POR ALUMNO Y GRUPO</font></div></td>
  </tr>
</table>
";

$diarevisar="d".$dianum;

	if($orden=='') { $orden2="a.agid ASC"; }
	if($orden=='proveedora') { $orden2="b.aapellido_paterno ASC"; }
	if($orden=='proveedorz') { $orden2="b.aapellido_paterno DESC"; }
	if($orden=='rfca') { $orden2="c.gid ASC"; }	
	if($orden=='rfcz') { $orden2="c.gid DESC"; }
	if($orden=='responsablea') { $orden2="d.pnombre ASC"; }
	if($orden=='responsablez') { $orden2="d.pnombre DESC"; }

	include("../../Includes/mifecha.php");

	/////////////////////////********************************
	
echo"<br>
<table width=\"95%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
  <tr>
	 <td>Grupos Terminados: </td>
	 <td><select name=\"grterminados\" onChange=\"MM_jumpMenu('parent.frames[\'contenido\']',this,0)\">
	 <option value=\"\">Selecciona</option>";

$maygid=0;

$gruposterminados=mysql_query("select * from dwork_empresa_grupos a inner join dwork_empresa_productos b 
on a.pid=b.pid where a.gstatus=2 ORDER by a.gf_termino DESC",$link);


while($grt=mysql_fetch_array($gruposterminados)){
	
	$elhorario=mysql_query("select * from dwork_horarios_dias a inner join dwork_horarios_horas b WHERE a.hoid='$grt[hoid]' AND b.hohid='$grt[hohid]'",$link);
	$hr=mysql_fetch_array($elhorario);
	if($grt[gid]==$gid){ $sel1="selected"; $sel2=""; }else{ $sel1=""; $sel2=""; }
	echo"<option $sel1 value=\"enviosolicitudes.php?usuario=$usuario&sesion=$sesion&gid=$grt[gid]\">
	
		$grt[gid] - $grt[pnombre] ($hr[hodesc] de $hr[hohdesc])</option>";
	
	$grupis = $grt[gid];
	
}
	 
echo"</select></td>
</tr>";

/*
<tr>
     <td>Grupos Activos : </td>
     <td><select name=\"gractivos\" onChange=\"MM_jumpMenu('parent.frames[\'contenido\']',this,0)\">
     <option value=\"\">Selecciona</option>";

$maygid=0;


$gruposactivos=mysql_query("select * from dwork_empresa_grupos a inner join dwork_empresa_productos b 
on a.pid=b.pid where gstatus=1",$link);

while($gra=mysql_fetch_array($gruposactivos)){
	
	$elhorario=mysql_query("select * from dwork_horarios_dias a inner join dwork_horarios_horas b WHERE a.hoid='$gra[hoid]' AND b.hohid='$gra[hohid]'",$link);
	$hr=mysql_fetch_array($elhorario);
	if($gra[gid]==$gid){ $sel2="selected"; $sel1=""; }else{ $sel2=""; $sel1=""; }
	echo"<option $sel2 value=\"diplomasyevaluaciones.php?usuario=$usuario&sesion=$sesion&gid=$gra[gid]\">$gra[gid] - $gra[pnombre] - $grt[pnombre] ($hr[hodesc] de $hr[hohdesc]</option>";
	
}
	 
echo"</select>
     
     </td>
  </tr>";
  
  */
  echo"</table>";
	
	/////////////////////////********************************
	
if($gid!=''){	
	
	$elgrupo=mysql_query("select * from dwork_empresa_grupos a inner join dwork_empresa_productos b inner join
	dwork_horarios_horas c on a.pid=b.pid and a.hohid=c.hohid and a.gid = '$gid' order by a.hohid",$link);
	
	
	while($gr=mysql_fetch_array($elgrupo)){
		
	
     $proveedores=mysql_query("select * from dwork_alumnos_grupos a inner join dwork_alumnos b inner join 
     dwork_empresa_grupos c inner join dwork_empresa_productos d on a.aid=b.aid and c.gid=$gr[gid] and a.gid=c.gid 
     and c.pid=d.pid ORDER BY $orden2",$link);
     
     $cuantosprov=mysql_num_rows($proveedores);

echo"<br>
	<table width=\"95%\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\" bgcolor=\"#FFFFFF\" align=\"center\">
	<tr><td>";


echo"
	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\" bgcolor=\"#FFFFFF\" align=\"center\">
	<tr>
		<td colspan=8>"; 

	$descripciongrupo=mysql_query("select * from dwork_empresa_grupos c inner join dwork_empresa_productos d 
	inner join dwork_horarios_dias e inner join dwork_horarios_horas f on c.pid=d.pid and c.hoid=e.hoid and c.hohid=f.hohid
	where c.gid=$gr[gid]",$link);
			
			while($descgpo=mysql_fetch_array($descripciongrupo)) {
			
				echo"<B>GRUPO "; printf("%03d",$descgpo[gid]);echo"</B> - $descgpo[pnombre] en <b>$descgpo[hodesc] de $descgpo[hohdesc]</b><br>
			Fecha de Inicio:<b>"; cambiaFecha($descgpo[gf_inicio]); echo "</b>- Finaliza El:<b>"; cambiaFecha($descgpo[gf_termino]);
			$diplomado="$descgpo[pnombre]";
$fechafin="$descgpo[gf_termino]";
$ciudad="$descgpo[gciudad]";


$quien_asesor=mysql_query("select * from dwork_empresa_grupos a inner join dwork_asesores_grupos b inner join dwork_empresa_asesores c
 WHERE a.gid = $gr[gid] and a.gid = b.gid and b.asid=c.asid",$link);
 while ($kien=mysql_fetch_array($quien_asesor))
 {
 	$asesor="$kien[astit] $kien[asnombre] $kien[asapellido_paterno] $kien[asapellido_materno]";
 	}
			}

echo"</td>
	</tr>
  	<tr bgcolor=\"#C1D4F1\">";

echo"<td width=\"6%\"><font class=\"tittabla\"><strong>No.</strong></font></td>";

echo"<td>&nbsp;&nbsp;";

	if($orden=="proveedora"){

	echo"<font class=\"tittabla\"><a href=\"enviosolicitudes.php?usuario=$usuario&sesion=$sesion&orden=proveedorz&b=1&gid=$gid&producto=$producto\"><strong>Alumno</strong>&nbsp;&nbsp;&nbsp;<img src=\"$ruta/desc.jpg\" border=0></a>";

	} else {

	echo"<font class=\"tittabla\"><a href=\"enviosolicitudes.php?usuario=$usuario&sesion=$sesion&orden=proveedora&b=0&gid=$gid&producto=$producto\"><strong>Alumno</strong>&nbsp;&nbsp;&nbsp;<img src=\"$ruta/asc.jpg\" border=0></a>";

	}

echo"</td>";

echo"   <td align=\"center\"><font class=\"tittabla\"><strong>Asistencia</strong></td>";
echo"   <td align=\"center\"><font class=\"tittabla\"><strong>Total a pagar</strong></td>";
echo"   <td align=\"center\"><font class=\"tittabla\"><strong>Abonado</strong></td>";
echo"   <td align=\"center\"><font class=\"tittabla\"><strong>Saldo</strong></td>";

echo"   <td align=\"center\"><font class=\"tittabla\"><strong>Ya Evaluo?</strong></td>";
echo"   <td align=\"center\"><font class=\"tittabla\"><strong>Email</strong></td>";
echo"   <td align=\"center\"><font class=\"tittabla\"><strong>Ultima Solicitud</strong></td>";
echo"   <td align=\"center\"><font class=\"tittabla\"><strong>Ultimo Recordatorio</strong></td>";
echo"   <td align=\"center\"><font class=\"tittabla\"><strong>Envios</strong></td>";
echo"   <td align=\"center\"><font class=\"tittabla\"><strong>Ver</strong></td>";
//////poner td segun los permisos

echo"</tr>";

////while de proveedores

$na=1;
while($pr=mysql_fetch_array($proveedores)) { 

	//COPIAR Y PEGAR EN LOS DEMAS
	
	
	$agidJuan = $pr[agid];
	
if($pr[deserto]==1){
		$bcolor="RED";
	}else{	
		if($num_fila2%2 == 0){$bcolor="#FFFFFF"; }else{ $bcolor="#EEF3FB";}
	}
	echo "<tr bgcolor='$bcolor' onMouseOver=\"this.bgColor='FF9966';\" onMouseOut=\"this.bgColor='$bcolor'\">";
	
$elMailAlumno = $pr[acorreo];
$aid=$pr[aid];
echo"<td><font class=\"tittablatd\">$na [$pr[aid]] - $pr[agid]</td>";
echo"<td><font class=\"tittablatd\">$pr[anombres] $pr[aapellido_paterno] $pr[aapellido_materno]</td>";
echo"<td><a href=\"../Asistencias/historico_alumno.php?agid=$pr[agid]\" onclick=\"return parent.GB_showCenter('HISTORICO DE ASISTENCIA DE ALUMNO $pr[agid]', this.href, 600, 900)\"); return false;\">VER</a></td>";

$totalpago=mysql_query("select SUM(pgcantidad) as pagototal from dwork_alumnos_pagos where agid='$pr[agid]'",$link);
$sal=mysql_fetch_array($totalpago);

$losabonos=mysql_query("select SUM(abcantidad) as abonado from dwork_alumnos_abonos where agid='$pr[agid]'",$link);
$ab=mysql_fetch_array($losabonos);

echo"<td align=\"right\"><font class=\"tittablatd\">"; 

////CONSULTO SI ES 0 PA BUSCAR AL SOCIO


//if($sal[pagototal]<='0'){



/// TIENE SOCIO??? BUSQUEDA


	$quieneselsocio = mysql_query("SELECT * from dwork_alumnos_grupos WHERE agid = '$pr[agid]'",$link);
	$qSocio=mysql_fetch_array($quieneselsocio);

	$elquedebe ="";

				if($qSocio[con_relacion] != ''){
				
				
				//SOCIO
				
			
			$elquedebe= $qSocio[con_relacion];
			
	//ABONOS DEL SOCIO
			$abSocio = mysql_query("SELECT SUM(abcantidad) as abonadoSocio from dwork_alumnos_abonos where agid = '$elquedebe' ",$link);
					$pagadoSocio=mysql_fetch_array($abSocio);
					$abonadoSocio = $pagadoSocio[abonadoSocio];
				
	//PAGOS DEL SOCIO
			        
			$losPagosdelsocio=mysql_query("select SUM(pgcantidad) as pagadosocio from dwork_alumnos_pagos where agid='$elquedebe'",$link);
					$pgsocio=mysql_fetch_array($losPagosdelsocio);
					$ctopagoelsocio=$pgsocio[pagadosocio];
				



	/// CUANTO ES CUANTO
			
			
			   $saldoSocio = $ctopagoelsocio-$abonadoSocio;
			   
			   
			   
	///////////////////////////////////////
				echo number_format($sal[pagototal],2);
				echo" <br>($elquedebe - $saldoSocio)";
				
				// FIN DE SOCIO
				
				}else{
				
				 echo number_format($sal[pagototal],2);
				}



//}else{
	
	
	//echo number_format($sal[pagototal],2);
	
//}

 echo"</td>";


echo"<td align=\"right\"><font class=\"tittablatd\">"; echo number_format($ab[abonado],2); echo"</td>";

$elmontohastahoy=mysql_query("select SUM(pgcantidad) as pagoshastahoy from dwork_alumnos_pagos where pgfecha<='$hoy' 
and agid='$pr[agid]'",$link);

$mtohoy=mysql_fetch_array($elmontohastahoy);

$montohastahoy=$mtohoy[pagoshastahoy]-$ab[abonado];

$saldo=$sal[pagototal]-$ab[abonado];

echo"<td align=\"right\"><font class=\"tittablatd\">"; 


///SU SALDO DEL ALUMNO

 echo number_format($saldo,2); 

//COMENTADO EL SAB 13 MARZO

/*
if($saldoSocio == 0){

	
	$saldoReal = $saldo;
	
	echo""; echo number_format($saldoReal,2); 

}else{
	
	
	$saldoReal = $saldoSocio;
	
	echo number_format($saldoReal,2);
	
}

*/

echo"</td>";

echo"<td align=\"right\">";

if($elquedebe == ''){ 

		echo"--"; 
	}else{ 
	
		if($saldoSocio <= 0 ){ echo"0.00"; 
		
		}else{ echo number_format($saldoSocio,2); }  
		
	}




echo"</td>";


// EVALUACION - revisar si evaluo

$evaluaciones=mysql_query("select * from evaluaciones_alumnos where agid='$pr[agid]'",$link);
$numevaluacion=mysql_num_rows($evaluaciones);

if($numevaluacion == 0){
	$evaluo="NO";
	echo"<td align=\"center\"><a href=\"evaluacion_add.php?aid=$aid&agid=$pr[agid]&sede=$sede&grupo=$gid\">Generar Folio</a></td>";
	
}else{
	
	$evaluo="SI";
echo"<td align=\"center\">SI</td>";
}

//echo"<td align=\"center\">$evaluo</td>";
echo"<td align=\"center\"><a href=\"evaluacion_add.php?aid=$aid&agid=$pr[agid]&sede=$sede&grupo=$gid\">Generar Folio</a></td>";

// DIPLOMA
/*
if($pr[diploma] == 1){
	$diplos="GENERADO"; 
}else{ 
	if($saldo > 0){
		$diplos="<font color=\"RED\">DEBE</font>";
	}else{
		if($numevaluacion == 0){
			$diplos="FALTA EVALUAR";
		}else{
			$diplos="<a href=\"generadiploma.php?alumno=$pr[anombres] $pr[aapellido_paterno] $pr[aapellido_materno]&diplomado=$diplomado=&fecha=$fechafin&instructor=$asesor\">GENERAR</a>";
		}
	}
}*/

//echo"<td align=\"center\">$diplos</td>";

echo"<td align=\"center\">";

/// REVISO QUE TENGA MAIL YO JUAN

if($elMailAlumno == ''){ 
	echo"<a href=\"actualizardatos.php?usuario=$usuario&sesion=$sesion&aid=$pr[aid]\" onclick=\"return parent.GB_showCenter('ACTUALIZAR DATOS DEL ALUMNO', this.href, 500, 700)\"><font color=\"RED\">LLAMAR</font></a>"; 
}else{ 
	echo"$elMailAlumno";
}


echo"</td>";

//$pr[agid]




//////////consultar si ya se envio la solicitud



////////// PONGO EL ULTIMO ENVIO DE SOLICITUD

echo"<td align=\"center\">";

$solicitudesalumno= mysql_query("SELECT * from diplomas_envios_solicitudes where solagid='$agidJuan' order by solfecha DESC limit 1 ",$link);

$sihaySolicitud = mysql_num_rows($solicitudesalumno);



if($sihaySolicitud == 0){

		echo" -- ";

}else{
	
	while($sl = mysql_fetch_array($solicitudesalumno)){
	
	 cambiaFecha($sl[solfecha]);
	//echo"$sl[solfecha]<br>";	
	
	}
}

echo"</td>";


////////// PONGO EL ULTIMO ENVIO DE SOLICITUD

echo"<td align=\"center\">";

$recordatoriosPagoAlumno= mysql_query("SELECT * from alumnos_recordatorios_pago where reagid='$agidJuan' order by refecha DESC limit 1 ",$link);

$sihayRecordatorio = mysql_num_rows($recordatoriosPagoAlumno);



if($sihayRecordatorio == 0){

		echo" -- ";

}else{
	
	while($rl = mysql_fetch_array($recordatoriosPagoAlumno)){
	
	 cambiaFecha($rl[refecha]);
	
	}
}

echo"</td>";


//////////consultar si ya hay diploma
echo"<td align=\"center\">";


////////// REVISO SI DEVE SI NO NO PONGO EL VINCULO
//echo"$agidJuan<hr>";


// REVISO SI TIENE SOCIO


if(empty($elquedebe)){
	
	// NO TIENE SOCIO PERO DEBE???
	
	if($saldo<='0'){
		
			// NO DEBE PERO YA EVALUO???
			
			if($evaluo == 'SI'){ 
			
				// OK YA EVALUO PERO HAY DIPLOMA?
				
				$sql_diplomas = mysql_query("SELECT * FROM diplomas WHERE agid='$agidJuan'", $link);
				$simonHay = mysql_num_rows($sql_diplomas);
				
				$elpdftabla = mysql_fetch_array($sql_diplomas);
				$elpdfArchivo = $elpdftabla[diploma]; 
								
						if($simonHay > '0'){

							$foliomd=$elpdftabla[foliomd]; 
							
				$filename = "http://diplomas.alumnosdiser.com/".$elpdfArchivo;
				
						if (@fopen($filename, "r")) {
   					
					
					echo"CERTIFICADO ENVIADO";
					
					} else {
  					
					echo "<a href=\"http://evaluacion.alumnosdiser.com/diploma_add.php?agid=$agidJuan&usuario=$usuario&sesion=$sesion&gid=$gid&sede=$sede\">REGENERAR DIPLOMA</a>";
}
						
						}else{
							
							echo "<a href=\"http://evaluacion.alumnosdiser.com/diploma_add.php?agid=$agidJuan&usuario=$usuario&sesion=$sesion&gid=$gid&sede=$sede\">CREAR DIPLOMA</a>";
							
						}
				
			
			}else{ 
			
							echo"<a href=\"enviosolicitud_mail.php?gid=$gid&aid=$aid&agid=$agidJuan\">ENVIAR SOLICITUD DE EVALUACION</a>"; 
			
			}	
		
	}else{
		
		
	echo"<a href=\"enviorecordatoriopago_mail.php?gid=$gid&aid=$aid&agid=$agidJuan&eldebe=$saldo\"> ENVIAR RECORDATORIO DE PAGO</a>";
		
	}
	
	
	
}else{
	
	
	// SI TIENE SOCIO .... PERO EL SOCIO O EL DEBEN???
	
$saldoTotal = $saldo+$saldoSocio;

	//if(($saldo<='0') && ($saldoSocio<='0')){ 
	
	if($saldoTotal<='0'){ 
			// OK NO DEBEN PERO YA EVALUAO ESTE
			
	if($evaluo == 'SI'){ 
			
			
			//echo"YA EVALUO";
				// OK YA EVALUO PERO HAY DIPLOMA?
				//echo"$agidJuan";
				$sql_diplomas2 = mysql_query("SELECT * FROM diplomas WHERE agid='$agidJuan'", $link);
				$simonHay = mysql_num_rows($sql_diplomas2);
		
				$elpdftabla = mysql_fetch_array($sql_diplomas2);
				$elpdfArchivo = $elpdftabla[diploma]; 
				$foliomd = $elpdftabla[foliomd];
								
						if($simonHay > '0'){
							
							$filename = "http://diplomas.alumnosdiser.com/".$elpdfArchivo;
				
							if (@fopen($filename, "r")) {

								echo"ENVIAR CERTIFICADO";
					
							} else {
								echo "<a href=\"http://evaluacion.alumnosdiser.com/diploma_add.php?agid=$agidJuan&usuario=$usuario&sesion=$sesion&gid=$gid&sede=$sede\">REGENERAR DIPLOMA</a>";
							}
						}else{
							echo "<a href=\"http://evaluacion.alumnosdiser.com/diploma_add.php?agid=$agidJuan&usuario=$usuario&sesion=$sesion&gid=$gid&sede=$sede\">CREAR DIPLOMA</a>";
						}
			
	}else{
		
		echo"<a href=\"enviosolicitud_mail.php?gid=$gid&aid=$aid&agid=$agidJuan\">ENVIAR SOLICITUD DE EVALUACION</a>";
		
	}
			
			
			
			
		//echo"NINGUNO DEBE"; 
		
	}else{ 
		
			echo"<a href=\"enviorecordatoriopago_mail.php?gid=$gid&aid=$aid&agid=$agidJuan&eldebe=$saldo&elsocio=$elquedebe&saldosocio=$saldoSocio\"> ENVIAR RECORDATORIO DE PAGO</a>"; 
		
	}
	
	
	}



echo"</td>";

$sql_diplomahecho = mysql_query("SELECT * FROM diplomas WHERE agid='$agidJuan'", $link);
$simHay = mysql_num_rows($sql_diplomahecho);
				
$rowpdf = mysql_fetch_array($sql_diplomahecho);
$elpdfArchivo = $elpdftabla[diploma]; 
								
if($simHay >= 1){

	$foliomd=$rowpdf['foliomd']; 
}else{
	$foliomd=""; 
}


echo"<td align=\"center\"><a href=\"Genera_Diploma/Genera/res/pdf.php?folio=$foliomd&sede=LE\" target=\"_blank\">Ver</a></td>";

$na=$na+1;
$num_fila++;


echo"</tr>";


     }
     mysql_free_result($proveedores);

     
     ///////Evaluacion General
     
     $evageneral=mysql_query("select * from evaluaciones_alumnos where gid='$gid'",$link);
     while($ev=mysql_fetch_array($evageneral)){
     	
     	$sql_evaluacion=mysql_query("select * from evaluaciones_respuestas where evid='$ev[evid]'",$link);
     	
     	
     }
     
     
     echo"</table>
     
     </td></tr>";
     
     
echo"</table>";

	}

	
echo"
<br>
<table width=\"400\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
<tr>
   <td align=\"center\"><img src=\"$ruta/printer.jpg\" border=0 align=\"absmiddle\"> &nbsp;&nbsp;&nbsp;<font class=\"agregar\"><a href=\"imprimereporte.php\" target=\"_blank\">IMPRIMIR REPORTE</a></font></td>
   
   
   <td align=\"center\"><img src=\"$ruta/refresh.jpg\" border=0 align=\"absmiddle\"> &nbsp;&nbsp;&nbsp;<font class=\"agregar\"><a href=\"enviosolicitudes.php?usuario=$usuario&sesion=$sesion&gid=$gid\">ACTUALIZAR</a></font></td>


</tr>
</table>";

}else{
	
echo"
<br>
<table width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
<tr>
   <td align=\"center\">Selecciona un Grupo</td>
</tr>
</table>";
	
}


?>