<?php //Mantto solicitud-proyecto  sp_mantto_solicitudproyecto

session_start();
include "../librerias/abrir_conexion.php";

$operacion=$_GET['operacion'];

if ($operacion == 1){
$fechasolicitud = date('Y-m-d');
$idalumno=$_SESSION['IDUSER'];   
$idproyecto=$_GET['id'];
$comentario=null;
$estado='P';   
}

if ($operacion==3){
$idalumno=$_SESSION['IDUSER'];   
$idproyecto=$_GET['idproy'];
$fechasolicitud='2000-01-01';
$comentario=null;
$estado='X';       
}

$instruccion_solicitud ="select sp_mantto_solicitudproyecto(
                                                '$operacion',
                                                '$idalumno',
                                                '$idproyecto',
                                                '$fechasolicitud',
                                                '$comentario',
                                                '$estado');";

$resultado_solicitud= pg_query($instruccion_solicitud) or die ("<SPAN CLASS='error'>Fallo en consulta de usuario!!</SPAN>".pg_last_error());
$respuesta=  pg_fetch_array($resultado_solicitud);
$row=$respuesta[0];
 //muestra pagina de fondo mientras esta activo el cuadro de dialogo


include "plantilla_fondo.php";
        

echo "    
        <script language='JavaScript'>
        alert('$row');
        window.location = '../paginas/Inicio/plantilla_pagina.php';
        </script>";

include "../librerias/cerrar_conexion.php";
?>