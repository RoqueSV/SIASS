<?php
include "../librerias/abrir_conexion.php";

$query="select idproyecto,horas from alumno_proyecto where idalumno=".$_GET['id'].";";
$resul = pg_query($query) or die ("<SPAN CLASS='error'>Fallo en consulta!!</SPAN>".pg_last_error());

$operacion = 2;
$idalumno=$_GET['id'];
$estadoAlumnoProyecto=$_POST['estado'];   
$revision=2;

while ($row =  pg_fetch_array($resul)){   
$idproyecto=$row['idproyecto'];    
$horas=$row['horas'];
$instruccion_alumno ="select sp_mantto_alumnoproyecto(
                                                '$operacion',
                                                '$idalumno',
                                                '$idproyecto',
                                                '$horas',
                                                '$estadoAlumnoProyecto',
                                                '$revision'
                                                  );";


$resultado_alumno= pg_query($instruccion_alumno) or die ("<SPAN CLASS='error'>Fallo en consulta de alumno_proyecto!!</SPAN>".pg_last_error());

}
$respuesta=  pg_fetch_array($resultado_alumno);
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
