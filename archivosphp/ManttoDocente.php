<?php
session_start();
include "../librerias/abrir_conexion.php";
$_SESSION['datos_form'] = $_POST; // Guardar datos del form en caso de error
$operacion=$_GET['operacion'];


if ($operacion==1){

$idDocente=0;
$usuarioDocente=$_POST['usuario'];
$claveDocente=$_POST['contraseniad2'];
$idescuela=$_POST['escuela'];
$nombreDocente=$_POST['nombred'];
$emailDocente=$_POST['emaild'];
$telefonoDocente=$_POST['telefonod'];
$estadoDocente='A';
}

if ($operacion==2){
    
if(isset($_POST['escuela']))$escuela = $_POST['escuela']; //para regresar dato en modificaCuenta
$idDocente=$_GET['id'];

/* Verificar si un docente actualment ejerce de tutor, de ser asi no se puede dar de baja */
if(isset($_POST['verifica'])){
 $numtutoria=$_POST['verifica'];
 if ($numtutoria>0){
 //muestra pagina de fondo mientras esta activo el cuadro de dialogo
  include "plantilla_fondo.php"; 
  exit( '<script>alert("Error. Docente asignado actualmente");
 document.location.href= "../paginas/Docente/frmConsultarDocente.php"</script>');}
}
    
    
/* Cambia o no la clave */
$clavedoc=  pg_fetch_array(pg_query("select clavedocente from docente where iddocente=".$idDocente)); 
if ($_POST['clave2']==$clavedoc[0])
 $claveDocente=$clavedoc[0]; // no la cambio
else
 $claveDocente =  md5 ($_POST['clave2']); // La cambio, hay q encriptar!
/* ** */    
$usuarioDocente=$_POST['usuario'];
$idescuela=$_GET['idescuela'];
$nombreDocente=$_POST['nombred'];
$emailDocente=$_POST['emaild'];
$telefonoDocente=$_POST['telefonod'];
$estadoDocente=$_POST['estadod'];
}

if ($operacion==3){
$idDocente=$_GET['id'];
$usuarioDocente=null;
$claveDocente=null;
$idescuela=0;
$nombreDocente=null;
$emailDocente=null;
$telefonoDocente=null;
$estadoDocente=null;
}

$instruccion_usuario ="select sp_mantto_docente(
                                                '$operacion',
                                                '$idDocente',
                                                '$idescuela',											
                                                '$usuarioDocente',
                                                '$claveDocente',
                                                '$nombreDocente',
                                                '$telefonoDocente',
                                                '$emailDocente',
                                                '$estadoDocente');";



$resultado_docente= pg_query($instruccion_usuario) or die ("<SPAN CLASS='error'>Fallo en consulta de usuario(docente)!!</SPAN>".pg_last_error());
$respuesta=  pg_fetch_array($resultado_docente);
$row=$respuesta[0];


if ($operacion==1 OR $operacion==2){
// Verificar si el procedimiento registra errores o no
if ($row=='Registro agregado satisfactoriamente.' OR $row=='Datos Actualizados.'){
 unset($_SESSION['datos_form']);   
 $url='../paginas/Inicio/plantilla_pagina.php';
}
else if ($row=='El Nombre de Usuario: '.$usuarioDocente.' ya existe')
   {
   $_SESSION['datos_form']['usuario']="";
   $url='../paginas/Cuenta/frmModificaCuenta.php';  
   }
   else if ($row=='El Nombre de Docente: '.$nombreDocente.' ya existe'){
   $_SESSION['datos_form']['nombred']="";    
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
        window.location = '../paginas/Docente/frmIngresarDocente.php';
        </script>";}
else if($operacion==2){
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
        window.location = '../paginas/Docente/frmConsultarDocente.php';
        </script>";   
}
include "../librerias/cerrar_conexion.php";
?>
