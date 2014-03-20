<?php
include "../../librerias/cabecera.php";
$idproyecto=$_GET['id'];
$idalumno=$_GET['aid'];

if(isset($_REQUEST['Aceptar'])){   

	
	echo "<script languaje='javascript'> 
		alert('Proyecto Asignado');
		window.location = '../paginas/Inicio/plantilla_pagina.php';
	  </script>";
}   
else{                      
	if(isset($_REQUEST['Cancelar'])){
		echo "<script languaje='javascript'> 
		window.location = '../paginas/Inicio/plantilla_pagina.php';
	  </script>";
	}
	else {?>
		<script type="text/javascript" 	 src="../js/funciones.js"></script>
		<center><h2>Confirme asignaci&oacute;n de Proyecto</h2></center>
		<br>
		<form method="post" action="confirmaasignacion" accept-charset="LATIN1" >
		<center>
		<table width="40%"  class="marco">
			<tr>
				<td  height="35">Proyecto: </td>
				<td></td>
			</tr>
			<tr>
				<td  height="35">Alumno: </td>
				<td></td>
			</tr>
               </table>
		<br>
		<input type="submit" name="Aceptar" class="buton" value="Aceptar">
		<input type="submit" name="Cancelar" class="buton" value="Cancelar">
		</center>
		</form>	
	<?php }
}

include "../../librerias/pie.php";
?>