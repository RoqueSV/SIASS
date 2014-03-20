<?php
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

?>

<center><h2>REGISTRO DE ESCUELAS</h2></center>
<img src="../../imagenes/escuela.jpg"  alt="Escuela" class="imagen"/>
<br>
		<form method="post" action="../../archivosphp/ManttoEscuela.php?operacion=1">
		<center>
		<table width="40%"  class="marco">
		<tr>
		<td height="35">Nombre Escuela: </td>
		<td><input type="text" name="nombre" id="nombre" class=":required :only_on_submit"></td>
		</tr>
		</table>
		<br>
		<input type="submit" name="buton" class="buton" value="Guardar">
		</center>
		</form>
<br><br><br>
<?php
include "../../librerias/pie.php";
?>
