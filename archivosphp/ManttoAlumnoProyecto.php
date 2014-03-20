<?php

/* Mantenimiento para la tabla Alumno - Proyecto */
/* Descripcion :  
 * Operacion 1: Ingreso de registro en alumno-proyecto
 * Operacion 2: Actualizar alumno-proyecto, actualizar fintutoria en tutoria-alumno, comprobar si todas las tutorias
 * para el proyecto han sido finalizadas, de ser asi, actualizar estadoproyecto en Proyecto.
 * autor: Roquet
 */

session_start();
include "../librerias/abrir_conexion.php";


$operacion=$_GET['operacion'];

if ($operacion == 1){
$idalumno=$_GET['id'];
$idproyecto=$_POST['idproyecto'];
$horas=$_POST['horas'];
$estadoAlumnoProyecto=$_POST['estado'];   
$revision=0;
}

if ($operacion == 2){
$idalumno=$_GET['id'];
$idproyecto=$_POST['idproyecto'];
$horas=$_POST['horas'];
$estadoAlumnoProyecto=$_POST['estado'];   

/* Actualizar fechafin en TutoriaAlumno*/
 if (($_POST['estado']=='F' OR $_POST['estado']=='B') and $_SESSION['TYPEUSER']==4){ // Finalizado por tutor
     
  // Verificar si se han asignado horas  
  if ($horas==0 AND $_POST['estado']=='F'){
  include "plantilla_fondo.php";
  
  exit('<script>alert("Error. \xa1El alumno no tiene horas asignadas!");
  document.location.href= "../paginas/Docente/frmDetalleAlumno.php?id='.$idalumno.'"</script>');   
  } // fin verificar horas
  
  $revision=1; //Aprueba tutor.
  $idTutoria=$_POST['idtutoria'];
  $iniciotutoria=$_POST['inicio'];
  $fintutoria=  date('Y-m-d');   
  
  $instruccion_alumnotutoria ="select sp_mantto_tutoriaalumno(
                                                '$operacion',
                                                '$idalumno',
                                                '$idTutoria',
                                                '$iniciotutoria',
                                                '$fintutoria'
                                                  );";

 pg_query($instruccion_alumnotutoria) or die ("<SPAN CLASS='error'>Fallo en consulta de alumno_tutoria!!</SPAN>".pg_last_error());
 
 } // Fin estado=F
 else {
     if ($_SESSION['TYPEUSER']==2)
         $revision=2; // Aprobo coordinador
      else $revision=0; // Si estado no es finalizado
 }
} // Fin operacion=2

if ($operacion==3){
$idalumno=$_GET['id'];
$idproyecto=$_POST['idproyecto'];
$horas=$_POST['horas'];
$estadoAlumnoProyecto=$_POST['estado'];  
$revision=0;
}


$instruccion_alumno ="select sp_mantto_alumnoproyecto(
                                                '$operacion',
                                                '$idalumno',
                                                '$idproyecto',
                                                '$horas',
                                                '$estadoAlumnoProyecto',
                                                '$revision'
                                                  );";

$resultado_alumno= pg_query($instruccion_alumno) or die ("<SPAN CLASS='error'>Fallo en consulta de alumno_proyecto!!</SPAN>".pg_last_error());
$respuesta=  pg_fetch_array($resultado_alumno);
$row=$respuesta[0];

/*Verificar si el proyecto ya se dio del todo por finalizado - Actualizar estado en Proyecto*/
$cantAlumnos=  pg_fetch_array(pg_query("select count(idalumno) from alumno_proyecto where idproyecto=$idproyecto;"));
$cantFinalizados= pg_fetch_array(pg_query("select count(idalumno) from alumno_proyecto where idproyecto=$idproyecto and (estadoalumnoproyecto<>'P' AND estadoalumnoproyecto<>'L');"));

$cantDetenidos= pg_fetch_array(pg_query("select count(idalumno) from alumno_proyecto where idproyecto=$idproyecto and (estadoalumnoproyecto='L');"));


if ($cantAlumnos[0]==$cantFinalizados[0]){ // si se han finalizado todas las tutorias

$instruccion_proyecto ="select * from sp_mantto_proyecto('$operacion','$idproyecto','F');"; //Finalizar proyecto
pg_query($instruccion_proyecto) or die ("<SPAN CLASS='error'>Fallo en consulta de proyecto!!</SPAN>".pg_last_error());  
}

else if ($cantDetenidos[0]>0){ // Hay estadoalumnoproyecto en detenido
    if ($cantDetenidos[0]+$cantFinalizados[0]==$cantAlumnos[0]){ // Solo hay finalizados y detenidos
    $instruccion_proyecto ="select * from sp_mantto_proyecto('$operacion','$idproyecto','L');"; //Proyecto Detenido
    pg_query($instruccion_proyecto) or die ("<SPAN CLASS='error'>Fallo en consulta de proyecto!!</SPAN>".pg_last_error());  
    }
    
}
else{ // Poner el proyecto en proceso
    $instruccion_proyecto ="select * from sp_mantto_proyecto('$operacion','$idproyecto','P');"; //Proyecto Detenido
    pg_query($instruccion_proyecto) or die ("<SPAN CLASS='error'>Fallo en consulta de proyecto!!</SPAN>".pg_last_error());  
    }


 //muestra pagina de fondo mientras esta activo el cuadro de dialogo


include "plantilla_fondo.php";
        
if ($operacion==1){
echo "    
        <script language='JavaScript'>
        alert('$row');
        window.location = '../paginas/Inicio/plantilla_pagina.php';
        </script>";
}

if (($operacion==2 AND $_SESSION['TYPEUSER']==4) OR $operacion ==3){ //Actualizar o eliminar
echo "    
        <script language='JavaScript'>
        alert('$row');
        window.location = '../paginas/Docente/frmVerAlumnosTutoria.php';
        </script>";
}
if (($operacion==2 AND $_SESSION['TYPEUSER']==2)){ //Actualizar por coordinador
echo "    
        <script language='JavaScript'>
        alert('$row');
        window.location = '../paginas/Inicio/plantilla_pagina.php';
        </script>";
}
include "../librerias/cerrar_conexion.php";
?>
