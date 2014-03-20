<?php
session_start();
include "../librerias/abrir_conexion.php";

  

$instruccion_insert = "INSERT INTO alumno (idalumno,idcarrera,carnet,nombrealumno,apellidosalumno,nivelacademico,porcentaje,direccionalumno,telefonoalumno,emailalumno,fechaapertura,fotografia) 
select (select (coalesce(max(idalumno),0)+1) from alumno),idcarreraaux,carnetaux,nombrealumnoaux,apellidosalumnoaux,nivelacademicoaux,porcentajeaux,direccionalumnoaux,telefonoalumnoaux,emailalumnoaux,current_date,fotografiaaux from alumno_aux
where carnetaux= '".$_SESSION['user']."';";

$instruccion_delete = "DELETE FROM alumno_aux where carnetaux='".$_SESSION['user']."';";

pg_query($instruccion_insert) or die ("<SPAN CLASS='error'>Fallo en consulta de alumno_aux_insertar!</SPAN>".pg_last_error());
pg_query($instruccion_delete) or die ("<SPAN CLASS='error'>Fallo en consulta de alumno_aux_eliminar!</SPAN>".pg_last_error());

//muestra pagina de fondo mientras esta activo el cuadro de dialogo
include "plantilla_fondo.php";
?>
    
        <script language='JavaScript'>
        alert('Apertura exitosa de expediente');
        parent.MENU.location.href ='../Interfaz/Menu.php';
        parent.PRINCIPAL.location.href ='../paginas/Inicio/plantilla_pagina.php';
      	</script>
<?php
include "../librerias/cerrar_conexion.php";
?>
