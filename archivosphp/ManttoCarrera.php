<?php
include "../librerias/abrir_conexion.php";

$operacion=$_GET['operacion'];


if ($operacion==1){
$idcarrera=0;
$idescuela=$_POST['escuela'];
$codcarrera=$_POST['codigoc'];
$nombrecarrera=$_POST['nombrec'];
$porcentajecarrera=$_POST['porcentajec'];
$plan=$_POST['plan'];
$horas=$_POST['horas'];
}

if ($operacion==2){
$idcarrera=$_GET['id'];
$idescuela=$_POST['escuela'];
$codcarrera=$_POST['codigoc'];
$nombrecarrera=$_POST['nombrec'];
$porcentajecarrera=$_POST['porcentajec'];
$plan=$_POST['plan'];
$horas=$_POST['horas'];
}

if ($operacion==3){
$idcarrera=$_GET['id'];
$idescuela=0;
$codcarrera=null;
$nombrecarrera=null;
$porcentajecarrera=0;
$plan=0;    
$horas=0;
}

$instruccion_usuario ="select sp_mantto_carrera(
                                                '$operacion',
                                                '$idcarrera',
                                                '$idescuela',
                                                '$codcarrera',
                                                '$nombrecarrera',
                                                '$porcentajecarrera',
                                                '$plan',
                                                '$horas');";



$resultado_usuario= pg_query($instruccion_usuario) or die ("<SPAN CLASS='error'>Fallo en consulta de usuario!!</SPAN>".pg_last_error());
$respuesta=  pg_fetch_array($resultado_usuario);
$row=$respuesta[0];

 //muestra pagina de fondo mientras esta activo el cuadro de dialogo
 include "plantilla_fondo.php";
        

echo "    
        <script language='JavaScript'>
        alert('$row');
        window.location = '../paginas/Carrera/frmConsultarCarrera.php';
        </script>";


include "../librerias/cerrar_conexion.php";
?>
