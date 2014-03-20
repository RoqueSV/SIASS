<?php
include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";

include "../../js/editor/sample/editor_HS.php";


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

$datosDoc = pg_fetch_array(pg_query("select * from datos_documento where idalumno=".$_SESSION['IDUSER']." and iddocumento='".$_GET['iddoc']."';"));

?>
<link rel="stylesheet" href="../../js/editor/sample/sample.css">
<script src="../../js/editor/ckeditor.js"></script>
<style>.tinytable{width: 95%;}</style>
<center>

<?php 
if($datosDoc['tipodocumento']=="M")
echo '<b><p style = "font-size:16px">INGRESO DE ACTIVIDADES MEMORIA DE LABORES</p></b>';
if($datosDoc['tipodocumento']=="P")
echo '<b><p style = "font-size:16px">INGRESO DE PLAN DE TRABAJO</p></b>';
?>

<table border="0" class='tinytable'>
<tr><thead>
<th width="50%"><h3>Proyecto: </h3></th>
<th width="30%"><h3>Docente Tutor:</h3></th>
<th width="10%"><h3>Actualizaci&oacute;n: </h3></th>
<th width="10%"><h3>Creaci&oacute;n:</h3></th>
</thead></tr>
<tr><td><?php echo $datosDoc['NombreProyecto'];?> </td><td align="left"><a href="mailto:<?php echo $datosDoc['emaildocente'];?>"><?php echo $datosDoc['NombreDocente'];?></a></td><td><?php echo $datosDoc['FechaActualizacion'];?></td><td align="left"><?php echo $datosDoc['FechaCreacion'];?></td></tr>
</table>
<p style = "font-size:12px">- Puede editar sobre el cuadro de texto &oacute; hacerlo en un editor de texto avanzado*(MS Word &oacute; Writer de LibreOffice) y luego pegar su contenido.<br>
 * Recursos como imagenes, debera copiarlas directamente sobre el cuadro de texto, desde su ubicacion en el computador.</p>
<form action="../../archivosphp/ManttoDocumento.php?operacion=2" enctype="multipart/form-data" method="post"> <!-- operacion=2 actualizar-->
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
		</td>
		</tr>
    </table>
 
 <input type="submit" class="buton" name="buton" id="buton" value="Guardar" />
 <br>
 
</form>

<?php
include "../../librerias/pie.php";
include "../../librerias/cerrar_conexion.php";
?>
