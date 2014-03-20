<?php
include "../../librerias/cabecera.php";
?>
<script type="text/javascript" 	 src="../../js/funciones.js"></script>
<center><h2>Propuesta de Proyecto</h2></center>
<br>
		<form method="post" action="../../archivosphp/ManttoPropuesta_proyecto.php?operacion=1&" name="frm_propuestaproyecto" id="frm_propuestaproyecto">
		<center>
		<table width="40%"  class="marco">
			<tr height="35">
				<td>Nombre Proyecto: </td>
				<td><input type="text" name="nombrep" id="nombrep" class=":required :only_on_submit"></td>
			</tr>
			<tr>
        		<td height="35">Descripci�n </td>
                <td>
                 <input type="text" name="descripcionp" id="descripcionp" class=":required :only_on_submit">
                 </select>   
                </td>
        	</tr> 
			<tr height="35">
              	<td>Institucion: </td>
                <td><select name="institucion" id="institucion" class=":required :only_on_submit" >
                <option value="" selected="selected">Seleccionar..</option>
                <?php
                include "../../librerias/abrir_conexion.php";
                $consulta ="select idinstitucion, nombreinstitucion from institucion;";
                $resultado= pg_query($consulta) or die ("<SPAN CLASS='error'>Fallo en consulta!!</SPAN>".pg_last_error());
                while($row=  pg_fetch_array($resultado)){
                echo"<option value=".$row[0].">".$row[1]."</option>";
                }
                include "../../librerias/cerrar_conexion.php";
                ?>
                </select>
				</td>
			</tr>
			<tr>
				<td height="35">Debes incluir un plan de trabajo para tu propuesta</td>
			</tr>
			<tr>
				<td height="35">Seleccionar Plan de Trabajo:</td>
				<td> <input type="file" name="plan" id="plan" class=":required"/></td>  
			</tr>
			
			
        	
        </table>
		<br>
		<input type="submit" name="buton" class="buton" value="Enviar">
		</center>
		</form>

<?php
include "../../librerias/pie.php";
?>
