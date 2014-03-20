<?php
//Archivo para hacer la insercion o eliminacion de una propuesta por un JEFE (APROBADA INMEDIATAMENTE)
include "../librerias/abrir_conexion.php";
$operacion=$_GET['operacion'];
// $idAlumno=$_GET['id'];
If($operacion==1){//si se agregara un nuevo registro
	if(($_POST['institucion'])!=""){//para el form nueva propuesta se podra elegir entre una institucion existente o nueva.
		$datoinst=$_POST["institucion"];
		$datos=explode("-",$datoinst);
		$idinstitucion=$datos[0];
		$nominstitucion=$datos[1];
	}
	else{
		$idinstitucion='NULL';
		$nominstitucion=$_POST['institucion2'];
	}
	$nomProyecto=$_POST['nomProyecto'];
	$descripcionpropuesta=$_POST['descripcion'];
	$estudiantesrequeridos=$_POST['estRequeridos'];
	$carrera=$_POST['carrera'];
	$duracionestimada=$_POST['duracion'];
	$nomcontacto=$_POST['contacto'];
	$correocontacto=$_POST['correo'];
	$comentarioprop=$_POST['comentario'];
	// $estadoi=$_POST['estadoi'];
	// IF(isset($_POST['estado'])){//estado del proyecto, definido por el jefe
	// $estado=$_POST['estado'];}
	// ELSE{
	// $estado="P";}
	//aprobamos la propuesta de inmediato
	$estadoprop="A";
	//Insertamos los datos de la nueva propuesta
	$instruccion2="select * FROM sp_mantto_propuesta(
	$operacion,
	1,
	 $idinstitucion,
	'$nominstitucion',
	'$nomProyecto',
	'$descripcionpropuesta',
	'$estudiantesrequeridos',
	'$duracionestimada',
	'$nomcontacto',
	'$correocontacto',
	'$estadoprop',
	'$comentarioprop')";
	// echo $instruccion2;
	$resultado= pg_query($instruccion2) or die ("<SPAN CLASS='error'>Fallo en consulta sp_mantto_propuesta2!!</SPAN>".pg_last_error());
	$respuesta=  pg_fetch_array($resultado);
	$row=$respuesta[0];
	$idpropuesta=$respuesta[1];
	
	//insertamos en tabla proyecto
	$instruccion3="select * FROM sp_mantto_proyecto(
	$operacion,
	1,
	'D')";
	// echo $instruccion3;
	$resultado= pg_query($instruccion3) or die ("<SPAN CLASS='error'>Fallo en consulta sp_mantto_proyecto!!</SPAN>".pg_last_error());
	$respuesta=  pg_fetch_array($resultado);
	$row3=$respuesta[0];
	$idproyecto=$respuesta[1];
	
	//insertamos el registro en la tabla Seconvierte, que asocia a la propuesta con un proyecto asociado
	$instruccion="select sp_mantto_seconvierte(1,$idpropuesta,$idproyecto)";
	$resultado= pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta tabla HSace!!</SPAN>".pg_last_error());
	$respuesta=  pg_fetch_array($resultado);
	$row1=$respuesta[0];
	
	//insertamos en la tabla carrera-propuesta
	// echo $carrera;
	if($carrera=='*'){
	
		$instruccion = "SELECT idcarrera FROM carrera ORDER BY 1";
		$consulta = pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en la consulta carrera!!</SPAN>".pg_last_error());
		while($opciones = pg_fetch_array($consulta)){	
		// echo "ENTRA";
		echo $opciones[0];
		// echo $cidcarrera[0];
		$instruccion="select sp_mantto_propuesta_carrera(1,$opciones[0],$idpropuesta)";
		$resultado= pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta tabla Propuesta_carrera!!</SPAN>".pg_last_error());
		$respuesta=  pg_fetch_array($resultado);
		$row2=$respuesta[0];
		}
	}
	else{
	// echo "No ENTRA";
		$instruccion="select sp_mantto_propuesta_carrera(1,$carrera,$idpropuesta)";
		$resultado= pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta tabla Propuesta_carrera!!</SPAN>".pg_last_error());
		$respuesta=  pg_fetch_array($resultado);
		$row2=$respuesta[0];
	}
}//Fin insercion de nueva propuesta Jefe

 //muestra pagina de fondo mientras esta activo el cuadro de dialogo
 include "plantilla_fondo.php";
//row para propuesta        
$mensaje=$row2;
echo "    
        <script language='JavaScript'>
        alert('$mensaje');
        window.location = '../paginas/Inicio/plantilla_pagina.php';
        </script>";

include "../librerias/cerrar_conexion.php";
?>