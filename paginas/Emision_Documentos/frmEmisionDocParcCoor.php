<?php
include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";

$query="select a.idalumno,carnet, nombrealumno||' '||apellidosalumno nomalumno, sum(horas) totalhoras, nombrecarrera
from carrera c
join alumno a on c.idcarrera=a.idcarrera
join alumno_proyecto pa on a.idalumno=pa.idalumno 
where pa.estadoalumnoproyecto='F'
group by a.idalumno,carnet, nomalumno,nombrecarrera,horasrequeridas
having sum(horas)>0 and sum(horas)<horasrequeridas;";
$resul=pg_query($query);

?>


<script type="text/javascript" 	 src="../../js/funciones.js"></script>
<style>.tinytable{width: 90%;}</style>
<form  action="" method="post" accept-charset="LATIN1" name="frmc_institucion" id="frmc_institucion">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
<!------------------------------------------------------------------------------------------------------------------------>
			<tr>
				<td align="center"><h2>EMISION DE CONSTANCIA PARCIAL DE SERVICIO SOCIAL</h2>
			  	</td>
			</tr>
<!------------------------------------------------------------------------------------------------------------------------>
			<tr>
				<td>
					<?php					
					
					if(pg_num_rows($resul)>0){
					?>
					<h3 align="center">Click en los datos de un alumno, para ver los detalles y emitir documentos.</h3>
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
							<td height="119" colspan="3" align="center">
								<table cellpadding="0" cellspacing="0" id="table" class="tinytable">
									<thead class="titulo1">
										<tr>
											<th onMouseOver="toolTip('Ordenar por Alumno',this)" width="15%"><h3>Carnet</h3></th>
											<th onMouseOver="toolTip('Ordenar por Proyecto',this)" width="30%"><h3>Alumno</h3></th>
											<th onMouseOver="toolTip('Ordenar por Inicio Tutoria',this)" width="15%"><h3>Horas</h3></th>
											<th onMouseOver="toolTip('Ordenar por Fin Tutoria',this)" width="40%"><h3>Carrera</h3></th>
							
										</tr>
									</thead>
									<tbody class="subtitulo2">
										<?php
										while ($row = pg_fetch_array($resul)){
										?>
										<tr align="center"> <!-- href='.php?id=$row[0]' -->
											<td><?php echo "<a title='Ver Detalles de Proyecto' style='color: black;' href='frmDetalleAlumnoCoor.php?op=1&id=$row[0]'>".$row['carnet']."</a>";?></td>
											<td><?php echo "<a title='Ver Detalles de Proyecto' style='color: black;' href='frmDetalleAlumnoCoor.php?op=1&id=$row[0]'>".$row['nomalumno']."</a>";?></td>
											<td><?php echo "<a title='Ver Detalles de Proyecto' style='color: black;' href='frmDetalleAlumnoCoor.php?op=1&id=$row[0]'>".$row['totalhoras']."</a>";?></td>
											<td><?php echo "<a title='Ver Detalles de Proyecto' style='color: black;' href='frmDetalleAlumnoCoor.php?op=1&id=$row[0]'>".$row['nombrecarrera']."</a>";?></td>
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
								
								<img src="../../imagenes/icono_recargar.png" align="top" onClick="redireccionar('frmEmisionDocAlumnosParc.php');" onMouseOver="toolTip('Actualizar',this)" class="manita">
								<img src="../../imagenes/icono_cancelar.png" align="top" onClick="redireccionar('../inicio/plantilla_pagina.php')" onMouseOver="toolTip('Cancelar, volver atras',this)" class="manita">
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
									No hay alumnos que hayan cumplido con las horas establecidas .<br><br>					
								<img src="../../imagenes/icono_cancelar.png" align="top" onClick="redireccionar('../inicio/plantilla_pagina.php')" onMouseOver="toolTip('Cancelar, ir al inicio',this)" class="manita">
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
                <br><br>




<?php
include "../../librerias/pie.php";
include "../../librerias/cerrar_conexion.php";
?>