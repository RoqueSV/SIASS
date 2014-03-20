<?php
include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";

/* Bloque seguridad */
if (!(isset($_SESSION['TYPEUSER']))) {
header("Location: ../../paginas/Inicio/frmAccesoDenegado.php");
exit(); 
}
else if (!($_SESSION['TYPEUSER']==4)) {
session_destroy();
header("Location: ../../paginas/Inicio/frmAcceso.php");
exit();    
}
 /* **********    */


$datosalumno=pg_query("select carnet,emailalumno, nombrealumno|| ' ' || apellidosalumno  Nombre from alumno where idalumno=".$_GET['id'].";");
$alumno=  pg_fetch_array($datosalumno);
$proyecto="select p.idproyecto, nomproyecto, nominstitucion, descripcionpropuesta, coalesce(horas,0) horas, duracionestimada, estadoAlumnoProyecto 
from docente d
join tutoria t on (d.iddocente=t.iddocente)
join tutoria_alumno ta on (t.idtutoria=ta.idtutoria)
join alumno a on (ta.idalumno=a.idalumno)
join alumno_proyecto ap on (a.idalumno=ap.idalumno) 
join proyecto p on (ap.idproyecto=p.idproyecto) 
join se_convierte sc on (p.idproyecto=sc.idproyecto) 
join propuesta_proyecto pp on (sc.idpropuesta=pp.idpropuesta) where a.idalumno=".$_GET['id']." and d.iddocente = ".$_SESSION['IDUSER']." order by ap.idproyecto desc;";
$detalle_proyecto=  pg_fetch_array(pg_query($proyecto));

$documentoM="select d.iddocumento from documento d join alumno_documento ad on (d.iddocumento=ad.iddocumento) where idalumno=".$_GET['id']." and idproyecto= ".$detalle_proyecto['idproyecto']." and tipodocumento='M';";
$memoria=  pg_fetch_array(pg_query($documentoM));
$documentoP="select d.iddocumento from documento d join alumno_documento ad on (d.iddocumento=ad.iddocumento) where idalumno=".$_GET['id']." and idproyecto= ".$detalle_proyecto['idproyecto']." and tipodocumento='P';";
$plan=  pg_fetch_array(pg_query($documentoP));

$estudiantesasignados= pg_query("SELECT a.idalumno,nombrealumno ||' '|| apellidosalumno nombre, carnet from
alumno_proyecto ap join alumno a on (ap.idalumno=a.idalumno)
join tutoria_alumno ta on (a.idalumno=ta.idalumno)
join tutoria t on (ta.idtutoria=t.idtutoria)
WHERE ap.idproyecto=".$detalle_proyecto['idproyecto']." and iddocente=".$_SESSION['IDUSER']);
?>

<style>.tinytable{width: 50%;}</style>
<h2 align="center">DETALLES DE PROYECTO</h2>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center">
        <b>Carnet: </b><?php echo $alumno['carnet']; ?>
	&nbsp; &nbsp;
        <b>Alumno: </b><a href="mailto:<?php echo $alumno['emailalumno']; ?>"><?php echo $alumno['nombre']; ?></a>
	</td> 
      </tr>
</table>
<br>
	<table class="tinytable" align="center">
	<thead><tr><th colspan="2"><h3>INFORMACION</h3></tr></thead>
		<?php
		echo"
		<tr>
                  <td id='tdr' width='40%'><b>NOMBRE:</b></td>
                  <td id='tdl'>".$detalle_proyecto['nomproyecto']."</td>
                </tr>
		<tr>
                  <td id='tdr'><b>INSTITUICION:</b></td>
                  <td id='tdl'>".$detalle_proyecto['nominstitucion']."</td>
                </tr>
		<tr>
                  <td id='tdr'><b>DESCRIPCION:</b></td>
                  <td id='tdl'>".$detalle_proyecto['descripcionpropuesta']."</td>
                </tr>
                <tr>
                  <td id='tdr'><b>DURACION ESTIMADA:</b></td>
                  <td id='tdl'>".$detalle_proyecto['duracionestimada']." meses</td>
                </tr>
                <tr>
                  <td id='tdr'><b>HORAS:</b></td>
                  <td id='tdl'>".$detalle_proyecto['horas']."</td>
                </tr>
                <tr>
                  <td id='tdr'><b>ESTUDIANTES ASIGNADOS:</b></td>
                  <td id='tdl'>";
                while($row=pg_fetch_array($estudiantesasignados))        
                echo "<a title='Ver alumno' style='color: ligthblue;' href='javascript:void(0)' onclick=\"parent.PRINCIPAL.location.href='frmDetalleAlumno.php?id=$row[0]'\">".$row['carnet']."</a>","&nbsp;&nbsp;&nbsp;";
                echo "</td>
                </tr>
		<tr>
                  <td id='tdr'><b>ESTADO PROYECTO:</b></td>
                  <td id='tdl'>";
                  if($detalle_proyecto['estadoalumnoproyecto']=='D')
                  echo "Disponible";
                  if($detalle_proyecto['estadoalumnoproyecto']=='C')
                  echo "Pendiente aprobaci&oacute;n"; 
                  if($detalle_proyecto['estadoalumnoproyecto']=='P')
                  echo "En proceso";
                  if($detalle_proyecto['estadoalumnoproyecto']=='F')
                  echo "Finalizado";
                  if($detalle_proyecto['estadoalumnoproyecto']=='L')
                  echo "Detenido";
                  if($detalle_proyecto['estadoalumnoproyecto']=='B')
                  echo "De baja";
                  echo "</td> </tr>";
                  if ($detalle_proyecto['estadoalumnoproyecto']<>'F')
                  {
		?>	
        <tr>
            <td colspan="2"> <?php echo '<input type="button" class="buton" name="return" value="Cambiar estado del proyecto" onclick="document.location.href=\'frmCambiarEstado.php?id='.$_GET['id'].'\'"/> '; ?></td>
        </tr> 
        <?php }?>
	</table>
        
        <br/>
        <center>
        <?php 
        echo '
        <input type="button" class="buton" name="memoria" value="Memoria de labores" onclick="document.location.href=\'../Alumno/frmVerActividadesAlumno.php?idalum='.$_GET['id'].'&iddoc='.$memoria[0].'\'"/>
        <input type="button" class="buton" name="plan" value="Plan de trabajo" onclick="document.location.href=\'../Alumno/frmVerActividadesAlumno.php?idalum='.$_GET['id'].'&iddoc='.$plan[0].'\'"/>
        <input type="button" class="buton" name="return" value="Regresar" onclick="document.location.href=\'frmVerAlumnosTutoria.php\'"/>   
        ';?>
        </center>

<?php      
include "../../librerias/cerrar_conexion.php";
include "../../librerias/pie.php";
?>

