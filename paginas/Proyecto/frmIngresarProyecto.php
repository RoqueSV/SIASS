<?php
include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";

/* Bloque seguridad */
if (!(isset($_SESSION['TYPEUSER']))) {
header("Location: ../../paginas/Inicio/frmAccesoDenegado.php");
exit(); 
}
else if (!($_SESSION['TYPEUSER']==1)) {
session_destroy();
header("Location: ../../paginas/Inicio/frmAcceso.php");
exit();    
}
 /* **********    */

?>
<script type="text/javascript" 	 src="../../js/funciones.js"></script>
<center><h2>Nueva Propuesta de Proyecto</h2><p style="font-size: 11px;">Este proyecto no necesita aprobaci&oacute;n</p></center>
<br>
		<form method="post" action="../../archivosphp/ManttoPropuestaJefe.php?operacion=1" name="frm_proyecto" id="frm_proyecto">
		<center>
		   <table width="63%"  class="marco">
			 <tr>
				<td height="35">Nombre:</td>
				<td> <input type="text" name="nomProyecto" id="nomProyecto" class=":required :only_on_submit"/></td>  
			 </tr> 
			 <tr> 
			   <td height="35" width="29%">Instituci&oacute;n: </td>
			   <td width="68%">
				 <select name="institucion" id="institucion" >
				 <option value="" selected="selected"  ></option>  
				 <?php 
				$instruccion = "SELECT idinstitucion,nombreinstitucion FROM institucion ORDER BY 1";
			$consulta = pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en la consulta institucion!!</SPAN>".pg_last_error());
			while($opciones = pg_fetch_array($consulta)){
			echo"
			<option value='".$opciones[0]."-".$opciones[1]."'>".$opciones[1]."</option>";
			}
			?> 
				 </select>
			</tr>
			<tr>
				 <td height="35" width="35%">Otra: </td> 
				 <td><br> <input type="text" size="30" name="institucion2" id="institucion2" /><p style="font-size: 9px;">(Si no esta en la lista)</p></td>  
				 <label for="institucion2"></label></td>
			</tr>
			<tr>
			   <td height="35">Descripci&oacute;n: </td>
			   <td><label for="descripcion"></label>
			   <Textarea  maxlength=150 rows=2 cols=35 id="descripcion" name="descripcion" class=":required :only_on_submit" onMouseOver='toolTip("Ir a la primera pagina",'this')>
			   </Textarea>
			  </tr>
			 <tr>
			   <td height="35">Estudiantes Requeridos: </td>
			   <td><input type="text" name="estRequeridos" id="estRequeridos" class=":required :only_on_submit :number"/></td>
			</tr> 
			<tr> 
			   <td height="35" width="29%">Carrera(s): </td>
			   <td width="68%"><br>
				 <select name="carrera" id="carrera" ">
				 <option value="" selected="selected"  ></option>  
				 <?php 
				$instruccion = "SELECT idcarrera,nombrecarrera FROM carrera ORDER BY 1";
			$consulta = pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en la consulta carrera!!</SPAN>".pg_last_error());
			while($opciones = pg_fetch_array($consulta)){
			echo"
			<option value='".$opciones[0]."'>".$opciones[1]."</option>";
			}
			?> 
			<option value="*">*</option>
				 </select><p style="font-size: 9px;">(Elige * si aplica para cualquier carrera)</p>
			</tr>
			<tr>   
			   <td height="35">Duraci&oacute;n: </td>
			   <td><br><input type="text" name="duracion" id="duracion" class=":required :only_on_submit :number"><p style="font-size: 9px;">(Meses)</p></td>  </td>
			 </tr>
			 <tr>
			   <td height="35">Contacto:</td>
			   <td><label for="contacto"></label>
				 <input type="text" name="contacto" id="contacto" class=":required :only_on_submit" /></td>
			</tr>
			<tr>
			   <td height="35">Correo:</td>
			   <td><label for="correo"></label>
				 <input type="text" name="correo" id="correo" class=":required :only_on_submit :email"></input></td>
			</tr>
			<tr>
			   <td  height="35">Comentario:</td>
			   <td><label for="comentario"></label>
				 <textarea name="comentario" id="comentario" class=":required :only_on_submit" cols="45" rows="2"></textarea></td>
			   </td>
			 </tr>
			 <!--<tr> 
			   <td height="35" width="29%">Estado del proyecto: </td>
			   <td width="68%"><br>
				 <select name="estadoi" id="estadoi" >
				 <option value="D" selected="selected">Disponible</option>  
				 <option value="A">Asignado</option>  
				 <option value="P">En Proceso</option>  
				 <option value="L">Detenido</option>  
				 </select>
			</tr>-->
		 </table>
		 
		 <br>
		 <input type="submit" class="buton" name="buton" id="buton" value="Enviar" />
		 <br>
		 </center>
		</form>

<?php
include "../../librerias/pie.php";
include "../../librerias/cerrar_conexion.php";
?>
