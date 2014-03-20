<?PHP
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
//consulta 1.0
/*
$query="select nomproyecto, nominstitucion, carnet, emailalumno email, 
nombrealumno||' '||apellidosalumno nombrealumno, nombredocente
from propuesta_proyecto pp join se_convierte sc on pp.idpropuesta=sc.idpropuesta
join proyecto p on sc.idproyecto=p.idproyecto 
join alumno_proyecto ap on p.idproyecto=ap.idproyecto
join alumno a on ap.idalumno=a.idalumno 
join tutoria t on p.idproyecto=t.idproyecto 
join docente d on t.iddocente=d.iddocente 
where p.idproyecto=".$_GET['idp'].";"; */
//echo $query;

//Consulta 2.0 // da deschongue :S
//verificar que consulta devuelve solo los alumnos de un mismo tutor
$query="select nomproyecto, nominstitucion, carnet, emailalumno email, 
nombrealumno||' '||apellidosalumno nombrealumno, nombredocente, iniciotutoria, fintutoria, estadoalumnoproyecto
from propuesta_proyecto pp 
join se_convierte sc on pp.idpropuesta=sc.idpropuesta 
join proyecto p on sc.idproyecto=p.idproyecto 
join tutoria t on p.idproyecto=t.idproyecto 
join docente d on t.iddocente=d.iddocente 
join tutoria_alumno ta on ta.idtutoria=t.idtutoria
join alumno a on a.idalumno=ta.idalumno
join alumno_proyecto ap on (ap.idalumno=a.idalumno and ap.idproyecto=p.idproyecto)
where p.idproyecto=".$_GET['idp']." and t.idtutoria=".$_GET['idt'].";";
$resul=pg_query($query);
?>
<style>.tinytable{width: 95%;}</style>
<h2 align="center">DETALLES DE PROYECTO</h2>

<table border="0" class="tinytable" align="center">
<tr><thead>
<th width='45%'><h3>PROYECTO</h3></th><th width='25%'><h3>INSTITUCI&Oacute;N</h3><th width='30%'><h3>TUTOR</h3></th>
</thead></tr>
<?php
$integrantes="";
while($row=pg_fetch_array($resul))
{
$info="<tr><td>".$row['nomproyecto']."</td><td> ".$row['nominstitucion']."</td><td>".$row['nombredocente']."</td><tr>";
$integrantes.="<tr><td>".$row['carnet']."</td><td>".$row['nombrealumno']."</td><td><a href='mailto:".$row['email']."'>".$row['email']."</a></td><td>";
if($row['estadoalumnoproyecto']=="P") 
$integrantes.= "En Proceso"; 

if($row['estadoalumnoproyecto']=="F") 
$integrantes.= "Finalizado"; 

if($row['estadoalumnoproyecto']=="L") 
$integrantes.= "Detenido"; 

if($row['estadoalumnoproyecto']=="B") 
$integrantes.= "de Baja";
 
$integrantes.="</td><td>".$row['iniciotutoria']."</td><td>".$row['fintutoria']."</td></tr>";
}//while
echo $info;
?>
<tr><td colspan='3'>
<table align="center" width="100%" border="0" >
<tr><td colspan="6" align="center"><b>ESTUDIANTES ASIGNADOS</b></td></tr>
<tr><td width="10%"><b>CARNET</b></td><td width="35%"><b>NOMBRE</b></td><td width="25%"><b>CORREO</b></td><td width="10%"><b>ESTADO</b></td><td width="10%"><b>F. INICIO</b></td><td width="10%"><b>F. FIN</b></td></tr>
<?php
echo $integrantes;
?>
</table>
</td></tr>
</table>
<br>
<br>

<!-- enviar id de alumno-->
<center>
<input type="button" value="Regresar" onclick="document.location.href='frmVerHistorialProyectos.php?idalum=1'" class="buton">
</center>
<!-- <a href="frmVerHistorialProyectos.php">Regresar</a> -->

<?php
include "../../librerias/pie.php";
include "../../librerias/cerrar_conexion.php";
?>