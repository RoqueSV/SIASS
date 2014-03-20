<?php
//Archivo para hacer la insercion o eliminacion de una propuesta por un Alumno
include "../librerias/abrir_conexion.php";
$operacion=$_GET['operacion'];
$idAlumno=$_GET['id'];
$error=0;
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
	$comentarioprop=null;
	$cadena_equipo=$_POST['equipo'];
	$datos_equipo=explode(",",$cadena_equipo);
	$total_equipo=sizeof($datos_equipo);
	$totalestudiantes_prop=0;
	IF(isset($_POST['estadoprop'])){//Si la propuesta es por parte del jefe queda abierta a esa pposiblidada(reutilizar codigo)
	$estadoprop=$_POST['estadoprop'];}
	ELSE{
	$estadoprop="P";}
	$carnets="";
	if($cadena_equipo<>"") $totalestudiantes_prop=$total_equipo+1;
	else $totalestudiantes_prop=$estudiantesrequeridos;
	//Validaciones antes de ingresar algo
	if($duracionestimada>18){
				echo "    
				<script language='JavaScript'>
				alert('La duraci\u00F3n de un proyecto no puede sobrepasar 18 meses');
				window.location = '../paginas/Proyecto/frmEnviarPropuesta.php';
				</script>";
				$error=1;
	}
	if($estudiantesrequeridos>10){
				echo "    
				<script language='JavaScript'>
				alert('La cantidad de estudiantes reuqeridos sobrepasa el l\u00EDmite 10');
				window.location = '../paginas/Proyecto/frmEnviarPropuesta.php';
				</script>";
				$error=1;
	}
	if($estudiantesrequeridos<$totalestudiantes_prop){
		echo "    
        <script language='JavaScript'>
        alert('El total de integrantes del equipo no puede sobrepasar a los estudiantes requeridos del proyecto');
        window.location = '../paginas/Proyecto/frmEnviarPropuesta.php';
        </script>";
		$error=1;
	}
	//validaciones para el equipo
	if($estudiantesrequeridos>1 AND $_POST['equipo']<>' '){
		//validamos que sean carnets validos
		$i=0;
		while($datos_equipo[$i]){
			$carnet=$datos_equipo[$i];
			//validamos cada carnet y si no lo encuentra en T. Alumno no hay insercion de propuesta de proyecto
			$query_valida="SELECT idalumno,idcarrera from alumno where carnet='$carnet'";
			$res_query_valida=pg_query($query_valida) or die ("<SPAN CLASS='error'>Fallo en consulta consulta valida carnets!!</SPAN>".pg_last_error());
			$res=pg_num_rows($res_query_valida);
			$res_valores=pg_fetch_array($res_query_valida);
			if($res<>1){
				echo "    
				<script language='JavaScript'>
				alert('Corrobore los carnet de los alumnos que forman el equipo ( $carnet )');
				window.location = '../paginas/Proyecto/frmEnviarPropuesta.php';
				</script>";
				$error=1;
			}
			$i++;
			
		//validamos que los alumnos pertenezcan a la carrera de la propuesta
		if($carrera<>'*'){
			// echo "idcarrera: ".$res_valores[1];
			$query_carrera_alumno="SELECT nombrecarrera from carrera where idcarrera=$res_valores[1]";
			// echo $query_carrera_alumno;
			$res_query_ca=pg_query($query_carrera_alumno) or die ("<SPAN CLASS='error'>Fallo en consulta valida carreras!!</SPAN>".pg_last_error());
				$row=pg_fetch_array($res_query_ca);
				if($row[0]<>$carrera){
					echo "    
					<script language='JavaScript'>
					alert('Hay un alumno que no corresponde a la carrera seleccionada para el proyecto ( $carnet )');
					window.location = '../paginas/Proyecto/frmEnviarPropuesta.php';
					</script>";
					$error=1;
				}
		}
		//validamos que los alumnos no tengan proyecto asignado o haya hecho una propuesta o que hayan aplicado a un proyecto
		$query_verifica1="SELECT idAlumno FROM hace h INNER JOIN propuesta_proyecto pp ON h.idPropuesta=pp.idPropuesta WHERE idAlumno=$res_valores[0] AND estadoProp='P'";
		$query_verifica2="SELECT idAlumno FROM alumno_proyecto WHERE idAlumno=$res_valores[0] AND (estadoAlumnoProyecto='P' OR estadoAlumnoProyecto='L')";
		$query_verifica3="SELECT idAlumno FROM solicitud_proyecto WHERE idAlumno=$res_valores[0] AND estado='P'";
		$res1=pg_query($query_verifica1) or die ("<SPAN CLASS='error'>Fallo en consulta valida1!!</SPAN>".pg_last_error());
		$res2=pg_query($query_verifica2) or die ("<SPAN CLASS='error'>Fallo en consulta valida2!!</SPAN>".pg_last_error());
		$res3=pg_query($query_verifica3) or die ("<SPAN CLASS='error'>Fallo en consulta valida3!!</SPAN>".pg_last_error());
		
			if((pg_num_rows($res1)>0)OR(pg_num_rows($res2)>0) OR (pg_num_rows($res3)>0)){
				echo "    
						<script language='JavaScript'>
						alert('Hay un alumno( $carnet ) del equipo que está participando en procesos de proyecto(ya sea en proyecto o propuesta)');
						window.location = '../paginas/Proyecto/frmEnviarPropuesta.php';
						</script>";
						$error=1;
			}
	}
}
if($error<>1){
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
	
	//insertamos el registro en la tabla hace, que asocia a la propuesta con el registro ingresado del alumno que la hizo
	$instruccion="select sp_mantto_hace(1,$idpropuesta,$idAlumno)";
	$resultado= pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta tabla HSace!!</SPAN>".pg_last_error());
	$respuesta=  pg_fetch_array($resultado);
	$row1=$respuesta[0];
	//revisa si se requieren mas alumnos y si se ingreso un grupo de trabajo
	if($estudiantesrequeridos>1 AND $_POST['equipo']<>' '){
		$i=0;
		while($datos_equipo[$i]){
			$carnet=$datos_equipo[$i];
			$consulta_idalumno="SELECT idalumno FROM Alumno WHERE carnet='$carnet'";
			$query_idalumno=pg_query($consulta_idalumno) or die ("<SPAN CLASS='error'>Fallo en consulta sacar idAlumno!!</SPAN>".pg_last_error());
			// echo "/Consulta:";
			// echo $consulta_idalumno;
			$respuesta=pg_fetch_row($query_idalumno);
			$idAlumno=$respuesta[0];
			// echo "/id:";
			// echo $idAlumno;
			$instruccion="select sp_mantto_hace(1,$idpropuesta,$idAlumno)";
			$resultado= pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta tabla HSace!!</SPAN>".pg_last_error());
			$respuesta= pg_fetch_array($resultado);
			$carnets=$carnets.",".$datos_equipo[$i];
			$row1=$respuesta[0];
			$i++;
		}
	}
	
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
}

}//Fin insercion de nueva propuesta Alumno

else{
//$idpropuesta=$_POST['idpropuesta'];
// $idinstitucion=$_POST['idinstitucion'];
if(($_POST['institucion'])==""){
	$datoinst=$_POST["institucion"];
	$datos=explode("-",$datoinst);
	$idinstitucion=$datos[0];
	$nominstitucion=$datos[1];
}
else{
	$idinstitucion=0;
	$nominstitucion=$_POST['institucion2'];
}
// echo $idinstitucion;
// echo $nominstitucion;

$nomProyecto=$_POST['nomProyecto'];
$descripcionpropuesta=$_POST['descripcion'];
$estudiantesrequeridos=$_POST['estRequeridos'];
$duracionestimada=$_POST['duracion'];
$nomcontacto=$_POST['contacto'];
$correocontacto=$_POST['correo'];
IF(isset($_POST['estadoprop'])){
$estadoprop=$_POST['estadoprop'];}
ELSE{
$estadoprop="P";}
$comentarioprop=$_POST['comentario'];

//aqui emquede 23-01 //Bueno y vos que desvergue estas haciendo aqui? .l. en todo andas va! xD
//caso en que una
if($estadoprop=="A"){
//insertamos un registro en proyecto.. correspondiente a la propuesta que ha sido ingresada
$instruccion="select mensaje, id from sp_mantto_proyecto(1,0,'D')";
$resultado= pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta de se_convierte!!</SPAN>".pg_last_error());
$respuesta=  pg_fetch_array($resultado);
$idproyecto=$respuesta['id']; //idproyecto generado en la insercion del registro en Proyecto

//insertamos el registro en la tabla se_convierte, que asocia a la propuesta con el registro ingresado en Proyecto
$instruccion="select sp_mantto_seconvierte(1,$idpropuesta,$idproyecto)";
$resultado= pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta de se_convierte!!</SPAN>".pg_last_error());

//Actualizamos el estado de la Propuesta_Proyecto a D (disponible).
//se envian todos los datos actualizables que contiene la tabla, ya que el SP los requiere
$instruccion="select sp_mantto_propuesta(
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

$resultado= pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta de se_convierte!!</SPAN>".pg_last_error());
$respuesta=  pg_fetch_array($resultado);
$row=$respuesta[0];

}

//Caso en que una propuesta es Rechazada.
if($estadoprop=="R"){
$instruccion="select sp_mantto_propuesta(
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

$resultado= pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta de se_convierte!!</SPAN>".pg_last_error());
$respuesta=  pg_fetch_array($resultado);
$row=$respuesta[0];
}
}
 //muestra pagina de fondo mientras esta activo el cuadro de dialogo
 include "plantilla_fondo.php";
 // if($total_equipo>0) $row=$row.", registrada ademas a para estos estudiantes".$carnets;
// $mensaje=$row." ".$row1." ".$row2;
$mensaje=$row;
echo "    
        <script language='JavaScript'>
        alert('$mensaje');
        window.location = '../paginas/Inicio/plantilla_pagina.php';
        </script>";

include "../librerias/cerrar_conexion.php";
?>