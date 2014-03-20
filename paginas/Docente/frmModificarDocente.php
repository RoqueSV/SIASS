<?php
/* NOTA: Este archivo no es utilizado. 
 * Guardado para posibles cambios con respecto a la modificacion de tutores por parte del jefe.
 */
include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";
$id=$_GET['id'];
$result = pg_query("SELECT d.usuarioDocente,d.nombreDocente,d.emailDocente,d.telefonoDocente,d.claveDocente,e.nombreEscuela,e.idescuela FROM Docente as d, Escuela as e WHERE d.idescuela=e.idescuela AND idDocente= '$id'") or die("La consulta de Docente fallo: " . pg_last_error());
$docentes = pg_fetch_row($result);

/* Recuperar los valores del formulario en caso de error: */
if (isset($_SESSION['datos_form'])){
$datos = $_SESSION['datos_form'];
//Borrar la variable de sesion que se crea
unset($_SESSION['datos_form']);}
?>
<script type='text/javascript' 	 src='../../js/funciones.js'></script>
            <center><h2>Modificar Cuenta (Tutor)</h2></center><br>
            <form <?php echo "action='../../archivosphp/ManttoDocente.php?id=$id&operacion=2&pag=1'" ?>  method="post">
            <center>
            <table width="40%"  class="marco">
            <tr>
            <td height="35">Escuela: </td>
            <td> 
             <input name="escuela" type="text" id="escuela" value="<?php if(isset($datos["escuela"])) echo $datos["escuela"]; else echo $docentes[5];?>" class="disabled" readonly="readonly" />
            </td>
            </tr>
            <tr>
            <td  height="35">Usuario: </td>
            <td>
            <input type="text" name="usuario" id="usuario" class=":required :only_on_submit" value="<?php if(isset($datos["usuario"])) echo $datos["usuario"]; else echo $docentes[0];?>" /></td>
            </tr>
            <tr>
            <td  height="35">Nombre: </td>
            <td><input type="text" name="nombred" id="nombred" class=":required :only_on_submit" value="<?php if(isset($datos["nombred"])) echo $datos["nombred"]; else echo $docentes[1];?>"></td>
            </tr>	
            <tr>
            <td  height="35">Email:</td>
            <td>
            <input type="text" name="emaild" id="emaild" class=":required :email :only_on_submit" value="<?php if(isset($datos["emaild"])) echo $datos["emaild"]; else echo $docentes[2];?>"/></td>
            </tr>
            <tr>
            <td  height="35">Telef&oacute;no:</td>
            <td>
            <input name="telefonod" type="text" id="telefonod" class=":required :number :only_on_submit"  size="8" maxlength="8" onMouseOver="toolTip('Ingrese numero tel\xe9fonico sin guiones',this)" value="<?php if(isset($datos["telefonod"])) echo $datos["telefonod"]; else echo $docentes[3];?>" />
            <tr>
            <td height="35">Contrase&ntilde;a:</td>
            <td><input type="password" name="clave1" id="clave1" value="<?php if(isset($datos["clave2"])) echo $datos["clave2"]; else echo $docentes[4];?>" class=":required :min_length;6 :only_on_submit" /></td>
            </tr>
            <tr>
            <td height="35">Confirmar Contrase&ntilde;a: </td>
            <td>
            <input type="password" name="clave2" id="clave2" value="<?php if(isset($datos["clave2"])) echo $datos["clave2"]; else echo $docentes[4];?>" class=":required :same_as;clave1  :only_on_submit" /></td>
            </tr>	
            </table>
            <br>
            <input type="submit" name="buton" class="buton" id="buton" value="Guardar" />
            <input type="button" name="buton2" class="buton" value="Cancelar" <?php echo  "onclick=\"location.href='../Inicio/plantilla_pagina.php'\""; ?> />
            <br>
            </center>
            </form>
            <span id="toolTipBox"></span>
                
<?php
include "../../librerias/pie.php";
include "../../librerias/cerrar_conexion.php";
?>
