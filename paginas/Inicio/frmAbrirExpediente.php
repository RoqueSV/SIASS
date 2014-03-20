<?php
include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";
?>

<center><h1>Apertura de expediente de Servicio Social</h1>
<p style = "font-size:12px">Click para abrir tu expediente y tener acceso a las opciones para la gesti&oacute;n de servicio social</p>    
<input type="button" class="buton" value="Abrir Expediente" onclick="document.location.href='../../archivosphp/AbrirExpediente.php'">
</center>

<?php
include "../../librerias/pie.php";
include "../../librerias/cerrar_conexion.php";
?>