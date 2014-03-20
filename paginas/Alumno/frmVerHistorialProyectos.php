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

$datos=pg_fetch_array(pg_query("select nombrealumno|| ' ' || apellidosalumno  Nombre, carnet, nombrecarrera, nivelacademico nivel from alumno a join carrera c on a.idcarrera=c.idcarrera where a.idalumno=".$_SESSION['IDUSER'].";"));
/*
(select min(iniciotutoria) from tutoria_alumno ta2 join tutoria t2 on ta2.idtutoria=t2.idtutoria where t2.idproyecto=p.idproyecto) inicioproyecto, 
(select max(fintutoria) from tutoria_alumno ta2 join tutoria t2 on ta2.idtutoria=t2.idtutoria join proyecto p2 on t2.idproyecto=p2.idproyecto where t2.idproyecto=p.idproyecto and p2.estadoproyecto='F') finproyecto, 
*/
$query="select distinct p.idproyecto, a.idalumno, nombrealumno|| ' ' || apellidosalumno  Nombre, nomproyecto, nombredocente, estadoalumnoproyecto,
(select min(iniciotutoria) from tutoria_alumno ta2 join tutoria t2 on ta2.idtutoria=t2.idtutoria where t2.idproyecto=p.idproyecto) inicioproyecto, 
(select max(fintutoria) from tutoria_alumno ta2 join tutoria t2 on ta2.idtutoria=t2.idtutoria join proyecto p2 on t2.idproyecto=p2.idproyecto where t2.idproyecto=p.idproyecto and p2.estadoproyecto='F') finproyecto, 
coalesce(horas,0) horas, estadoproyecto, t.idtutoria 
from alumno a join alumno_proyecto ap on a.idalumno=ap.idalumno 
join proyecto p on ap.idproyecto=p.idproyecto 
join tutoria t on p.idproyecto=t.idproyecto
join docente d on t.iddocente=d.iddocente
join tutoria_alumno ta on (t.idtutoria=ta.idtutoria and ta.idalumno=a.idalumno)
join se_convierte sc on p.idproyecto=sc.idproyecto
join propuesta_proyecto pp on sc.idpropuesta=pp.idpropuesta
where a.idalumno=".$_SESSION['IDUSER'].";";
$resul=pg_query($query);
// echo $query;
?>
<style>.tinytable{width: 80%;}</style>


<h2 align="center">HISTORIAL DE PROYECTOS</h2>
<br>
<table class="marco" align="center" width="80%">
<tr><thead class="miestilo_lp"><th align="center">Alumno</th><th align="center">Carnet</th><th align="center">Carrera</th><th align="center">Nivel</th></thead></tr>
<tr><td align="center"><?php echo $datos['nombre'];?></td><td align="center"><?php echo $datos['carnet'];?></td><td align="center"><?php echo $datos['nombrecarrera'];?></td><td align="center"><?php echo $datos['nivel'];?></td></tr>
</table>
<br>
<?php 
if(pg_num_rows($resul)>0)
{
?>
<h3 align="center">Elija un proyecto, para ver sus detalles.</h3>
<table border='0' class='tinytable' align="center" cellpadding="0" cellspacing="0">
<tr>
<thead class="titulo1">
<th width="35%"><h3>Proyecto</h3></th>
<th width="25%"><h3>Tutor</h3></th>
<th width="10%"><h3>Inicio</h3></th>
<th width="10%"><h3>Finalizaci&oacute;n</h3></th>
<th width="10%"><h3>Horas</h3></th>
<th width="10%"><h3>Estado</h3></th>
</thead>
</tr>

<?php 
while($row=pg_fetch_array($resul)){
?>
<tr><td><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='frmVerDetalleProyecto.php?idp=<?php echo $row['idproyecto'];?>&idt=<?php echo $row['idtutoria'];?>'"> <?php echo $row['nomproyecto'];?></a></td><td><?php echo $row['nombredocente'];?></td><td><?php echo $row['inicioproyecto'];?></td><td>
<?php
if($row['finproyecto']!=null)
echo $row['finproyecto'];
else
echo "---";

echo"</td><td>".$row['horas']."</td><td>";

if($row['estadoproyecto']=="P") 
echo "En Proceso"; 

if($row['estadoproyecto']=="F") 
echo "Finalizado"; 

if($row['estadoproyecto']=="L") 
echo "Detenido"; 

if($row['estadoproyecto']=="B") 
echo "de Baja"; 

echo"</td></tr>";
}//fin while
?>

</table>
<br><br>
<?php 
}//fin if pg_num_rows
else{
?>
<h2 align="center" class="encabezado2"><img src="../../imagenes/exit.png"><br>NO POSEES HISTORIAL DE PROYECTOS!!</h2>
<br>
<?php

}
?>
<center><input type="button" value="Cancelar" onclick="document.location.href='../Inicio/plantilla_pagina.php'" class="buton"></center>
<br>
<?php
include "../../librerias/pie.php";
include "../../librerias/cerrar_conexion.php";
?>