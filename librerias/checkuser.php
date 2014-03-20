<?php
session_start();
sleep(1);
include('abrir_conexion.php');

if($_REQUEST) {
    $usuario = $_REQUEST['usuario'];
    if (strlen($usuario)==0){
     echo '<div id="Error">Requerido</div>';
    }
    else{ 
     if(isset($_SESSION['usuario'])){ /* Si modifica su cuenta su usuario se permite*/
      $id=$_SESSION['usuario']; //Viene de ModificaCuenta
      $tipo=$_SESSION['TYPEUSER'];
      switch($tipo):
	case 1: $query="select * from  administrador where usuario = '$usuario' and idadministrador<>'$id'";
	break;
	case 2: $query="select * from  administrador where usuario = '$usuario' and idadministrador<>'$id'";
	break;
	case 3: $query="select * from  administrador where usuario = '$usuario' and idadministrador<>'$id'";
	break;
	case 4: $query="select * from  docente where usuarioDocente = '$usuario' and iddocente<>'$id'";
	break;
	case 5: $query="select * from  institucion where emailContacto = '$usuario' and idinstitucion<>'$id'";
	break;
        
	default : break;
       endswitch;
      
      unset($_SESSION['usuario']);
       }
    else{ /*Si es usuario nuevo */
    $query = "select * from (select usuario from administrador 
              UNION 
              select usuarioDocente from docente
              UNION 
              select emailContacto from institucion where estadoinstitucion<>'B') as usuarios where usuario = '$usuario'";}
    $results = pg_query($query) or die('ok');

    if(pg_num_rows(@$results) > 0)
        echo '<div id="Error">Usuario ya existente</div>';
    else
        echo '<div id="Success">Usuario Disponible</div>';
}
}
include('cerrar_conexion.php');
?>

