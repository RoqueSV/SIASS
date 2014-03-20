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
$instruccion = "
SELECT p.idproyecto, pp.nomproyecto, pp.nominstitucion, pp.descripcionpropuesta as descripcion, p.estadoproyecto as estadoProyecto
FROM proyecto p, propuesta_proyecto pp, se_convierte sc
WHERE p.idproyecto=sc.idproyecto AND sc.idpropuesta=pp.idpropuesta AND (p.estadoProyecto='D' OR p.estadoProyecto='A' OR p.estadoProyecto='L' OR p.estadoProyecto='B') ORDER BY p.estadoProyecto";
// AND pp.estudiantesRequeridos<(count(sp.idAlumno)+count(ap.idAlumno))
$consulta_proyectos = pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta de proyectos!!</SPAN>".pg_last_error());
?>

		<script type="text/javascript" 	 src="../../js/funciones.js"></script>
		<style>.tinytable{width: 90%;}</style>
	        
        <form  action="" method="post" accept-charset="LATIN1" name="frmc_usuario" id="frmc_usuario">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
<!------------------------------------------------------------------------------------------------------------------------>
		<tr>
			<td align="center">
            <h2>CONSULTAR PROYECTOS DISPONIBLES</h2>
			<p style="font-size: 9px;">Se muestran los proyectos con estado Disponible, Asigando, Detenido y De Baja</p>
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
					<td height="120" colspan="3" align="center">
					<table cellpadding="0" cellspacing="0" id="table" class="tinytable" width="90%">
						<thead class="titulo1">
					<tr>
						<th onMouseOver="toolTip('Ordenar por proyecto',this)" width="70"><h3>Proyecto</h3></th>
						<th onMouseOver="toolTip('Ordenar por institucion',this)" width="5"><h3>Institucion</h3></th>
						<th onMouseOver="toolTip('Ordenar por codigo',this)" width="70"><h3>Descripci&oacute;n</h3></th>
						<th onMouseOver="toolTip('Ordenar por estado',this)" width="10"><h3>Estado</h3></th>
					</tr>
						</thead>
						<tbody class="subtitulo2">
							<?php
							while ($proyectos = pg_fetch_array($consulta_proyectos)){
							if($proyectos[4]=='D')$estadoProyecto='Disponible';
							if($proyectos[4]=='A')$estadoProyecto='Asignado';
							if($proyectos[4]=='L')$estadoProyecto='Detenido';
							if($proyectos[4]=='B')$estadoProyecto='De Baja';
							?>
					<tr align="center">
											<td><?php echo "<a title='Ver Proyecto' style='color: black;' href='frmModificarProyecto.php?id=$proyectos[0]'>".$proyectos[1]."</a>";?></td>
											<td><?php echo "<a title='Ver Proyecto' style='color: black;' href='frmModificarProyecto.php?id=$proyectos[0]'>".$proyectos[2]."</a>";?></td>
											<td><?php echo "<a title='Ver Proyecto' style='color: black;' href='frmModificarProyecto.php?id=$proyectos[0]'>".$proyectos['descripcion']."</a>";?></td>
											<td><?php echo "<a title='Ver Proyecto' style='color: black;' href='frmModificarProyecto.php?id=$proyectos[0]'>".$estadoProyecto."</a>";?></td>
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
							
						<img src="../../imagenes/agregar_proyecto.png" align="top"       onClick="redireccionar('frmIngresarProyecto.php')" onMouseOver="toolTip('Agregar un nuevo Proyecto',this)" class="manita">
						<img src="../../imagenes/icono_recargar.png" align="top" onClick="redireccionar('frmConsultarProyecto.php');" onMouseOver="toolTip('Actualizar',this)" class="manita">
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
							No hay proyectos registrados en el sistema.<br><br>
								
								Desea realizar el Registro de un Nuevo Proyecto?<br><br>
								<img src="../../imagenes/agregar_proyecto.png" align="top" onClick="redireccionar('frmIngresarProyecto.php')" onMouseOver="toolTip('Agregar un nuevo proyecto',this)" class="manita">
								
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