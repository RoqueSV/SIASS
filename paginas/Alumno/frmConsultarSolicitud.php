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

// $instruccion = "SELECT a.carnet,CONCAT(a.nombrealumno,' ',a.apellidosalumno) as nombre, pr.nomproyecto,pr.nominstitucion, pr.idpropuesta FROM alumno a, hace h, propuesta_proyecto pr WHERE a.idalumno=h.idalumno and h.idpropuesta=pr.idpropuesta AND pr.estadoprop='P' ORDER BY pr.nomproyecto";
$instruccion = "SELECT a.carnet,a.nombrealumno||' '||a.apellidosalumno as nombre, pr.nomproyecto,pr.nominstitucion,a.idAlumno,p.idProyecto FROM alumno a, Solicitud_proyecto sp,proyecto as p,se_convierte as sc, propuesta_proyecto pr WHERE a.idalumno=sp.idalumno and  sp.idproyecto=p.idproyecto AND p.idproyecto=sc.idproyecto AND sc.idpropuesta=pr.idpropuesta AND sp.estado='P' ORDER BY pr.nomproyecto";

$consulta_proyectos = pg_query($instruccion) or die ("<SPAN CLASS='error'>Fallo en consulta de solicitud de proyectos!!</SPAN>".pg_last_error());
?>

		<script type="text/javascript" 	 src="../../js/funciones.js"></script>
		<script language='javaScript' type='text/javascript'>
			function Aprobar(idalum,idproy,acc){
				var comm=prompt("Ingrese un comentario justificando la accion: ");
				if(comm!=null){
					if(acc==1){
						window.location='ProcesarSolicitudAlum.php?idalum='+idalum+"&idproy="+idproy+"&acc=1&comm="+comm;
					}
					if(acc==2){
						window.location='ProcesarSolicitudAlum.php?idalum='+idalum+"&idproy="+idproy+"&acc=2&comm="+comm;
					}
				}
				
			}
		</script>
		<style>.tinytable{width: 90%;}</style>
	        
        <form  action="" method="post" accept-charset="LATIN1" name="frmc_usuario" id="frmc_usuario">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
<!------------------------------------------------------------------------------------------------------------------------>
		<tr>
			<td align="center">
            <h2>SOLICITUDES DE PROYECTOS DE ALUMNOS</h2>
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
						<th onMouseOver="toolTip('Ordenar por Carnet',this)" width="25%"><h3>Carnet</h3></th>
						<th onMouseOver="toolTip('Ordenar por Alumno',this)" width="25%"><h3>Alumno</h3></th>
						<th onMouseOver="toolTip('Ordenar por proyecto',this)" width="30%"><h3>Proyecto</h3></th>
						<th onMouseOver="toolTip('Ordenar por fecha',this)" width="23%"><h3>Instituci&oacute;n</h3></th>
						<th width="5%"><h3>Opci&oacute;n</h3></th>
						
						</tr>
						</thead>
						<tbody class="subtitulo2">
							<?php
							while ($proyectos = pg_fetch_array($consulta_proyectos)){
							?>
					<tr align="center">
											<td><?php echo $proyectos[0];?></td>
											<td><?php echo $proyectos[1];?></td>
											<td><?php echo $proyectos[2];?></td>
											<td><?php echo $proyectos[3];?></td>
											<td><?php echo "<a href='javascript:void(0)' onClick=\"Aprobar($proyectos[4],$proyectos[5],1) \">Aprobar</a>|<a href='javascript:void(0)' onClick=\"Aprobar($proyectos[4],$proyectos[5],2) \">Rechazar</a>";?></td>
											
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
							
						   <img src="../../imagenes/icono_recargar.png" align="top" onClick="redireccionar('frmConsultarSolicitud.php');" onMouseOver="toolTip('Actualizar',this)" class="manita">
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