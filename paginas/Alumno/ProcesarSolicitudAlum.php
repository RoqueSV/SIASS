<?php
/*
Este archivo procesa las SOLICITUDES de proyecto que han realizado los alumnos
el jefe de la unidad, tiene la opcion de aprobarla o rechazarla
*/
include "../../librerias/abrir_conexion.php";
// $operacion=$_GET['operacion'];
$idalumno=$_GET['idalum'];
$idproyecto=$_GET['idproy'];
$accion=$_GET['acc'];
$comentario=$_GET['comm'];
if($accion=='1'){
	//tabla alumno_proyecto
	$instruccion2="Select * From sp_mantto_alumnoproyecto(1,$idalumno,$idproyecto,0,'P',0)";
	$instruccion="UPDATE solicitud_proyecto SET estado='A', comentario='$comentario' WHERE idAlumno=$idalumno AND idProyecto=$idproyecto";
	// $instruccion="Select sp_mantto_solicitudproyecto(2,'$idalumno','$idproyecto',,,'A')";
	$msg="Solicitud Aprobada";
	//actaulizar estado proyecto
	pg_query("UPDATE Proyecto SET estadoProyecto='A' WHERE idProyecto=$idproyecto") or die ("<SPAN CLASS='error'>Fallo en consulta de update ESTADO Proyecto!!</SPAN>".pg_last_error());
}
if($accion=='2'){
	$instruccion="UPDATE solicitud_proyecto SET estado='R', comentario='$comentario' WHERE idAlumno=$idalumno AND idProyecto=$idproyecto";
	// $instruccion="Select sp_mantto_solicitudproyecto(2,'$idalumno','$idproyecto',,,'R')";
	$msg="Solicitud Rechazada";
	$respuesta="";
}
pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta de update ESTADO SOLICITUD!!</SPAN>".pg_last_error());

if($accion=='1'){
$resultado= pg_query($instruccion2) or die ("<SPAN CLASS='error'>Fallo en consulta sp_mantto_propuesta2!!</SPAN>".pg_last_error());
$respuesta=  pg_fetch_array($resultado);
}

 //muestra pagina de fondo mientras esta activo el cuadro de dialogo
 include "plantilla_fondo.php";
echo "    
				<script language='JavaScript'>
				alert('$msg. $respuesta[0]');
				window.location = 'frmConsultarSolicitud.php';
				</script>";        

include "../librerias/cerrar_conexion.php";
?>