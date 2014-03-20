<?php
//Archivo para hacer la insercion o eliminacion de una propuesta por una Institucion
include "../librerias/abrir_conexion.php";
$operacion=$_GET['operacion'];
// $idAlumno=$_GET['id'];
$idInstitucion=$_GET['id'];
If($operacion==1){//si se agregara un nuevo registro
	$nomProyecto=$_POST['nomProyecto'];
	$descripcionpropuesta=$_POST['descripcion'];
	$estudiantesrequeridos=$_POST['estRequeridos'];
	$carrera=$_POST['carrera'];
	$duracionestimada=$_POST['duracion'];
	// $comentarioprop=$_POST['comentario'];
	$comentarioprop="";
	$estadoprop="P";
	//Validaciones antes de ingresar algo
	if($duracionestimada>18)echo "    
				<script language='JavaScript'>
				alert('La duraci\u00F3n de un proyecto no puede sobrepasar 18 meses');
				window.location = '../paginas/Proyecto/frmEnviarPropuesta.php';
				</script>";
	if($estudiantesrequeridos>10)echo "    
				<script language='JavaScript'>
				alert('La cantidad de estudiantes reuqeridos sobrepasa el l\u00EDmite 10');
				window.location = '../paginas/Proyecto/frmEnviarPropuesta.php';
				</script>";
	//Bsucamos los datos(nombreInstitucion) de la institucion
	$instruccion = "SELECT nombreInstitucion,nombreContacto, emailContacto FROM institucion WHERE idInstitucion=$idInstitucion ";
	$consulta = pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en la consulta busquedaInstitucion!!</SPAN>".pg_last_error());
	$opciones = pg_fetch_array($consulta);
	$nominstitucion=$opciones[0];
	$nombrecontacto=$opciones[1];
	$emailcontacto=$opciones[2];
	//Insertamos los datos de la nueva propuesta
	$instruccion2="select * FROM sp_mantto_propuesta(
	$operacion,
	1,
	$idInstitucion,
	'$nominstitucion',
	'$nomProyecto',
	'$descripcionpropuesta',
	'$estudiantesrequeridos',
	'$duracionestimada',
	'$nombrecontacto',
	'$emailcontacto',
	'$estadoprop',
	'$comentarioprop')";
	// echo $instruccion2;
	$resultado= pg_query($instruccion2) or die ("<SPAN CLASS='error'>Fallo en consulta sp_mantto_propuesta2!!</SPAN>".pg_last_error());
	if($respuesta=  pg_fetch_array($resultado)){
		$row=$respuesta[0];
		$idpropuesta=$respuesta[1];
		
		//insertamos en la tabla carrera-propuesta
		// echo $carrera;
		if($carrera=='*'){
		
			$instruccion = "SELECT idcarrera FROM carrera ORDER BY 1";
			$consulta = pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en la consulta carrera!!</SPAN>".pg_last_error());
			while($opciones = pg_fetch_array($consulta)){	
				// echo $opciones[0];
				// echo $cidcarrera[0];
				$instruccion="select sp_mantto_propuesta_carrera(1,$opciones[0],$idpropuesta)";
				$resultado= pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta tabla Propuesta_carrera!!</SPAN>".pg_last_error());
				$respuesta=  pg_fetch_array($resultado);
				$row2=$respuesta[0];
			}
		}
		else{
			$instruccion="select sp_mantto_propuesta_carrera(1,$carrera,$idpropuesta)";
			$resultado= pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta tabla Propuesta_carrera!!</SPAN>".pg_last_error());
			$respuesta=  pg_fetch_array($resultado);
			$row2=$respuesta[0];
		}
		$mensaje=$row2;
		include "plantilla_fondo.php";
		echo "    
        <script language='JavaScript'>
        alert('$mensaje');
        window.location = '../paginas/Inicio/plantilla_pagina.php';
        </script>";
	}
	else{
		include "plantilla_fondo.php";
		echo "    
        <script language='JavaScript'>
        alert('Error al guardar la propuesta. Intente de nuevo o contacte al administrador');
        window.location = '../paginas/Inicio/plantilla_pagina.php';
        </script>";
	}
}//Fin insercion de nueva propuesta Alumno

 //muestra pagina de fondo mientras esta activo el cuadro de dialogo

// $row1=$row1.", asignado ademas a estos estudiantes".$carnets;


include "../librerias/cerrar_conexion.php";
?>