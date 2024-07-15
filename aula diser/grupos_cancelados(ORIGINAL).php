<?php include("../../seg.php"); 

include("../js.php");

include("../../conexion.php");

$gid="$_GET[gid]";
$anio="$_POST[anio]";
$producto="$_POST[producto]";

$usuario="$_GET[usuario]";
$sesion="$_GET[sesion]";

///////////////////////////



////////////////////////Validacion de permisos de modulo


$este="$_SERVER[PHP_SELF]";

$arch=explode("/",$este);

$arch = array_reverse($arch);
$archivo=$arch[0];


///////////////////////fin de validaci�n, hasta el final se cierra el else


$ruta="../../thema";

echo"<br>";
 include("../../imprime_top.php");


$desc_modulo=mysql_query("select * from dwork_modulos where marchivo='$archivo'");

while($mod=mysql_fetch_array($desc_modulo)) { 

$moduloname="$mod[mnombre]";

echo"
<table width=\"95%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
  <tr>
	<td width=\"55\" rowspan=\"3\"><img src=\"$ruta/$mod[micono]\"></td>

     <td><font class=\"titconten\">$mod[mnombre]</td>
  </tr>
  <tr>
     <td><hr style=\"BORDER-RIGHT: solid; BORDER-TOP: solid; BORDER-LEFT: solid; COLOR: #FE9900; BORDER-BOTTOM: solid\" size=1 width=100%></td>
  </tr>
  <tr>
     <td><div align=\"justify\"><font class=\"titconten2\">$mod[mdescripcion]</font></div></td>
  </tr>
</table><br>";

$modulo=$mod[modid];

}
mysql_free_result($desc_modulo);


//////Contenido de Proveedores


//////validar a que submodulos tiene acceso el se�or


$submod_add=mysql_query("select * from dwork_modulos a inner join dwork_personal_modulos_permisos b where a.mparent=$modulo and a.modid=b.modid and b.pid = '$usuario'");

while($mod=mysql_fetch_array($submod_add)) { 


$subarchivo=explode(".",$archivo);

$agrega="$subarchivo[0]_add.$subarchivo[1]";

$imgagrega="$subarchivo[0]_add.gif";

$files[]="$mod[marchivo]";

$modifica="$subarchivo[0]_mod.$subarchivo[1]";

$imgmod="$subarchivo[0]_mod.gif";

$elimina="$subarchivo[0]_del.$subarchivo[1]";

$imgdel="$subarchivo[0]_del.gif";

$imglist="$subarchivo[0]_list.gif";

}

mysql_free_result($submod_add);

$elementos=count($files);

for($i=0;$i<$elementos;$i++){
	$sf=explode("_",$files[$i]);

	if($sf[1]=="add.php"){
		$fileagrega=$files[$i];
	}
	if($sf[1]=="mod.php"){
		$filemod=$files[$i];
	}
	if($sf[1]=="del.php"){
		$filedel=$files[$i];
	}
}




echo"<td>
<table width=\"95%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
  <tr>
     <td rowspan=\"2\">&nbsp;</td>	
";



echo"
  </tr></table><br>";

//////formulario de busqueda


///////////////////////////


//echo"--$clid";

echo"
<table width=\"95%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">

<tr>
<td>
<!-- AJAX AUTOSUGGEST SCRIPT -->
<script type='text/javascript' src='lib/ajax_framework4.js'></script>";
	echo"<link href=\"lib/estilo.css\" rel=\"stylesheet\" type=\"text/css\" />";
	echo"<form name=\"opciones\" action=\"gruposcanc.php\" method=\"GET\">
	
<input type=\"hidden\" name=\"usuario\" value=\"$usuario\">
<input type=\"hidden\" name=\"sesion\" value=\"$sesion\">
<input type=\"hidden\" name=\"aid\" value=\"$gid\">";

echo"
<div id=\"search-wrap\"><b><font class=\"titconten\">Buscar por ID Grupo</font></b>: 
<input name=\"search-q\" id=\"search-q\" type=\"text\" onkeyup=\"javascript:autosuggest(); \" value=\"\" size=\"70\">
<input name=\"usuario\" id=\"usuario\" type=\"hidden\" value=\"$usuario\"/>
<input name=\"sesion\" id=\"sesion\" type=\"hidden\" value=\"$sesion\"/>
<div id=\"results\"></div>
</div>

	   </td></tr></table></form>";



echo"<br>";


//buskeda por grupos o años

echo"
<form name=\"prod\" action=\"gruposcanc.php\" method=\"POST\">
<table width=\"95%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">

<tr>
<td>
<div><b><font class=\"titconten\">Selecciona el Prog. Academico</font></b>: 
<select name=\"producto\">";
$productos=mysql_query("select distinct b.pid, a.pnombre from dwork_empresa_productos a inner join dwork_empresa_grupos b on a.pid=b.pid where b.gstatus = '3'");

while($row=mysql_fetch_array($productos)) { 

echo"<option value=\"$row[pid]\">$row[pnombre]</option>";
}

echo"
</select>

<input name=\"usuario\" id=\"usuario\" type=\"hidden\" value=\"$usuario\"/>
<input name=\"sesion\" id=\"sesion\" type=\"hidden\" value=\"$sesion\"/>
<input type=\"submit\" value=\"Consultar\">
</div>

	   </td></tr></table></form>";



echo"<br>";
//fin de las buskedas

	
	$orden="$_GET[orden]";
	$b="$_GET[b]";
	$c="$_GET[c]";
	$d="$_GET[d]";
	$e="$_GET[e]";


	if($orden=='') { $orden2="a.gid ASC"; }
	if($orden=='proveedora') { $orden2="b.pnombre ASC"; }
	if($orden=='proveedorz') { $orden2="b.pnombre DESC"; }
	if($orden=='rfca') { $orden2="a.gf_inicio ASC"; }	
	if($orden=='rfcz') { $orden2="a.gf_inicio DESC"; }
	if($orden=='responsablea') { $orden2="c.audescripcion ASC"; }
	if($orden=='responsablez') { $orden2="c.audescripcion DESC"; }

	if($orden=='grupoa') { $orden2="a.gid ASC"; }
	if($orden=='grupoz') { $orden2="a.gid DESC"; }

//// ordfenados por zona

	if($orden=='zonaa') { $orden2="d.hdesc ASC"; }
	if($orden=='zonaz') { $orden2="d.hdesc DESC"; }

	
/// Toma en cuenta que  en la consulta proveeedores aora es order by $orden

///where a.gf_termino>now()
if($producto==''){

if($gid=='' and $producto==''){
     $proveedores=mysql_query("select * from dwork_empresa_grupos a inner join dwork_empresa_productos b inner join dwork_empresa_aulas c 
on a.pid=b.pid and a.auid=c.auid where gstatus=3 ORDER BY gf_termino DESC limit 20",$link);
}else{
 $proveedores=mysql_query("select * from dwork_empresa_grupos a inner join dwork_empresa_productos b inner join dwork_empresa_aulas c 
on a.pid=b.pid and a.auid=c.auid where gstatus=3  and a.gid='$gid' ORDER BY gf_termino limit 1",$link);
}

}else{
$proveedores=mysql_query("select * from dwork_empresa_grupos a inner join dwork_empresa_productos b inner join dwork_empresa_aulas c 
on a.pid=b.pid and a.auid=c.auid where gstatus=3  and b.pid='$producto' ORDER BY a.gf_termino DESC",$link);
}
     $cuantosprov=mysql_num_rows($proveedores);

echo"
	<table width=\"95%\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\" bgcolor=\"#C1D4F1\" align=\"center\">
	<tr><td bgcolor=\"#FFFFFF\">";


echo"
	<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" bgcolor=\"#C1D4F1\" align=\"center\">

  	<tr bgcolor=\"#C1D4F1\">";

    echo"<td><font class=\"tittabla\">SEDE</font></td>";
    echo"<td>&nbsp;&nbsp;";


	if($orden=="grupoa"){

	echo"<a href=\"gruposcanc.php?usuario=$usuario&sesion=$sesion&orden=grupoz&b=1\"><font class=\"tittabla\">Grupo</font>&nbsp;&nbsp;&nbsp;<img src=\"$ruta/desc.jpg\" border=0></a>";

	} else {

	echo"<a href=\"gruposcanc.php?usuario=$usuario&sesion=$sesion&orden=grupoa&b=0\"><font class=\"tittabla\">Grupo</font>&nbsp;&nbsp;&nbsp;<img src=\"$ruta/asc.jpg\" border=0></a>";

	}

echo"</td>";


           echo"<td>&nbsp;&nbsp;";


/// vinculito de orden de proveedores

	if($orden=="proveedora"){

	echo"<a href=\"gruposcanc.php?usuario=$usuario&sesion=$sesion&orden=proveedorz&b=1\"><font class=\"tittabla\">Producto</font>&nbsp;&nbsp;&nbsp;<img src=\"$ruta/desc.jpg\" border=0></a>";

	} else {

	echo"<a href=\"gruposcanc.php?usuario=$usuario&sesion=$sesion&orden=proveedora&b=0\"><font class=\"tittabla\">Producto</font>&nbsp;&nbsp;&nbsp;<img src=\"$ruta/asc.jpg\" border=0></a>";

	}

echo"</td>
            <td><font class=\"tittabla\">Asesor</font></td>
    	   <td><strong>";

/// vinculito de orden de rfc

	if($orden== 'rfca'){
	echo"<a href=\"gruposcanc.php?usuario=$usuario&sesion=$sesion&orden=rfcz&c=1\"><font class=\"tittabla\">Fecha Inicio</font>&nbsp;&nbsp;&nbsp;<img src=\"$ruta/desc.jpg\" border=0>";
	} else {
	echo"<a href=\"gruposcanc.php?usuario=$usuario&sesion=$sesion&orden=rfca&c=0\"><font class=\"tittabla\">Fecha Inicio</font>&nbsp;&nbsp;&nbsp;<img src=\"$ruta/asc.jpg\" border=0>";
	}


echo"</td>

    	   <td><font class=\"tittabla\"><strong>Fecha Fin</strong></td>
    	   <td>";


/// vinculito de orden de responsable


	if($orden== 'responsablea'){
	echo"<a href=\"gruposcanc.php?usuario=$usuario&sesion=$sesion&orden=responsablez&d=1\"><font class=\"tittabla\">Aula</font>&nbsp;&nbsp;&nbsp;<img src=\"$ruta/desc.jpg\" border=0>";
	} else {
	echo"<a href=\"gruposcanc.php?usuario=$usuario&sesion=$sesion&orden=responsablea&d=0\"><font class=\"tittabla\">Aula</font&nbsp;&nbsp;&nbsp;<img src=\"$ruta/asc.jpg\" border=0>";
	}


echo"</div></td>

	   <td><div align=\"center\">";

/// vinculito de orden de zona


	if($orden== 'zonaa'){
	echo"<a href=\"gruposcanc.php?usuario=$usuario&sesion=$sesion&orden=zonaz&e=1\"><font class=\"tittabla\">Horario</font>&nbsp;&nbsp;&nbsp;<img src=\"$ruta/desc.jpg\" border=0>";
	} else {
	echo"<a href=\"gruposcanc.php?usuario=$usuario&sesion=$sesion&orden=zonaa&e=0\"><font class=\"tittabla\">Horario</font>&nbsp;&nbsp;&nbsp;<img src=\"$ruta/asc.jpg\" border=0>";
	}




echo"</div></td>
    	   <td width=\"7%\"><div align=\"center\"><font class=\"tittabla\"><strong># alumnos</strong></div></td>
    	   <td width=\"6%\"><div align=\"center\"><font class=\"tittabla\"><strong>Detalles</strong></div></td>


";

//////poner td segun los permisos
echo"</tr>";

////while de proveedores

while($pr=mysql_fetch_array($proveedores)) { 


echo "<tr ";	if ($num_fila%2==0)		echo "bgcolor=#FAFCFE";	else		echo "bgcolor=#EEF3FB";	echo ">";

$sql_lasede=mysql_query("select * from auladiser_sedes where sid='$pr[sedeid]'", $link);
$sd=mysql_fetch_array($sql_lasede);

echo"<td><font class=\"tittablatd\">&nbsp;$sd[sciudad]</td>";

echo"<td><font class=\"tittablatd\">&nbsp;";printf("%04d",$pr[gid]);echo"</td>";

echo"<td><font class=\"tittablatd\">&nbsp;$pr[pnombre]</td>";


$sql_elasesor=mysql_query("select a.asid, a.asnombre, a.asapellido_paterno, a.asapellido_materno, a.astelefono, a.astelefono_cel,
			a.astelefono_ofna, a.asemail from dwork_empresa_asesores a inner join dwork_asesores_grupos b on a.asid=b.asid where
			b.gid='$pr[gid]'",$link);
		if(mysql_num_rows($sql_elasesor) > 1){
			while($elas=mysql_fetch_array($sql_elasesor)){
				$asesor="<a href=\"../Asesores/asesores_details.php?asid=$elas[asid]\" onclick=\"return parent.GB_showCenter('INFORMACION DEL ASESOR', this.href, 500, 900)\">$elas[asnombre] $elas[asapellido_paterno] $elas[asapellido_materno]</a><br>";
			}
		}else{
			$elas=mysql_fetch_array($sql_elasesor);
			$asesor="<a href=\"../Asesores/asesores_details.php?asid=$elas[asid]\" onclick=\"return parent.GB_showCenter('INFORMACION DEL ASESOR', this.href, 500, 900)\">$elas[asnombre] $elas[asapellido_paterno] $elas[asapellido_materno]</a>";
		}
echo"<td width=120><font class=\"tittablatd\">$asesor</td>";

echo"<td><font class=\"tittablatd\">";

$fex=explode("-",$pr[gf_inicio]);
			
$dia=$fex[2]; $mes=$fex[1]; $anio=$fex[0];
			
$an=substr($anio,2,3);
			
include("conviertefecha.php");
			
$lafecha="$dia de $mtxt $an";

echo"$lafecha</td>";

echo"<td><font class=\"tittablatd\">";

$fex=explode("-",$pr[gf_termino]);
			
$dia=$fex[2]; $mes=$fex[1]; $anio=$fex[0];
			
$an=substr($anio,2,3);
			
include("conviertefecha.php");
			
$lafecha2="$dia de $mtxt $an";

echo"$lafecha2</td>";

$sihayalumnosahi=mysql_query("select * from dwork_alumnos_grupos where gid=$pr[gid]",$link);
$ctosalumnostiene=mysql_num_rows($sihayalumnosahi);

echo"<td><font class=\"tittablatd\">$pr[audescripcion]</td>";

if($pr[hoid]!='0'){
	$sql_horario=mysql_query("select * from dwork_horarios_dias a inner join dwork_horarios_horas b where a.hoid='$pr[hoid]' and b.hohid='$pr[hohid]'",$link);
	$hr=mysql_fetch_array($sql_horario);
	$horario="$hr[hodesc] de $hr[hohdesc]";
}else{
	$sql_horario=mysql_query("select * from dwork_empresa_horarios where hid='$pr[hid]'",$link);
	$hr=mysql_fetch_array($sql_horario);
	$horario="$hr[hdesc]";
}

echo"<td><font class=\"tittablatd\">$horario</td>";

echo"<td align=\"center\"><font class=\"tittablatd\">$ctosalumnostiene</td>";

echo"<td align=\"center\">";

//echo"<a href=\"grupos_details.php?usuario=$usuario&sesion=$sesion&gid=$pr[gid]\" target=\"popup\" onclick=\"return parent.GB_showCenter('DETELLES DEL GRUPO', this.href, 450, 700)\"); return false;\"><img src=\"$ruta/ico_view.jpg\" border=0></a></td>";
echo"<a href=\"../Cobranza/cobranzaseg2.php?usuario=$usuario&sesion=$sesion&gid=$pr[gid]\" onclick=\"return parent.GB_showCenter('DETALLES DEL GRUPO', this.href, 500, 900)\"><img src=\"$ruta/ico_view.jpg\" border=0></a></td>";

echo"</td>";



////poner los td segun los permisos

$num_fila++;


     }
     mysql_free_result($proveedores);


////fin de while

echo"</td></tr></table>";

echo"</td>";

echo"</tr></table>";

////fin de contenido

include("../../imprime_foot.php");
   



?>