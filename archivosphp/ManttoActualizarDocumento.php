<?php
include "../librerias/abrir_conexion.php";


//Datos del documento
$iddocumento=$_POST['iddocumento'];
$idProyecto=$_POST['idproyecto'];
$idtutoria=0;
$nombredocumento=$_POST['nombred'];//nombredocumento o contenido del documento
$fechaactualizacion="current_date";// fecha actual del server postgres
$tipodoc=null;

//Actualizar Documento
$instruccion ="select * from sp_mantto_documento(2,
                                                 $iddocumento,
                                                 $idProyecto,
                                                 $idtutoria,
                                                 '$nombredocumento',
                                                 $fechaactualizacion,
                                                 '$tipodoc'
                                                 );";


$resultado= pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta de documento!!</SPAN>".pg_last_error());
$respuesta=  pg_fetch_array($resultado);
$row=$respuesta[0];

if(isset($_POST['horas']) and $_POST['horas']<>'')
{
//Datos Alumno_Proyecto
$idAlumno=$_POST['idalumno'];
$horas=$_POST['horas'];
$estadoAlumnoProyecto='P';    
    
    
//Actualizar horas en Alumno_Proyecto
$instruccion ="select sp_mantto_alumnoproyecto(2,
                                               $idAlumno,
                                               $idProyecto,
                                               $horas,
                                               '$estadoAlumnoProyecto',
                                               0
                                               );";

pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta de alumno_proyecto!!</SPAN>".pg_last_error());
}
//muestra pagina de fondo mientras esta activo el cuadro de dialogo
include "plantilla_fondo.php";
 
echo "    
        <script language='JavaScript'>
        alert('$row');
        window.location = '../paginas/Inicio/plantilla_pagina.php';
	</script>";



include "../librerias/cerrar_conexion.php";
?>
