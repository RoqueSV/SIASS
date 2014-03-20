<?php
include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";
/* Estados solicitudes :
   P: Pendiente
   A: Aprobada 
   R: Rechazada
 */

/* Bloque seguridad */
if (!(isset($_SESSION['TYPEUSER']))) {
header("Location: ../../paginas/Inicio/frmAccesoDenegado.php");
exit(); 
}
else if (!($_SESSION['TYPEUSER']==6)) {
session_destroy();
header("Location: ../../paginas/Inicio/frmAcceso.php");
exit();    
}
 /* **********    */
$alumno=pg_fetch_array(pg_query("select nombrealumno|| ' ' || apellidosalumno  Nombre, carnet, nombrecarrera from alumno a join carrera c on a.idcarrera=c.idcarrera where a.idalumno=".$_SESSION['IDUSER'].";"));

$solicitud= pg_query("select sp.idproyecto, nomProyecto, fechaSolicitud, estado, sp.comentario from Solicitud_Proyecto sp join Proyecto p on (sp.idProyecto=p.idProyecto) join Se_Convierte sc on (p.idProyecto=sc.idProyecto) join Propuesta_proyecto pp on (sc.idPropuesta=pp.idPropuesta) where idAlumno = ".$_SESSION['IDUSER'].";");
global $estado;
global $idproyecto;
?>
<style>.tinytable{width: 80%;}</style>

<h2 align="center">REVISION DE SOLICITUDES</h2>
<br>
<table class="marco" align="center" width="80%">
<tr>
  <th align="center">Alumno</th>
  <th align="center">Carnet</th>
  <th align="center">Carrera</th>
</tr>
<tr>
  <td align="center"><?php echo $alumno['nombre'];?></td>
  <td align="center"><?php echo $alumno['carnet'];?></td>
  <td align="center"><?php echo $alumno['nombrecarrera'];?></td>
</tr>
</table>
<br>
<?php 
if(pg_num_rows($solicitud)>0)
{
?>
<table border='0' class='tinytable' align="center" cellpadding="0" cellspacing="0">
<thead class="titulo1">
<tr>
<th width="35%"><h3>Proyecto</h3></th>
<th width="15%"><h3>Fecha Solicitud</h3></th>
<th width="20%"><h3>Estado</h3></th>
<th width="20%"><h3>Comentario</h3></th>
</tr>
</thead>
<?php 
while($row=pg_fetch_array($solicitud)){
$estado = $row['estado'];
$idproyecto = $row['idproyecto'];
?>
<tr>
<td><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='frmVerDetalleSolicitud.php?pag=1&id=<?php echo $idproyecto; ?>'" title='Ver proyecto'><?php echo $row['nomproyecto']; ?></a></td>
<td><?php echo $row['fechasolicitud']; ?></td>
<td>
<?php
if($row['estado']=='P')
echo "Pendiente";
if($row['estado']=='R')
echo "Rechazada";
if($row['estado']=='A')
{
 $estadoproy=pg_fetch_array(pg_query("select estadoAlumnoProyecto from Alumno_Proyecto where idProyecto=".$row['idproyecto'].";")); 
 if ($estadoproy[0]=='P')
     echo "Aprobada (Proyecto en curso)";
 else if ($estadoproy[0]=='F')
     echo "Aprobada (Proyecto finalizado)";
 else if ($estadoproy[0]=='A')
     echo "Aprobada (Sin tutor asignado)";
 else if ($estadoproy[0]=='L')
     echo "Aprobada (Proyecto detenido)";
 else if ($estadoproy[0]=='B')
     echo "Aprobada (Proyecto dado de baja)";
 else echo "Aprobada";
}
echo "</td>";
echo "<td>$row[4]</td>";
}    

?>

</tr>
</table>
<br><br>
<?php 
}//fin if pg_num_rows
else{
?>
<h2 align="center" class="encabezado2"><img src="../../imagenes/exit.png"><br>NO EXISTEN SOLICITUDES DE APLICACION A PROYECTOS!!</h2>
<br>
<?php
}
if ($estado == 'P'){
echo '
<center>
<input type="button" value="Cancelar solicitud" onclick="document.location.href=\'../../archivosphp/ManttoSolicitud.php?operacion=3&idproy='.$idproyecto.'\'" class="buton">
<input type="button" value="Inicio" onclick="document.location.href=\'../Inicio/plantilla_pagina.php\'" class="buton">
</center>
';
}
else{
?>
<center><input type="button" value="Inicio" onclick="document.location.href='../Inicio/plantilla_pagina.php'" class="buton"></center>
<br>
<?php
}
include "../../librerias/pie.php";
include "../../librerias/cerrar_conexion.php";
?>
