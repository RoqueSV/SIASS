<?php
include "../../librerias/abrir_conexion.php";
include "../../librerias/cabecera.php";

/* Bloque seguridad */
if (!(isset($_SESSION['TYPEUSER']))) {
header("Location: ../../paginas/Inicio/frmAccesoDenegado.php");
exit(); 
}
else if (!($_SESSION['TYPEUSER']==3)) {
session_destroy();
header("Location: ../../paginas/Inicio/frmAcceso.php");
exit();    
}
 /* **********    */

$escuela=$_GET['id'];
$instruccion_select = "
SELECT
*
FROM escuela
WHERE idescuela = '$escuela'";

$consulta_escuelas = pg_query($instruccion_select) or die ("<SPAN CLASS='error'>Fallo en consulta_usuario!!</SPAN>".pg_last_error());
$escuelas = pg_fetch_array($consulta_escuelas);



echo"<script type='text/javascript'>
function pregunta() {

    if(confirm('\xbfEsta seguro de eliminar este registro?')) {

        document.location.href= '../../archivosphp/ManttoEscuela.php?id=$escuela&operacion=3';

    }

}
</script> "; 
?>
<style>.tinytable{width: 40%;}</style>
<h2 align="center">DETALLES DE LA ESCUELA</h2>
<h3 align="center">Puede eliminar o modificar el registro, pulsando sobre el boton correspondiente.</h3>

<table class="tinytable" align="center">
<tr>
  <th colspan="2"><h3>DATOS DE LA ESCUELA</h3></th>
</tr>

<?php
echo"
<tr>
  <td id='tdr' width='40%'><b>CODIGO ESCUELA:</b></td>
  <td id='tdl'>".$escuelas['idescuela']."</td>
</tr>
<tr>
  <td id='tdr'><b>NOMBRE ESCUELA:</b></td>
  <td id='tdl'>".$escuelas['nombreescuela']."</td>
</tr>
";
?>
</table>
<br>
<center>
<!-- <input type="button" name="buton" class="buton" value="Modificar" <?php /*echo "onclick=\"location.href='../Cuenta/frmConfirmarUsuario.php?id=$usuario'\""; */?> /> --> 
<input type="button" name="buton" class="buton" value="Eliminar"  <?php echo "onclick=\"pregunta();\""; ?>/>
<input type="button" name="buton" class="buton" value="Modificar" <?php echo "onclick=\"location.href='frmModificarEscuela.php?id=$escuela'\""; ?>/>
<input type="button" name="buton" class="buton" value="Regresar"  <?php echo  "onclick=\"location.href='frmConsultarEscuela.php'\""; ?>/>
</center>

<?php
include "../../librerias/cerrar_conexion.php";
include "../../librerias/pie.php";
?>

