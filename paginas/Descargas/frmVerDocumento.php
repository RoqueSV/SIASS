<?php
include "../../librerias/abrir_conexion.php";
include "../../librerias/cabecera.php";

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

$archivo=$_GET['id'];
$instruccion_select = "
SELECT
idarchivo,
nombre,
ruta
FROM archivos
WHERE idarchivo = '$archivo'";

$consulta_archivos = pg_query($instruccion_select) or die ("<SPAN CLASS='error'>Fallo en consulta_usuario!!</SPAN>".pg_last_error());
$archivos = pg_fetch_array($consulta_archivos);
$ruta=$archivos['ruta'];


echo"<script type='text/javascript'>
function pregunta() {

    if(confirm('\xbfEsta seguro de eliminar este documento?')) {

        document.location.href= '../../archivosphp/ManttoArchivos.php?id=$archivo&ruta=$ruta&operacion=3';

    }

}
</script> "; 
?>
<style>.tinytable{width: 40%;}</style>
<h2 align="center">DETALLES DEL ARCHIVO</h2>
<h3 align="center">Puede eliminar o modificar el archivo, pulsando sobre el boton correspondiente.</h3>

<table class="tinytable" align="center">
<tr>
  <th colspan="2"><h3>DATOS DEL ARCHIVO</h3></th>
</tr>

<?php
echo"
<tr>
  <td id='tdr' width='40%'><b>CODIGO ARCHIVO:</b></td>
  <td id='tdl'>".$archivos['idarchivo']."</td>
</tr>
<tr>
  <td id='tdr'><b>NOMBRE DOCUMENTO:</b></td>
  <td id='tdl'>".$archivos['nombre']."</td>
</tr>
";
?>
</table>
<br>
<center>
<!-- <input type="button" name="buton" class="buton" value="Modificar" <?php /*echo "onclick=\"location.href='../Cuenta/frmConfirmarUsuario.php?id=$usuario'\""; */?> /> --> 
<input type="button" name="buton" class="buton" value="Eliminar"  <?php echo "onclick=\"pregunta();\""; ?>/>
<input type="button" name="buton" class="buton" value="Modificar" <?php echo "onclick=\"location.href='frmModificarDocumento.php?id=$archivo'\""; ?>/>
<input type="button" name="buton" class="buton" value="Regresar"  <?php echo  "onclick=\"location.href='frmConsultarDocumentos.php'\""; ?>/>
</center>

<?php
include "../../librerias/cerrar_conexion.php";
include "../../librerias/pie.php";
?>
