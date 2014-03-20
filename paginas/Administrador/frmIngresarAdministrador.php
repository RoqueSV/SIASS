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

//Recuperar los valores del formulario en caso de error:
if (isset($_SESSION['datos_form'])){
$datos = $_SESSION['datos_form'];
//Borrar la variable de sesion que se crea
unset($_SESSION['datos_form']);}
?>

<script type="text/javascript" 	 src="../../js/funciones.js"></script>
<script type="text/javascript" 	 src="../../js/checkuser.js"></script>
<h2>Ingreso de Usuarios</h2>
<img src="../../imagenes/usuarionew.jpg"  alt="Usuario nuevo" class="imagen"/>

<form   action="../../archivosphp/ManttoAdministrador.php?operacion=1" method="post" name="frmc_usuario" id="frmc_usuario">
  <table  width="50%" align="center" class="marco">
    <tr>
        <td width="127" height="35">Nombre Usuario:</td>
	<td width="135"><label for="usuario"></label>
	<input size="35" type="text" name="usuario" id="usuario"  class=":required :only_on_submit" value="<?php if(isset($datos["usuario"])) echo $datos["usuario"]; ?>" />
       
        <div id="Info"></div>
        </td>
       
    </tr>
    <tr>
        <td height="35">Contrase&ntilde;a:</td>
      <td><input size="35" type="password" name="clave1" id="clave1" value="<?php if(isset($datos["clave2"])) echo $datos["clave2"]; ?>" class=":required :min_length;6 :only_on_submit" /></td>
    </tr>
    <tr>
	<td height="35">Confirmar Contrase&ntilde;a: </td>
	<td><label for="clave2"></label>
        <input size="35" type="password" name="clave2" id="clave2" value="<?php if(isset($datos["clave2"])) echo $datos["clave2"]; ?>" class=":required :same_as;clave1  :only_on_submit" /></td>
    </tr>
    <tr>
	<td height="35">Cargo: </td>
	<td>
         <select name="cargo" size="1" id="cargo" >
            <?php if(isset($datos["cargo"])){    
            echo "<option value='".$datos["cargo"]."' selected='selected'>".$datos['cargo']."</option>";}
            ?>
            <option value="Administrador">Administrador</option>
            <option value="Jefe Unidad S.S.">Jefe Unidad S.S.</option>
            <option value="Coordinador">Coordinador</option>
         </select>   
    </td>
    </tr>
    <tr>
        <td height="35">Nombre Completo: </td>
        <td><input size="35" type="text" name="nombre" id="nombre" class=":required :alpha :only_on_submit" value="<?php if(isset($datos["nombre"])) echo $datos["nombre"]; ?>" /></td>
   </tr>
   <tr>
        <td height="35">Email:</td>
	<td><label for="email"></label>
	<input size="35" type="text" name="email" id="email" class=":required :email :only_on_submit" value="<?php if(isset($datos["email"])) echo $datos["email"]; ?>" /></td>
    </tr>
    <tr>
        <td height="35">Tel&eacute;fono:</td>
	<td><label for="telefono"></label>
	<input name="telefono" id="telefono" type="text"  class=":phone :only_on_submit"  value="<?php if(isset($datos["telefono"])) echo $datos["telefono"]; ?>" maxlength=8 onMouseOver="toolTip('Ingrese numero tel\xe9fonico sin guiones',this)"/>
        </td>
    </tr>
  </table>
<br>
<center>

<input type="submit" name="buton" class="buton" value="Guardar" />
<input type="button" name="buton2" class="buton" value="Cancelar" <?php echo  "onclick=\"location.href='../Inicio/plantilla_pagina.php'\""; ?> />
</center>
</form>
<span id="toolTipBox"></span>

<?php
include "../../librerias/pie.php";
?>