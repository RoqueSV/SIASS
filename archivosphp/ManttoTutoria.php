<?php
include "../librerias/abrir_conexion.php";

$operacion=$_GET['operacion'];

if ($operacion==1){
$idTutoria=0;
$idDocente=$_POST['tutor'];
$idProyecto=$_GET['id'];
}

if ($operacion==2){
$idTutoria=$_GET['id'];
$idDocente=$_POST['tutor'];
$idProyecto=$_GET['id'];
}

if ($operacion==3){
$idTutoria=$_GET['id'];
$idDocente=$_POST['tutor'];
$idProyecto=$_GET['id'];
}

$instruccion_tutoria ="select id from sp_mantto_tutoria(
                                                '$operacion',
                                                '$idTutoria',
                                                '$idDocente',
                                                '$idProyecto'                                               
                                                );";



$resultado_tutoria=pg_query($instruccion_tutoria) or die ("<SPAN CLASS='error'>Fallo en consulta de tutoria!!</SPAN>".pg_last_error());
$respuesta=  pg_fetch_array($resultado_tutoria);
$tutoria = $respuesta['id']; //id q acabo de insertar

//muestra pagina de fondo mientras esta activo el cuadro de dialogo
include "plantilla_fondo.php";

include "ManttoTutoria_Alumno.php"; // Llenar tabla tutoria_alumno, documento y actualizar proyecto (en tabla proyecto y alumno-proyecto)

?>

