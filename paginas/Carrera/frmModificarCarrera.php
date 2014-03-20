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

$carrera=$_GET['id'];
$instruccion_select = "
SELECT
idescuela,
(select nombreescuela from escuela e where e.idescuela=c.idescuela) escuela,
codcarrera,
nombrecarrera,
porcentajecarrera,
plan,
horasrequeridas
FROM carrera c
WHERE idcarrera = '$carrera'";

$consulta_carreras = pg_query($instruccion_select) or die ("<SPAN CLASS='error'>Fallo en consulta_carrera!!</SPAN>".pg_last_error());
$carreras = pg_fetch_array($consulta_carreras);
?>  

<center><h2>Modificaci&oacute;n de Carrera</h2></center><br>
<form method="post" <?php echo "action=\"../../archivosphp/ManttoCarrera.php?id=$carrera&operacion=2\""; ?> name="frmcarrera" id="frmcarrera">

<table width="50%"  align="center" class="marco">
    <tr >
	<td height="35">Codigo Carrera: </td>
	<td><input type="text" name="codigoc" id="codigoc" class=":required :only_on_submit" value="<?php echo $carreras["codcarrera"];?>"></td>
    </tr>
    <tr>
	<td height="35">Nombre Carrera: </td>
	<td><input name="nombrec" type="text" class=":required :only_on_submit" id="nombrec" value="<?php echo $carreras["nombrecarrera"];?>" /></td>
   </tr>
   <tr>
	<td height="35">Escuela: </td>
	<td><select name="escuela" id="escuela">
			
			<?php
			echo '<option value="'.$carreras["idescuela"].'" selected="selected">'.$carreras["escuela"].'</option>';
			$consulta_escuela ="select * from escuela;";
                        $resultado= pg_query($consulta_escuela) or die ("<SPAN CLASS='error'>Fallo en consulta de usuario!!</SPAN>".pg_last_error());
			while($row=  pg_fetch_array($resultado)){
			echo"<option value=".$row[0].">".$row[1]."</option>";
			}	
			?>
	     </select>
	</td>
   </tr>
   <tr>
	<td height="35">Porcentaje Requerido: </td>
	<td><input type="text" name="porcentajec" id="porcentajec" maxlength="5" class=":required :number :only_on_submit" value="<?php echo $carreras["porcentajecarrera"];?>" ></td>
   </tr>
   <tr>
	<td height="35">Plan de Estudios: </td>
	<td><input type="text" name="plan" id="plan" maxlength="4" class=":required :integer :only_on_submit" value="<?php echo $carreras["plan"];?>"></td>
   </tr>
    <tr>
	<td height="35">Horas Requeridas: </td>
	<td><input type="text" name="horas" id="horas" maxlength="3" class=":required :integer :only_on_submit" value="<?php echo $carreras["horasrequeridas"];?>"></td>
   </tr>
 </table>
<br>
<center>
<input type="submit" name="buton1" class="buton" value="Guardar" />
<input type="button" name="buton2" class="buton" value="Cancelar" <?php echo  "onclick=\"location.href='frmVerCarrera.php?id=$carrera'\""; ?> />
</center>

</form>

<?php      
include "../../librerias/cerrar_conexion.php";
include "../../librerias/pie.php";
?>
