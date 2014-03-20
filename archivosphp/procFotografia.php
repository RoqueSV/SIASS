<?php

/****** Validación de fotografia ******/
$uploadedfileload="true";
if ($operacion==1){
$prefijo = substr(md5(uniqid(rand())),0,6); //Prefijo de 6 caracteres para diferenciar nombre
$file_name=$prefijo.$_FILES['fotografia']['name'];

// Validar tamaño maximo
if ($_FILES['fotografia']['size']>(100000))
{$msg='<script>alert("El archivo es mayor que 100kb, debes reduzcirlo antes de subirlo");
document.location.href= "../paginas/Alumno/frmIngresarAlumno.php"</script>';
$uploadedfileload="false";}

// Validar formato
else {
  if (!($_FILES['fotografia']['type'] == "image/pjpeg" OR $_FILES['fotografia']['type'] == "image/gif" OR $_FILES['fotografia']['type'] == "image/jpeg" OR $_FILES['fotografia']['type'] == "image/png"))
   {
   $msg='<script>alert("Tu archivo tiene que ser JPG, PNG o GIF. Otros archivos no son permitidos");
   document.location.href= "../paginas/Alumno/frmIngresarAlumno.php"</script>';
   $uploadedfileload="false";
   }
}
// Si cumple condiciones especificar carpeta donde se guardará

$add="fotografias/$file_name";

if($uploadedfileload=="true")
{

   if(move_uploaded_file ($_FILES['fotografia']['tmp_name'], $add)){
   $fotografia=$add;
   }
 else {exit( '<script>alert("Error al subir el archivo");
 document.location.href= "../paginas/Alumno/frmIngresarAlumno.php"</script>');
 }

}else{exit ($msg);}
} // Fin insertar

if ($operacion==2){
// Modificar

if (is_uploaded_file($_FILES['fotografia']['tmp_name'])) {//Verificar si ha subido un archivo
// Validar tamaño maximo
if ($_FILES['fotografia']['size']>(100000))
{include "plantilla_fondo.php";
$msg='<script>alert("El archivo es mayor que 100kb, debes reduzcirlo antes de subirlo");
document.location.href= "../paginas/Cuenta/frmModificaCuenta.php"</script>';
$uploadedfileload="false";}

// Validar formato
else {
  if (!($_FILES['fotografia']['type'] == "image/pjpeg" OR $_FILES['fotografia']['type'] == "image/gif" OR $_FILES['fotografia']['type'] == "image/jpeg" OR $_FILES['fotografia']['type'] == "image/png"))
   {
   include "plantilla_fondo.php";
   $msg='<script>alert("Tu archivo tiene que ser JPG, PNG o GIF. Otros archivos no son permitidos");
   document.location.href= "../paginas/Cuenta/frmModificaCuenta.php"</script>';
   $uploadedfileload="false";
   }
}


// Si cumple condiciones especificar carpeta donde se guardará

$add=$_GET['fotografia'];

if (strlen($add)==0)
{$prefijo = substr(md5(uniqid(rand())),0,6); //Prefijo de 6 caracteres para diferenciar nombre
$file_name=$prefijo.$_FILES['fotografia']['name'];
$add="fotografias/$file_name";}


if($uploadedfileload=="true")
{
   if(move_uploaded_file ($_FILES['fotografia']['tmp_name'], $add)){
   $fotografia=$add;
   }
 else {exit('<script>alert("Error al subir el archivo");
 document.location.href= "../paginas/Cuenta/frmModificaCuenta.php"</script>');
 }

}else {exit ($msg); }
}
else{ $add=$_GET['fotografia']; $fotografia=$add; } 
    
}// fin Modificar
?>
