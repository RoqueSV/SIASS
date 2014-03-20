<?php
session_start();
/* Bloque seguridad */
if (!(isset($_SESSION['TYPEUSER']))) {
header("Location: ../../paginas/Inicio/frmAccesoDenegado.php");
exit(); 
}
else if (!($_SESSION['TYPEUSER']==1 )) { // 4- coordinador
session_destroy();
header("Location: ../../paginas/Inicio/frmAcceso.php");
exit();    
}
 /* **********    */
?>

<html>
<body>
<embed src="ManualJefe.pdf" style="width:100%; height:100%">
</body>
</html>