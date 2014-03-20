<?php
include "../../librerias/cabecera.php";
/* 
if(isset($_GET['id'])){   // En caso de que el Admin pueda modificar datos de otros usuarios (coordinadores),
$usuario=$_GET['id'];     // tendria q mandar este usuario a frmModificaCuenta
}                         // vendria desde frmVerAdministrador - Opcion Modificar
else{
 $usuario=$_SESSION['IDUSER'];
} */

?>
<script type="text/javascript" 	 src="../js/funciones.js"></script>
<center><h2>Confirme su identidad</h2></center>
<br>  
		<form method="post" <?php echo "action=\"frmModificaCuenta.php\""?> >
		<center>
		<table width="40%"  class="marco">
			<tr>
				<td  height="35">Ingrese su clave nuevamente: </td>
				<td><input type="password" name="clave" id="clave" class=":required :only_on_submit" /></td>
			</tr>
               </table>
		<br>
		<input type="submit" name="buton" class="buton" value="Verificar">
		</center>
		</form>

<?php
include "../../librerias/pie.php";
?>
