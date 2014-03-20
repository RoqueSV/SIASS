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

$usuario=$_GET['id'];
$instruccion_select = "
SELECT
idadministrador,
usuario,
clave,
cargo,
nombreadmin,
emailadmin,
telefonoadmin
FROM administrador
WHERE idadministrador = '$usuario'";

$consulta_usuarios = pg_query($instruccion_select) or die ("<SPAN CLASS='error'>Fallo en consulta_usuario!!</SPAN>".pg_last_error());
$usuarios = pg_fetch_array($consulta_usuarios);



echo"<script type='text/javascript'>
function pregunta() {

    if(confirm('\xbfEsta seguro de eliminar este registro?')) {

        document.location.href= '../../archivosphp/ManttoAdministrador.php?id=$usuario&operacion=3';

    }

}
</script> "; 
?>
<style>.tinytable{width: 40%;}</style>
<center><h2>Usuario: <?php echo $usuarios["usuario"]; ?> </h2></center><br>

<table class="tinytable" align="center">
<tr>
  <th colspan="2"><h3>DATOS DE USUARIO</h3></th>
</tr>

<?php
echo"
<tr>
  <td id='tdr'><b>CODIGO USUARIO:</b></td>
  <td id='tdl'>".$usuarios['idadministrador']."</td>
</tr>
<tr>
  <td id='tdr'><b>USUARIO:</b></td>
  <td id='tdl'>".$usuarios['usuario']."</td>
</tr>
<tr>
  <td id='tdr'><b>CARGO:</b></td>
  <td id='tdl'>".$usuarios['cargo']."</td>
</tr>
<tr>
  <td id='tdr'><b>NOMBRE USUARIO:</b></td>
  <td id='tdl'>".$usuarios['nombreadmin']."</td>
</tr>
<tr>
  <td id='tdr'><b>EMAIL:</b></td>
  <td id='tdl'>".$usuarios['emailadmin']."</td>
</tr>
<tr>
  <td id='tdr'><b>TELEFONO:</b></td>
  <td id='tdl'>".$usuarios['telefonoadmin']."</td>
</tr>

";
?>
</table>
<br>
<center>
<!-- <input type="button" name="buton" class="buton" value="Modificar" <?php /*echo "onclick=\"location.href='../Cuenta/frmConfirmarUsuario.php?id=$usuario'\""; */?> /> --> 
<input type="button" name="buton" class="buton" value="Eliminar"  <?php echo "onclick=\"pregunta();\""; ?>/>
<input type="button" name="buton" class="buton" value="Regresar"  <?php echo  "onclick=\"location.href='frmConsultarAdministrador.php'\""; ?>/>
</center>

<?php
include "../../librerias/cerrar_conexion.php";
include "../../librerias/pie.php";
?>