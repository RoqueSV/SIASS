<?php
include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";

/* Estados Revisiones :
   1: Aprobo Tutor
   2: Aprobo Coordinador
   3: Genero jefe
 */
$alumno=pg_fetch_array(pg_query("select nombrealumno|| ' ' || apellidosalumno  Nombre, carnet, nombrecarrera from alumno a join carrera c on a.idcarrera=c.idcarrera where a.idalumno=".$_SESSION['IDUSER'].";"));
$horas=  pg_fetch_array(pg_query("select sum(horas) from alumno_proyecto where idalumno=".$_SESSION['IDUSER'].";"));
$horasreq = pg_fetch_array(pg_query("select horasrequeridas from carrera natural join alumno where idalumno=".$_SESSION['IDUSER'].";"));
$proyecto=pg_query("select p.idproyecto, nomproyecto, revision, sum(horas) horas from carrera c
join alumno a on (c.idcarrera=a.idcarrera)
join alumno_proyecto ap on (a.idalumno=ap.idalumno) 
join proyecto p on (ap.idproyecto=p.idproyecto) 
join se_convierte sc on (p.idproyecto=sc.idproyecto) 
join propuesta_proyecto pp on (sc.idpropuesta=pp.idpropuesta) where a.idalumno=".$_SESSION['IDUSER']." 
AND estadoalumnoproyecto='F' 
group by p.idproyecto,nomproyecto,revision,horasrequeridas
having (sum(horas)>0 and sum(horas)<horasrequeridas) order by 1;");
?>
<style>.tinytable{width: 80%;}</style>

<h2 align="center">EMISION DE CONSTANCIAS PARCIALES</h2>
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
if(($horas[0]<$horasreq[0]) and pg_num_rows($proyecto)>0)
{
?>

<table border='0' class='tinytable' align="center" cellpadding="0" cellspacing="0">
<thead class="titulo1">
<tr>
<th width="35%"><h3>Proyecto</h3></th>
<th width="15%"><h3>Horas</h3></th>
<th width="20%"><h3>Estado</h3></th>
</tr>
</thead>
<?php 
while($row=pg_fetch_array($proyecto)){

$idproyecto = $row['idproyecto'];
echo "
<tr>
<td><a href='frmVerDetalleSolicitud.php?id=$idproyecto' title='Ver proyecto'>".$row['nomproyecto']."</a></td>
<td>".$row['horas']."</td>
<td>";
if($row['revision']== 3)
echo "Generada";
if($row['revision']<>3)
echo "No generada";
echo "</td></tr>";
}
?>
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
