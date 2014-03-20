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

$carrera=$_GET['id'];
$instruccion_select = "
SELECT
(select nombreescuela from escuela e where e.idescuela=c.idescuela) escuela,
codcarrera,
nombrecarrera,
porcentajecarrera,
plan,
horasrequeridas
FROM carrera c
WHERE idcarrera = '$carrera'";

$consulta_carreras = pg_query($instruccion_select) or die ("<SPAN CLASS='error'>Fallo en consulta_usuario!!</SPAN>".pg_last_error());
$carreras = pg_fetch_array($consulta_carreras);



echo"<script type='text/javascript'>
function pregunta() {

    if(confirm('\xbfEsta seguro de eliminar este registro?')) {

        document.location.href= '../../archivosphp/ManttoCarrera.php?id=$carrera&operacion=3';

    }

}
</script> "; 
?>
<style>.tinytable{width: 50%;}</style>
<h2 align="center">DETALLES DE LA CARRERA</h2>
<h3 align="center">Puede eliminar o modificar el registro, pulsando sobre el boton correspondiente.</h3>

<table class="tinytable" align="center">
<tr>
  <th colspan="2"><h3>DATOS DE LA CARRERA</h3></th>
</tr>

<?php
echo"
<tr>
  <td id='tdr' width='40%'><b>CODIGO CARRERA:</b></td>
  <td id='tdl'>".$carreras['codcarrera']."</td>
</tr>
<tr>
  <td id='tdr'><b>NOMBRE CARRERA:</b></td>
  <td id='tdl'>".$carreras['nombrecarrera']."</td>
</tr>
<tr>
  <td id='tdr'><b>PORCENTAJE REQUERIDO:</b></td>
  <td id='tdl'>".$carreras['porcentajecarrera']."%</td>
</tr>
<tr>
  <td id='tdr'><b>ESCUELA:</b></td>
  <td id='tdl'>".$carreras['escuela']."</td>
</tr>
<tr>
  <td id='tdr'><b>PLAN:</b></td>
  <td id='tdl'>".$carreras['plan']."</td>
</tr>
<tr>
  <td id='tdr'><b>HORAS REQUERIDAS:</b></td>
  <td id='tdl'>".$carreras['horasrequeridas']."</td>
</tr>
";
?>
</table>
<br>
<center>

<input type="button" name="buton" class="buton" value="Eliminar"  <?php echo "onclick=\"pregunta();\""; ?>/>
<input type="button" name="buton" class="buton" value="Modificar" <?php echo "onclick=\"location.href='frmModificarCarrera.php?id=$carrera'\""; ?>/>
<input type="button" name="buton" class="buton" value="Regresar"  <?php echo  "onclick=\"location.href='frmConsultarCarrera.php'\""; ?>/>
</center>

<?php
include "../../librerias/cerrar_conexion.php";
include "../../librerias/pie.php";
?>