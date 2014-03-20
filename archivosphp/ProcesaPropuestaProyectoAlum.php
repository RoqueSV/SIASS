<?php

include "../librerias/abrir_conexion.php";
$operacion=$_GET['operacion'];

//recibimos todos los campos del formulario
	$idpropuesta=$_POST['idpropuesta'];
	if($_POST['idinstitucion'])
	$idinstitucion=$_POST['idinstitucion'];
	else
	$idinstitucion='null';
	// $idcarrera=$_POST['idcarrera'];
	$nominstitucion=$_POST['nominstitucion'];
	$nomproyecto=$_POST['nomproyecto'];
	$descripcionpropuesta=$_POST['descripcionpropuesta'];
	$estudiantesrequeridos=$_POST['estudiantesrequeridos'];
	$duracionestimada=$_POST['duracionestimada'];
	$nomcontacto=$_POST['nomcontacto'];
	$correocontacto=$_POST['correocontacto'];
	$estadoprop=$_POST['estadoprop'];
	$comentarioprop=$_POST['comentarioprop'];

	//sacamos la cantidad de estudiantes a los que se les asignara este proyecto
	$instrucc="SELECT idAlumno FROM hace where idpropuesta='$idpropuesta'";
	$res_hace=pg_query($instrucc) OR die ("<SPAN CLASS='error'>Fallo en consulta de cantidad de estudiantes a asignar!!</SPAN>".pg_last_error());
	$cant=pg_num_rows($res_hace);
	
	//caso en que una propuesta es Aceptada
if($estadoprop=="A"){
//insertamos un registro en proyecto.. correspondiente a la propuesta que ha sido ingresada
if($cant<$estudiantesrequeridos)
$instruccion="select mensaje, id from sp_mantto_proyecto(1,0,'D')";
else
$instruccion="select mensaje, id from sp_mantto_proyecto(1,0,'A')";
$resultado= pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta de se_convierte!!</SPAN>".pg_last_error());
$respuesta=  pg_fetch_array($resultado);
$idproyecto=$respuesta['id']; //idproyecto generado en la insercion del registro en Proyecto

//insertamos el registro en la tabla se_convierte, que asocia a la propuesta con el registro ingresado en Proyecto
$instruccion="select sp_mantto_seconvierte(1,$idpropuesta,$idproyecto)";
$resultado= pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta de se_convierte!!</SPAN>".pg_last_error());

//Actualizamos el estado de la Propuesta_Proyecto a D (disponible).
//se envian todos los datos actualizables que contiene la tabla, ya que el SP los requiere
$instruccion="select * from sp_mantto_propuesta(
$operacion, 
$idpropuesta,
$idinstitucion, 
'$nominstitucion', 
'$nomproyecto', 
'$descripcionpropuesta', 
$estudiantesrequeridos, 
$duracionestimada, 
'$nomcontacto', 
'$correocontacto',
'$estadoprop',
'$comentarioprop')";


$resultado= pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta de sp_mantto_prop D!!</SPAN>".pg_last_error());
$respuesta=  pg_fetch_array($resultado);
$row="Propuesta aceptada exitosamente";

//Se asigna el proyecto al estudiante que hizo la propuesta y al equipo si es que hay en la tabla Alumno_proyecto

	while($idA=pg_fetch_array($res_hace)){
		$idalumno=$idA[0];
		$instrucc_sp="Select * from sp_mantto_alumnoproyecto(1,'$idalumno','$idproyecto,0,'P','')";
		// echo $instrucc_sp;
		////////////////
		$respuesta2=pg_query($instrucc_sp);
	}
}

//Caso en que una propuesta es Rechazada.
if($estadoprop=="R"){
$instruccion="select * from sp_mantto_propuesta(
$operacion, 
$idpropuesta,
$idinstitucion, 
'$nominstitucion', 
'$nomproyecto', 
'$descripcionpropuesta', 
$estudiantesrequeridos, 
$duracionestimada, 
'$nomcontacto', 
'$correocontacto',
'$estadoprop',
'$comentarioprop')";
// echo $instruccion;
$resultado= pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta de sp_mantto_prop R!!</SPAN>".pg_last_error());
$respuesta=  pg_fetch_array($resultado);
$row="Propuesta rechazada exitosamente";
}

 //muestra pagina de fondo mientras esta activo el cuadro de dialogo
 include "plantilla_fondo.php";
        

 echo "  <script language='JavaScript'>
         alert('$row');
         window.location = '../paginas/Inicio/plantilla_pagina.php';
         </script>";

include "../librerias/cerrar_conexion.php";
?>