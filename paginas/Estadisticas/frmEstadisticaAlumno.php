<?php
include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";

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

$datosalumno=pg_query("select carnet, nombrealumno|| ' ' || apellidosalumno  Nombre from alumno where idalumno=".$_GET['id'].";");
$alumno=  pg_fetch_array($datosalumno);
$proyecto="select p.idproyecto, nomproyecto, coalesce(nombredocente,'Tutor a&uacute;n no asignado') nombredocente, iniciotutoria, fintutoria, coalesce(horas,0) horas from docente d
join tutoria t on (d.iddocente=t.iddocente)
join tutoria_alumno ta on (t.idtutoria=ta.idtutoria)
right outer join alumno a on (ta.idalumno=a.idalumno)
join alumno_proyecto ap on (a.idalumno=ap.idalumno) 
join proyecto p on (ap.idproyecto=p.idproyecto) 
join se_convierte sc on (p.idproyecto=sc.idproyecto) 
join propuesta_proyecto pp on (sc.idpropuesta=pp.idpropuesta) where a.idalumno=".$_GET['id']." order by ap.idproyecto desc;";
$detalle_proyecto=pg_query($proyecto);
?>

<script type="text/javascript" 	 src="../../js/funciones.js"></script>
<style>.tinytable{width: 90%;}</style>
<form  action="" method="post" accept-charset="LATIN1" name="frmc_institucion" id="frmc_institucion">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
<!------------------------------------------------------------------------------------------------------------------------>
			<tr>
				<td align="center"><h2>PARTICIPACION EN PROYECTOS</h2>
			  	</td>
                               
			</tr>
                        <tr>
                                <td align="center">
                                    <b>Carnet: </b><?php echo $alumno['carnet']; ?>
			  	     &nbsp; &nbsp;
                                    <b>Alumno: </b><?php echo $alumno['nombre']; ?>
			  	</td> 
                        </tr>
<!------------------------------------------------------------------------------------------------------------------------>
			<tr>
				<td>
					<?php					
					
					if(pg_num_rows($detalle_proyecto)>0){
					?>
					<h3 align="center">Click en los datos de un proyecto, para ver los detalles.</h3>
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
											<th onMouseOver="toolTip('Ordenar por Proyecto',this)" width="40%"><h3>Proyecto</h3></th>
											<th onMouseOver="toolTip('Ordenar por Tutor',this)" width="30%"><h3>Tutor</h3></th>
											<th onMouseOver="toolTip('Ordenar por Fecha inicio',this)" width="10%"><h3>Inicio</h3></th>
                                                                                        <th onMouseOver="toolTip('Ordenar por Fecha fin',this)" width="10%"><h3>Fin</h3></th>
                                                                                        <th onMouseOver="toolTip('Ordenar por numero de horas',this)" width="10%"><h3>Horas</h3></th>
										</tr>
									</thead>
									<tbody class="subtitulo2">
										<?php
										while ($row = pg_fetch_array($detalle_proyecto)){
                                                                               /* if($row['estadoproyecto']=="P") 
                                                                                $estado = "En Proceso"; 
                                                                                
                                                                                if($row['estadoproyecto']=="C") 
                                                                                $estado = "Pendiente aprobaci&oacute;n"; 
                                                                                
                                                                                if($row['estadoproyecto']=="F") 
                                                                                $estado = "Finalizado"; 

                                                                                if($row['estadoproyecto']=="L") 
                                                                                $estado = "Detenido"; 

                                                                                if($row['estadoproyecto']=="B") 
                                                                                $estado = "de Baja"; */
										?>
										<tr align="center"> 
											<td><a title='Ver Detalles de Proyecto' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='frmVistaProyectos.php?id= <?php echo $row[0]; ?>'"><?php echo $row['nomproyecto']; ?></a></td>
											<td><a title='Ver Detalles de Proyecto' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='frmVistaProyectos.php?id= <?php echo $row[0]; ?>'"><?php echo $row['nombredocente']; ?></a></td>
											<td><a title='Ver Detalles de Proyecto' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='frmVistaProyectos.php?id= <?php echo $row[0]; ?>'">
                                                                                        <?php 
                                                                                        if ($row['iniciotutoria']!=null)
                                                                                             echo $row['iniciotutoria'];
                                                                                         else echo "--"; 
                                                                                        ?>
                                                                                        </a></td>
                                                                                        <td><a title='Ver Detalles de Proyecto' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='frmVistaProyectos.php?id= <?php echo $row[0]; ?>'">
                                                                                        <?php 
                                                                                        if ($row['fintutoria']!=null)
                                                                                             echo $row['fintutoria'];
                                                                                         else echo "--"; 
                                                                                        ?>
                                                                                        </a></td>
                                                                                        <td><a title='Ver Detalles de Proyecto' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='frmVistaProyectos.php?id= <?php echo $row[0]; ?>'"><?php echo $row['horas']; ?></a></td>
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
								
								<img src="../../imagenes/icono_recargar.png" align="top" onClick="redireccionar('frmEstadisticaAlumno.php?id=<?php echo $_GET['id'];?>');" onMouseOver="toolTip('Actualizar',this)" class="manita">
								<img src="../../imagenes/icono_cancelar.png" align="top" onClick="redireccionar('frmListaAlumnos.php')" onMouseOver="toolTip('Cancelar, volver atras',this)" class="manita">
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
									No hay proyectos asociados a este alumno.<br><br>					
								<img src="../../imagenes/icono_cancelar.png" align="top" onClick="redireccionar('frmListaAlumnos.php')" onMouseOver="toolTip('Cancelar, volver atras',this)" class="manita">
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