<?php
include "../../librerias/abrir_conexion.php";
include "../../librerias/cabecera.php";

/* Bloque seguridad */
if (!(isset($_SESSION['TYPEUSER']))) {
header("Location: ../../paginas/Inicio/frmAccesoDenegado.php");
exit(); 
}
else if (!($_SESSION['TYPEUSER']==1)) { // Jeje (1)
session_destroy();
header("Location: ../../paginas/Inicio/frmAcceso.php");
exit();    
}
 /* **********    */

$instruccion_select = "select a.idalumno, pp.idpropuesta, nomproyecto, carnet, nombrealumno ||' '||apellidosalumno nombre
from alumno a
join alumno_proyecto ap on(a.idalumno=ap.idalumno)
join proyecto p on(ap.idproyecto=p.idproyecto)
join se_convierte sc on(p.idproyecto=sc.idproyecto)
join propuesta_proyecto pp on(sc.idpropuesta=pp.idpropuesta)
where p.idproyecto=".$_GET['id'];

$consulta_proyectos = pg_query($instruccion_select) or die ("<SPAN CLASS='error'>Fallo en consulta_alumnos!!</SPAN>".pg_last_error());
?>
<script type="text/javascript" 	 src="../../js/funciones.js"></script>
<style>.tinytable{width: 90%;}</style>
<form  action="" method="post" accept-charset="LATIN1" name="frmc_institucion" id="frmc_institucion">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
<!------------------------------------------------------------------------------------------------------------------------>
			<tr>
				<td align="center"><h2>GENERAR CARTA DE PROYECTOS PARA LA INSTITUCION</h2>
			  	</td>
			</tr>
<!------------------------------------------------------------------------------------------------------------------------>
			<tr>
				<td>
					<?php					
					
					if(pg_num_rows($consulta_proyectos)>0){
					?>
					<h3 align="center">Click en los datos de un alumno, para generar la carta individual.</h3>
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
											<th onMouseOver="toolTip('Ordenar por Carnet',this)" width="15%"><h3>Carnet</h3></th>
											<th onMouseOver="toolTip('Ordenar por Alumno',this)" width="35%"><h3>Alumno</h3></th>
											<th onMouseOver="toolTip('Ordenar por Proyecto',this)" width="50%"><h3>Proyecto</h3></th>
											
										</tr>
									</thead>
									<tbody class="subtitulo2">
										<?php
										while ($row = pg_fetch_array($consulta_proyectos)){
										$idprop=$row[1];
										?>
										<tr align="center"> <!-- href='.php?id=$row[0]' -->
											
											<td><a title='Generar la carta del alumno en el Proyecto' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='CartaAprobacion.php?ida=<?php echo $row[0]; ?>&idp=<?php echo $row[1];?>'"><?php echo $row['carnet']; ?></a></td>
											<td><a title='Generar la carta del alumno en el Proyecto' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='CartaAprobacion.php?ida=<?php echo $row[0]; ?>&idp=<?php echo $row[1];?>'"><?php echo $row['nombre']; ?></a></td>
											<td><a title='Generar la carta del alumno en el Proyecto' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='CartaAprobacion.php?ida=<?php echo $row[0]; ?>&idp=<?php echo $row[1];?>'"><?php echo $row['nomproyecto']; ?></a></td>
																						
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
							<?php
								if(pg_num_rows($consulta_proyectos)>1){
									?>
									<input type="button" value="Generar Carta Grupal" onclick="parent.PRINCIPAL.location.href='CartaAprobacionGrupal.php?idp=<?php echo $idprop;?>'"><br><br>
							<?php } ?>
								
								<img src="../../imagenes/icono_recargar.png" align="top" onClick="redireccionar('frmCartaVerAlumnosDeProyecto.php?id=<?php echo $_GET['id']?>');" onMouseOver="toolTip('Actualizar',this)" class="manita">
								<img src="../../imagenes/icono_cancelar.png" align="top" onClick="redireccionar('../Inicio/plantilla_pagina.php')" onMouseOver="toolTip('Cancelar, volver al inicio',this)" class="manita">
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
                                                            NO HAY NINGUN ALUMNO ASIGNADO A ESTE PROYECTO.<br><br>					
								<img src="../../imagenes/icono_cancelar.png" align="top" onClick="redireccionar('../Inicio/plantilla_pagina.php')" onMouseOver="toolTip('Cancelar, volver al inicio',this)" class="manita">
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