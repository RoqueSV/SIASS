<?php

include "../librerias/abrir_conexion.php";

$operacion=$_GET['operacion'];

if ($operacion==1){
$idEscuela=0;
$nombreEscuela=$_POST['nombre'];
}

if ($operacion==2){
$idEscuela=$_GET['id'];
$nombreEscuela=$_POST['nombre'];
}

if ($operacion==3){
$idEscuela=$_GET['id'];
$nombreEscuela=null;
}

$instruccion_usuario ="select sp_mantto_escuela(
                                                '$operacion',
                                                '$idEscuela',
                                                '$nombreEscuela');";


$resultado_usuario= pg_query($instruccion_usuario) or die ("<SPAN CLASS='error'>Fallo en consulta de mantto de Escuela!!</SPAN>".pg_last_error());
$respuesta=  pg_fetch_array($resultado_usuario);
$row=$respuesta[0];

 //muestra pagina de fondo mientras esta activo el cuadro de dialogo
 include "plantilla_fondo.php";
if ($operacion==1){
  echo "    
        <script language='JavaScript'>
        alert('$row');
        window.location = '../paginas/Escuela/frmConsultarEscuela.php';
        </script>";  
}    
else {
echo "    
        <script language='JavaScript'>
        alert('$row');
        window.location = '../paginas/Inicio/plantilla_pagina.php';
        </script>";}
include "../librerias/cerrar_conexion.php";
?>