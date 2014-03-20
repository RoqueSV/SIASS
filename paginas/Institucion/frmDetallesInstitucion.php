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

$idInstitucion=$_GET['id'];
$row = pg_fetch_array(pg_query("select * from institucion where idinstitucion=".$idInstitucion.";"));

?>

<script type='text/javascript'>
function pregunta() {

    if(confirm('\xbfEsta seguro de eliminar este registro?')) {
        document.getElementById("detalleInst").submit();
}
}
</script>



<style>.tinytable{width: 60%;}</style>
<h2 align="center">DETALLES DE INSTITUCI&Oacute;N</h2>
<h3 align="center">Puede dar de baja a la instituci&oacute;n, pulsando sobre el boton correspondiente.</h3>


<form method="post" action="../../archivosphp/ManttoInstitucion.php?operacion=2" name="detalleInst" id="detalleInst">
<input type="hidden" name="idinstitucion" id="idinstitucion" value="<?php echo $row['idinstitucion'];?>">
<input type="hidden" name="nombreinstitucion" id="nombreinstitucion" value="<?php echo $row['nombreinstitucion'];?>">
<input type="hidden" name="rubro" id="rubro" value="<?php echo $row['rubro'];?>">
<input type="hidden" name="nombrecontacto" id="nombrecontacto" value="<?php echo $row['nombrecontacto'];?>">
<input type="hidden" name="cargocontacto" id="cargocontacto" value="<?php echo $row['cargocontacto'];?>">
<input type="hidden" name="telefonocontacto" id="telefonocontacto" value="<?php echo $row['telefonocontacto'];?>">
<input type="hidden" name="emailcontacto" id="emailcontacto" value="<?php echo $row['emailcontacto'];?>">
<input type="hidden" name="clave2" id="clave2" value="<?php echo $row['claveinstitucion'];?>">
<input type="hidden" name="estadoinstitucion" id="estadoinstitucion" value="B">

<table class="tinytable" align="center">
<tr><thead><th colspan="2"><h3>INSTITUCI&Oacute;N</h3></thead></tr>
<?php
echo"
<tr><td id='tdr' width='40%'><b>NOMBRE:</b></td><td id='tdl'>".$row['nombreinstitucion']."</td></tr>
<tr><td id='tdr'><b>RUBRO:</b></td><td id='tdl'>".$row['rubro']."</td></tr>
<tr><td id='tdr'><b>CONTACTO:</b></td><td id='tdl'>".$row['nombrecontacto']."</td></tr>
<tr><td id='tdr'><b>CARGO DE CONTACTO:</b></td><td id='tdl'>".$row['cargocontacto']."</td></tr>
<tr><td id='tdr'><b>TELEFONO:</b></td><td id='tdl'>".$row['telefonocontacto']."</td></tr>
<tr><td id='tdr'><b>CORREO:</b></td><td id='tdl'><a href='mailto:".$row['emailcontacto']."'>".$row['emailcontacto']."</a></td></tr>
";

?>
</table>

<br>
<center>
<input type="button" value="Dar de Baja" class="buton" onclick="pregunta();">
<input type="button" value="Regresar" class="buton" onclick="document.location.href='frmConsultarInstituciones.php'">
</center>
</form>

<?php
include "../../librerias/pie.php";
include "../../librerias/cerrar_conexion.php";
?>