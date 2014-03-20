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

// $instruccion = "SELECT a.carnet, pr.nomproyecto,s.fechasolicitud FROM alumno a, proyecto p, solicitud_proyecto s, propuesta_proyecto pr, se_convierte sc WHERE s.idalumno=a.idalumno and s.idproyecto=p.idproyecto AND sc.idproyecto=p.idproyecto AND pr.idpropuesta=sc.idpropuesta";
$instruccion = "SELECT a.carnet,a.nombrealumno ||' '||a.apellidosalumno as nombre, pr.nomproyecto,pr.nominstitucion, pr.idpropuesta FROM alumno a, hace h, propuesta_proyecto pr WHERE a.idalumno=h.idalumno and h.idpropuesta=pr.idpropuesta AND pr.estadoprop='P' ORDER BY pr.idpropuesta";

$consulta_proyectos = pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta de proyectos!!</SPAN>".pg_last_error());
?>

		<script type="text/javascript" 	 src="../../js/funciones.js"></script>
		<style>.tinytable{width: 80%;}</style>
	        
        <form  action="" method="post" accept-charset="LATIN1" name="frmc_usuario" id="frmc_usuario">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
<!------------------------------------------------------------------------------------------------------------------------>
		<tr>
			<td align="center">
            <h2>PROPUESTAS DE PROYECTOS DE ALUMNOS</h2>
			</td>
		</tr>
<!------------------------------------------------------------------------------------------------------------------------>
		<tr>
			<td>
			<?php					
			// $cantidad_proyectos = pg_query("SELECT count(idpropuesta) FROM propuesta_proyecto pr,  WHERE estadoprop='P'") or die ("<SPAN CLASS='error'>Fallo la consulta!!</SPAN>".pg_last_error());
			$cantidad = pg_num_rows($consulta_proyectos);
			if($cantidad <> 0){
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
					<td height="120" colspan="3" align="center">
					<table cellpadding="0" cellspacing="0" id="table" class="tinytable">
						<thead class="titulo1">
					<tr>
						<th onMouseOver="toolTip('Ordenar por proyecto',this)" width="80"><h3>Proyecto</h3></th>
						<th onMouseOver="toolTip('Ordenar por fecha',this)" width="40"><h3>Instituci&oacute;n</h3></th>
						<th onMouseOver="toolTip('Ordenar por carnet',this)" width="10"><h3>Carnet</h3></th>
						<th onMouseOver="toolTip('Ordenar por nombre',this)" width="70"><h3>Nombre</h3></th>
						</tr>
						</thead>
						<tbody class="subtitulo2">
							<?php
							// $qContador=pg_query("SELECT count(pr.idpropuesta) as contador, pr.idpropuesta FROM alumno a, hace h, propuesta_proyecto pr WHERE a.idalumno=h.idalumno and h.idpropuesta=pr.idpropuesta AND pr.estadoprop='P' group BY pr.idpropuesta");
							// $rows_tabla=pg_fetch_array($qContador);
							
							while ($proyectos = pg_fetch_array($consulta_proyectos)){
							
							?>
						<tr align="center">
											<td><?php echo "<a title='Ver Proyecto' style='color: black;' href='frmProcesarPropuestaAlum.php?id=$proyectos[4]'>".$proyectos[2]."</a>";?></td>
											<td><?php echo "<a title='Ver Proyecto' style='color: black;' href='frmProcesarPropuestaAlum.php?id=$proyectos[4]'>".$proyectos[3]."</a>";?></td>
											<td><?php echo "<a title='Ver Proyecto' style='color: black;' href='frmProcesarPropuestaAlum.php?id=$proyectos[4]'>".$proyectos[0]."</a>";?></td>
											<td><?php echo "<a title='Ver Proyecto' style='color: black;' href='frmProcesarPropuestaAlum.php?id=$proyectos[4]'>".$proyectos[1]."</a>";?></td>
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
							
						   <img src="../../imagenes/icono_recargar.png" align="top" onClick="redireccionar('frmConsultarPropuesta.php');" onMouseOver="toolTip('Actualizar',this)" class="manita">
						<img src="../../imagenes/icono_cancelar.png" align="top" onClick="redireccionar('../Inicio/plantilla_pagina.php')" onMouseOver="toolTip('Cancelar, volver al Inicio',this)" class="manita"></td>
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
		<h2 align="center" class="encabezado2"><img src="../../imagenes/exit.png"><br>NO SE PUDO GENERAR LA LISTA DE SOLICITUDES!!</h2>
				<table align="center" class="alerta error centro">
					<tr>
						<td align="center" colspan="3">
							No hay solicitudes registradas en el sistema.</td>
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