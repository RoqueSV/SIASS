<?php
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

$instruccion_select = "
SELECT
*
FROM institucion
WHERE idinstitucion =".$_SESSION['IDUSER'];

$consulta_institucion = pg_query($instruccion_select) or die ("<SPAN CLASS='error'>Fallo en consulta_usuario!!</SPAN>".pg_last_error());
$institucion = pg_fetch_array($consulta_institucion);

?>

<script type='text/javascript'>
function pregunta() {

    if(confirm('\xbfEsta seguro de eliminar este registro?')) {
        document.getElementById("detalleInst").submit();
}
}
</script> 

<style>.tinytable{width: 50%;}</style>
<center><h2>Instituci&oacute;n: <?php echo $institucion["nombreinstitucion"]; ?> </h2></center>
<p style="font-size: 12px; text-align:center;">(Tenga en cuenta que al darse de baja su registro sera eliminado de la base de datos del sistema)</p>
<br>

<form method="post" action="../../archivosphp/ManttoInstitucion.php?operacion=2" name="detalleInst" id="detalleInst">
<input type="hidden" name="idinstitucion" id="idinstitucion" value="<?php echo $institucion['idinstitucion'];?>">
<input type="hidden" name="nombreinstitucion" id="nombreinstitucion" value="<?php echo $institucion['nombreinstitucion'];?>">
<input type="hidden" name="rubro" id="rubro" value="<?php echo $institucion['rubro'];?>">
<input type="hidden" name="nombrecontacto" id="nombrecontacto" value="<?php echo $institucion['nombrecontacto'];?>">
<input type="hidden" name="cargocontacto" id="cargocontacto" value="<?php echo $institucion['cargocontacto'];?>">
<input type="hidden" name="telefonocontacto" id="telefonocontacto" value="<?php echo $institucion['telefonocontacto'];?>">
<input type="hidden" name="emailcontacto" id="emailcontacto" value="<?php echo $institucion['emailcontacto'];?>">
<input type="hidden" name="clave2" id="clave2" value="<?php echo $institucion['claveinstitucion'];?>">
<input type="hidden" name="estadoinstitucion" id="estadoinstitucion" value="B">
<table class="tinytable" align="center">
<tr>
  <th colspan="2"><h3>DATOS DE INSTITUCION</h3></th>
</tr>
<?php
echo"
<tr>
  <td id='tdr' width='40%'><b>NOMBRE INSTITUCION:</b></td>
  <td id='tdl'>".$institucion['nombreinstitucion']."</td>
</tr>
<tr>
  <td id='tdr'><b>RUBRO:</b></td>
  <td id='tdl'>".$institucion['rubro']."</td>
</tr>
<tr>
  <td id='tdr'><b>CONTACTO:</b></td>
  <td id='tdl'>".$institucion['nombrecontacto']."</td>
</tr>
<tr>
  <td id='tdr'><b>CARGO CONTACTO:</b></td>
  <td id='tdl'>".$institucion['cargocontacto']."</td>
</tr>
<tr>
  <td id='tdr'><b>EMAIL:</b></td>
  <td id='tdl'>".$institucion['emailcontacto']."</td>
</tr>
<tr>
  <td id='tdr'><b>TELEFONO:</b></td>
  <td id='tdl'>".$institucion['telefonocontacto']."</td>
</tr>

";
?>
</table>
<br>
<center>
<!-- <input type="button" name="buton" class="buton" value="Modificar" <?php /*echo "onclick=\"location.href='../Cuenta/frmConfirmarUsuario.php?id=$usuario'\""; */?> /> --> 
<input type="button" name="buton" class="buton" value="Darse de baja"  onclick="pregunta();" />
<input type="button" name="buton" class="buton" value="Cancelar"  onclick="location.href='../Inicio/plantilla_pagina.php'" />
</center>
</form>

<?php
include "../../librerias/cerrar_conexion.php";
include "../../librerias/pie.php";
?>
