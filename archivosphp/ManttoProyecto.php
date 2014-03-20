<?php

include "../librerias/abrir_conexion.php";

$operacion=$_GET['operacion'];


if ($operacion==1){

$idproyecto=0;
$idinstitucion=$_POST['institucion'];
$nombreproy=$_POST['nombrep'];
$estadoproy=$_POST['estado'];
}

if ($operacion==2){
$idproyecto=$_GET['idproy'];
$idinstitucion=$_GET['idins'];
$nombreproy=$_POST['nombrep'];
$estadoproy=$_POST['estado'];
}

if ($operacion==3){
$idproyecto=$_GET['idproy'];
$idinstitucion=$_GET['idins'];
$nombreproy=null;
$estadoproy=null;
}

$instruccion ="select * from sp_mantto_proyecto('$operacion','$idproyecto','$idinstitucion','$nombreproy','$estadoproy');";

$resultado= pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta de proyecto!!</SPAN>".pg_last_error());

$respuesta=  pg_fetch_array($resultado);
$row=$respuesta[0];

 //muestra pagina de fondo mientras esta activo el cuadro de dialogo
 include "plantilla_fondo.php";
        
if($operacion==1){
echo "    
        <script language='JavaScript'>
        alert('$row');
        window.location = '../paginas/Proyecto/frmIngresarProyecto.php';
        </script>";}
else{
echo "    
        <script language='JavaScript'>
        alert('$row');
        window.location = '../paginas/Inicio/plantilla_pagina.php';
        </script>";
}

include "../librerias/cerrar_conexion.php";
?>
