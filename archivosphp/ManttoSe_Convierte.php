<?php
include "../librerias/abrir_conexion.php";


$operacion=$_GET['operacion'];

if ($operacion==1){
$idpropuesta=$_GET['idpropuesta'];
$idproyecto=$_GET['idproyecto'];
}

if ($operacion==2){
$idpropuesta=$_GET['idpropuesta'];
$idproyecto=$_GET['idproyecto'];
}

if ($operacion==3){
$idpropuesta=$_GET['idpropuesta'];
$idproyecto=$_GET['idproyecto'];
}

$instruccion ="select sp_mantto_seconvierte('$operacion',$idpropuesta,$idproyecto);";

$resultado= pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta de se_convierte!!</SPAN>".pg_last_error());

$respuesta=  pg_fetch_array($resultado);
$row=$respuesta[0];

 //muestra pagina de fondo mientras esta activo el cuadro de dialogo
 include "plantilla_fondo.php";
        
if($operacion==1){
echo "    
        <script language='JavaScript'>
        alert('$row');
        window.location = '../paginas/institucion/frmConsultarPropuestas.php';
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