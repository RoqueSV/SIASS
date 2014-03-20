<?php
include "../librerias/abrir_conexion.php";

$operacion=$_GET['operacion'];


if ($operacion==1){
include "procFotografia.php";
$idalumno=0;
$idcarrera=$_POST['carrera'];
$carnet=$_POST['carnet'];
$nombresalumno=$_POST['nombres'];
$apellidosalumno=$_POST['apellidos'];
$nivelacademico=$_POST['nivel'];
$porcentaje=$_POST['porcentaje'];
$direccionalumno=$_POST['direccion'];
$telefonoalumno=$_POST['telefono'];
$emailalumno=$_POST['email'];
$fechaapertura='2000-01-01';
}

if ($operacion==2){
include "procFotografia.php";
$idalumno=$_GET['id'];;
$idcarrera=$_GET['carrera'];
$carnet=$_GET['carnet_alumno'];
$nombresalumno=$_GET['nombres'];
$apellidosalumno=$_GET['apellidos'];
$nivelacademico=$_POST['nivel'];
$porcentaje=$_POST['porcentajecarrera'];
$direccionalumno=$_POST['direccion'];
$telefonoalumno=$_POST['telefonoalumno'];
$emailalumno=$_POST['emailalumno'];
$fechaapertura='2000-01-01';    
}

if($operacion==3){
$idalumno=$_GET['id'];;
$idcarrera=null;
$carnet=null;
$nombresalumno=null;
$apellidosalumno=null;
$nivelacademico=null;
$porcentaje=0;
$direccionalumno=null;
$telefonoalumno=0;
$emailalumno=null;
$fechaapertura=null;    
}

$instruccion_usuario ="select sp_mantto_alumno(
                                                '$operacion',
                                                '$idalumno',
                                                '$idcarrera',
                                                '$carnet',
                                                '$nombresalumno',
                                                '$apellidosalumno',
                                                '$nivelacademico',
                                                '$porcentaje',
                                                '$direccionalumno',
                                                '$telefonoalumno',
                                                '$emailalumno',
                                                '$fechaapertura',
                                                '$fotografia');";


$resultado_usuario= pg_query($instruccion_usuario) or die ("<SPAN CLASS='error'>Fallo en consulta de usuario!!</SPAN>".pg_last_error());
$respuesta=  pg_fetch_array($resultado_usuario);
$row=$respuesta[0];


 //muestra pagina de fondo mientras esta activo el cuadro de dialogo
 include "plantilla_fondo.php";
 
if($operacion==1){
echo "    
        <script language='JavaScript'>
        alert('$row');
        window.location = '../paginas/Inicio/plantilla_pagina.php';
        </script>";}
else{
echo "    
        <script language='JavaScript'>
        alert('$row');
        document.location.href = '../paginas/Alumno/frmVerExpediente.php';
        </script>";
}

include "../librerias/cerrar_conexion.php";

?>
