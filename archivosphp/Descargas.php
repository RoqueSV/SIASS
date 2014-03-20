<?php
if (!isset($_GET['file']) || empty($_GET['file'])) {
 exit();
}

$root = 'documentos/';
$file = basename($_GET['file']);
$path = $root.$file;
$type = '';
$extension=strtolower(end(explode('.',$file)));
$nombredoc = $_GET['nombre'].'.'.$extension;

 if (is_file($path)) {
 $size = filesize($path);
 if (function_exists('mime_content_type')) {
 $type = mime_content_type($path);
 } else if (function_exists('finfo_file')) {
 $info = finfo_open(FILEINFO_MIME);
 $type = finfo_file($info, $path);
 finfo_close($info);
 }
 else{
        switch($extension)
        {
            case 'pdf': $type = 'application/pdf';
            break;
            case 'docx': $type = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';  
            break;
            case 'doc': $type = 'application/msword';  
            break;
            default: $type = 'application/force-download';
        }
 }
 // Definir headers
 header('Pragma: public'); 
 header('Expires: 0');
 header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
 header('Content-Type: '.$type.'');
 header('Content-Disposition: attachment; filename="'.$nombredoc.'"');
 header('Content-Transfer-Encoding: binary');
 header('Content-Length: '.$size.'');
 // Descargar archivo
 readfile($path);
 clearstatcache();
} else {
 die("El archivo no existe.");
}
?>
