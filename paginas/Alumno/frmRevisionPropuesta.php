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

/* Estados propuestas :
   P: Pendiente
   A: Aprobada 
   R: Rechazada
 */
$alumno=pg_fetch_array(pg_query("select nombrealumno|| ' ' || apellidosalumno  Nombre, carnet, nombrecarrera from alumno a join carrera c on a.idcarrera=c.idcarrera where a.idalumno=".$_SESSION['IDUSER'].";"));
$solicitud= pg_query("select pp.idpropuesta, nomProyecto, nomInstitucion, estadoProp from Propuesta_Proyecto pp
join Hace h on (pp.idPropuesta=h.idPropuesta)
join Alumno a on (h.idalumno=a.idalumno)
where a.idAlumno = ".$_SESSION['IDUSER'].";");
global $idproyecto;
?>
<style>.tinytable{width: 80%;}</style>

<h2 align="center">REVISION DE PROPUESTAS REALIZADAS</h2>
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
<th width="15%"><h3>Instituci&oacute;n</h3></th>
<th width="20%"><h3>Estado</h3></th>
</tr>
</thead>
<?php 
while($row=pg_fetch_array($solicitud)){
$idproyecto = $row['idpropuesta'];
?>
<tr>
<td><a href="javascript:void(0)" onclick= "parent.PRINCIPAL.location.href='frmVerDetallePropuesta.php?id=<?php echo $idproyecto; ?>'" title='Ver proyecto'><?php echo $row['nomproyecto']; ?></a></td>
<td><?php echo $row['nominstitucion']; ?></td>
<td>
<?php
if($row['estadoprop']=='P')
echo "Pendiente";
if($row['estadoprop']=='R')
echo "Rechazada";
if($row['estadoprop']=='A')
{
 $estadoproy=pg_fetch_array(pg_query("select estadoAlumnoProyecto from propuesta_proyecto pp join se_convierte sc on pp.idpropuesta=sc.idpropuesta
 join proyecto p on sc.idproyecto=p.idproyecto join alumno_proyecto ap on p.idproyecto=ap.idproyecto where pp.idPropuesta=".$row['idpropuesta'].";")); 
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
}    
echo "</td></tr>";
?>
</table>
<br><br>
<?php 
}//fin if pg_num_rows
else{
?>
<h2 align="center" class="encabezado2"><img src="../../imagenes/exit.png"><br>NO SE HAN REALIZADO PROPUESTAS DE PROYECTOS!!</h2>
<br>
<?php
}
?>
<center><input type="button" value="Inicio" onclick="document.location.href='../Inicio/plantilla_pagina.php'" class="buton"></center>
<br>
<?php
include "../../librerias/pie.php";
include "../../librerias/cerrar_conexion.php";
?>

