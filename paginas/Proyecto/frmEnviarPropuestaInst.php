<?php
   //session_start ();
include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";

/* Bloque seguridad */
if (!(isset($_SESSION['TYPEUSER']))) {
header("Location: ../../paginas/Inicio/frmAccesoDenegado.php");
exit(); 
}
else if (!($_SESSION['TYPEUSER']==5)) {
session_destroy();
header("Location: ../../paginas/Inicio/frmAcceso.php");
exit();    
}
 /* **********    */

$idinst=$_SESSION['IDUSER'];
?>

<center> <h2>NUEVA PROPUESTA DE PROYECTO</h2><br><p style="font-size: 9px;">(Esta propuesta ser&aacute; enviada para aprobaci&oacute;n)</p></center>
<form id="formpropuesta" name="formpropuesta" action="../../archivosphp/ManttoPropuestaInstitucion.php?operacion=1&id=<?php echo $idinst; ?>" enctype="multipart/form-data" method="post">
<center>
   <table width="63%"  class="marco">
     <tr>
		<td>Nombre:</td>
		<td> <input type="text" size="40" name="nomProyecto" id="nomProyecto" class=":required"/></td>  
     </tr>
    <tr>
       <td>Descripci&oacute;n: </td>
       <td><label for="descripcion"></label>
       <Textarea  maxlength=150 rows=2 cols=35 id="descripcion" name="descripcion" class=":required" onMouseOver='toolTip("Ir a la primera pagina",'this')>
	   </Textarea>
      </tr>
     <tr>
       <td>Estudiantes Requeridos: </td>
       <td><input type="text" name="estRequeridos" id="estRequeridos" class=":required :number" maxlength="2" onchange="valida_equipo(this.value)"/></td>
    </tr> 
	<tr> 
       <td width="29%">Carrera(s): </td>
       <td width="68%"><br>
         <select name="carrera" id="carrera" class="required"> 
         <?php 
        $instruccion = "SELECT idcarrera,nombrecarrera FROM carrera ORDER BY 1";
	$consulta = pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en la consulta carrera!!</SPAN>".pg_last_error());
	while($opciones = pg_fetch_array($consulta)){
	echo"
	<option value='".$opciones[0]."'>".$opciones[1]."</option>";
	}
	?> 
	<option value="*" selected>*</option>
         </select><p style="font-size: 9px;">(Elige * si aplica para cualquier carrera)</p>
	</tr>
    <tr>   
	   <td>Duraci&oacute;n: </td>
	   <td><br><input type="text" name="duracion" id="duracion" class=":required :number :advice" maxlength="2"><p style="font-size: 9px;">(Meses)</p></td>  </td>
	 </tr>
    <!--<tr>
       <td>Comentario:</td>
       <td><label for="comentario"></label>
         <textarea name="comentario" id="comentario" class=":required :only_on_submit" cols="45" rows="2"></textarea></td>
       </td>
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
