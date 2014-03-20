<?php
//Historial de proyectos presentado por Instituciones
include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";

/* Bloque seguridad */
if (!(isset($_SESSION['TYPEUSER']))) {
header("Location: ../../paginas/Inicio/frmAccesoDenegado.php");
exit(); 
}
else if (!($_SESSION['TYPEUSER']==5)) {
session_destroy();
header("Location: ../../paginas/Inicio/frmAcceso.php");
exit();    
}
 /* **********    */


$query="select nomproyecto, nominstitucion,descripcionpropuesta, estadoproyecto, nombredocente 
from propuesta_proyecto pp
join se_convierte sh on pp.idpropuesta=sh.idpropuesta
join proyecto p on sh.idproyecto=p.idproyecto
left join tutoria t on p.idproyecto=t.idproyecto
left join docente d on t.iddocente=d.iddocente
where p.idproyecto=".$_GET['id'].";";
$resul=pg_query($query);
$row = pg_fetch_array($resul)
?>

<style>.tinytable{width: 50%;}</style>
<h2 align="center">DETALLES DE PROYECTO</h2>

	<table class="tinytable" align="center">
	<thead><tr><th colspan="2"><h3>INFORMACION</h3></tr></thead>
		<?php
		echo"
		<tr>
                  <td id='tdr' width='40%'><b>NOMBRE:</b></td>
                  <td id='tdl'>".$row['nomproyecto']."</td>
                </tr>
		<tr>
                  <td id='tdr'><b>INSTITUICION:</b></td>
                  <td id='tdl'>".$row['nominstitucion']."</td>
                </tr>
		<tr>
                  <td id='tdr'><b>DESCRIPCION:</b></td>
                  <td id='tdl'>".$row['descripcionpropuesta']."</td>
                </tr>
                <tr>
                  <td id='tdr'><b>ESTADO PROYECTO:</b></td>
                  <td id='tdl'>";
                  if($row['estadoproyecto']=='D')
                  echo "Sin Asignar";
                  if($row['estadoproyecto']=='A')
                  echo "Asignado a Alumnos"; 
                  if($row['estadoproyecto']=='P')
                  echo "En proceso";
                  if($row['estadoproyecto']=='F')
                  echo "Finalizado";
                  if($row['estadoproyecto']=='L')
                  echo "Detenido";
                  if($row['estadoproyecto']=='B')
                  echo "De baja";
                  
                  echo"</td> </tr>
				  <tr>
                  <td id='tdr'><b>DOCENTE TUTOR:</b></td>
                  <td id='tdl'>";
				  if($row['nombredocente']==null)
				  echo "---";
				  else
				  echo $row['nombredocente'];
				  
				  echo"</td>
                </tr>";
		
		?>	
	</table>
        <br/>
        <center>
		<input type="button" class="buton" name="regresar" value="Regresar" onclick="document.location.href='frmHistorialProyectosInst.php'"/>
        <input type="button" class="buton" name="inicio" value="Inicio" onclick="document.location.href='../Inicio/plantilla_pagina.php'"/>
        </center>



<?php
include "../../librerias/pie.php";
include "../../librerias/cerrar_conexion.php";
?>