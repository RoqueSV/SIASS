<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Accion Cuentas</title>
</head>

<body>
<?php
//INCLUIR LAS ACCIONES INGRESAR, ACTUALIZAR, ELIMINAR EN UN MISMO ARCHIVO
$id=$_GET['idAdmin'];
$tipousuario=$_GET['tipousuario'];

if($tipousuario==1){
	$usuario=$_POST['usuarioAdmin'];
	$nombre=$_POST['nombreAdmin'];
	$email=$_POST['emailAdmin'];
	$telefono=$_POST['telefonoAdmin'];
	$clave=$_POST['clave1'];
	$cargo=$_POST['cargoAdmin'];
	
	if($cargo=="Administrador"){
		$rol=1;
	}
	else{
		if($cargo=="Coordinador"){
			$rol=2;
		}
		else{
			if($cargo=="Sub-Coordinador"){
			$rol=3;
			}
			else{//otro
			$rol=4;
			}
		}
	}
	//SELECT sp_mantto_administrador(operacion,idadmin,usuarioadmin,pass,cargo,nombre,'admin@admin.com','22223333',rol);
	$mensaje = pg_query("SELECT sp_mantto_administrador(2,'$id','$usuario','$clave1','$cargo','$nombre','$email','$telefono','$rol');") or die("La consulta de Actualizar Administrador fallo: " . pg_last_error());
	
	echo "<script>alert('$mensaje')</script>";
	echo "<script>window.location='../verlibro.php?cod=$libro'</script>";
}
?>
</body>
</html>