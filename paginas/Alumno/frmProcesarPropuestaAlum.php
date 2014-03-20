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
$idpro=$_GET['id'];
$row = pg_fetch_array(pg_query("select * from propuesta_proyecto where idpropuesta=".$idpro.";"));
?>

<style>.tinytable{width: 70%;}</style>
<h2 align="center">DETALLE DE PROPUESTA DE PROYECTO (ALUMNO)</h2>

<form method="post" action="../../archivosphp/ProcesaPropuestaProyectoAlum.php?operacion=2">
<input type="hidden" name="idpropuesta" id="idpropuesta" value="<?php echo $row['idpropuesta'];?>">
<input type="hidden" name="idinstitucion" id="idinstitucion" value="<?php echo $row['idinstitucion'];?>">

<input type="hidden" name="nominstitucion" id="nominstitucion" value="<?php echo $row['nominstitucion'];?>">
<input type="hidden" name="nomproyecto" id="nomproyecto" value="<?php echo $row['nomproyecto'];?>">
<input type="hidden" name="descripcionpropuesta" id="descripcionpropuesta" value="<?php echo $row['descripcionpropuesta'];?>">
<input type="hidden" name="estudiantesrequeridos" id="estudiantesrequeridos" value="<?php echo $row['estudiantesrequeridos'];?>">
<input type="hidden" name="duracionestimada" id="duracionestimada" value="<?php echo $row['duracionestimada'];?>">
<input type="hidden" name="nomcontacto" id="nomcontacto" value="<?php echo $row['nomcontacto'];?>">
<input type="hidden" name="correocontacto" id="correocontacto" value="correocontacto">
<input type="hidden" name="estadoprop" id="estadoprop" value="">


<table class="tinytable" align="center">
<tr><thead><th colspan="2"><h3>PROPUESTA</h3></thead></tr>


<?php
echo"
<tr><td id='tdr' width='40%'><b>NOMBRE INSTITUCION:</b></td><td id='tdl'>".$row['nominstitucion']."</td></tr>
<tr><td id='tdr'><b>NOMBRE PROYECTO:</b></td><td id='tdl'>".$row['nomproyecto']."</td></tr>
<tr><td id='tdr'><b>DESCRIPCION:</b></td><td id='tdl'>".$row['descripcionpropuesta']."</td></tr>
<tr><td id='tdr'><b># ESTUDIANTES:</b></td><td id='tdl'>".$row['estudiantesrequeridos']."</td></tr>
<tr><td id='tdr'><b>DURACION (MESES):</b></td><td id='tdl'>".$row['duracionestimada']."</td></tr>
<tr><td id='tdr'><b>CONTACTO:</b></td><td id='tdl'>".$row['nomcontacto']."</td></tr>
<tr><td id='tdr'><b>CORREO:</b></td><td id='tdl'>".$row['correocontacto']."</td></tr>
<tr><td id='tdr'><b>COMENTARIO:</b></td><td id='tdl'><textarea id='comentarioprop' name='comentarioprop' rows='2' cols='60' style='resize:none'></textarea></td></tr>
";
?>
</table>
<br><center>
<input type="button" value="Aprobar" class="buton" onclick="document.getElementById('estadoprop').value='A';this.form.submit();">
<input type="button" value="Rechazar" class="buton" onclick="document.getElementById('estadoprop').value='R';this.form.submit();">
<input type="button" value="Regresar" class="buton" onclick="document.location.href='frmConsultarPropuesta.php'">
</center>
</form>
<br><br>

<?php
include "../../librerias/pie.php";
include "../../librerias/cerrar_conexion.php";
?>