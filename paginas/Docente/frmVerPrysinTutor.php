<?php
include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";

/* Bloque seguridad */
if (!(isset($_SESSION['TYPEUSER']))) {
header("Location: ../../paginas/Inicio/frmAccesoDenegado.php");
exit(); 
}
else if (!($_SESSION['TYPEUSER']==1 OR $_SESSION['TYPEUSER']==2)) {
session_destroy();
header("Location: ../../paginas/Inicio/frmAcceso.php");
exit();    
}
 /* **********    */


$alumno = $_GET['id'];

$detalle_proyecto = "
	SELECT
        pp.idpropuesta,
        nombrealumno||' '||apellidosalumno nombre,
        ap.idproyecto,
	nomproyecto,
	nominstitucion,
	descripcionpropuesta,
	duracionestimada,
        estudiantesrequeridos
	from alumno a join alumno_proyecto ap on (a.idalumno=ap.idalumno) 
        join proyecto p on (ap.idproyecto=p.idproyecto) 
        join se_convierte sc on (p.idproyecto=sc.idproyecto) 
        join propuesta_proyecto pp on (sc.idpropuesta=pp.idpropuesta)
        where a.idalumno = '$alumno'";

$consulta_proyecto = pg_query($detalle_proyecto) or die ("<SPAN CLASS='error'>Fallo en consulta_proyecto!!</SPAN>".pg_last_error());
$resultado_proyecto = pg_fetch_array($consulta_proyecto);
$proyecto=$resultado_proyecto['idproyecto']; //enviar a mantto tutoria
$estudiantes = pg_fetch_array(pg_query("select count(idproyecto)from Alumno_Proyecto where idproyecto = $proyecto"));
?>
<script type='text/javascript' 	 src='../../js/funciones.js'></script>
<style>.tinytable{width: 50%;}</style>
<h2 align="center">DETALLES DEL PROYECTO</h2>


	<form method="post" <?php echo "action=\"../../archivosphp/ManttoTutoria.php?id=$proyecto&idal=$alumno&operacion=1\""; ?> name="frmtutores" id="frmtutores">
	<table class="tinytable" align="center">
            <thead><tr><th colspan="2"><h3>Selecci&oacute;n de tutor</h3></th></tr></thead>
		<?php
                $idpropuesta=$resultado_proyecto['idpropuesta'];
             
                $consulta_docente ="select iddocente,nombredocente from docente 
                                    where idescuela in (select idescuela from carrera
                                    where idcarrera in (select idcarrera from propuesta_carrera
                                    where idpropuesta=$idpropuesta))and estadodocente='A';";
                $resultado= pg_query($consulta_docente) or die ("<SPAN CLASS='error'>Fallo en consulta de docente!!</SPAN>".pg_last_error());
		echo"
		<tr><td id='tdr' width='200'><b>ALUMNO:</b></td><td id='tdl'>".$resultado_proyecto['nombre']."</td></tr>
                <tr><td id='tdr'><b>PROYECTO:</b></td><td id='tdl'>".$resultado_proyecto['nomproyecto']."</td></tr>
		<tr><td id='tdr'><b>INSTITUCION:</b></td><td id='tdl'>".$resultado_proyecto['nominstitucion']."</td></tr>
		<tr><td id='tdr'><b>DESCRIPCION:</b></td><td id='tdl'>".$resultado_proyecto['descripcionpropuesta']."</td></tr>
                <tr><td id='tdr'><b>No. DE ESTUDIANTES REQUERIDOS:</b></td><td id='tdl'>".$resultado_proyecto['estudiantesrequeridos']."</td></tr>
		<tr><td id='tdr'><b>No. DE ESTUDIANTES ASIGNADOS:</b></td><td id='tdl'>".$estudiantes['0']."</td></tr>
		<tr><td id='tdr'><b>DURACION ESTIMADA (Meses):</b></td><td id='tdl'>".$resultado_proyecto['duracionestimada']."</td></tr>"; ?>
		<tr>
                <td id='tdr'><b>SELECCIONAR TUTOR:</b></td>
                <td id='tdl'>
                     <select name='tutor' id='tutor' class=':required :only_on_submit'>
			<option value='' selected='selected'>Seleccionar..</option>
			<?php
                        while($row=  pg_fetch_array($resultado)){
			echo"<option value=".$row[0].">".$row[1]."</option>";
			}
			?>
		    </select>
                </td>
                </tr>
		</table>
		<br>
		<center>
		<input type="submit" name="buton1" class="buton" value="Asignar" />
		<input type="button" name="buton2" class="buton" value="Cancelar" <?php echo  "onclick=\"location.href='frmProysinTutor.php'\""; ?> />
		</center>
	</form>
<?php      
include "../../librerias/cerrar_conexion.php";
include "../../librerias/pie.php";
?>