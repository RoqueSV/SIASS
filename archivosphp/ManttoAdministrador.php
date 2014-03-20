<?php
session_start();
include "../librerias/abrir_conexion.php";
$_SESSION['datos_form'] = $_POST; // Guardar datos del form en caso de error
$operacion=$_GET['operacion'];



if ($operacion==1){

$idadministrador=0;
$usuario=$_POST['usuario'];
$clave=$_POST['clave2'];
$cargo=$_POST['cargo'];
$nombreadmin=$_POST['nombre'];
$emailadmin=$_POST['email'];
$telefonoadmin=$_POST['telefono'];
$rol=0;}

if ($operacion==2){
$idadministrador=$_GET['id'];
$usuario=$_POST['usuario'];
$clave=$_POST['clave2'];
$cargo=$_POST['cargo'];
$nombreadmin=$_POST['nombre'];
$emailadmin=$_POST['email'];
$telefonoadmin=$_POST['telefono'];
$rol=0; 
}

if ($operacion==3){
$idadministrador=$_GET['id'];
$usuario=null;
$clave=null;
$cargo=null;
$nombreadmin=null;
$emailadmin=null;
$telefonoadmin=null;
$rol=0;    
}

$instruccion_usuario ="select sp_mantto_administrador(
                                                '$operacion',
                                                '$idadministrador',
                                                '$usuario',
                                                '$clave',
                                                '$cargo',
                                                '$nombreadmin',
                                                '$emailadmin',
                                                '$telefonoadmin',
                                                '$rol');";


$resultado_usuario= pg_query($instruccion_usuario) or die ("<SPAN CLASS='error'>Fallo en consulta de usuario!!</SPAN>".pg_last_error());
$respuesta=  pg_fetch_array($resultado_usuario);
$row=$respuesta[0];

if ($operacion==1 OR $operacion==2){
// Verificar si el procedimiento registra errores o no
if ($row=='Usuario agregado satisfactoriamente' OR $row=='Datos actualizados'){
 unset($_SESSION['datos_form']);   
 $url='../paginas/Inicio/plantilla_pagina.php';
}
else if ($row=='Error. El correo ingresado ya fue registrado')
   // Si hay error, regresar id del usuario sobre el q se estan haciendo las modificaciones. Esto en caso de q el
   // admin pueda modificar datos de otros usuarios (coordinadores)
   {
   $_SESSION['datos_form']['email']="";
   $url='../paginas/Cuenta/frmModificaCuenta.php';  
   }
   else if ($row=='Error. Ya existe el nombre de usuario: '.$usuario){
   $_SESSION['datos_form']['usuario']="";    
   $url='../paginas/Cuenta/frmModificaCuenta.php';
   }
   
}
 //muestra pagina de fondo mientras esta activo el cuadro de dialogo
 include "plantilla_fondo.php";
   
// Mostrar mensajes con JS
if($operacion==1){
echo "    
        <script language='JavaScript'>
        alert('$row');
        window.location = '../paginas/Administrador/frmIngresarAdministrador.php';
        </script>";}
        
else if ($operacion==2){
    
echo "    
        <script language='JavaScript'>
        alert('$row');
        window.location = '$url';
        </script>";
}
else {
    echo "    
        <script language='JavaScript'>
        alert('$row');
        window.location = '../paginas/Administrador/frmConsultarAdministrador.php';
        </script>";
}
include "../librerias/cerrar_conexion.php";
?>
