<?php

/****** Validación de archivos ******/
$uploadedfileload="true";
if ($operacion==1){
$prefijo = substr(md5(uniqid(rand())),0,6); //Prefijo de 6 caracteres para diferenciar nombre
$file_name=$prefijo.$_FILES['archivo']['name'];


// Validar tamaño maximo
if ($_FILES['archivo']['size']>(7340032))
{include "plantilla_fondo.php";
$msg='<script>alert("El archivo es mayor que 7Mb, debe reduzcirlo antes de subirlo");
document.location.href= "../paginas/Descargas/frmNuevoDocumento.php"</script>';
$uploadedfileload="false";}
// Validar formato
else {
  if (!($_FILES['archivo']['type'] == "application/octect-stream" OR $_FILES['archivo']['type'] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" OR $_FILES['archivo']['type'] == "application/msword" OR $_FILES['archivo']['type'] == "application/pdf"))
   {
   include "plantilla_fondo.php";
   $msg='<script>alert("Tu archivo tiene que ser pdf o word. Otros archivos no son permitidos");
   document.location.href= "../paginas/Descargas/frmNuevoDocumento.php"</script>';
   $uploadedfileload="false";
   }
}
// Si cumple condiciones especificar carpeta donde se guardará

$add="documentos/$file_name";

if($uploadedfileload=="true")
{

   if(move_uploaded_file ($_FILES['archivo']['tmp_name'], $add)){
   $ruta=$add;
   }
 else {exit( '<script>alert("Error al subir el archivo");
 document.location.href= "../paginas/Descargas/frmNuevoDocumento.php"</script>');
 }

}else{exit ($msg);}
} // Fin insertar

if ($operacion==2){
// Modificar

if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {//Verificar si ha subido un archivo
// Validar tamaño maximo
if ($_FILES['archivo']['size']>(7340032))
{include "plantilla_fondo.php";
$msg='<script>alert("El archivo es mayor que 7Mb, debe reduzcirlo antes de subirlo");
document.location.href= "../paginas/Cuenta/frmModificaCuenta.php"</script>';
$uploadedfileload="false";}

// Validar formato
else {
  if (!($_FILES['archivo']['type'] == "application/octect-stream" OR $_FILES['archivo']['type'] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" OR $_FILES['archivo']['type'] == "application/vnd.ms-word" OR $_FILES['archivo']['type'] == "application/pdf"))
   {
   include "plantilla_fondo.php";
   $msg='<script>alert("Tu archivo tiene que ser pdf o word. Otros archivos no son permitidos");
   document.location.href= "../paginas/Cuenta/frmModificaCuenta.php"</script>';
   $uploadedfileload="false";
   }
}


// Si cumple condiciones especificar carpeta donde se guardara

$add=$_GET['archivo'];

if (strlen($add)==0) // si hay null en campo del archivo (no habia doc) en la BD
{$prefijo = substr(md5(uniqid(rand())),0,6); //Prefijo de 6 caracteres para diferenciar nombre
$file_name=$prefijo.$_FILES['archivo']['name'];
$add="documentos/$file_name";}


if($uploadedfileload=="true")
{
   if(move_uploaded_file ($_FILES['archivo']['tmp_name'], $add)){
   $ruta=$add;
   }
 else {exit('<script>alert("Error al subir el archivo");
 document.location.href= "../paginas/Cuenta/frmModificaCuenta.php"</script>');
 }

}else {exit ($msg); }
}
else{ $add=$_GET['archivo']; $ruta=$add; } 
    
}// fin Modificar
?>
