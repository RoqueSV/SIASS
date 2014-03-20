<?php
session_start();
include "../../librerias/abrir_conexion.php";

/* Bloque seguridad */
if (!(isset($_SESSION['TYPEUSER']))) {
header("Location: ../../paginas/Inicio/frmAccesoDenegado.php");
exit(); 
}
else if (!($_SESSION['TYPEUSER']==6)) {
session_destroy();
header("Location: ../../paginas/Inicio/frmAcceso.php");
exit();    
}
 /* **********    */

$idalumno=$_SESSION['IDUSER'];
$instruccion = "select a.idalumno, a.idCarrera from alumno as a where a.idalumno NOT IN (SELECT sp.idalumno FROM solicitud_proyecto as sp WHERE sp.estado='P') AND a.idalumno NOT IN (SELECT ap1.idalumno FROM alumno_proyecto as ap1 WHERE ap1.estadoalumnoproyecto='P' OR ap1.estadoalumnoproyecto='L') AND a.idalumno NOT IN(SELECT h.idalumno FROM hace as h INNER JOIN propuesta_proyecto as pp ON h.idpropuesta=pp.idpropuesta WHERE pp.estadoProp='P') AND a.idalumno=$idalumno";

$consulta_alumnos = pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta de alumnos sin proyecto!!</SPAN>".pg_last_error());
if(pg_num_rows($consulta_alumnos)<>1){
include "plantilla_fondo2.php";
	echo "    
        <script language='JavaScript'>
        alert('No puedes hacer propuestas, si ya hiciste una o estas participando en un proyecto');
        window.location = '../../paginas/Inicio/plantilla_pagina.php';
        </script>";
}
$band=0;
include "../../librerias/cabecera.php";
?>
<script type='text/javascript'>
function valida_equipo(valor){
	val=valor
	if(val>1){
		formpropuesta.equipo.style.visibility='visible';
	}
	if(val==1){
		formpropuesta.equipo.style.visibility='hidden';
	}
}
</script>
<center> <h2>NUEVA PROPUESTA DE PROYECTO</h2><p style="font-size: 11px;">(Esta propuesta se te(les) asignar&aacute; automaticamente si se aprueba)</p></center>
<form id="formpropuesta" name="formpropuesta" action="../../archivosphp/ManttoPropuestaAlumno.php?operacion=1&id=<?php echo $idalumno ?>" enctype="multipart/form-data" method="post">
<center>
   <table width="63%"  class="marco">
     <tr>
		<td>Nombre:</td>
		<td  height="35"> <input type="text" size="40" name="nomProyecto" id="nomProyecto" class=":required :only_on_submit"/></td>  
     </tr>
     <tr> 
       <td width="35">Instituci&oacute;n: </td>
       <td>
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
		 <td width="35">Otra: </td> 
		 <td><br> <input type="text" size="40" name="institucion2" id="institucion2" /><p style="font-size: 9px;">(Si no esta en la lista)</p></td>  
         <label for="institucion2"></label></td>
    </tr>
    <tr>
       <td  height="35">Descripci&oacute;n: </td>
       <td><label for="descripcion"></label>
       <Textarea  maxlength=150 rows=2 cols=35 id="descripcion" name="descripcion" class=":required :only_on_submit" onMouseOver='toolTip("Ir a la primera pagina",'this')>
	   </Textarea>
      </tr>
     <tr>
       <td  height="35">Estudiantes Requeridos: </td>
       <td><input type="text" name="estRequeridos" id="estRequeridos" class=":required :only_on_submit :number" maxlength="2" onchange="valida_equipo(this.value)"/></td>
    </tr> 
	<tr> 
       <td width="35">Carrera(s): </td>
       <td width="68%"><br>
         <select name="carrera" id="carrera" ">
         
         <?php 
        $instruccion = "SELECT idcarrera,nombrecarrera FROM carrera ORDER BY 1";
	$consulta = pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en la consulta carrera!!</SPAN>".pg_last_error());
	while($opciones = pg_fetch_array($consulta)){
	if($row[1]== $opciones[0])
		echo"<option value='".$opciones[0]."' selected='selected'>".$opciones[1]."</option>";
	else
		echo"<option value='".$opciones[0]."'>".$opciones[1]."</option>";
	}
	?> 
	<option value="*">*</option>
         </select><p style="font-size: 11px;">(Elige * si aplica para cualquier carrera)</p>
	</tr>
    <tr>   
	   <td  height="35">Duraci&oacute;n: </td>
	   <td><br><input type="text" name="duracion" id="duracion" class=":required :only_on_submit :number :advice" maxlength="2"><p style="font-size: 11px;">(Meses)</p></td>  </td>
	 </tr>
     <tr>
       <td  height="35">Contacto:</td>
       <td><label for="contacto"></label>
         <input type="text" size="40" name="contacto" id="contacto"  class=":required :only_on_submit" /></td>
	</tr>
	<tr>
       <td  height="35">Correo:</td>
       <td><label for="correo"></label>
         <input type="text" size="40" name="correo" id="correo" class=":required :only_on_submit :email"></input></td>
    </tr>
    <tr>
       <td  height="35">Equipo de trabajo:</td>
       <td>
         <br><input type="text" size="40" name="equipo" id="equipo" size="70" placeholder="separados por coma (,)" /><p style="font-size: 11px;">Si ya tienes equipo. Ingresa el carnet</p></td>
	</tr>
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
