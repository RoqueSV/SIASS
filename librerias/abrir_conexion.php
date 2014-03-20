<?php
// Asignando valores a variables
$host = "localhost";
//$host = "mywebaccess.sytes.net";
$port = "5432";
$user = "jurisprudencia";
$pass = "jurisprudencia";
$dbname = "BD_SIASS"; /* "SIASS" ;*/ 

// Conectando y seleccionado la base de datos  
$dbconn = pg_connect("
host=$host 
dbname=$dbname 
user=$user 
password=$pass 
port=$port")
or die('No se ha podido conectar : ' . pg_last_error());
?>
