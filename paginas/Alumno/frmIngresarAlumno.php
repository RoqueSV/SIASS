<?php

include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";
/*Obtener Fecha Actual
$obtenerfecha = pg_query("select current_date");
$fecha = pg_fetch_array($obtenerfecha);*/
?>

<center> <h2>Apertura de Expediente</h2></center><br>
<form action="../../archivosphp/ManttoAlumno.php?operacion=1" enctype="multipart/form-data" method="post">
<center>
   
   <table width="63%"  class="marco">
     <tr>
     <td height="35">Seleccionar Fotograf&iacute;a:</td>
     <td> <input type="file" name="fotografia" id="fotografia" class=":required"/></td>  
     </tr>
     <tr> 
       <td height="35" width="29%">Carrera: </td>
       <td width="68%">
         <select name="carrera" id="carrera" class=":required :only_on_submit">
         <option value="" selected="selected"></option>  
         <?php 
        $instruccion = "SELECT idcarrera,nombrecarrera FROM carrera ORDER BY 1";
	$consulta = pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en la consulta!!</SPAN>".pg_last_error());
	while($opciones = pg_fetch_array($consulta)){
	echo"
	<option value='".$opciones[0]."'>".$opciones[1]."</option>";
	}
	?> 
         </select>
         <label for="carrera"></label></td>
       </tr>
     <tr>
       <td height="35">Carnet: </td>
       <td><label for="carnet"></label>
         <input type="text" name="carnet" id="carnet" class=":required :only_on_submit"/></td>
       </tr>
     <tr>
       <td height="35">Nombres: </td>
       <td><input type="text" name="nombres" id="nombres" class=":required :only_on_submit"/></td>
       </tr>
     <tr>
       <td height="35">Apellidos: </td>
       <td><input type="text" name="apellidos" id="apellidos" class=":required :only_on_submit"></td>
       </tr>
     <tr>
       <td height="35">Nivel Ac&aacute;demico:</td>
       <td>
        <select name="nivel" size="1" id="cargo" class=":required">
            <option value="Tercer Año">Tercer a&ntilde;o</option>
            <option value="Cuarto Año">Cuarto a&ntilde;o</option>
            <option value="Quinto Año">Quinto a&ntilde;o</option>
            <option value="Egresado">Egresado</option>
         </select>   
       </td>
       </tr>
     <tr>
       <td height="35">% Carrera:</td>
       <td><label for="porcentaje"></label>
         <input type="text" name="porcentaje" id="porcentaje" /></td>
       </tr>
     <tr>
       <td height="35">Direcci&oacute;n:</td>
       <td><label for="direccion"></label>
         <textarea name="direccion" id="direccion" class=":required :only_on_submit" cols="45" rows="2"></textarea></td>
       </tr>
     <tr>
       <td  height="35">Telef&oacute;no:</td>
       <td><label for="telefono"></label>
         <input name="telefono" type="text" id="telefono" class=":phone :only_on_submit"  maxlength=8 />
       </td>
       </tr>
     <tr>
       <td height="35">Email:</td>
       <td><label for="email"></label>
         <input type="text" name="email" id="email" class=":required :email :only_on_submit"/></td>
       </tr>
     <tr>
       <td  height="35">Fecha Apertura:</td>
       <td><label for="fecha"></label>
         <input type="text" name="fecha" id="fecha" disabled="disabled" value='<?php echo date("d-m-Y") ?>'/></td>
       <td width="3%">&nbsp;</td>
       </tr>
 </table>
 
 <br>
 <input type="submit" class="buton" name="buton" id="buton" value="Guardar" />
 <br>
 </center>

</form>
<?php
include "../../librerias/pie.php";
include "../../librerias/cerrar_conexion.php";
?>
