<?php
include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";

$datos_docs = pg_query ("select * from archivos");

if(pg_num_rows($datos_docs)>0)
{
?>

<style>.tinytable{width: 80%;}</style>   
<center><h2>Descarga de Documentos</h2>
  Descarga aqui los diferentes formularios necesarios para el procedimiento del Servicio Social.
</center><br>

<table border='0' class='tinytable' align="center" cellpadding="0" cellspacing="0">
<thead class="titulo1">
<tr>
<th width="35%"><h3>Documento</h3></th>
<th width="35%"><h3>Descarga</h3></th>
</tr>
</thead>

<?php 
while($row=pg_fetch_array($datos_docs)){ ?>
<tr>
 <td><b><?php echo strtoupper($row['nombre']); ?></b></td>
 <td>
 <a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../../archivosphp/Descargas.php?file=<?php echo $row['ruta']; ?>&nombre=<?php echo $row['nombre']; ?>'"> <img  name='doc' id='doc' src='../../imagenes/descargas.jpg'/></a>
 </td>
</tr>
<?php }//fin while
?>

</table>
<br><br>
<?php 
}//fin if pg_num_rows
else{
?>
<h2 align="center" class="encabezado2"><img src="../../imagenes/exit.png"><br>NO EXISTEN DOCUMENTOS PARA DESCARGA</h2>
<br>
<?php
}
include "../../librerias/pie.php";
include "../../librerias/cerrar_conexion.php";
?>