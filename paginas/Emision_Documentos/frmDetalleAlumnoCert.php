<?php
include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";

/* Bloque seguridad */
if (!(isset($_SESSION['TYPEUSER']))) {
header("Location: ../../paginas/Inicio/frmAccesoDenegado.php");
exit(); 
}
else if (!($_SESSION['TYPEUSER']==1)) {
session_destroy();
header("Location: ../../paginas/Inicio/frmAcceso.php");
exit();    
}
 /* **********    */

$query="select nombrealumno||' '||apellidosalumno nomalumno, carnet, nomproyecto, nombredocente, iniciotutoria,fintutoria,estadoalumnoproyecto,
horas, revision
from alumno a
join alumno_proyecto ap on a.idalumno=ap.idalumno
join proyecto p on ap.idproyecto=p.idproyecto
join se_convierte sc on p.idproyecto=sc.idproyecto
join propuesta_proyecto pp on sc.idpropuesta=pp.idpropuesta
join tutoria t on p.idproyecto=t.idproyecto
join docente d on t.iddocente=d.iddocente
join tutoria_alumno ta on (t.idtutoria=ta.idtutoria and ta.idalumno=a.idalumno)
where a.idalumno=".$_GET['id'].";";
$resul = pg_query($query) or die ("<SPAN CLASS='error'>Fallo en consulta!!</SPAN>".pg_last_error());
$row = pg_fetch_array($resul);
$nombrealumno=$row['nomalumno'];
$carnet=$row['carnet'];

?>

<style>.tinytable{width: 80%;}</style>
<h2 align="center">DETALLES DE ALUMNO</h2>

	<table class="tinytable" align="center">
	<thead><tr><th colspan="2"><h3>INFORMACION</h3></tr></thead>
		<?php
		echo"
		<tr><td width='70%'><b>NOMBRE:</b></td><td width=''30%><b>CARNET</b></td></tr>
		<tr><td>".$nombrealumno."</td><td>".$carnet."</td></tr>
		</table>";
		
		echo "<table class='tinytable' align='center'>
		<tr><td width='35%'><b>Proyecto</b></td width='25%'><td><b>Tutor</b></td><td width='10%'><b>Inicio</b></td><td width='10%'><b>Fin</b></td><td width='10%'><b>Horas</b></td><td width='10%'><b>Estado</b></td></tr>
		";
		pg_result_seek($resul,0);
		while($row=pg_fetch_array($resul)){
		echo "<tr><td>".$row['nomproyecto']."</td><td>".$row['nombredocente']."</td><td>".$row['iniciotutoria']."</td><td>".$row['fintutoria']."</td><td>".$row['horas']."</td><td>";
		
		if($row['revision']<=0||$row['revision']>3)
		echo "Error. Tutor no aprob&oacute;";
				
		if($row['revision']==1)
		echo "Aprob&oacute; Tutor";
				
		if($row['revision']==2)
		echo "Aprob&oacute; Tutor y Coordinador";
		
		if($row['revision']==3)
		echo "Doc. ya Generado";
		
		echo"</td></tr>";
		}
		
		
		?>	
		</table>
        <br/>
        <center>
        <input type="button" class="buton" name="inicio" value="Inicio"  style="width: 150px" onclick="document.location.href='../Inicio/plantilla_pagina.php'"/>
		<input type="button" class="buton" name="inicio" value="Regresar"  style="width: 150px" onclick="document.location.href='frmEmisionDocAlumnosCert.php'"/>
		<input type="button" class="buton" name="inicio" value="Generar Certificaci&oacute;n"  style="width: 150px" onclick="document.location.href='certificacionSS.php?ida=<?php echo $_GET['id']?>'"/>
        </center>



<?php
include "../../librerias/pie.php";
include "../../librerias/cerrar_conexion.php";
?>