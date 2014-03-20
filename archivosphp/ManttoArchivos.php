<?php 

include "../librerias/abrir_conexion.php";

$operacion=$_GET['operacion'];

if ($operacion == 1){
include 'procArchivos.php'; // Aqui obtengo el valor para $ruta
$idarchivo = 0;
$nombre=$_POST['nombre'];    
}

if ($operacion == 2){
include 'procArchivos.php';
$idarchivo = $_GET['id'];
$nombre=$_POST['nombre'];   
}

if ($operacion==3){
$idarchivo = $_GET['id'];
$nombre=null;   
$ruta=$_GET['ruta'];    
unlink($ruta);
}

$instruccion_solicitud ="select sp_mantto_archivos(
                                                '$operacion',
                                                '$idarchivo',
                                                '$nombre',
                                                '$ruta');";

$resultado_archivos= pg_query($instruccion_solicitud) or die ("<SPAN CLASS='error'>Fallo en consulta de archivos!!</SPAN>".pg_last_error());
$respuesta=  pg_fetch_array($resultado_archivos);
$row=$respuesta[0];
 //muestra pagina de fondo mientras esta activo el cuadro de dialogo


include "plantilla_fondo.php";
        

if ($operacion==1){
echo "    
        <script language='JavaScript'>
        alert('$row');
        window.location = '../paginas/Descargas/frmNuevoDocumento.php';
        </script>";
}

if ($operacion==2 || $operacion==3){
echo "    
        <script language='JavaScript'>
        alert('$row');
        window.location = '../paginas/Descargas/frmConsultarDocumentos.php';
        </script>";
}

include "../librerias/cerrar_conexion.php";
?>