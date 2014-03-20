<?php
// Descripcion: Se lleva a cabo el registro de alumnos en la tabla tutoria-alumno, ademas se crean los registros
// correspondientes en tabla documento y documento alumno. El estado del proyectob(en tabla proyecto
// y alumno_proyecto) se actualiza a P, lo que significa que el proyecto ya esta en proceso.
// autor: Roquet

$fechahoy = date('Y-m-d');

if ($operacion == 1) {
    $idAlumno =$_GET['idal'];
    $idTutoria = $tutoria;
    $InicioTutoria = $fechahoy;
    $FinTutoria = '2000-01-01';
}

if ($operacion == 2) {
    $idAlumno =$_GET['idal'];
    $idTutoria = $tutoria;
    $InicioTutoria = $fechahoy;
    $FinTutoria = null;
}

if ($operacion == 3) {
    $idAlumno =$_GET['id'];
    $idTutoria = $tutoria;
    $InicioTutoria = $fechahoy;
    $FinTutoria = null;
}

$instruccion_tutoriaalumno = "select sp_mantto_tutoriaalumno(
                                                '$operacion',
                                                '$idAlumno',
                                                '$idTutoria',
                                                '$InicioTutoria',
                                                '$FinTutoria'
                                                );";



$resultado_tutoria = pg_query($instruccion_tutoriaalumno) or die("<SPAN CLASS='error'>Fallo en consulta de tutoria!!</SPAN>" . pg_last_error());
$respuesta = pg_fetch_array($resultado_tutoria);
$row = $respuesta[0];


if ($operacion == 1) {
// ************************* Crear documentos ******************************
// 1. Memoria de Labores
 $instruccion_documento = "select * from sp_mantto_documento(
                                                '1',    
                                                '0',
                                                '$idProyecto',
                                                '$idTutoria',
                                                ' ',
                                                '$InicioTutoria',
                                                'M'
                                                );";
 $resultado1=pg_query($instruccion_documento) or die("<SPAN CLASS='error'>Fallo en consulta de documento!!</SPAN>" . pg_last_error());
 $documento=  pg_fetch_array($resultado1);
 // 2. Plan de trabajo
 $instruccion_documento2 = "select * from sp_mantto_documento(
                                                '1',    
                                                '0',
                                                '$idProyecto',
                                                '$idTutoria',
                                                ' ',
                                                '$InicioTutoria',
                                                'P'
                                                );";
 $resultado2=pg_query($instruccion_documento2) or die("<SPAN CLASS='error'>Fallo en consulta de documento!!</SPAN>" . pg_last_error());
 $documento2=  pg_fetch_array($resultado2);
 
 //Registro en Alumno-documento
 // Memoria
$instruccion_documento3 = "select sp_mantto_alumno_documento(
                          '1',
                          '$idAlumno',
                          '$documento[1]'
                           );";
 
 pg_query($instruccion_documento3) or die("<SPAN CLASS='error'>Fallo en consulta de documento_alumno!!</SPAN>" . pg_last_error());
 
 //Plan
$instruccion_documento4 = "select sp_mantto_alumno_documento(
                          '1',
                          '$idAlumno',
                          '$documento2[1]'
                           );";
 
 pg_query($instruccion_documento4) or die("<SPAN CLASS='error'>Fallo en consulta de documento_alumno!!</SPAN>" . pg_last_error());

// *********************** Fin crear docs ************************************
 
 
// Cambiar estado proyecto a P (Tabla Proyecto)
$instruccion_proyecto = "select * from sp_mantto_proyecto(
                                                '2',    
                                                '$idProyecto',
                                                'P'
                                                );";
 pg_query($instruccion_proyecto) or die("<SPAN CLASS='error'>Fallo en consulta de documento!!</SPAN>" . pg_last_error()); 
 
// Cambiar estado proyecto a P (Tabla Alumno-Proyecto)
$horas=  pg_fetch_array(pg_query("select horas from Alumno_Proyecto where idalumno=$idAlumno and idproyecto=$idProyecto"));
$instruccion_proyecto = "select sp_mantto_alumnoproyecto(
                                                '2',
                                                '$idAlumno',
                                                '$idProyecto',
                                                '$horas[0]',
                                                'P',
                                                '0'
                                                );";
 pg_query($instruccion_proyecto) or die("<SPAN CLASS='error'>Fallo en consulta de documento!!</SPAN>" . pg_last_error());  
 
}
if ($operacion == 1) {
    echo "    
        <script language='JavaScript'>
        alert('$row');
        window.location = '../paginas/Docente/frmProysinTutor.php';
        </script>";
} else {
    echo "    
        <script language='JavaScript'>
        alert('$row');
        window.location = '../paginas/Inicio/plantilla_pagina.php';
        </script>";
}

include "../librerias/cerrar_conexion.php";
?>
