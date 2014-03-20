<?php
include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";

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

?>  

<center><h2>Modificaci&oacute;n de Escuelas</h2></center><br>
<form method="post" <?php echo "action=\"../../archivosphp/ManttoEscuela.php?id=$escuela&operacion=2\""; ?>  enctype="multipart/form-data">

<table  width="55%" align="center" class="marco">
    <tr>
	<td height="35">Nombre Escuela:</td>
	<td><input type="text" name="nombre" id="nombre"  size="40" value="<?php echo $escuelas["nombreescuela"];?>" class=":required :only_on_submit"/></td>
    </tr>
  </table>
<br>
<center>
<input type="submit" name="buton1" class="buton" value="Guardar" />
<input type="button" name="buton2" class="buton" value="Cancelar" <?php echo  "onclick=\"location.href='frmVerEscuela.php?id=$escuela'\""; ?> />
</center>


</form>

<?php      
include "../../librerias/cerrar_conexion.php";
include "../../librerias/pie.php";
?>

