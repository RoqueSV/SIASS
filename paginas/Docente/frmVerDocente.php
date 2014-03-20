<?php
include "../../librerias/abrir_conexion.php";
include "../../librerias/cabecera.php";

/* Bloque seguridad */
if (!(isset($_SESSION['TYPEUSER']))) {
header("Location: ../../paginas/Inicio/frmAccesoDenegado.php");
exit(); 
}
else if (!($_SESSION['TYPEUSER']==1 OR $_SESSION['TYPEUSER']==2)) {
session_destroy();
header("Location: ../../paginas/Inicio/frmAcceso.php");
exit();    
}
 /* **********    */

$estado=$_GET['estado'];
$docente=$_GET['id'];
$instruccion_select = "
SELECT
iddocente,
idescuela,
(select nombreescuela from escuela e where e.idescuela=d.idescuela) escuela, 
usuariodocente,
clavedocente,
nombredocente,
telefonodocente,
emaildocente,
estadodocente
FROM docente d
WHERE iddocente = '$docente'";

$consulta_docentes = pg_query($instruccion_select) or die ("<SPAN CLASS='error'>Fallo en consulta_usuario!!</SPAN>".pg_last_error());
$docentes = pg_fetch_array($consulta_docentes);

$numtutoria=  pg_fetch_array(pg_query("select count(t.idtutoria) from tutoria t join tutoria_alumno ta 
on (t.idtutoria = ta.idtutoria) where iddocente =$docentes[0];"));



?>
<script type='text/javascript'>
function eliminar() {

    if(confirm('\xbfEsta seguro de dar de baja al tutor seleccionado?')) {
        document.getElementById('estadod').value='B';
        document.getElementById('frmDocente').submit();
}
}

function alta() {

    if(confirm('\xbfEsta seguro de dar de alta al tutor seleccionado?')) {
        document.getElementById('estadod').value='A';
        document.getElementById('frmDocente').submit();
}
}
</script>


<style>.tinytable{width: 50%;}</style>
<center><h2>Tutor: <?php echo $docentes["nombredocente"]; ?> </h2></center><br>

<form name="frmDocente" id="frmDocente" <?php echo "action='../../archivosphp/ManttoDocente.php?id=$docentes[0]&operacion=2&idescuela=$docentes[1]'" ?>  method="post">
<input type="hidden" name="usuario" id="usuario" value="<?php echo $docentes['usuariodocente'];?>">
<input type="hidden" name="nombred" id="nombred" value="<?php echo $docentes['nombredocente'];?>">
<input type="hidden" name="clave2" id="clave2" value="<?php echo $docentes['clavedocente'];?>">
<input type="hidden" name="emaild" id="emaild" value="<?php echo $docentes['emaildocente'];?>">
<input type="hidden" name="telefonod" id="telefonod" value="<?php echo $docentes['telefonodocente'];?>">
<input type="hidden" name="estadod" id="estadod" value="">
<input type="hidden" name="verifica" id="verifica" value="<?php echo $numtutoria[0];?>">


<table class="tinytable" align="center">
<tr>
  <th colspan="2"><h3>DATOS DE TUTOR</h3></th>
</tr>

<?php
echo"
<tr>
  <td id='tdr'><b>CORREL.:</b></td>
  <td id='tdl'>".$docentes['iddocente']."</td>
</tr>
<tr>
  <td id='tdr'><b>USUARIO:</b></td>
  <td id='tdl'>".$docentes['usuariodocente']."</td>
</tr>
<tr>
  <td id='tdr'><b>ESCUELA:</b></td>
  <td id='tdl'>".$docentes['escuela']."</td>
</tr>
<tr>
  <td id='tdr'><b>NOMBRE DOCENTE:</b></td>
  <td id='tdl'>".$docentes['nombredocente']."</td>
</tr>
<tr>
  <td id='tdr'><b>EMAIL:</b></td>
  <td id='tdl'><a href='mailto:".$docentes['emaildocente']."'>".$docentes['emaildocente']."</a>"."</td>
</tr>
<tr>
  <td id='tdr'><b>TELEFONO:</b></td>
  <td id='tdl'>".$docentes['telefonodocente']."</td>
</tr>

";
?>
</table>
<br>
<center>
<?php
if ($estado=='B')
echo '
<input type="button" name="buton" class="buton" value="Dar de alta"  onclick="alta();" />
<input type="button" name="buton" class="buton" value="Regresar"  onclick="location.href=\'frmConsultarDocente.php\'"/>    
</center>
</form>
';
else{
?>
<!-- <input type="button" name="buton" class="buton" value="Modificar" <?/* php echo "onclick=\"location.href='frmModificarDocente.php?id=$docente'\""; */?>/> -->
<input type="button" name="buton" class="buton" value="Eliminar"  onclick="eliminar();" />
<input type="button" name="buton" class="buton" value="Regresar"  onclick="location.href='frmConsultarDocente.php'"/>
</center>
</form>

<?php
}
include "../../librerias/cerrar_conexion.php";
include "../../librerias/pie.php";
?>