<?php
include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";
$proyecto=$_GET['id'];
$detalle_proyecto = "
	SELECT
	pr.nomProyecto,
	pr.nominstitucion,
	pr.descripcionPropuesta,
	pr.estudiantesrequeridos,
	pr.duracionestimada

	FROM proyecto p, Propuesta_proyecto pr, se_convierte sc
	WHERE p.idproyecto=sc.idproyecto AND sc.idpropuesta=pr.idpropuesta AND p.idproyecto = '$proyecto'";

$consulta_proyecto = pg_query($detalle_proyecto) or die ("<SPAN CLASS='error'>Fallo en consulta_proyecto!!</SPAN>".pg_last_error());
$resultado_proyecto = pg_fetch_array($consulta_proyecto);
?>  
<script type='text/javascript' 	 src='../../js/funciones.js'></script>
<style>.tinytable{width: 50%;}</style>
<h2 align="center">DETALLES DE PROYECTO</h2>


	<form method="post" <?php echo "action=\"../../archivosphp/ManttoSolicitud.php?id=$proyecto&operacion=1\""; ?> name="frmapproy1" id="frmapproy1">
	<table class="tinytable" align="center">
	<tr><thead><th colspan="2"><h3>PROYECTO</h3></thead></tr>
		<?php
		echo"
		<tr><td id='tdr' width='40%'><b>NOMBRE:</b></td><td id='tdl'>".$resultado_proyecto['0']."</td></tr>
		<tr><td id='tdr'><b>INSTITUICION:</b></td><td id='tdl'>".$resultado_proyecto['1']."</td></tr>
		<tr><td id='tdr'><b>DESCRIPCION:</b></td><td id='tdl'>".$resultado_proyecto['2']."</td></tr>
		<tr><td id='tdr'><b>ESTUDIANTES REQUERIDOS:</b></td><td id='tdl'>".$resultado_proyecto['3']."</td></tr>
		<tr><td id='tdr'><b>DURACION ESTIMADA (Meses):</b></td><td id='tdl'>".$resultado_proyecto['4']."</td></tr>
		<BR>
		<tr><td id='tdr'><b>ENVIAR COMENTARIOS:</b></td><td id='tdl'><Textarea  maxlength=150 rows=2 cols=35 id='comentario' name='comentario' class=':only_on_submit' onMouseOver='toolTip('Ir a la primera pagina',this)'></Textarea></td></tr>
		";
		?>
		</table>
		<BR>
		<CENTER>
		<input type="submit" name="buton1" class="buton" value="Aplicar" />
		<input type="button" name="buton2" class="buton" value="Cancelar" <?php echo  "onclick=\"location.href='frmConsultarDisponible.php'\""; ?> />
		</center>
	</form>


<span id='toolTipBox'></span>
<?php      
include "../../librerias/cerrar_conexion.php";
include "../../librerias/pie.php";
?>
