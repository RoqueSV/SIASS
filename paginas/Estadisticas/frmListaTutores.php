<?php
include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";

/* Bloque seguridad */
if (!(isset($_SESSION['TYPEUSER']))) {
header("Location: ../../paginas/Inicio/frmAccesoDenegado.php");
exit(); 
}
else if (!($_SESSION['TYPEUSER']==1 OR $_SESSION['TYPEUSER']==2 OR $_SESSION['TYPEUSER']==4)) {
session_destroy();
header("Location: ../../paginas/Inicio/frmAcceso.php");
exit();    
}
 /* **********    */

$query="select d.iddocente, nombredocente, emaildocente, telefonodocente, count(idtutoria) numproyectos  from docente d 
left outer join tutoria t on d.iddocente=t.iddocente 
left outer join proyecto p on t.idproyecto=p.idproyecto 
left outer join se_convierte sc on p.idproyecto=sc.idproyecto 
left outer join propuesta_proyecto pp on sc.idpropuesta=pp.idpropuesta group by d.iddocente, nombredocente, emaildocente, telefonodocente;";
$resul=pg_query($query);
?>


<script type="text/javascript" 	 src="../../js/funciones.js"></script>
<style>.tinytable{width: 95%;}</style>
<form  action="" method="post" accept-charset="LATIN1" name="frmc_institucion" id="frmc_institucion">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
<!------------------------------------------------------------------------------------------------------------------------>
			<tr>
				<td align="center"><h2>TUTORES</h2>
			  	</td>
			</tr>
<!------------------------------------------------------------------------------------------------------------------------>
			<tr>
				<td>
					<?php					
					
					if(pg_num_rows($resul)>0){
					?>
					<h3 align="center">Click en los datos de un tutor, para ver la lista de alumnos asociados.</h3>
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
											<th onMouseOver="toolTip('Ordenar por C&oacute;digo',this)" width="10%"><h3>C&oacute;digo</h3></th>
											<th onMouseOver="toolTip('Ordenar por Tutor',this)" width="30%"><h3>Tutor</h3></th>
											<th onMouseOver="toolTip('Ordenar por Correo',this)" width="30%"><h3>Correo</h3></th>
											<th onMouseOver="toolTip('Ordenar por Telefono',this)" width="15%"><h3>Telefono</h3></th>
											<th onMouseOver="toolTip('Ordenar por Cantidad de Proyectos',this)" width="15%"><h3># Proyectos</h3></th>
										</tr>
									</thead>
									<tbody class="subtitulo2">
										<?php
										while ($row = pg_fetch_array($resul)){
										?>
										<tr align="center">
											<td><a title='Ver los alumnos asignados al tutor' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='frmEstadisticaTutor.php?id=<?php echo $row[0];?>'"><?php echo $row['iddocente'];?></a></td>
											<td><a title='Ver los alumnos asignados al tutor' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='frmEstadisticaTutor.php?id=<?php echo $row[0];?>'"><?php echo $row['nombredocente'];?></a></td>
											<td><a title='Ver los alumnos asignados al tutor' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='frmEstadisticaTutor.php?id=<?php echo $row[0];?>'"><?php echo $row['emaildocente'];?></a></td>
											<td><a title='Ver los alumnos asignados al tutor' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='frmEstadisticaTutor.php?id=<?php echo $row[0];?>'"><?php echo $row['telefonodocente'];?></a></td>
											<td><a title='Ver los alumnos asignados al tutor' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='frmEstadisticaTutor.php?id=<?php echo $row[0];?>'"><?php echo $row['numproyectos'];?></a></td>
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
								
								<img src="../../imagenes/icono_recargar.png" align="top" onClick="redireccionar('frmListaTutores.php');" onMouseOver="toolTip('Actualizar',this)" class="manita">
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
					<h2 align="center" class="encabezado2"><img src="../../imagenes/exit.png"><br>NO SE PUDO GENERAR LA LISTA DE TUTORES!!</h2>
					<table align="center" class="alerta error centro">
						<tr>
							<td align="center" colspan="3">
									No hay Docentes-Tutores Registrados.<br><br>					
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
                <br><br>


<?php
include "../../librerias/pie.php";
include "../../librerias/cerrar_conexion.php";
?>