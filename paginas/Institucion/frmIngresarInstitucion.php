<?php
include "../../librerias/cabecera.php";

//Recuperar los valores del formulario en caso de error:
if (isset($_SESSION['datos_form'])){
$datos = $_SESSION['datos_form'];
//Borrar la variable de sesion que se crea
unset($_SESSION['datos_form']);}
?>

<center><h2>REGISTRO DE INSTITUCIONES</h2>
Registro para instituciones que deseen dar a conocer proyectos para horas sociales (previa autorizaci&oacute;n).<br/>
(Utilice email como nombre de usuario)
</center><br>
                <script type="text/javascript" 	 src="../../js/checkuser.js"></script>
		<form method="post" action="../../archivosphp/ManttoInstitucion.php?operacion=1">
		<center>
		<table width="55%"  class="marco">
		<tr height="35">
		<td>Nombre Instituci&oacute;n: </td>
		<td><input type="text" name="nombreinstitucion" size="45%" id="nombreinstitucion" value="<?php if(isset($datos["nombreinstitucion"])) echo $datos["nombreinstitucion"]; ?>" class=":required :only_on_submit"></td>
		</tr>
		<tr height="35">
		<td>Rubro: </td>
		<td><select name="rubro" id="rubro" class=":required :only_on_submit">
			<option value="" selected="selected">Seleccionar..</option>
			<option value="Comercial">Comercial</option>
			<option value="Consultor&iacute;a">Consultor&iacute;a</option>
			<option value="Financiero">Financiero</option>
			<option value="Gubernamental">Gubernamental</option>
			<option value="Industrial">Industrial</option>
			<option value="Maquila">Maquila</option>
			<option value="ONG">ONG</option>
			<option value="Publicidad">Publicidad</option>
			<option value="Servicios">Servicio</option>
			<option value="Tecnolog&iacute;as de Informaci&oacute;n">Tecnolog&iacute;as de Informaci&oacute;n</option>
			<option value="Telecomunicaciones">Telecomunicaciones</option>
                        <option value="Otros">Otros</option>
			</select></td>
			<!-- 	ART 28
					Persona Natural
					Sector Publico Nacional
					Sector Privado Nacional
					Sector Publico Internacional
					Sector Privado Internacional
					Orgaizacion Social
			-->
			
		</tr>
		<tr height="35">
		<td>Nombre Contacto: </td>
		<td><input type="text" name="nombrecontacto" size="45%" id="nombrecontacto" value="<?php if(isset($datos["nombrecontacto"])) echo $datos["nombrecontacto"]; ?>" class=":required :alpha :only_on_submit"></td>
		</tr>
		<tr height="35">
		<td>Cargo Contacto: </td>
		<td><input type="text" name="cargocontacto" size="45%" id="cargocontacto" value="<?php if(isset($datos["cargocontacto"])) echo $datos["cargocontacto"]; ?>" class=":required :alpha :only_on_submit"></td>
		<tr height="35">
		<td>Tel&eacute;fono: </td>
		<td><input type="text" name="telefonocontacto" size="30%" id="telefonocontacto" maxlength="8" value="<?php if(isset($datos["telefonocontacto"])) echo $datos["telefonocontacto"]; ?>" class=":required :number :only_on_submit">
		</td>
		</tr>
		<tr height="35">
		<td>Correo Electr&oacute;nico: </td>
		<td><input type="text" name="usuario" id="usuario" size="45%" value="<?php if(isset($datos["emailcontacto"])) echo $datos["emailcontacto"]; ?>" class=":required :email :only_on_submit">
                <div id="Info"></div></td>
		</tr>
		<tr height="35">
		<td>Contrase&ntilde;a: </td>
		<td><input type="password" name="clave" size="30%" id="clave" value="<?php if(isset($datos["clave2"])) echo $datos["clave2"]; ?>" class=":min_length;6 :only_on_submit"></td>
		</tr>
		<tr height="35">
		<td>Repetir Contrase&ntilde;a: </td>
		<td><input type="password" name="clave2" size="30%" id="clave2" value="<?php if(isset($datos["clave2"])) echo $datos["clave2"]; ?>" class=":same_as;clave :only_on_submit"></td>
		</tr>
		</table>
		<br>
		<input type="submit" name="buton" class="buton" value="Guardar">
		<input type="reset" name="buton" class="buton" value="Limpiar">
		<input type="button" name="buton" class="buton" value="Cancelar" onclick="location.href='../Inicio/plantilla_pagina.php'">
		
		</center>
		</form>

<?php
include "../../librerias/pie.php";
?>
