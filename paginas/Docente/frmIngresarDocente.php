<?php
include "../../librerias/cabecera.php";

/* Bloque seguridad */
if (!(isset($_SESSION['TYPEUSER']))) {
header("Location: ../../paginas/Inicio/frmAccesoDenegado.php");
exit(); 
}
else if (!($_SESSION['TYPEUSER']==1 OR $_SESSION['TYPEUSER']==2)) {
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
<script type="text/javascript" 	 src="../../js/checkuser.js"></script>
<center><h2>Ingreso de Tutores</h2></center>
<img src="../../imagenes/usertutor.jpg"  alt="Usuario Docente" class="imagen"/>
		<form method="post" action="../../archivosphp/ManttoDocente.php?operacion=1">
		<center>
		<table width="50%"  class="marco">
		<tr>
		<td  height="35">Usuario Docente: </td>
		<td><input size="30" type="text" name="usuario" id="usuario" value="<?php if(isset($datos["usuario"])) echo $datos["usuario"]; ?>" class=":required :only_on_submit">
                <div id="Info"></div>
                </td>
                </tr>
		<tr>
		<td  height="35">Contrase&ntilde;a: </td>
		<td><input size="30" type="password" name="contraseniad" id="contraseniad" value="<?php if(isset($datos["contraseniad2"])) echo $datos["contraseniad2"]; ?>" class=":min_length;6 :only_on_submit"></td>
		</tr>
		<tr>
		<td  height="35">Repetir Contrase&ntilde;a: </td>
		<td><input size="30" type="password" name="contraseniad2" id="contraseniad2" value="<?php if(isset($datos["contraseniad2"])) echo $datos["contraseniad2"]; ?>" class=":required :same_as;contraseniad :only_on_submit"></td>
		</tr>
		<tr>
		<td  height="35">Nombre Docente: </td>
		<td><input size="30" type="text" name="nombred" id="nombred" value="<?php if(isset($datos["nombred"])) echo $datos["nombred"]; ?>" class=":required :alphapoint :only_on_submit"></td>
		</tr>
		<tr>
		<td height="35">Escuela: </td>
		<td><select name="escuela" id="escuela" class=":required :only_on_submit">
			<option value="" selected="selected">Seleccionar..</option>
			<?php
                        include "../../librerias/abrir_conexion.php";
                        if(isset($datos["escuela"])){ 
                        $consulta=  pg_query("select nombreescuela from escuela where idescuela=".$datos["escuela"]);
                        $escuela = pg_fetch_array($consulta);
                        echo "<option value='".$datos["escuela"]."' selected='selected'>".$escuela[0]."</option>";}
			
			$consulta ="select * from escuela;";
                        $resultado= pg_query($consulta) or die ("<SPAN CLASS='error'>Fallo en consulta de usuario!!</SPAN>".pg_last_error());
			while($row=  pg_fetch_array($resultado)){
			echo"<option value=".$row[0].">".$row[1]."</option>";
			}
			include "../../librerias/cerrar_conexion.php";
			?>
			</select>
		</td>
		</tr>
		<tr>
                    <td  height="35">Tel&eacute;fono: </td>
		<td><input size="8" type="text" name="telefonod" id="telefonod" maxlength="8" value="<?php if(isset($datos["telefonod"])) echo $datos["telefonod"]; ?>" class=":required :phone :only_on_submit" onMouseOver="toolTip('Ingrese numero tel\xe9fonico sin guiones',this)"></td>
		</tr>
		<tr>
		<td  height="35">Correo Electr&oacute;nico: </td>
		<td><input size="30" type="text" name="emaild" id="emaild" value="<?php if(isset($datos["emaild"])) echo $datos["emaild"]; ?>" class=":required :email :only_on_submit"></td>
		</tr>
		</table>
		<br>
		<input type="submit" name="buton" class="buton" value="Guardar">
                <input type="button" name="buton2" class="buton" value="Cancelar" <?php echo  "onclick=\"location.href='../Inicio/plantilla_pagina.php'\""; ?> />
		</center>
		</form>
                <span id="toolTipBox"></span>
<?php
include "../../librerias/pie.php";
?>
