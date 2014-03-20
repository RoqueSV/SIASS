<?php
/* NOTA: Este archivo no es utilizado. 
 * Guardado para posibles cambios con respecto a la modificacion de usuarios.
 */
include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";
$usuario=$_GET['id'];
$instruccion_select = "
SELECT
idadministrador,
usuario,
clave,
cargo,
nombreadmin,
emailadmin,
telefonoadmin
FROM administrador
WHERE idadministrador = '$usuario'";

$consulta_usuarios = pg_query($instruccion_select) or die ("<SPAN CLASS='error'>Fallo en consulta_usuario!!</SPAN>".pg_last_error());
$usuarios = pg_fetch_array($consulta_usuarios);
?>  

<script type='text/javascript' 	 src='../../js/funciones.js'></script>
<center><h2>Modificaci&oacute;n de Usuarios</h2></center><br>
<form method="post" <?php echo "action=\"../../archivosphp/ManttoAdministrador.php?id=$usuario&operacion=2\""; ?> name="frmusuario" id="frmusuario">

<table  width="40%" align="center" class="marco">
    <tr>
	<td width="127" height="35">Nombre Usuario:</td>
	<td width="135"><label for="usuario"></label>
	<input type="text" name="usuario" id="usuario" class=":required :only_on_submit" value="<?php echo $usuarios["usuario"];?>"/>		  
        </td>
    </tr>
    <tr>
        <td height="35">Contrase&ntilde;a nueva:</td>
      <td><input type="password" name="clave1" id="clave1" class=":required :min_length;6 :only_on_submit" value="<?php echo $usuarios["clave"];?>" /></td>
    </tr>
    <tr>
	<td height="35">Confirmar Contrase&ntilde;a: </td>
	<td><label for="clave2"></label>
        <input type="password" name="clave2" id="clave2" class=":required :same_as;clave1  :only_on_submit" value="<?php echo $usuarios["clave"];?>" /></td>
    </tr>
    <tr >
	<td height="35">Cargo: </td>
	<td>
         <select name="cargo" size="1" id="cargo" >
            <option value="Administrador">Administrador</option>
            <option value="Coordinador">Coordinador</option>
            <option value="Sub-Coordinador">Sub-Coordinador</option>
            <option value="Otro">Otro</option>
         </select>   
        </td>
    </tr>
    <tr>
        <td height="35">Nombre: </td>
        <td><input type="text" name="nombre" id="nombre" class=":required :alpha :only_on_submit" value="<?php echo $usuarios["nombreadmin"];?>"></td>
   </tr>
   <tr>
        <td height="35">Email:</td>
	<td><label for="email"></label>
	<input type="text" name="email" id="email" class=":required :email :only_on_submit" value="<?php echo $usuarios["emailadmin"];?>" /></td>
    </tr>
    <tr>
        <td height="35">Tel&eacute;fono:</td>
	<td><label for="telefono"></label>
	<input name="telefono" id="telefono" type="text"  class=":phone :only_on_submit"  maxlength=8 onMouseOver="toolTip('Ingrese numero telefonico sin guion',this)" value="<?php echo $usuarios["telefonoadmin"];?>"/>
        </td>
    </tr>
  </table>
<br>
<center>
<input type="submit" name="buton1" class="buton" value="Guardar" />
<input type="button" name="buton2" class="buton" value="Cancelar" <?php echo  "onclick=\"location.href='frmVerAdministrador.php?id=$usuario'\""; ?> />
</center>


</form>
<span id='toolTipBox'></span>
<?php      
include "../../librerias/cerrar_conexion.php";
include "../../librerias/pie.php";
?>
