<?php
include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";
if(isset($_GET['elim'])){
	$idproy=$_GET['id'];
	if(pg_num_rows(pg_query("SELECT idAlumno FROM Alumno_Proyecto WHERE idProyecto=$idproy"))>0)
	echo "<script languaje='javascript'> 
		alert('Acci\u00F3n cancelada, No puede eliminar este proyecto. Existen asignaciones a este proyecto ');
		window.location = '../paginas/Inicio/plantilla_pagina.php';
	  </script>";
	 
	//Verificar si la propuesta del proyecto fue de un alumno
	$qhace=pg_query("SELECT idPropuesta FROM Se_Convierte as sc INNER JOIN Propuesta_proyecto as pp ON sc.idProyecto=pp.idProyecto INNER JOIN Hace as h ON pp.idPropuesta=h.idPropuesta WHERE sc.idProyecto=$idproy");	
	if(pg_num_rows($qhace)>0){
	$rhace=pg_fetch_array($qhace);
	pg_query("DELETE FROM Hace Where idPropuesta=$rhace[0]") or die ("<SPAN CLASS='error'>Fallo en consulta_ELIMINAR_HACE!!</SPAN>".pg_last_error());
	}
	//sacar idPropuesta, borrar se_convierte, propuesta carrera, propuesta, proyecto.
	$qsc=pg_query("SELECT idPropuesta FROM Se_Convierte WHERE idProyecto=$idproy") or die ("<SPAN CLASS='error'>Fallo en consulta_idPropuesta!!</SPAN>".pg_last_error());
	$rsc=pg_fetch_array($qsc);
	
	pg_query("DELETE FROM Se_Convierte WHERE idPropuesta=$rsc[0]") or die ("<SPAN CLASS='error'>Fallo en consulta_ELIMINAR_SE_CONV!!</SPAN>".pg_last_error());
	
	pg_query("DELETE FROM propuesta_carrera WHERE idPropuesta=$rsc[0]") or die ("<SPAN CLASS='error'>Fallo en consulta_Propuesta_carrera!!</SPAN>".pg_last_error());
	
	pg_query("DELETE FROM Propuesta_proyecto WHERE idPropuesta=$rsc[0]") or die ("<SPAN CLASS='error'>Fallo en consulta_ELIMINAR_Propuesta!!</SPAN>".pg_last_error());
	
	if(pg_query("DELETE FROM Proyecto WHERE idProyecto=$idproy") or die ("<SPAN CLASS='error'>Fallo en consulta_ELIMINAR_PROYECTO!!</SPAN>".pg_last_error()))
	echo "<script languaje='javascript'> 
		alert('Acci\u00F3n Realizada. Proyecto Eliminado');
		window.location = '../Inicio/plantilla_pagina.php';
	  </script>";
}

$proyecto=$_GET['id'];
$detalle_proyecto = "
	SELECT
	pr.nomProyecto,
	pr.nominstitucion,
	pr.descripcionPropuesta,
	pr.estudiantesrequeridos,
	pr.duracionestimada,
	pr.nomcontacto,
	pr.correoContacto,
	pr.comentarioProp,
	pr.idinstitucion,
	pr.idpropuesta,
	pr.estadoprop,
	p.estadoProyecto

	FROM proyecto p, Propuesta_proyecto pr, se_convierte sc
	WHERE p.idproyecto=sc.idproyecto AND sc.idpropuesta=pr.idpropuesta AND p.idproyecto = '$proyecto'";

$consulta_proyecto = pg_query($detalle_proyecto) or die ("<SPAN CLASS='error'>Fallo en consulta_proyecto!!</SPAN>".pg_last_error());
$resultado_proyecto = pg_fetch_array($consulta_proyecto);
?>  
<script type='text/javascript' 	 src='../../js/funciones.js'></script>
<script language='javaScript' type='text/javascript'>
	function goElim(id){
		var respuesta=confirm('\u00BFEsta seguro de borrar este Proyecto?');
		if (respuesta) window.location='frmModificarProyecto.php?elim=1&id='+id;
	}
</script>
<style>.tinytable{width: 50%;}</style>
<h2 align="center">DETALLES DE PROYECTO</h2>


	<form method="post" <?php echo "action=\"../../archivosphp/ActualizaProyecto.php?id=$proyecto&operacion=2\""; ?> name="frmapproy1" id="frmapproy1">
	<table class="tinytable" align="center">
	<tr><thead><th colspan="2"><h3>PROYECTO</h3></thead></tr>
		<?php
		$nombre=$resultado_proyecto['0'];
		$institucion=$resultado_proyecto['1'];
		$descripcion=$resultado_proyecto['2'];
		$estrequeridos=$resultado_proyecto['3'];
		$durestimada=$resultado_proyecto['4'];
		$contacto=$resultado_proyecto['5'];
		$correo=$resultado_proyecto['6'];
		$comentarios=$resultado_proyecto['7'];
		$idinstitucion=$resultado_proyecto['8'];
		$idpropuesta=$resultado_proyecto['9'];
		$estadoprop=$resultado_proyecto['10'];
		$cod_estadoP=$resultado_proyecto['11'];
		if($resultado_proyecto['11']=='D')$estadoProyecto='Disponible';
		if($resultado_proyecto['11']=='A')$estadoProyecto='Asignado';
		if($resultado_proyecto['11']=='L')$estadoProyecto='Detenido';
		if($resultado_proyecto['11']=='B')$estadoProyecto='De Baja';
		
		echo"
		<tr><td id='tdr' width='40%'><b>NOMBRE:</b></td><input type='hidden' id='idpropuesta' name='idpropuesta' value='$idpropuesta'></input><input type='hidden' id='nombre' name='nombre' value='$nombre'></input><td id='tdl'>".$nombre."</td></tr>
		<tr><td id='tdr'><b>INSTITUCION:</b><input type='hidden' id='institucion' name='institucion' value='$institucion'></input><input type='hidden' id='idinstitucion' name='idinstitucion' value='$idinstitucion'></input></td><td id='tdl'>".$institucion."</td></tr>
		<tr><td id='tdr'><b>DESCRIPCION:</b><input type='hidden' id='estadoprop' name='estadoprop' value='$estadoprop'></input><input type='hidden' id='descripcion' name='descripcion' value='$descripcion'></input></td><td id='tdl'>".$descripcion."</td></tr>
		
		<tr><td id='tdr'><b>ESTUDIANTES REQUERIDOS:</b></td><input type='hidden' id='estrequeridos' name='estrequeridos' value='$estrequeridos' class=':only_on_submit'></input><td id='tdl'>".$estrequeridos."</td></tr>
		<tr><td id='tdr'><b>DURACION ESTIMADA (Meses):</b></td><td id='tdl'><input id='durestimada' name='durestimada' value='$durestimada' class=':only_on_submit'></input></td></tr>
		<tr><td id='tdr'><b>CONTACTO:</b></td><td id='tdl'><input id='contacto' name='contacto' value='$contacto' class=':only_on_submit'></input></td></tr>
		<tr><td id='tdr'><b>CORREO:</b></td><td id='tdl'><input id='correo' name='correo' value='$correo' class=':only_on_submit'></input></td></tr>
		<BR
		<tr><td id='tdr'><b>COMENTARIOS:</b></td><td id='tdl'><Textarea  maxlength=150 rows=2 cols=35 id='comentario' name='comentario' class=':only_on_submit' >$comentarios</Textarea></td></tr>";
		if($resultado_proyecto['11']=='B')
		echo "<tr><td id='tdr'><b>CAMBIAR ESTADO:</b></td><td id='tdl'>
		<select id='estadoProyecto' name='estadoProyecto' class=':only_on_submit'>
			<option value='$cod_estadoP' selected>$estadoProyecto</option>
			<option value='D'>Disponible</option>
			<option value='A'>Asignado</option>
			<option value='L'>Detenido</option>
			<option value='B'>De Baja</option>
		</select>
		</td></tr>
		";
		else
		echo "<tr><td id='tdr'><b>ESTADO:</b><input type='hidden' id='estadoProyecto' name='estadoProyecto' value='$estadoProyecto'></td><td id='tdl'>".$estadoProyecto."</td></tr>
		";
		?>
	</table>
		<BR>
		<CENTER>
		<input type="submit" name="buton1" class="buton" value="Guardar" />
		<input type="button" name="buton2" class="buton" value="Cancelar" <?php echo  "onclick=\"location.href='frmConsultarProyecto.php'\""; ?> />
		<?php 
		if($estadoProyecto=="Disponible")
		echo "<input type='button' name='buton3' class='buton' value='Eliminar' onClick='goElim(".$proyecto.")'/>";
		?></center>
	</form>


<span id='toolTipBox'></span>
<?php      
include "../../librerias/cerrar_conexion.php";
include "../../librerias/pie.php";
?>
