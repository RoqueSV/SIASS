<?php

include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";

/* Variables de sesion para confirmar identidad de usuario */
$tipo=$_SESSION['TYPEUSER'];
$id=$_SESSION['IDUSER'];

/* Recuperar los valores del formulario en caso de error: */
if (isset($_SESSION['datos_form'])){
$datos = $_SESSION['datos_form'];
//Borrar la variable de sesion que se crea
unset($_SESSION['datos_form']);}

/* Manejo de autenticacion */
if(isset($_POST['clave'])) //Si viene desde Modificar mi Cuenta
$pass= md5($_POST['clave']); // Encriptar la clave
else {
 if ($tipo==1 OR $tipo==2) // Viene desde mantto Admin y hubo error.
 $consulta=  pg_fetch_array(pg_query("select clave from administrador where idadministrador='$id'"));
  else if ($tipo==4) // Viene desde mantto Tutor y hubo error.
     $consulta=  pg_fetch_array(pg_query("select claveDocente from Docente where idDocente='$id'"));
   else if($tipo==5) // Viene desde mantto Institucion y hubo error.
       $consulta=  pg_fetch_array(pg_query("select claveinstitucion from Institucion where idInstitucion='$id'"));
$pass= $consulta[0];
}


switch($tipo):
	case 1: $consulta="select count(*) from Administrador where idAdministrador='$id'and clave='$pass'";
	break;
	case 2: $consulta="select count(*) from Administrador where idAdministrador='$id'and clave='$pass'";
	break;
	case 3: $consulta="select count(*) from Administrador where idAdministrador='$id'and clave='$pass'";
	break;
	case 4: $consulta="select count(*) from Docente where idDocente='$id' and clavedocente='$pass'";
	break;
	case 5: $consulta="select count(*) from Institucion where idInstitucion='$id' AND claveInstitucion='$pass'";
	break;
        case 6: $consulta="select count(*) from Alumno where idAlumno='$id'";
	break;
	default : break;
endswitch;

$sql = pg_query($consulta) or die("No se pudo realizar la consulta verificar usuario");
$row = pg_fetch_array($sql);

if($row[0]<>0){
if($tipo==1 OR $tipo==2 OR $tipo==3){
	 /*  // Id del usuario actual - Viene desde frmConfirmarUsuario, o si hubo error desde manttoAdministrador
        $usuario=$_GET['id']; */ // Hace la distincion entre Jefe o Coordinador
	$result = pg_query("SELECT usuario,cargo,nombreAdmin,emailAdmin,telefonoAdmin,clave FROM Administrador WHERE idAdministrador= '$id'") or die("La consulta de Administrador fallo: " . pg_last_error());
	$row =pg_fetch_row($result);
        $_SESSION['usuario']=$id;  // Mandar a checkuser para controlar id de usuario

?>
<script type='text/javascript' 	 src='../../js/funciones.js'></script>
<script type="text/javascript" 	 src="../../js/checkuser.js"></script>
<center><h2>Modificar Cuenta</h2></center>
<form <?php echo "action='../../archivosphp/ManttoAdministrador.php?id=$id&operacion=2'" ?> method="post">
  
<center>
    <p style = "font-size:15px">* No modifique el campo de la contrase&ntilde;a si no desea cambiarla.</p>
  <table width="40%" align="center" class="marco">
  	<tr  >
	<td height="35">Cargo: </td>
	<td> 
    <!-- <select name="cargo" size="1" id="cargo" class=":required :only_on_submit">
        <?php /*if(isset($datos["cargo"])){    
            echo "<option value='".$datos["cargo"]."' selected='selected'>".$datos['cargo']."</option>
                  <option value='Jefe Unidad S.S.'>Jefe Unidad S.S.</option>
                  <option value='Coordinador'>Coordinador</option>";
            } else {      
        */ ?>
        <option value="<?php /*echo $row[1] */?>" selected="selected"><?php /*echo $row[1] */?></option>
        <option value="Jefe Unidad S.S.">Jefe Unidad S.S.</option>
        <option value="Coordinador">Coordinador</option>
        <?php /* } */?>
      </select>  -->
     <input size="30" name="cargo" type="text" id="cargo" value="<?php if(isset($datos["cargo"])) echo $datos["cargo"]; else echo $row[1];?>" class="disabled" readonly="readonly" />       
    </td>
    </tr>
    <tr>
	<td height="35">Usuario: </td>
	<td><label for="usuario"></label>
	<input size="30" type="text" name="usuario" id="usuario" class=":required :only_on_submit" value="<?php if(isset($datos["usuario"])) echo $datos["usuario"]; else echo $row[0];?>" />		  
        <div id="Info"></div></td>
    </tr>
    <tr>
        <td height="35">Nombre: </td>
        <td><input size="30" type="text" name="nombre" id="nombre" class=":required :only_on_submit" value="<?php if(isset($datos["nombre"])) echo $datos["nombre"]; else echo $row[2];?>"></td>
   </tr>
   <tr>
        <td height="35">Email:</td>
	<td>
	<input size="30" type="text" name="email" id="email" class=":required :email :only_on_submit" value="<?php if(isset($datos["email"])) echo $datos["email"]; else echo $row[3];?>"/></td>
    </tr>
    <tr>
        <td  height="35">Tel&eacute;fono:</td>
	<td>
	<input name="telefono" type="text" id="telefono" class=":required :number :phone :only_on_submit"  onMouseOver="toolTip('Ingrese numero tel\xe9fonico sin guiones',this)" maxlength="8" value="<?php if(isset($datos["telefono"])) echo $datos["telefono"]; else  echo $row[4];?>" />
	</td>
    </tr>
    <tr>
    <td height="35">Cambiar password?</td>
    <td height="35">
    <select name="cmb" id="cmb" onchange="txt(this.id)">
    <option value="1">Si</option>
    <option value="2" selected="selected">No</option>
    </select>   
    </td>
    </tr>
    <tr>
      <td  height="35" id="col1" style="display:none">Nueva Contrase&ntilde;a:</td>
      <td><input size="30" type="password" style="display:none" name="clave1" id="clave1" value="<?php if(isset($datos["clave2"])) echo $datos["clave2"]; else echo $row[5];?>" class=":required :min_length;6 :only_on_submit" /></td>
    </tr>
    <tr>
	<td height="35" id="col2" style="display:none">Confirmar Contrase&ntilde;a: </td>
	<td>
        <input size="30" type="password" style="display:none" name="clave2" id="clave2" value="<?php if(isset($datos["clave2"])) echo $datos["clave2"]; else echo $row[5];?>" class=":required :same_as;clave1  :only_on_submit" /></td>
    </tr>
 </table>
<input type="hidden" name="claveoriginal" id="claveoriginal" value="<?php echo $row[5];?>">
<br>
<input type="submit" name="buton" id="buton" class="buton" value="Guardar" />
<input type="button" name="buton2" class="buton" value="Cancelar" <?php echo  "onclick=\"location.href='../Inicio/plantilla_pagina.php'\""; ?> />
<br>
</center>
</form>
<span id="toolTipBox"></span>

<?php
}
else{
	if($tipo==4){ //id=4 tutor
		$result = pg_query("SELECT d.usuarioDocente,d.nombreDocente,d.emailDocente,d.telefonoDocente,d.claveDocente,e.nombreEscuela,e.idescuela,d.estadodocente FROM Docente as d, Escuela as e WHERE d.idescuela=e.idescuela AND idDocente= '$id'") or die("La consulta de Docente fallo: " . pg_last_error());
		$row =pg_fetch_row($result);
                $_SESSION['usuario']=$id;  // Mandar a checkuser para controlar id de usuario
	?>
		<script type="text/javascript" 	 src="../../js/checkuser.js"></script>
		<script type='text/javascript' 	 src='../../js/funciones.js'></script>
		<center><h2>Modificar Cuenta (Tutor)</h2></center>
		<form <?php echo "action='../../archivosphp/ManttoDocente.php?id=$id&operacion=2&idescuela=$row[6]'" ?>  method="post">
		<center>
            <p style = "font-size:15px">* No modifique el campo de la contrase&ntilde;a si no desea cambiarla.</p>        
            <table width="50%"  align="center" class="marco">
            <tr>
            <td height="35">Escuela: </td>
            <td> 
             <input size="30" name="escuela" type="text" id="escuela" value="<?php if(isset($datos["escuela"])) echo $datos["escuela"]; else echo $row[5];?>" class="disabled" readonly="readonly" />
            </td>
            </tr>
			<tr>
			<td  height="35">Usuario: </td>
			<td><label for="usuario"></label>
			<input size="30" type="text" name="usuario" id="usuario" class=":required :only_on_submit" value="<?php if(isset($datos["usuario"])) echo $datos["usuario"]; else echo $row[0];?>" />
			<div id="Info"></div></td>
                        </tr>
			<tr>
			<td  height="35">Nombre: </td>
			<td><input size="30" type="text" name="nombred" id="nombred" class=":required :only_on_submit" value="<?php if(isset($datos["nombred"])) echo $datos["nombred"]; else echo $row[1];?>"></td>
			</tr>	
		        <tr>
			<td  height="35">Email:</td>
			<td>
			<input type="text" size="30" name="emaild" id="emaild" class=":required :email :only_on_submit" value="<?php if(isset($datos["emaild"])) echo $datos["emaild"]; else echo $row[2];?>"/></td>
			</tr>
			<tr>
			<td  height="35">Telef&oacute;no:</td>
			<td>
			<input name="telefonod" type="text" id="telefonod" class=":required :number :phone :only_on_submit"  size="8" maxlength="8" onMouseOver="toolTip('Ingrese numero tel\xe9fonico sin guiones',this)" value="<?php if(isset($datos["telefonod"])) echo $datos["telefonod"]; else echo $row[3];?>" /></td>
                        </tr>
                        <tr>
                            <td height="35">Cambiar contrase&ntilde;a?</td>
                        <td height="35">
                        <select name="cmb" id="cmb" onchange="txt(this.id)">
                        <option value="1">Si</option>
                        <option value="2" selected="selected">No</option>
                        </select>   
                        </td>
                        </tr>
                        <tr>   
			<td height="35" id="col1" style="display:none">Nueva Contrase&ntilde;a:</td>
			<td><input size="30" type="password" style="display:none" name="clave1" id="clave1" value="<?php if(isset($datos["clave2"])) echo $datos["clave2"]; else echo $row[4];?>" class=":required :min_length;6 :only_on_submit"/></td>
                        </tr>
			<tr>
			<td height="35" id="col2" style="display:none">Confirmar Contrase&ntilde;a: </td>
			<td><input size="30" type="password" style="display:none" name="clave2" id="clave2" value="<?php if(isset($datos["clave2"])) echo $datos["clave2"]; else echo $row[4];?>" class=":required :same_as;clave1  :only_on_submit"/></td>
			
                        </tr>
		</table>
                <input type="hidden" name="claveoriginal" id="claveoriginal" value="<?php echo $row[4];?>"> 
                <input type="hidden" name="estadod" id="estadod" value="<?php echo $row[7];?>"> 
		<br>
		<input type="submit" name="buton"  class="buton"  value="Guardar" />
                <input type="button" name="buton2" class="buton" value="Cancelar" <?php echo  "onclick=\"location.href='../Inicio/plantilla_pagina.php'\""; ?> />
		<br>
		</center>
		</form>
                <span id="toolTipBox"></span>	
<?php	}
	else{
		if($tipo==5){//id=5 institucion
		$result = pg_query("SELECT nombreInstitucion,rubro,nombreContacto,cargoContacto,telefonoContacto,emailContacto,claveInstitucion,estadoInstitucion FROM Institucion WHERE idInstitucion= '$id'") or die("La consulta de Institucion fallo: " . pg_last_error());
		$row =pg_fetch_row($result);
                $_SESSION['usuario']=$id;  // Mandar a checkuser para controlar id de usuario
	?>
            <script type='text/javascript' 	 src='../../js/funciones.js'></script>
            <script type="text/javascript" 	 src="../../js/checkuser.js"></script>
            <center><h2>Modificar Cuenta (Institucion)</h2></center>
            <form <?php echo "action='../../archivosphp/ManttoInstitucion.php?operacion=2'"?> method="post">
            <center>
            <table width="40%"  align="center" class="marco">
		<tr>
                <td  height="35">Nombre Instituci&oacute;n: </td>
                <td><input size="30" type="text" name="nombreinstitucion" id="nombreinstitucion" class="disabled" readonly="readonly" value="<?php echo $row[0];?>"></td>
                </tr>	
	        <tr>
                <td  height="35">Rubro: </td>
                <td><select name="rubro"  id="rubro" class=":required :only_on_submit">
                <?php if(isset($datos["rubro"])){    
                echo "<option value='".$datos["rubro"]."' selected='selected'>".$datos['rubro']."</option>
                        <option value='Comercial'>Comercial</option>
			<option value='Consultor&iacute;a'>Consultor&iacute;a</option>
			<option value='Financiero'>Financiero</option>
			<option value='Gubernamental'>Gubernamental</option>
			<option value='Industrial'>Industrial</option>
			<option value='Maquila'>Maquila</option>
			<option value='ONG'>ONG</option>
			<option value='Publicidad'>Publicidad</option>
			<option value='Servicios'>Servicio</option>
			<option value='Tecnolog&iacute;as de Informaci&oacute;n'>Tecnolog&iacute;as de Informaci&oacute;n</option>
			<option value='Telecomunicaciones'>Telecomunicaciones</option>
                        <option value='Otros'>Otros</option>
                 ";
                 } else {      
                 ?>
                        <option value="Comercial" <?php if($row[1]=='Comercial') echo 'selected="selected"';?>>Comercial</option>
                        <option value="Consultor&iacute;a" <?php if($row[1]=='Consultor&iacute;a') echo 'selected="selected"';?>>Consultor&iacute;a</option>
			<option value='Financiero' <?php if($row[1]=='Financiero') echo 'selected="selected"';?>>Financiero</option>
			<option value='Gubernamental' <?php if($row[1]=='Gubernamental') echo 'selected="selected"';?>>Gubernamental</option>
			<option value='Industrial' <?php if($row[1]=='Industrial') echo 'selected="selected"';?>>Industrial</option>
			<option value='Maquila' <?php if($row[1]=='Maquila') echo 'selected="selected"';?>>Maquila</option>
			<option value='ONG' <?php if($row[1]=='ONG') echo 'selected="selected"';?>>ONG</option>
			<option value='Publicidad' <?php if($row[1]=='Publicidad') echo 'selected="selected"';?>>Publicidad</option>
			<option value='Servicios' <?php if($row[1]=='Servicios') echo 'selected="selected"';?>>Servicio</option>
			<option value='Tecnolog&iacute;as de Informaci&oacute;n' <?php if($row[1]=='Tecnolog&iacute;as de Informaci&oacute;n') echo 'selected="selected"';?>>Tecnolog&iacute;as de Informaci&oacute;n</option>
			<option value='Telecomunicaciones' <?php if($row[1]=='Telecomunicaciones') echo 'selected="selected"';?>>Telecomunicaciones</option>
                        <option value='Otros' <?php if($row[1]=='Otros') echo 'selected="selected"';?>>Otros</option>
                <?php  } ?>
                </select></td>
                </tr>	
	        <tr>
                <td  height="35">Nombre Contacto: </td>
                <td><input size="30" type="text" name="nombrecontacto" id="nombrecontacto" class=":required :only_on_submit" value="<?php if(isset($datos["nombrecontacto"])) echo $datos["nombrecontacto"]; else echo $row[2];?>"></td>
                </tr>	
		<tr>
                <td  height="35">Cargo Contacto: </td>
                <td><input size="30" type="text" name="cargocontacto" id="cargocontacto" class=":required :only_on_submit" value="<?php if(isset($datos["cargocontacto"])) echo $datos["cargocontacto"]; else echo $row[3];?>"></td>
                </tr>
		<tr>
		<td  height="35">Email:</td>
		<td>
		<input size="30" type="text" name="usuario" id="usuario" class=":required :email :only_on_submit" value="<?php if(isset($datos["usuario"])) echo $datos["usuario"]; else echo $row[5];?>"/>
		<div id="Info"></div></td>
                </tr>
		<tr>
		<td  height="35">Telef&oacute;no:</td>
		<td>
		<input name="telefonocontacto" type="text" id="telefonocontacto" class=":required :number :phone :only_on_submit"  onMouseOver="toolTip('Ingrese numero telefonico sin guion',this)" size="8" maxlength="8" value="<?php if(isset($datos["telefonocontacto"])) echo $datos["telefonocontacto"]; else echo $row[4];?>" />
                </tr>
		<tr>
                <td height="35">Cambiar contrase&ntilde;a?</td>
                <td height="35">
                <select name="cmb" id="cmb" onchange="txt(this.id)">
                <option value="1">Si</option>
                <option value="2" selected="selected">No</option>
                </select>   
                </td>
                </tr>
                <tr>   
                <td height="35" id="col1" style="display:none">Nueva Contrase&ntilde;a:</td>
                <td><input size="30" type="password" style="display:none" name="clave1" id="clave1" value="<?php if(isset($datos["clave2"])) echo $datos["clave2"]; else echo $row[6];?>" class=":required :min_length;6 :only_on_submit"/></td>
                </tr>
                <tr>
                <td height="35" id="col2" style="display:none">Confirmar Contrase&ntilde;a: </td>
                <td><input size="30" type="password" style="display:none" name="clave2" id="clave2" value="<?php if(isset($datos["clave2"])) echo $datos["clave2"]; else echo $row[6];?>" class=":required :same_as;clave1  :only_on_submit"/></td>
                </tr>
                </table>
                <input type="hidden" name="claveoriginal" id="claveoriginal" value="<?php echo $row[6];?>">
		<br>
                <input type="hidden" name="idinstitucion" id="idinstitucion" value="<?php echo $id; ?> ">
                <input type="hidden" name="estadoinstitucion" id="estadoinstitucion" value="<?php echo $row[7]; ?> ">
		<input type="submit" name="buton"  class="buton" value="Guardar" />
                <input type="button" name="buton2" class="buton" value="Cancelar" <?php echo  "onclick=\"location.href='../Inicio/plantilla_pagina.php'\""; ?> />
                <br>
                </center>
                </form>
                <span id='toolTipBox'></span>
	<?php	}
		else{
			if($tipo==6){//tipo=6 alumno o general tipo=0
                        $carnet_alumno=$_SESSION['user'];
                        $result = pg_query("SELECT
                        idalumno,
                        idcarrera,
                        carnet,
                        nombrealumno,
                        apellidosalumno,
                        nivelacademico,
                        porcentaje,
                        direccionalumno,
                        telefonoalumno,
                        emailalumno,
                        fechaapertura,
                        fotografia
                        FROM alumno 
                        WHERE carnet = '$carnet_alumno'") or die("La consulta de Alumno fallo: " . pg_last_error());
		        $row =  pg_fetch_array($result);
                        $idalumno=$row["idalumno"];
                        $carrera = $row["idcarrera"];
                        $nombrealumno=$row["nombrealumno"];
                        $apellidosalumno=$row["apellidosalumno"];
                        $fecha = explode('-',$row["fechaapertura"]);
                        $fotografia = $row["fotografia"];
                        $consulta_carrera= pg_fetch_array(pg_query("select nombreCarrera from carrera where idCarrera=$carrera"));
                        ?>
                        <script type='text/javascript' 	 src='../../js/funciones.js'></script>
                        <center><h2>Edici&oacute;n de Informaci&oacute;n</h2>
                           
                        <table class="marco" align="center" width="40%">
                            <thead>
                             <tr>
                              <th align="center">Alumno</th>
                              <th align="center">Carnet</th>
                             </tr>
                            </thead>
                            <tr>
                              <td align="center"><?php echo $row["nombrealumno"]." ".$row["apellidosalumno"];?></td>
                              <td align="center"><?php echo $row['carnet'];?></td>
                            </tr>
                            
                        </table>
                        <br/>
                        </center>
                        <form method="post" <?php echo "action=\"../../archivosphp/ManttoAlumno.php?id=$idalumno&carnet_alumno=$carnet_alumno&carrera=$carrera&nombres=$nombrealumno&apellidos=$apellidosalumno&fotografia=$fotografia&operacion=2\""; ?> enctype="multipart/form-data" name="frmalumno" id="frmalumno">
                        <center><?php echo '<img src="../../archivosphp/'.$row["fotografia"].'" border="0" width="150" height="150" />';?> </center><br>
                        <table  width="50%" align="center" class="marco">
                            <tr>
                                <td height="35">Cambiar Fotograf&iacute;a:</td>
                                <td> <input type="file" name="fotografia" id="fotografia"/></td>  		     
                            </tr>
                           <tr>
                                <td height="35">Carrera:</td>
                                <td><label for="carrera"></label>
                                <input type="text" size="33" name="carrera" id="carrera" class="disabled" readonly="readonly" value="<?php echo $consulta_carrera[0];?>" /></td>
                           </tr>
                           <tr>
                                <td height="35">Nivel:</td>
                                <td><label for="nivel"></label>
                                <input type="text" name="nivel" id="nivel" class="disabled" readonly="readonly" value="<?php echo $row["nivelacademico"];?>" /></td>
                           </tr>
                           <tr>
                                <td height="35">% Carrera:</td>
                                <td><label for="porcentajecarrera"></label>
                                <input type="text" name="porcentajecarrera" id="porcentajecarrera" class="disabled" readonly="readonly" value="<?php echo $row["porcentaje"];?>" /></td>
                           </tr>
                            <tr>
                                <td height="35">Direcci&oacute;n: </td>
                                <td><textarea name="direccion" id="direccion" cols="45" rows="2" class=":required"><?php echo $row["direccionalumno"]; ?></textarea></td>
                           </tr>
                           <tr>
                                <td height="35">Email:</td>
                                <td><label for="email"></label>
                                <input type="text" size="33" name="emailalumno" id="emailalumno" class=":required :email :only_on_submit" value="<?php echo $row["emailalumno"];?>" /></td>
                           </tr>
                           <tr>
                                <td height="35">Tel&eacute;fono:</td>
                                <td><label for="telefonoalumno"></label>
                                <input type="text" name="telefonoalumno" id="telefonoalumno"  class=":required :phone :only_on_submit"  maxlength=8 onMouseOver="toolTip('Ingrese numero tel\xe9fonico sin guiones',this)" value="<?php echo $row["telefonoalumno"];?>"/></td>
                           </tr>
                           
                           <tr>
                                <td height="35">Fecha Apertura:</td>
                                <td><label for="fechaapertura"></label>
                                <input type="text" name="fechaapertura" id="fechaapertura" disabled="disabled" value="<?php echo "$fecha[2]-$fecha[1]-$fecha[0]";?>" /></td>
                           </tr>
                        </table>
                         
                        <br>
                        <center>
                        <p style = "font-size:12px">* Los cuadros de texto sombreados no son editables. No puedes cambiar la informaci&oacute;n que contienen.</p>
                        <input type="submit" name="buton1" class="buton" value="Guardar" />
                        <input type="button" name="buton2" class="buton" value="Cancelar" <?php echo  "onclick=\"location.href='../Inicio/plantilla_pagina.php'\""; ?> />
                        </center>
                        </form>
                        <span id='toolTipBox'></span>
                        <?php }
		}
	}
}
}
else{
	echo '<script>alert("Error. Verifique sus datos e intente nuevamente")</script>';
	echo "<script>window.location = 'frmConfirmarUsuario.php'</script>";
}
include "../../librerias/pie.php";
include "../../librerias/cerrar_conexion.php";
?>
