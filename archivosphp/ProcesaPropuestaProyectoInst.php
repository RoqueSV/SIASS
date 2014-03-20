<?php
/*
ESTE ARCHIVO PROCESA LAS PROPUESTAS DE PROYECTO QUE HAN REALIZADO LAS INSTITUCIONES
EL JEFE DE LA UNIDAD, TIENE LA OPCION DE APROBARLA O RECHAZARLA

** NO TOCAR QUE SE JODE ** 
*/
include "../librerias/abrir_conexion.php";
$operacion=$_GET['operacion'];

//recibimos todos los campos del formulario
	$idpropuesta=$_POST['idpropuesta'];
	$idinstitucion=$_POST['idinstitucion'];
	$nominstitucion=$_POST['nominstitucion'];
	$nomproyecto=$_POST['nomproyecto'];
	$descripcionpropuesta=$_POST['descripcionpropuesta'];
	$estudiantesrequeridos=$_POST['estudiantesrequeridos'];
	$duracionestimada=$_POST['duracionestimada'];
	$nomcontacto=$_POST['nomcontacto'];
	$correocontacto=$_POST['correocontacto'];
	$estadoprop=$_POST['estadoprop'];
	$comentarioprop=$_POST['comentarioprop'];

	
	//caso en que una propuesta es Aceptada
if($estadoprop=="A"){
//insertamos un registro en proyecto.. correspondiente a la propuesta que ha sido ingresada
$instruccion="select mensaje, id from sp_mantto_proyecto(1,0,'D')";
$resultado= pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta de se_convierte!!</SPAN>".pg_last_error());
$respuesta=  pg_fetch_array($resultado);
$idproyecto=$respuesta['id']; //idproyecto generado en la insercion del registro en Proyecto

//insertamos el registro en la tabla se_convierte, que asocia a la propuesta con el registro ingresado en Proyecto
$instruccion="select sp_mantto_seconvierte(1,$idpropuesta,$idproyecto)";
$resultado= pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta de se_convierte!!</SPAN>".pg_last_error());

//Actualizamos el estado de la Propuesta_Proyecto A (Aprobada).
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
$row=$respuesta[0];
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

$resultado= pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta de sp_mantto_prop R!!</SPAN>".pg_last_error());
$respuesta=  pg_fetch_array($resultado);
$row=$respuesta[0];
}

 //muestra pagina de fondo mientras esta activo el cuadro de dialogo
 include "plantilla_fondo.php";
        

 echo "  <script language='JavaScript'>
         alert('$row');
         window.location = '../paginas/Inicio/plantilla_pagina.php';
         </script>";

include "../librerias/cerrar_conexion.php";
?>