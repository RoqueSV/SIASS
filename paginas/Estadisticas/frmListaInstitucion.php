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


// $instruccion = "
// SELECT p.idproyecto, pp.nomproyecto, pp.nominstitucion, pp.descripcionpropuesta as descripcion,p.estadoProyecto as estado
// FROM proyecto p, propuesta_proyecto pp, se_convierte sc
// WHERE p.idproyecto=sc.idproyecto AND sc.idpropuesta=pp.idpropuesta AND (p.estadoProyecto<>'D')";
$instruccion="SELECT i.idInstitucion, i.nombreinstitucion, i.nombreContacto, i.emailContacto,i.telefonoContacto,i.estadoinstitucion FROM institucion as i";
//INstituciones no registradas
$instruccion2="SELECT pp.idInstitucion, pp.nominstitucion FROM propuesta_proyecto as pp WHERE pp.idInstitucion NOT IN (SELECT i.idInstitucion FROM institucion as i)";
// AND pp.estudiantesRequeridos<(count(sp.idAlumno)+count(ap.idAlumno))
$consulta_instituciones = pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta de instituciones!!</SPAN>".pg_last_error());
?>

		<script type="text/javascript" 	 src="../../js/funciones.js"></script>
		<style>.tinytable{width: 90%;}</style>
	        
        <form  action="" method="post" accept-charset="LATIN1" name="frmc_usuario" id="frmc_usuario">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
<!------------------------------------------------------------------------------------------------------------------------>
		<tr>
			<td align="center">
            <h2>HISTORICO DE INSTITUCIONES</h2>
			</td>
		</tr>
<!------------------------------------------------------------------------------------------------------------------------>
		<tr>
			<td>
			<?php					
			$cantidad_instituciones = pg_query("SELECT count(idInstitucion) FROM institucion") or die ("<SPAN CLASS='error'>Fallo la consulta!!</SPAN>".pg_last_error());
			$cantidad = pg_fetch_array($cantidad_instituciones);
			if($cantidad[0] <> 0){
			?>
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
					<td height="120" colspan="3" align="center">
					<table cellpadding="0" cellspacing="0" id="table" class="tinytable">
						<thead class="titulo1">
					<tr>
						<th onMouseOver="toolTip('Ordenar por institucion',this)" width="15"><h3>Institucion</h3></th>
						<th onMouseOver="toolTip('Ordenar por proyecto',this)" width="80"><h3>Proyectos Aprobados</h3></th>
						<th onMouseOver="toolTip('Ordenar por estado',this)" width="5"><h3>Estado Solicitud</h3></th>
						<th onMouseOver="toolTip('Ordenar por Descripcion',this)" width="70"><h3>Contacto</h3></th>
					</tr>
						</thead>
						<tbody class="subtitulo2">
							<?php
							while ($institucion = pg_fetch_array($consulta_instituciones)){
								if($institucion['estadoinstitucion']=='A')$est='APROBADA';
								if($institucion['estadoinstitucion']=='P')$est='PENDIENTE';
								$queryProy=pg_query("SELECT * FROM Propuesta_proyecto as pp WHERE idInstitucion='$institucion[0]' AND estadoProp='A' AND idPropuesta NOT IN(SELECT h.idPropuesta FROM Hace as h)") or die ("<SPAN CLASS='error'>Fallo la consulta cantproyectos institucion!!</SPAN>".pg_last_error());
								$cant=pg_num_rows($queryProy);
								
							?>
							<tr style="align:left">
	<td><?php echo "<a title='Ver Institucion' style='color: black;' href='javascript:void(0)' onClick=\"parent.PRINCIPAL.location.href='frmVistaInstituciones.php?id=$institucion[0]'\">".$institucion[1]."</a>";?></td>
								<td><?php echo "<a title='Ver Institucion' style='color: black;' href='javascript:void(0)' onClick=\"parent.PRINCIPAL.location.href='frmVistaInstituciones.php?id=$institucion[0]'\">".$cant."</a>";?></td>
								<td><?php echo "<a title='Ver Institucion' style='color: black;' href='javascript:void(0)' onClick=\"parent.PRINCIPAL.location.href='frmVistaInstituciones.php?id=$institucion[0]'\">".$est."</a>";?></td>
								<td style="text-align:left"><?php echo "<a title='Ver Institucion' style='color: black;' href='javascript:void(0)' onClick=\"parent.PRINCIPAL.location.href='frmVistaInstituciones.php?id=$institucion[0]'\">".$institucion[2]."</a>";?></td>
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
						<img src="../../imagenes/icono_recargar.png" align="top" onClick="redireccionar('frmListaInstitucion.php');" onMouseOver="toolTip('Actualizar',this)" class="manita">
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
			<h2 align="center" class="encabezado2"><img src="../../imagenes/exit.png"><br>NO SE PUDO GENERAR LA LISTA DE INSTITUCIONES!!</h2>
				<table align="center" class="alerta error centro">
					<tr>
						<td align="center" colspan="3">
							No hay Instituciones registrados en el sistema.<br><br>
								
								
								
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