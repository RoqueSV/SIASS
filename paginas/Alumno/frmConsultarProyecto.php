<?php

include "../../librerias/abrir_conexion.php";
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

$idalumno=$_GET['id'];
$nombre_alumno=$_GET['nom'];

$consulta_carrera=pg_query("SELECT idcarrera FROM alumno WHERE idalumno=$idalumno")or die ("<SPAN CLASS='error'>Fallo en consulta de carrera, alumno!!</SPAN>".pg_last_error());
$result_consulta=pg_fetch_array($consulta_carrera);
$idcarrera=$result_consulta[0];

$instruccion = "
SELECT p.idproyecto, pp.nomproyecto, pp.nominstitucion, pp.estudiantesrequeridos, pp.descripcionPropuesta
FROM proyecto p, propuesta_proyecto pp, se_convierte sc,propuesta_carrera pc
WHERE p.idproyecto=sc.idproyecto AND sc.idpropuesta=pp.idpropuesta AND pp.idpropuesta=pc.idpropuesta AND (p.estadoProyecto='D' OR p.estadoProyecto='A') AND pc.idcarrera=$idcarrera";

$consulta_proyectos = pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta de proyectos!!</SPAN>".pg_last_error());
?>

		<script type="text/javascript" 	 src="../../js/funciones.js"></script>
		<style>.tinytable{width: 100%;}</style>
	        
        <form  action="" method="post" accept-charset="LATIN1" name="frmc_usuario" id="frmc_usuario">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
<!------------------------------------------------------------------------------------------------------------------------>
		<tr>
			<td align="center">
           <h2>ASIGNAR PROYECTO A: <?php echo $nombre_alumno;?></h2>
			</td>
		</tr>
		<tr>
			<td align="center">
			<h3>
				Elija un proyecto para asignarlo al alumno
			</h3>
			</td>
		</tr>
<!------------------------------------------------------------------------------------------------------------------------>
		<tr>
			<td>
			<?php					
			$cantidad_proyectos = pg_query("SELECT count(idproyecto) FROM proyecto") or die ("<SPAN CLASS='error'>Fallo la consulta!!</SPAN>".pg_last_error());
			$cantidad = pg_fetch_array($cantidad_proyectos);
			if($cantidad[0] <> 0){
			?>
			<table align="center" class="marco" width="90%">
			<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<tr>
					<td>
						<span class="subtitulo2">Buscar</span>
						<select id="columns" onchange="sorter.search('query')"></select>
						<input type="text" id="query" onkeyup="sorter.search('query')"/>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					<td align="right" class="subtitulo2">
						Registros
						<span id="startrecord"></span>-<span id="endrecord"></span> de <span id="totalrecords"></span>
					</td>
				</tr>
			<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<tr>
					<td height="120" colspan="5" align="center">
					<table cellpadding="0" cellspacing="0" id="table" class="tinytable" width="100%">
						<thead class="titulo1">
					<tr>
						<th onMouseOver="toolTip('Ordenar por proyecto',this)" width="20%"><h3>Proyecto</h3></th>
						<th onMouseOver="toolTip('Ordenar por institucion',this)" width="18%"><h3>Institucion</h3></th>
						<th width="20%"><h3>Descripcion</h3></th>
						<th onMouseOver="toolTip('Ordenar por estudiantes requeridos',this)" width="5%"><h3 style="font-size:11px">Requeridos</h3></th>
						<th onMouseOver="toolTip('Ordenar por estudiantes asigandos',this)" width="5%"><h3 style="font-size:11px">Asignados</h3></th>
						<th onMouseOver="toolTip('Ordenar por solicitudes realizadas',this)" width="5%" ><h3 style="font-size:11px">Solicitudes</h3></th>
					</tr>
						</thead>
						<tbody class="subtitulo2">
							<?php
							while ($proyectos = pg_fetch_array($consulta_proyectos)){
							//consultas del proyecto
							$c_asignados = "SELECT idalumno FROM alumno_proyecto WHERE idproyecto='$proyectos[0]' AND estadoalumnoproyecto='P'";
							$consulta_asignados = pg_query($c_asignados) or die ("<SPAN CLASS='error'>Fallo en consulta de alumos_asignados!!</SPAN>".pg_last_error());
							$est_asignados = pg_num_rows($consulta_asignados);
							
							$c_solicitudes = "SELECT idalumno FROM solicitud_proyecto WHERE idproyecto='$proyectos[0]' AND estado='P'";
							$consulta_solicitudes = pg_query($c_solicitudes) or die ("<SPAN CLASS='error'>Fallo en consulta de solicitudes_alumnos!!</SPAN>".pg_last_error());
							$est_solicitudes = pg_num_rows($consulta_solicitudes);
							//total de alumno que participaran en un proyecto
							$total_proyecto=$est_solicitudes+$est_asignados;
							?>
					<tr align="center">
											<td><?php echo "<a title='Ver Proyecto' style='color: black;' href='javascript:void(0)' onClick=\"parent.PRINCIPAL.location.href='../../archivosphp/confirmaasignacion.php?id=$proyectos[0]&aid=$idalumno&req=$proyectos[3]&num=$total_proyecto'\">".$proyectos[1]."</a>";?></td>
											
											<td><?php echo "<a title='Ver Proyecto' style='color: black;' href='javascript:void(0)' onClick=\"parent.PRINCIPAL.location.href='../../archivosphp/confirmaasignacion.php?id=$proyectos[0]&aid=$idalumno&req=$proyectos[3]&num=$total_proyecto'\">".$proyectos[2]."</a>";?></td>
											<td><?php echo "<a title='Ver Proyecto' style='color: black;' href='javascript:void(0)' onClick=\"parent.PRINCIPAL.location.href='../../archivosphp/confirmaasignacion.php?id=$proyectos[0]&aid=$idalumno&req=$proyectos[3]&num=$total_proyecto'\">".$proyectos[4]."</a>";?></td>
											<td><?php echo "<a title='Ver Proyecto' style='color: black;' href='javascript:void(0)' onClick=\"parent.PRINCIPAL.location.href='../../archivosphp/confirmaasignacion.php?id=$proyectos[0]&aid=$idalumno&req=$proyectos[3]&num=$total_proyecto'\">".$proyectos[3]."</a>";?></td>
											<td><?php echo "<a title='Ver Proyecto' style='color: black;' href='javascript:void(0)' onClick=\"parent.PRINCIPAL.location.href='../../archivosphp/confirmaasignacion.php?id=$proyectos[0]&aid=$idalumno&req=$proyectos[3]&num=$total_proyecto'\">".$est_asignados."</a>";?></td>
											<td><?php echo "<a title='Ver Proyecto' style='color: black;' href='javascript:void(0)' onClick=\"parent.PRINCIPAL.location.href='../../archivosphp/confirmaasignacion.php?id=$proyectos[0]&aid=$idalumno&req=$proyectos[3]&num=$total_proyecto'\">".$est_solicitudes."</a>";?></td>
					</tr>
						<?php
						}
						?>
						</tbody>
					</table>
					</td>
				</tr>
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<tr>
					<td>
						<span id="tablenav">
						<img src="../../imagenes/mostrar_primero.png"  alt="Primera Pagina" onMouseOver="toolTip('Ir a la primera pagina',this)" onClick="sorter.move(-1,true)" class="manita">
						<img src="../../imagenes/mostrar_anterior.png"  alt="Anterior Pagina" onMouseOver="toolTip('Ir a la pagina anterior',this)" onClick="sorter.move(-1)" class="manita">
						<img src="../../imagenes/mostrar_siguiente.png"  alt="Siguiente Pagina" onMouseOver="toolTip('Ir a la pagina siguiente',this)" onClick="sorter.move(1)" class="manita">
						<img src="../../imagenes/mostrar_ultimo.png"  align="top" alt="Ultima Pagina" onMouseOver="toolTip('Ir a la ultima pagina',this)" onClick="sorter.move(1,true)" class="manita">								
						<select id="pagedropdown" onMouseOver="toolTip('Seleccionar pagina',this)"></select>
						<span class="subtitulo2"><a href="javascript:sorter.showall()" onMouseOver="toolTip('Ver todos los registros',this)">Ver todos</a></span>
								</span>
					</td>
					<td>
							
						
						<img src="../../imagenes/icono_recargar.png" align="top" onClick="redireccionar('frmConsultarProyecto.php?id=<?php echo $idalumno;?>&nom=<?php echo $nombre_alumno;?>');" onMouseOver="toolTip('Actualizar',this)" class="manita">
						<img src="../../imagenes/icono_cancelar.png" align="top" onClick="redireccionar('../Inicio/plantilla_pagina.php')" onMouseOver="toolTip('Cancelar, volver al Inicio',this)" class="manita">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					<td id="tablelocation">
						<span class="subtitulo2">Entradas por pagina</span>
						<select onchange="sorter.size(this.value)" onMouseOver="toolTip('Cantidad de registros a mostrar',this)">
									<option value="5">5</option>
									<option value="10" selected="selected">10</option>
									<option value="20">20</option>
									<option value="50">50</option>
									<option value="100">100</option>
						</select>
						<span class="subtitulo2">
						Pagina <span id="currentpage"></span> de <span id="totalpages"></span>
						</span>
					</td>
				</tr>
				</table>
				<?php } else{ ?>
			<h2 align="center" class="encabezado2"><img src="../../imagenes/exit.png"><br>NO SE PUDO GENERAR LA LISTA DE PROYECTOS!!</h2>
				<table align="center" class="alerta error centro">
					<tr>
						<td align="center" colspan="3">
							No hay proyectos disponibles registrados en el sistema.<br><br>
								
								Desea realizar el Registro de un Nuevo Proyecto?<br><br>
								<img src="../../imagenes/agregar_proyecto.png" align="top" onClick="redireccionar('../Proyecto/frmIngresarProyecto.php')" onMouseOver="toolTip('Agregar un nuevo proyecto',this)" class="manita">
								
								<img src="../../imagenes/icono_cancelar.png" align="top" onClick="redireccionar('../Inicio/plantilla_pagina.php')" onMouseOver="toolTip('Cancelar, volver al Inicio',this)" class="manita">
						</td>
					</tr>
				</table>
				<?php } ?>
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<script type="text/javascript" src="../../js/tinytable.js"></script>
                                <script type="text/javascript" src="../../js/tinytable.options.js"></script>
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<span id="toolTipBox"></span>
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
			</td>
		</tr>
<!------------------------------------------------------------------------------------------------------------------------>				
	</table>
    </form> 
    <br>
<?php 
include "../../librerias/cerrar_conexion.php"; 
include "../../librerias/pie.php"; 
?>