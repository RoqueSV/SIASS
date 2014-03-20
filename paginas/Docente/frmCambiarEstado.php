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

$datosalumno=pg_query("select carnet, nombrealumno|| ' ' || apellidosalumno  Nombre from alumno where idalumno=".$_GET['id'].";");
$alumno=  pg_fetch_array($datosalumno);
$proyecto="select p.idproyecto,ta.idtutoria, ta.iniciotutoria,ta.fintutoria,nomproyecto, nominstitucion, descripcionpropuesta, coalesce(horas,0) horas, duracionestimada, estadoalumnoproyecto 
from docente d
join tutoria t on (d.iddocente=t.iddocente)
join tutoria_alumno ta on (t.idtutoria=ta.idtutoria)
join alumno a on (ta.idalumno=a.idalumno)
join alumno_proyecto ap on (a.idalumno=ap.idalumno) 
join proyecto p on (ap.idproyecto=p.idproyecto) 
join se_convierte sc on (p.idproyecto=sc.idproyecto) 
join propuesta_proyecto pp on (sc.idpropuesta=pp.idpropuesta) where a.idalumno=".$_GET['id']." and d.iddocente = ".$_SESSION['IDUSER']." order by ap.idproyecto desc;";
$detalle_proyecto=  pg_fetch_array(pg_query($proyecto));
?>
<style>.tinytable{width: 50%;}</style>
<h2 align="center">CAMBIAR ESTADO DEL PROYECTO</h2>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center">
        <b>Carnet: </b><?php echo $alumno['carnet']; ?>
	&nbsp; &nbsp;
        <b>Alumno: </b><?php echo $alumno['nombre']; ?>
	</td> 
      </tr>
</table>
<br>
		<form method="post" <?php echo "action=\"../../archivosphp/ManttoAlumnoProyecto.php?id=".$_GET['id']."&operacion=2\""?> >
		<center>
		<table width="40%"  class="marco">
	        <tr>
                <td id='tdr'><b>ESTADO DEL PROYECTO:</b></td>
                <td id='tdl'>
                    <select name="estado" id="estado" class=":required :only_on_submit">
                      
                        <option value="P" <?php if($detalle_proyecto['estadoalumnoproyecto']=='P') echo 'selected="selected"';?>>En proceso</option>
                        <option value="F" <?php if($detalle_proyecto['estadoalumnoproyecto']=='F') echo 'selected="selected"';?>>Finalizado</option>
                        <option value="B" <?php if($detalle_proyecto['estadoalumnoproyecto']=='B') echo 'selected="selected"';?>>de Baja</option>
                        <option value="L" <?php if($detalle_proyecto['estadoalumnoproyecto']=='L') echo 'selected="selected"';?>>Detenido</option>
                        
                    </select>
                </td>
                </tr>
               </table>
               <input type="hidden" name="idproyecto" id="idproyecto" value="<?php echo $detalle_proyecto['idproyecto']?>" >
               <input type="hidden" name="idtutoria" id="idtutoria" value="<?php echo $detalle_proyecto['idtutoria']?>" >
               <input type="hidden" name="horas" id="horas" value="<?php echo $detalle_proyecto['horas']?>" >
               <input type="hidden" name="inicio" id="inicio" value="<?php echo $detalle_proyecto['iniciotutoria']?>" >

 		<br>
		<input type="submit" name="buton" class="buton" value="Guardar">
                <?php echo'<input type="button" class="buton" name="return" value="Cancelar" onclick="document.location.href=\'frmDetalleAlumno.php?id='.$_GET['id'].'\'"/>';?>
		</center>
		</form>

<?php
include "../../librerias/cerrar_conexion.php";
include "../../librerias/pie.php";
?>

