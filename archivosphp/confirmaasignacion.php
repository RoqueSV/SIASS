<?php
include "../librerias/abrir_conexion.php";
include "../librerias/cabecera.php";
$idproyecto=$_GET['id'];
$idalumno=$_GET['aid'];
$requeridos=$_GET['req'];
//numero de alumno q participaran en un proyecto
$total=$_GET['num'];
$fechasol = date("d-m-Y");

$query_alumno="select a.carnet as carnet,a.nombreAlumno||' '||a.apellidosalumno as alumno from alumno as a where a.idalumno='$idalumno'";
$query_proyecto="SELECT pp.nomproyecto as nomproyecto, pp.nominstitucion as nominstitucion
FROM proyecto p, propuesta_proyecto pp, se_convierte sc
WHERE p.idproyecto=sc.idproyecto AND sc.idpropuesta=pp.idpropuesta AND p.idproyecto=$idproyecto";

$consulta_alumno= pg_query($query_alumno) or die ("<SPAN CLASS='error'>Fallo en consulta de alumno!!</SPAN>".pg_last_error());
$res_alumno=pg_fetch_array($consulta_alumno);

$consulta_proyecto= pg_query($query_proyecto) or die ("<SPAN CLASS='error'>Fallo en consulta de proyecto!!</SPAN>".pg_last_error());
$res_proyecto=pg_fetch_array($consulta_proyecto);

if($requeridos<=$total){
	echo "<script languaje='javascript'> 
		alert('$requeridos<=$total');
		window.location = '../paginas/Inicio/plantilla_pagina.php';
	  </script>";
}

if(isset($_REQUEST['Aceptar'])){  
	$fecha=date('Y-m-d');
	//comm no se utiliza??
	$comm="Proyecto asigando por JEFE UPS - ".$_POST['comentario'];
	$query_solicitud="SELECT * FROM sp_mantto_solicitudproyecto(1,$idalumno,$idproyecto,'$fecha','$comm','A'); ";
	$query_insert2 = pg_query($query_solicitud) or die ("<SPAN CLASS='error'>Fallo en consulta de solicitud de proyecto!!</SPAN>".pg_last_error());
	$respuesta2 = pg_fetch_array($query_insert2);
	
	$query_asignacion="Select * FROM sp_mantto_alumnoproyecto(1,$idalumno,$idproyecto,0,'P',0);";
	$query_insert = pg_query($query_asignacion) or die ("<SPAN CLASS='error'>Fallo en consulta de asignacion de proyecto!!</SPAN>".pg_last_error());
	$respuesta = pg_fetch_array($query_insert);
	if(pg_query("UPDATE proyecto SET estadoProyecto='A' WHERE idProyecto=$idproyecto")){
	$row = $respuesta[0];	
	}else $row ="No se pudo completar la asignacion.";
	echo "<script languaje='javascript'> 
		alert('$row');
		window.location = '../paginas/Inicio/plantilla_pagina.php';
	  </script>";
}   
else{                      
	if(isset($_REQUEST['Cancelar'])){
		echo "<script languaje='javascript'> 
		alert('Acci\u00F3n cancelada');
		window.location = '../paginas/Inicio/plantilla_pagina.php';
	  </script>";
	}
	else {?>
		<script type="text/javascript" 	 src="../js/funciones.js"></script>
		<center><h2>Confirme asignaci&oacute;n de Proyecto</h2></center>
		<br>
		<form method="post" action="" accept-charset="LATIN1" >
		<center>
		<table width="50%"  class="marco">
			<tr>
				<td  height="35">Proyecto: </td><td><b><?php echo $res_proyecto['nomproyecto']?> </b></td>
			</tr>
			<tr>
				<td  height="35">Instituci&oacute;n: </td><td><b><?php echo $res_proyecto['nominstitucion']?></b></td>
			</tr>
			<tr>
				<td  height="35">Alumno: </td><td><b><?php echo $res_alumno['alumno'] ?></b></td>
			</tr>
			<tr>
				<td  height="35">Carnet: </td><td><b><?php echo $res_alumno['carnet'] ?></b></td>
			</tr>
			<tr>
				<td  height="35">Fecha de Solicitud: </td><td><b><?php echo $fechasol; ?> </b></td>
			</tr>
			<tr>
				<td  height="35">Comentario: </td><td><input type='text' name='comentario' id='comentario' size='50' maxlength='100'></td>
			</tr>
               </table>
		<br>
		<input type="submit" name="Aceptar" class="buton" value="Aceptar">
		<input type="submit" name="Cancelar" class="buton" value="Cancelar">
		</center>
		</form>	
	<?php
	}
}

include "../librerias/pie.php";
?>