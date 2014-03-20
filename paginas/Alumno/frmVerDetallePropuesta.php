<?php

include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";
include '../../librerias/crearWord/FuncionesPHP.php';

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

$proyecto=$_GET['id'];
$detalle_proyecto = "
	SELECT
	nomProyecto,
	nomInstitucion,
	descripcionPropuesta,
        estudiantesrequeridos,
        duracionestimada,
	comentarioprop
	FROM 
        Propuesta_proyecto
	WHERE idpropuesta = '$proyecto'";

$consulta_proyecto = pg_query($detalle_proyecto) or die ("<SPAN CLASS='error'>Fallo en consulta_proyecto!!</SPAN>".pg_last_error());
$resultado_proyecto = pg_fetch_array($consulta_proyecto);
$participantes = pg_query("select nombrealumno||' '||apellidosalumno nombre
from alumno natural join hace natural join propuesta_proyecto
where idpropuesta=$proyecto");
?>  
<style>.tinytable{width: 50%;}</style>
<h2 align="center">DETALLES DE PROYECTO</h2>

	<table class="tinytable" align="center">
	<thead><tr><th colspan="2"><h3>INFORMACION</h3></tr></thead>
		<?php
		echo"
		<tr>
                  <td id='tdr' width='40%'><b>NOMBRE:</b></td>
                  <td id='tdl'>".$resultado_proyecto['nomproyecto']."</td>
                </tr>
		<tr>
                  <td id='tdr'><b>INSTITUICION:</b></td>
                  <td id='tdl'>".$resultado_proyecto['nominstitucion']."</td>
                </tr>
		<tr>
                  <td id='tdr'><b>DESCRIPCION:</b></td>
                  <td id='tdl'>".$resultado_proyecto['descripcionpropuesta']."</td>
                </tr>
                <tr>
                  <td id='tdr'><b>ESTUDIANTES REQUERIDOS:</b></td>
                  <td id='tdl'>".$resultado_proyecto['estudiantesrequeridos']."</td>
                </tr>
                <tr>
                  <td id='tdr'><b>DURACION ESTIMADA:</b></td>
                  <td id='tdl'>".$resultado_proyecto['duracionestimada']."  meses</td>
                </tr>";
                if (pg_num_rows($participantes)>1){
                echo"<tr>
                  <td id='tdr'><b>PARTICIPANTES:</b></td>
                  <td id='tdl'>";
                while($row=pg_fetch_array($participantes))        
                echo $row['nombre'],"<br/>"; 
                echo "</td>
                </tr>";
                }
		echo "<tr>
                  <td id='tdr'><b>OBSERVACIONES:</b></td>
                  <td id='tdl'>".$resultado_proyecto['comentarioprop']."</td> 
               </tr>";
		
		?>	
	</table>
        <br/>
        <center>
        <input type="button" class="buton" name="regresar" value="Regresar" onclick="document.location.href='frmRevisionPropuesta.php?idalum=<?php echo $_SESSION['IDUSER']; ?>'"/>
        </center>

<?php      
include "../../librerias/cerrar_conexion.php";
include "../../librerias/pie.php";
?>



