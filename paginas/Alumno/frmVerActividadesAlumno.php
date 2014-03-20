<?php
include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";

/* Bloque seguridad */
if (!(isset($_SESSION['TYPEUSER']))) {
header("Location: ../../paginas/Inicio/frmAccesoDenegado.php");
exit(); 
}
else if (!($_SESSION['TYPEUSER']==4 OR $_SESSION['TYPEUSER']==2)) {
session_destroy();
header("Location: ../../paginas/Inicio/frmAcceso.php");
exit();    
}
 /* **********    */

include "../../js/editor/sample/editor_HS.php";

$datosDoc = pg_fetch_array(pg_query("select * from datos_documento  where idalumno=".$_GET['idalum']." and iddocumento='".$_GET['iddoc']."';"));
$alumno = pg_fetch_array(pg_query("select nombrealumno||' '||apellidosalumno from alumno where idalumno=".$datosDoc['idalumno']));
$proyecto =  pg_fetch_array(pg_query("select idproyecto from alumno_proyecto where idalumno=".$_GET['idalum']));
?>
<link rel="stylesheet" href="../../js/editor/sample/sample.css">
<script src="../../js/editor/ckeditor.js"></script>
<style>.tinytable{width: 95%;}</style>
<center>

<?php 
if($datosDoc['tipodocumento']=="M")
echo '<b><p style = "font-size:16px">REVISION DE ACTIVIDADES - MEMORIA DE LABORES</p></b>';
if($datosDoc['tipodocumento']=="P")
echo '<b><p style = "font-size:16px">REVISION DEL PLAN DE TRABAJO</p></b>';
?>

<table border="0" class='tinytable'>
<thead><tr>
<th width="50%"><h3>Proyecto: </h3></th>
<th width="30%"><h3>Alumno:</h3></th>
<th width="10%"><h3>Actualizaci&oacute;n: </h3></th>
<th width="10%"><h3>Creaci&oacute;n:</h3></th>
</tr></thead>
<tr><td><?php echo $datosDoc['NombreProyecto'];?> </td><td align="left"><a href="mailto:<?php echo $datosDoc['emailalumno']; ?>"> <?php echo $alumno[0];?></a></td><td><?php echo $datosDoc['FechaActualizacion'];?></td><td align="left"><?php echo $datosDoc['FechaCreacion'];?></td></tr>
</table>
<p style = "font-size:12px">- Puede editar sobre el cuadro de texto &oacute; hacerlo en un editor de texto avanzado*(MS Word &oacute; Writer de LibreOffice) y luego pegar su contenido.<br>
 - Recursos como imagenes, debera copiarlas directamente sobre el cuadro de texto, desde su ubicacion en el computador.</p>
<form action="../../archivosphp/ManttoActualizarDocumento.php?operacion=2" enctype="multipart/form-data" method="post"> <!-- operacion=2 actualizar-->
    <table width="95%">
        <tr>
        <td><textarea class="ckeditor" name="nombred" cols="50" id="mlabores" rows="20" >
		<?php
		$query="select nombredocumento from documento where iddocumento=".$_GET['iddoc'].";";
		//echo $query;
		$resul1 = pg_query($query) or die("No se pudo realizar la consulta (obtener documento de Memoria Labores)");
		$resul2 = pg_fetch_array($resul1);
		echo $resul2[0];
		
		?>
		</textarea>
		<input type="hidden" name="iddocumento" id="iddocumento" value="<?php echo $_GET['iddoc']?>">
                <input type="hidden" name="idproyecto" id="idproyecto" value="<?php echo $proyecto[0] ?>">
                <input type="hidden" name="idalumno" id="idalumno" value="<?php echo $_GET['idalum'] ?>">
		</td>
		</tr>
    </table>
 <br/>
 <?php
 if($_SESSION['TYPEUSER']==2){
 echo'
 <input type="button" class="buton" name="return" value="Regresar" onclick="document.location.href=\'../Emision_Documentos/frmDetalleAlumnoCoor.php?id='.$_GET['idalum'].'&op='.$_GET['op'].'\'"/>   
 </form>'; 
}
else{
 if($datosDoc['tipodocumento']=="M"){
 $horas = pg_fetch_array(pg_query("select horas from alumno_proyecto where idalumno=".$_GET['idalum']." and idproyecto='".$proyecto[0]."';")); ?>
 
 <table>
     <tr>
         <td><b>Horas obtenidas:</b></td>
         <td><input type="text" name="horas" id="horas" value="<?php echo $horas[0]; ?>" class=":number :only_on_submit"/></td>
     </tr>  
 </table>
 <?php } ?>
 <br>
 <input type="submit" class="buton" name="buton" id="buton" value="Guardar" />
 <input type="button" name="buton" class="buton" value="Regresar"  <?php echo  "onclick=\"location.href='../Docente/frmDetalleAlumno.php?id=".$_GET['idalum']."'\""; ?>/>
 <br>
</form>

<?php
}
include "../../librerias/pie.php";
include "../../librerias/cerrar_conexion.php";
?>

