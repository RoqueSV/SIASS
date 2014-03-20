<?php

include "../librerias/abrir_conexion.php";

$operacion=$_GET['operacion'];

if ($operacion==1){
$iddocumento=0;
//$idalumno=$_POST['idalumno'];
$idproyecto=$_POST['idproyecto'];
$idtutoria=$_POST['idtutoria'];
$nombredocumento=$_POST['nombred'];//nombredocumento o contenido del documento
$fechaactualizacion="current_date";// fecha actual del server postgres
$tipodoc=$_POST['tipodoc'];
}

if ($operacion==2){ //actualizar
$iddocumento=$_POST['iddocumento'];
//$idalumno=0;
$idproyecto=0;
$idtutoria=0;
$nombredocumento=$_POST['nombred'];//nombredocumento o contenido del documento
$fechaactualizacion="current_date";// fecha actual del server postgres
$tipodoc=null;
}

if ($operacion==3){
$iddocumento=$_POST['iddocumento'];
//$idalumno=null;
$idproyecto=null;
$idtutoria=null;
$nombredocumento=null;//nombredocumento o contenido del documento
$fechaactualizacion=null;
$tipodoc=null;
}

$instruccion ="select * from sp_mantto_documento($operacion,
										$iddocumento,
										$idproyecto,
										$idtutoria,
										'$nombredocumento',
										$fechaactualizacion,
										'$tipodoc'
										);";

//echo $instruccion;
$resultado= pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta de documento!!</SPAN>".pg_last_error());
$respuesta=  pg_fetch_array($resultado);
$row=$respuesta[0];

        //dudas obre a donde debe redirigir la pag...

 //muestra pagina de fondo mientras esta activo el cuadro de dialogo
 include "plantilla_fondo.php";
 
echo "    
        <script language='JavaScript'>
        alert('$row');
		window.location = '../paginas/Inicio/plantilla_pagina.php';
		</script>";



include "../librerias/cerrar_conexion.php";
?>
