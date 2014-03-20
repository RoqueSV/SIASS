<?php
include "../../librerias/abrir_conexion.php";
include "../../librerias/cabecera.php";

/* Bloque seguridad */
if (!(isset($_SESSION['TYPEUSER']))) {
header("Location: ../../paginas/Inicio/frmAccesoDenegado.php");
exit(); 
}
else if (!($_SESSION['TYPEUSER']==1 OR $_SESSION['TYPEUSER']==6 )) {
session_destroy();
header("Location: ../../paginas/Inicio/frmAcceso.php");
exit();    
}
 /* **********    */


if(isset($_GET['carnet'])){
$carnet_alumno=$_GET['carnet'];
}
else{
$carnet_alumno=$_SESSION['user'];}
$instruccion_select = "
SELECT
idalumno,
(select nombrecarrera from carrera c where a.idcarrera=c.idcarrera) carrera,
carnet,
nombrealumno,
apellidosalumno,
nivelacademico,
porcentaje,
direccionalumno,
telefonoalumno,
emailalumno,
fechaapertura,
fotografia
FROM alumno a
WHERE carnet = '$carnet_alumno'";

$consulta_alumnos = pg_query($instruccion_select) or die ("<SPAN CLASS='error'>Fallo en consulta_usuario!!</SPAN>".pg_last_error());
$alumnos = pg_fetch_array($consulta_alumnos);

$fecha = explode('-',$alumnos["fechaapertura"]);

?>
<script type="text/javascript" 	 src="../../js/funciones.js"></script>
<style>.tinytable{width: 40%;}</style>
<center>
    <h2>Ficha de registro para estudiantes en servicio social.</h2>
       
 <table class="marco" align="center" width="40%">
        <thead>
            <tr>
            <th align="center">Alumno</th>
            <th align="center">Carnet</th>
            </tr>
        </thead>
        <tr>
            <td align="center"><?php echo $alumnos["nombrealumno"]." ".$alumnos["apellidosalumno"];?></td>
            <td align="center"><?php echo $alumnos['carnet'];?></td>
        </tr>
   </table>
  <p>
   <?php echo '<img src="../../archivosphp/'.$alumnos["fotografia"].'" border="0" width="150" height="150" />';?>
  </p>
</center><br>
<table class="tinytable" align="center">
<tr>
  <th colspan="2"><h3>DATOS</h3></th>
</tr>

<?php
echo"
<tr>
  <td id='tdr'><b>CARRERA:</b></td>
  <td id='tdl'>".$alumnos['carrera']."</td>
</tr>
<tr>
  <td id='tdr'><b>NIVEL:</b></td>
  <td id='tdl'>".$alumnos['nivelacademico']."</td>
</tr>
<tr>
  <td id='tdr'><b>PORCENTAJE CARRERA:</b></td>
  <td id='tdl'>".$alumnos['porcentaje']."%</td>
</tr>
<tr>
  <td id='tdr'><b>DIRECCION:</b></td>
  <td id='tdl'>".$alumnos['direccionalumno']."</td>
</tr>
<tr>
  <td id='tdr'><b>EMAIL:</b></td>
  <td id='tdl'><a href='mailto:".$alumnos['emailalumno']."'>".$alumnos['emailalumno']."</a></td>
</tr>
<tr>
  <td id='tdr'><b>TELEFONO:</b></td>
  <td id='tdl'>".$alumnos['telefonoalumno']."</td>
</tr>
<tr>
  <td id='tdr'><b>FECHA APERTURA:</b></td>
  <td id='tdl'>".$fecha[2]."-".$fecha[1]."-".$fecha[0]."</td>
</tr>
";
?>
</table> <br/>
<center>
<?php
if(isset($_GET['carnet'])){ ?>
<input type="button" name="buton" class="buton" value="Regresar"  onclick="location.href='../Estadisticas/frmListaAlumnos.php'"/>        
<?php } else { ?>
<img src="../../imagenes/icono_recargar.png" align="top" onClick="redireccionar('frmVerExpediente.php');" onMouseOver="toolTip('Refrescar',this)" class="manita">
<?php } ?>
<span id="toolTipBox"></span>
</center>
<?php
include "../../librerias/cerrar_conexion.php";
include "../../librerias/pie.php";
?>
