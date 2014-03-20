<?php
include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";
include '../../librerias/crearWord/FuncionesPHP.php';
$proyecto=$_GET['id'];
$detalle_proyecto = "
	SELECT
	distinct nomProyecto,
	nomInstitucion,
	descripcionPropuesta,
	estadoProyecto,
        (select min(iniciotutoria) from tutoria_alumno tta
        join tutoria tt on tta.idtutoria=tt.idtutoria
        where tt.idproyecto=p.idproyecto) iniciotutoria,
        (select max(fintutoria) from tutoria_alumno tta 
        join tutoria tt on tta.idtutoria=tt.idtutoria 
        join proyecto pp on tt.idproyecto=pp.idproyecto
        where pp.estadoproyecto='F' and pp.idproyecto=p.idproyecto) fintutoria
	FROM 
        tutoria_alumno ta join tutoria t on (ta.idtutoria=t.idtutoria)
        right outer join proyecto p on (t.idproyecto=p.idproyecto) 
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
                  <td id='tdr'><b>INICIO PROYECTO:</b></td>
                  <td id='tdl'>";
                 if($resultado_proyecto['iniciotutoria']!=null)
                    echo fecha2letra($resultado_proyecto['iniciotutoria'],1);
                  else echo "---";
                echo " 
                </tr>
                <tr>
                  <td id='tdr'><b>FIN PROYECTO:</b></td>
                  <td id='tdl'>";
                  if($resultado_proyecto['fintutoria']!=null)
                    echo fecha2letra($resultado_proyecto['fintutoria'],1);
                  else echo "---";
                echo "      
                 </td>
                </tr>
		<tr>
                  <td id='tdr'><b>ESTADO PROYECTO:</b></td>
                  <td id='tdl'>";
                  if($resultado_proyecto['estadoproyecto']=='D')
                  echo "Disponible";
                  if($resultado_proyecto['estadoproyecto']=='A')
                  echo "Asignado a alumnos"; 
                  if($resultado_proyecto['estadoproyecto']=='P')
                  echo "En proceso";
                  if($resultado_proyecto['estadoproyecto']=='F')
                  echo "Finalizado";
                  if($resultado_proyecto['estadoproyecto']=='L')
                  echo "Detenido";
                  if($resultado_proyecto['estadoproyecto']=='B')
                  echo "De baja";
                  
                  echo "</td> </tr>";
		
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

