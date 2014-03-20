<?php
session_start();
include "../librerias/abrir_conexion.php";
$_SESSION['datos_form'] = $_POST; // Guardar datos del form en caso de error
$operacion=$_GET['operacion'];

/*
EstadoInstitucion: A(alta) P(pendiente) B(baja)

*/
if ($operacion==1){

$idInstitucion=0;
$nombreinstitucion=$_POST['nombreinstitucion'];
$rubro=$_POST['rubro'];
$nombrecontacto=$_POST['nombrecontacto'];
$cargocontacto=$_POST['cargocontacto'];
$emailcontacto=$_POST['usuario'];
$telefonoContacto=$_POST['telefonocontacto'];
$claveInstitucion=$_POST['clave2'];
$estadoInstitucion='P';
}

if ($operacion==2){
$idInstitucion=$_POST['idinstitucion'];

/* Cambia o no la clave */
$claveins=  pg_fetch_array(pg_query("select claveinstitucion from institucion where idinstitucion=".$idInstitucion)); 

if ($_POST['clave2']==$claveins[0])
 $claveInstitucion=$claveins[0]; // no la cambio
else
 $claveInstitucion =  md5 ($_POST['clave2']); // La cambio, hay q encriptar!
/* ** */   

$nombreinstitucion=$_POST['nombreinstitucion'];
$rubro=$_POST['rubro'];
$nombrecontacto=$_POST['nombrecontacto'];
$cargocontacto=$_POST['cargocontacto'];
$emailcontacto=$_POST['usuario'];
$telefonoContacto=$_POST['telefonocontacto'];
$estadoInstitucion=$_POST['estadoinstitucion'];
}

if ($operacion==3){
$idInstitucion=$_GET['id'];
$nombreinstitucion=null;
$rubro=null;
$nombrecontacto=null;
$cargocontacto=null;
$emailcontacto=null;
$telefonoContacto=null;
$claveInstitucion=null;
$estadoInstitucion=null;
}

$instruccion_usuario ="select sp_mantto_institucion(
                                                '$operacion',
                                                '$idInstitucion',
                                                '$nombreinstitucion',											
                                                '$rubro',
                                                '$nombrecontacto',
                                                '$cargocontacto',
                                                '$telefonoContacto',
                                                '$emailcontacto',
						'$claveInstitucion',
						'$estadoInstitucion');";




$resultado_usuario= pg_query($instruccion_usuario) or die ("<SPAN CLASS='error'>Fallo en consulta de usuario(institucion)!!</SPAN>".pg_last_error());
$respuesta=  pg_fetch_array($resultado_usuario);
$row=$respuesta[0]; 


if ($operacion==1 OR $operacion==2){
// Verificar si el procedimiento registra errores o no
if ($row=='Institucion agregada exitosamente.' OR $row=='Operacion realizada exitosamente.'){
 unset($_SESSION['datos_form']);   
 $url='../paginas/Inicio/plantilla_pagina.php';
}
else if ($row=='El email de contacto de Institucion: '.$emailcontacto.' ya existe')
   {
   $_SESSION['datos_form']['usuario']="";
   $url='../paginas/Cuenta/frmModificaCuenta.php';  
   }
   else if ($row=='El nombre de Institucion: '.$nombreinstitucion.' ya existe'){
   $_SESSION['datos_form']['nombreinstitucion']="";    
   $url='../paginas/Cuenta/frmModificaCuenta.php';  
   }
}

 //muestra pagina de fondo mientras esta activo el cuadro de dialogo
include "plantilla_fondo.php";       
if($operacion==1){
echo "    
        <script language='JavaScript'>
        alert('$row');
        window.location = '../paginas/Institucion/frmIngresarInstitucion.php';
        </script>";}
if($operacion==2||$operacion==3){
      echo "    
        <script language='JavaScript'>
        alert('$row');
        window.location = '$url';
        </script>";
}     
include "../librerias/cerrar_conexion.php";
?>
