<?php
include "../../librerias/cabecera.php";
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
if($row=pg_num_rows($consulta_alumnos)<>1){
    include "../../archivosphp/plantilla_fondo.php";
	echo "    
        <script language='JavaScript'>
        alert('No puedes hacer propuestas, si ya hiciste una o estas participando en un proyecto');
        window.location = '../../paginas/Inicio/plantilla_pagina.php';
        </script>";
}

 
/////////////////////////
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
