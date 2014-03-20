<?php 
	session_start();
	session_destroy();
	echo '<script>alert("Se cerr\xf3 correctamente la sesi\xf3n")</script>';
	echo "
        <script>
        window.location='Menu.php'
        window.parent.frames[3].location='../paginas/Inicio/plantilla_pagina.php'
        </script>";      
?> 