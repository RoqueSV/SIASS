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
	estadoProyecto,
	comentarioProp
	FROM 
        solicitud_proyecto sp join proyecto p on (sp.idproyecto=p.idproyecto) 
        join se_convierte sc on (p.idproyecto=sc.idproyecto)
        join Propuesta_proyecto pp on (sc.idpropuesta=pp.idpropuesta)
	WHERE p.idproyecto = '$proyecto'";

$consulta_proyecto = pg_query($detalle_proyecto) or die ("<SPAN CLASS='error'>Fallo en consulta_proyecto!!</SPAN>".pg_last_error());
$resultado_proyecto = pg_fetch_array($consulta_proyecto);

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
                </tr>
				  <tr>
                  <td id='tdr'><b>OBSERVACION:</b></td>
                  <td id='tdl'>".$resultado_proyecto['comentarioprop']."</td>
                </tr>
		<tr>
                  <td id='tdr'><b>ESTADO PROYECTO:</b></td>
                  <td id='tdl'>";
                  if($resultado_proyecto['estadoproyecto']=='D')
                  echo "Disponible";
                  if($resultado_proyecto['estadoproyecto']=='C')
                  echo "Pendiente aprobaci&oacute;n"; 
                  if($resultado_proyecto['estadoproyecto']=='P')
                  echo "En proceso";
                  if($resultado_proyecto['estadoproyecto']=='F')
                  echo "Finalizado";
                  if($resultado_proyecto['estadoproyecto']=='L')
                  echo "Detenido";
                  if($resultado_proyecto['estadoproyecto']=='B')
                  echo "De baja";
				  if($resultado_proyecto['estadoproyecto']=='A')
                  echo "Asignado";
                  echo "</td> </tr>";
		
		?>	
	</table>
        <br/>
        <center>
        <?php 
        $pagina = $_GET['pag'];
        if ($pagina==1){?>
        <input type="button" class="buton" name="regresar" value="Regresar" onclick="document.location.href='frmRevisionSolicitud.php'"/>
        <?php
        } else {?>
        <input type="button" class="buton" name="regresar" value="Regresar" onclick="document.location.href='frmVerificarCertificacion.php'"/>    
        <?php } ?> 
        </center>

<?php      
include "../../librerias/cerrar_conexion.php";
include "../../librerias/pie.php";
?>


