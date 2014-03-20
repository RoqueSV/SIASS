<?php
include "../../librerias/abrir_conexion.php";
include "../../librerias/cabecera.php";

/* Bloque seguridad */
if (!(isset($_SESSION['TYPEUSER']))) {
header("Location: ../../paginas/Inicio/frmAccesoDenegado.php");
exit(); 
}
else if (!($_SESSION['TYPEUSER']==3)) {
session_destroy();
header("Location: ../../paginas/Inicio/frmAcceso.php");
exit();    
}
 /* **********    */

$instruccion_select = "
SELECT
idcarrera,
idescuela,
codcarrera,
nombrecarrera,
porcentajecarrera,
plan,
horasrequeridas
FROM carrera";
$consulta_carreras = pg_query($instruccion_select) or die ("<SPAN CLASS='error'>Fallo en consulta_carreras!!</SPAN>".pg_last_error());
?>

<script type="text/javascript" 	 src="../../js/funciones.js"></script>
		<style>.tinytable{width: 80%;}</style>
	        
	        <form  action="" method="post" accept-charset="LATIN1" name="frmc_usuario" id="frmc_usuario">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
<!------------------------------------------------------------------------------------------------------------------------>
			<tr>
				<td align="center"><h2>CONSULTAR CARRERAS</h2>
			  	</td>
			</tr>
<!------------------------------------------------------------------------------------------------------------------------>
			<tr>
				<td>
					<?php					
					$cantidad_carreras = pg_query("SELECT count(idcarrera) FROM carrera") or die ("<SPAN CLASS='error'>Fallo en cantidad_carreras!!</SPAN>".pg_last_error());
					$cantidad = pg_fetch_array($cantidad_carreras);
					if($cantidad[0] <> 0){
					?>
                                        <h3 align="center">Click en una carrera para mas opciones</h3>
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
											<th onMouseOver="toolTip('Ordenar por codigo',this)" width="75"><h3>Codigo</h3></th>
											<th onMouseOver="toolTip('Ordenar por nombre',this)" width="200"><h3>Nombre</h3></th>
											<th onMouseOver="toolTip('Ordenar por porcentaje',this)" width="75"><h3>Porcentaje</h3></th>
											<th onMouseOver="toolTip('Ordenar por plan',this)" width="75"><h3>Plan</h3></th>
                                                                                        <th onMouseOver="toolTip('Ordenar por escuela',this)" width="225"><h3>Escuela</h3></th>
										</tr>
									</thead>
									<tbody class="subtitulo2">
										<?php
										while ($carreras = pg_fetch_array($consulta_carreras)){
                                                                                $consulta_escuela= pg_query("SELECT nombreescuela from escuela where idescuela='$carreras[1]'") or die ("<SPAN CLASS='error'>Fallo en consulta_carreras!!</SPAN>".pg_last_error());
                                                                                $escuela = pg_fetch_array($consulta_escuela); 
										?>
										<tr align="center">
											<td><a title='Ver Carrera' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='frmVerCarrera.php?id=<?php echo $carreras[0]; ?>'"><?php echo $carreras[2]; ?></a></td>
                                                                                       	<td><a title='Ver Carrera' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='frmVerCarrera.php?id=<?php echo $carreras[0]; ?>'"><?php echo $carreras[3]; ?></a></td>
											<td><a title='Ver Carrera' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='frmVerCarrera.php?id=<?php echo $carreras[0]; ?>'"><?php echo $carreras[4]; ?>%</a></td>
											<td><a title='Ver Carrera' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='frmVerCarrera.php?id=<?php echo $carreras[0]; ?>'"><?php echo $carreras[5]; ?></a></td>
										        <td><a title='Ver Carrera' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='frmVerCarrera.php?id=<?php echo $carreras[0]; ?>'"><?php echo $escuela[0]; ?></a></td>
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
								
								<img src="../../imagenes/agregar_proyecto.png" align="top"       onClick="redireccionar('frmIngresarCarrera.php')" onMouseOver="toolTip('Agregar una nueva Carrera',this)" class="manita">
								<img src="../../imagenes/icono_recargar.png" align="top" onClick="redireccionar('frmConsultarCarrera.php');" onMouseOver="toolTip('Actualizar',this)" class="manita">
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
					<h2 align="center" class="encabezado2"><img src="../../imagenes/exit.png"><br>NO SE PUDO GENERAR LA LISTA DE CARRERAS!!</h2>
					<table align="center" class="alerta error centro">
						<tr>
							<td align="center" colspan="3">
								No hay carreras registrados en el sistema.<br><br>
								
								Desea realizar el Registro de una Nueva Carrera?<br><br>
								<img src="../../imagenes/agregar_proyecto.png" align="top" onClick="redireccionar('frmIngresarCarrera.php')" onMouseOver="toolTip('Agregar una nueva carrera',this)" class="manita">
								
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
