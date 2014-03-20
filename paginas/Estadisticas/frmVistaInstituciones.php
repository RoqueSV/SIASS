<?php
include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";
include '../../librerias/crearWord/FuncionesPHP.php';
// $proyecto=$_GET['id'];
$institucion=$_GET['id'];


$sql_inst="SELECT i.idInstitucion, i.nombreInstitucion, i.nombreContacto, i.telefonoContacto, i.emailContacto,
(SELECT count(ppr.idInstitucion) FROM propuesta_proyecto ppr WHERE estadoProp='A' AND idInstitucion=i.idInstitucion) aprobadas, 
(SELECT count(ppr2.idInstitucion) FROM propuesta_proyecto ppr2 WHERE ppr2.idInstitucion=i.idInstitucion and ppr2.idpropuesta not in(select idpropuesta from hace)) propuestas, 
(SELECT count(p2.idProyecto) FROM proyecto p2 INNER JOIN se_convierte sc2 ON p2.idProyecto=sc2.idProyecto INNER JOIN Propuesta_proyecto pp2 ON sc2.idPropuesta=pp2.idPropuesta
 WHERE sc2.idProyecto=p2.idProyecto AND p2.estadoProyecto='P' AND pp2.idInstitucion=i.idInstitucion) enproceso  
FROM institucion i  WHERE i.idInstitucion='$institucion'";

$consulta_proyecto = pg_query($sql_inst) or die ("<SPAN CLASS='error'>Fallo en consulta_proyecto!!</SPAN>".pg_last_error());
$resultado_institucion = pg_fetch_array($consulta_proyecto);

?>  
<style>.tinytable{width: 50%;}</style>
<h2 align="center">DETALLES DE PROYECTOS DE INSTITUCION</h2>

	<table class="tinytable" align="center">
	<thead><tr><th colspan="2"><h3>INFORMACION</h3></tr></thead>
		<?php
		echo"
		<tr>
                  <td id='tdr' width='40%'><b>INSTITUCION:</b></td>
                  <td id='tdl'>".$resultado_institucion[1]."</td>
                </tr>
		<tr>
                  <td id='tdr'><b>CONTACTO:</b></td>
                  <td id='tdl'>".$resultado_institucion['2']."</td>
                </tr>
		<tr>
                  <td id='tdr'><b>TELEFONO/EMAIL</b></td>
                  <td id='tdl'>".$resultado_institucion['3']."/<a href='mailto:".$resultado_institucion[4]."'>".$resultado_institucion['4']."</a></td>
                </tr>
		<tr>
                  <td id='tdr'><b>PROPUESTAS REALIZADAS:</b></td>
                  <td id='tdl'>".$resultado_institucion['propuestas']."</td>
                </tr>
                <tr>
                  <td id='tdr'><b>ACEPTADAS:</b></td>
                  <td id='tdl'>".$resultado_institucion['aprobadas']."</td>
                </tr>
				<tr>
                  <td id='tdr'><b>EN PROCESO:</b></td>
                  <td id='tdl'>".$resultado_institucion['enproceso']."</td>
                </tr>";
		
		?>	
	</table>
        <br/>
        <center>
        <input type="button" class="buton" name="inicio" value="Regresar" onclick="javascript:history.back(1)"/>
        </center>

<?php      
include "../../librerias/cerrar_conexion.php";
include "../../librerias/pie.php";
?>

