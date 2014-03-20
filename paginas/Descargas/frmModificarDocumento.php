<?php
/* NOTA: Este archivo no es utilizado. 
 * Guardado para posibles cambios con respecto a la modificacion de usuarios.
 */
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
$ruta = $archivos ['ruta'];
?>  

<center><h2>Modificaci&oacute;n de Documento</h2></center><br>
<form method="post" <?php echo "action=\"../../archivosphp/ManttoArchivos.php?id=$archivo&archivo=$ruta&operacion=2\""; ?>  enctype="multipart/form-data">

<table  width="55%" align="center" class="marco">
    <tr>
	<td height="35">Nombre Documento:</td>
	<td><input type="text" name="nombre" id="nombre"  size="40" value="<?php echo $archivos["nombre"];?>" class=":required :only_on_submit"/></td>
    </tr>
    <tr>
     <td height="35">Seleccionar Documento:</td>
     <td> <input type="file" name="archivo" id="archivo" /></td>  
    </tr>
  </table>
<br>
<center>
<input type="submit" name="buton1" class="buton" value="Guardar" />
<input type="button" name="buton2" class="buton" value="Cancelar" <?php echo  "onclick=\"location.href='frmVerDocumento.php?id=$archivo'\""; ?> />
</center>


</form>

<?php      
include "../../librerias/cerrar_conexion.php";
include "../../librerias/pie.php";
?>

