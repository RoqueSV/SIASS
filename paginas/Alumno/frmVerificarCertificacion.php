<?php
include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";

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
/* Estados Revisiones :
   1: Aprobo Tutor
   2: Aprobo Coordinador
   3: Genero jefe
 */
$alumno=pg_fetch_array(pg_query("select nombrealumno|| ' ' || apellidosalumno  Nombre, carnet, nombrecarrera from alumno a join carrera c on a.idcarrera=c.idcarrera where a.idalumno=".$_SESSION['IDUSER'].";"));
$horas=  pg_fetch_array(pg_query("select sum(horas) from alumno_proyecto where idalumno=".$_SESSION['IDUSER'].";"));
$horasreq = pg_fetch_array(pg_query("select horasrequeridas from carrera natural join alumno where idalumno=".$_SESSION['IDUSER'].";"));
$proyecto=pg_query("select p.idproyecto, nomproyecto, (select count(revision) from alumno_proyecto where idalumno=a.idalumno and revision=1) revision from alumno a 
join alumno_proyecto ap on (a.idalumno=ap.idalumno) 
join proyecto p on (ap.idproyecto=p.idproyecto) 
join se_convierte sc on (p.idproyecto=sc.idproyecto) 
join propuesta_proyecto pp on (sc.idpropuesta=pp.idpropuesta) where a.idalumno=".$_SESSION['IDUSER']." 
AND estadoalumnoproyecto='F' order by p.idproyecto;");
global $revision;
?>
<style>.tinytable{width: 80%;}</style>

<h2 align="center">EMISION DE CERTIFICACION FINAL</h2>
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
if(($horas[0]>=$horasreq[0]) and pg_num_rows($proyecto)>0)
{
$registros=  pg_num_rows($proyecto);
?>

<table border='0' class='tinytable' align="center" cellpadding="0" cellspacing="0">
<thead class="titulo1">
<tr>
<th width="35%"><h3>Proyecto (s)</h3></th>
<th width="15%"><h3>Horas</h3></th>
<th width="20%"><h3>Estado Certificacion</h3></th>
</tr>
</thead>
<tr><td>
<?php
while($row=pg_fetch_array($proyecto)){
$revision=$row['revision']; ?>
<p><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='frmVerDetalleSolicitud.php?pag=2&id=<?php echo $row[0];?>'" title='Ver proyecto'><?php echo $row['nomproyecto']; ?></a></p>
<?php
} ?>
</td><td><?php echo $horas[0]; ?></td>
<td>
<?php
if($revision == $registros)
echo "&iexcl;Lista!<br/>Ya puedes solicitarla en la unidad de proyeccion social";
if($revision <> $registros)
echo "En proceso";
?>
</td></tr>   
</table>
<br><br>
<?php 
}//fin if pg_num_rows
else{
?>
<h2 align="center" class="encabezado2"><img src="../../imagenes/exit.png"><br>NO EXISTEN PROYETOS.</h2>
<?php
}
?>
<center><input type="button" value="Inicio" onclick="document.location.href='../Inicio/plantilla_pagina.php'" class="buton"></center>
<?php
include "../../librerias/pie.php";
include "../../librerias/cerrar_conexion.php";
?>
