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

<center><h2>Ingreso de Carrera</h2></center>
<img src="../../imagenes/escuela.jpg"  alt="Escuela" class="imagen"/>
<br><br>
<form method="post" action="../../archivosphp/ManttoCarrera.php?operacion=1">
 <center>
  <table width="55%"  class="marco">
    <tr >
	<td height="35">Codigo Carrera: </td>
	<td><input type="text" name="codigoc" id="codigoc" class=":required :only_on_submit"></td>
    </tr>
    <tr>
	<td height="35">Nombre Carrera: </td>
	<td><input name="nombrec" type="text" class=":required :only_on_submit" id="nombrec" value="" /></td>
   </tr>
   <tr>
	<td height="35">Escuela: </td>
	<td><select name="escuela" id="escuela" class=":required :only_on_submit">
			<option value="" selected="selected">Seleccione una..</option>
			<?php
			include "../../librerias/abrir_conexion.php";
			$consulta_escuela ="select * from escuela;";
                        $resultado= pg_query($consulta_escuela) or die ("<SPAN CLASS='error'>Fallo en consulta de usuario!!</SPAN>".pg_last_error());
			while($row=  pg_fetch_array($resultado)){
			echo"<option value=".$row[0].">".$row[1]."</option>";
			}
			include "../../librerias/cerrar_conexion.php";
			?>
	     </select>
	</td>
   </tr>
   <tr>
	<td height="35">Porcentaje Requerido: </td>
	<td><input type="text" name="porcentajec" id="porcentajec" maxlength="5" class=":required :number :only_on_submit"></td>
   </tr>
   <tr>
	<td height="35">Plan de Estudios: </td>
	<td><input type="text" name="plan" id="plan" maxlength="4" class=":required :integer :only_on_submit"></td>
   </tr>
   <tr>
	<td height="35">Horas requeridas: </td>
	<td><input type="text" name="horas" id="horas" maxlength="3" class=":required :integer :only_on_submit"></td>
   </tr>
 </table>
<br><br>
<input type="submit" class="buton" id="buton" value="Guardar">
</center>
</form>

<?php
include "../../librerias/pie.php";
?>
