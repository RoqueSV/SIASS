<?php
include "../../librerias/cabecera.php";

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

<h2>Gesti&oacute;n de Archivos</h2>

<form   action="../../archivosphp/ManttoArchivos.php?operacion=1" method="post" enctype="multipart/form-data">
  <table  width="55%" align="center" class="marco">
    <tr>
	<td height="35">Nombre Documento:</td>
	<td><input type="text" name="nombre" id="nombre"  size="40" class=":required :only_on_submit"/></td>
    </tr>
    <tr>
     <td height="35">Seleccionar Documento:</td>
     <td> 
     <input type="hidden" name="max_file_size" value='7340032'>
     <input type="file" name="archivo" id="archivo" class=":required"/>
     </td>  
     </tr>
  </table>
<br>
<center>
<input type="submit" name="buton" class="buton" value="Guardar" />
<input type="button" name="buton2" class="buton" value="Cancelar" <?php echo  "onclick=\"location.href='../Inicio/plantilla_pagina.php'\""; ?> />
</center>

</form>

<?php
include "../../librerias/pie.php";
?>
