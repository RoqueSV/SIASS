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

$instruccion_select = "
SELECT
idalumno,
carnet,
nombrealumno|| ' ' || apellidosalumno  Nombre,
(select nombrecarrera from carrera c where a.idcarrera=c.idcarrera),
(select count(idalumno) from alumno_proyecto ap where ap.idalumno=a.idalumno)
FROM alumno a WHERE idalumno>0 order by carnet";
$consulta_alumnos = pg_query($instruccion_select) or die ("<SPAN CLASS='error'>Fallo en consulta_alumnos!!</SPAN>".pg_last_error());
?>

		<script type="text/javascript" 	 src="../../js/funciones.js"></script>
		<style>.tinytable{width: 90%;}</style>
	        
	        <form  action="" method="post" accept-charset="LATIN1" name="frmc_alumno" id="frmc_alumno">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
<!------------------------------------------------------------------------------------------------------------------------>
			<tr>
				<td align="center"><h2>EXPEDIENTES DE ALUMNOS</h2>
			  	</td>
			</tr>
<!------------------------------------------------------------------------------------------------------------------------>
			<tr>
				<td>
					<?php					
					$cantidad_alumnos = pg_query("SELECT count(idalumno) FROM alumno") or die ("<SPAN CLASS='error'>Fallo en cantidad_alumnos!!</SPAN>".pg_last_error());
					$cantidad = pg_fetch_array($cantidad_alumnos);
					if($cantidad[0] <> 0){
					?>
                                         <center>
                                         <p>Click en los datos de un alumno, para ver su expediente.<br />
                                         Click en la columna Proyectos, para ver lista de proyectos del alumno.</p>
                                         </center>
                                         <table align="center" class="marco">
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
							<td height="119" colspan="3" align="center">
								<table cellpadding="0" cellspacing="0" id="table" class="tinytable">
									<thead class="titulo1">
										<tr>
											<th onMouseOver="toolTip('Ordenar por correlativo',this)" width="50"><h3>Correl.</h3></th>
                                                                                        <th onMouseOver="toolTip('Ordenar por carnet',this)" width="65"><h3>Carnet</h3></th>
											<th onMouseOver="toolTip('Ordenar por nombre',this)" width="155"><h3>Alumno</h3></th>
											<th onMouseOver="toolTip('Ordenar por carrera',this)" width="150"><h3>Carrera</h3></th>
                                                                                        <th onMouseOver="toolTip('Ordenar por # de proyectos',this)" width="60"><h3># Proyectos</h3></th>
										</tr>
									</thead>
									<tbody class="subtitulo2">
										<?php
										while ($alumnos = pg_fetch_array($consulta_alumnos)){
										?>
										<tr align="center">
											<td><a title='Ver Alumno' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../Alumno/frmVerExpediente.php?carnet=<?php echo $alumnos[1]; ?>'"><?php echo $alumnos[0]; ?></a></td>
                                                                                        <td><a title='Ver Alumno' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../Alumno/frmVerExpediente.php?carnet=<?php echo $alumnos[1]; ?>'"><?php echo $alumnos[1]; ?></a></td>
											<td><a title='Ver Alumno' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../Alumno/frmVerExpediente.php?carnet=<?php echo $alumnos[1]; ?>'"><?php echo $alumnos[2]; ?></a></td>
											<td><a title='Ver Alumno' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../Alumno/frmVerExpediente.php?carnet=<?php echo $alumnos[1]; ?>'"><?php echo $alumnos[3]; ?></a></td>
										        <td><a title='Ver Proyecto' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='frmEstadisticaAlumno.php?id=<?php echo $alumnos[0]; ?>'"><?php echo $alumnos[4]; ?></a></td>
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
								

								<img src="../../imagenes/icono_recargar.png" align="top" onClick="redireccionar('frmListaAlumnos.php');" onMouseOver="toolTip('Actualizar',this)" class="manita">
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
					<h2 align="center" class="encabezado2"><img src="../../imagenes/exit.png"><br>NO SE PUDO GENERAR LA LISTA DE ALUMNOS!!</h2>
					<table align="center" class="alerta error centro">
						<tr>
							<td align="center" colspan="3">
								No hay alumnos registrados en el sistema.<br><br>
								
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