<?php

   session_start ();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>

<script type="text/javascript" src="../js/logueo.js"></script>
<script type="text/javascript" src="../js/menu.js"></script>
<link rel="stylesheet" type="text/css" href="../css/principal.css" >
<script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="../js/jquery.lksMenu.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/lksMenuSkin3.css" />
        <script type="text/javascript">
        $('document').ready(function(){
            $('.menu').lksMenu();
        });
        </script>
      <script type="text/javascript">
         function capLock(e){
          kc=e.keyCode?e.keyCode:e.which;
          sk=e.shiftKey?e.shiftKey:((kc==16)?true:false);
          if(((kc>=65&&kc<=90)&&!sk)||((kc>=97&&kc<=122)&&sk))
          document.getElementById('caplock').style.visibility = 'visible';
          else document.getElementById('caplock').style.visibility = 'hidden';
          }
</script> 
</head>

<body id="body">
<br />

<?php 

if(isset($_REQUEST['logueo']) OR $_SESSION['user']<>''){
	include "../librerias/abrir_conexion.php";
	
	if(isset($_REQUEST['logueo'])){
		$user=$_REQUEST['usuario'];
		$pass=$_REQUEST['pass'];
		$_SESSION['user']=$user;
		$_SESSION['pass']=$pass;
	}
	else{
		$user=$_SESSION['user'];
		$pass=$_SESSION['pass'];
	}
	$consulta="select count(*) from Administrador where USUARIO='$user'and clave=md5('$pass')";
	$sql = pg_query($consulta) or die("No se pudo realizar la consulta 1 TablaAdministrador");
	$row = pg_fetch_array($sql);
	if($row[0]<>0){
	$consulta="select rol,idAdministrador from Administrador where USUARIO='$user' and clave=md5('$pass')";
	$sql = pg_query($consulta) or die("No se pudo realizar la consulta usuario(TablaAdminstrador)");
	$row = pg_fetch_array($sql);
	
   $var = $row[0];
   $_SESSION['IDUSER']=$row[1];
   
   if($var==1){//Jefe
	   $_SESSION['TYPEUSER']=1;
            echo'<script type="text/javascript" language="Javascript">
                     parent.frames[3].location.href ="../paginas/Inicio/plantilla_pagina.php";
                     </script>';
	   //Mostrar menu jefe
		?>
	<div>
		<p align="center" style="color:#009; font-weight: bold; padding-left: 5px;">Jefe Unidad de Servicio Social</p>
                <center><img src="../imagenes/user.png" alt="Usuario" width="32" height="32"></center>
                <p align="center" style="color:#009;">Usuario: <b><?php echo $user?></b>&#32;(<a href="logout.php">Salir</a>)
		<p align="center" style="color:#009;">  
  	<div class="menu">
         <ul>
            <li>
                <a href="javascript:void(0)">Cuenta</a>
                <ul>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Cuenta/frmConfirmarUsuario.php'" >Modificar mi cuenta</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0)">Proyectos</a>
                <ul>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Proyecto/frmIngresarProyecto.php'" >Ingresar nuevo proyecto</a></li>
		    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Proyecto/frmConsultarProyecto.php'" >Consultar proyectos</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0)">Tutores</a>
                <ul>
                 <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Docente/frmIngresarDocente.php'" >Ingresar tutor</a></li>
		         <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Docente/frmConsultarDocente.php'" >Consultar tutores</a></li>
				 <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Docente/frmProysinTutor.php'" >Asignar tutor</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0)">Gesti&oacute;n de alumnos</a>
                <ul>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Alumno/frmConsultarPropuesta.php'" >Revisar propuestas</a></li>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Alumno/frmConsultarSolicitud.php'" >Revisar solicitudes</a></li>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Alumno/frmAsignarProyectoAlumno.php'" >Asignar proyecto</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0)">Instituciones</a>
                <ul>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Institucion/frmVerSolicitudInstitucion.php'" >Ver solicitudes</a></li>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Institucion/frmConsultarPropuestas.php'" >Ver propuestas de proyectos</a></li>
					<li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Institucion/frmConsultarInstituciones.php'" >Consultar instituciones</a></li>
                </ul>
            </li>
	    <li>
                <a href="javascript:void(0)">Emisi&oacute;n de documentos</a>
                <ul>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Emision_Documentos/frmEmisionDocAlumnosParc.php'" >Constancia de Servicio Social</a></li> 
					<li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Emision_Documentos/frmEmisionDocAlumnosCert.php'" >Certificacion de Finalizaci&oacute;n de S.S.</a></li>
					<li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Emision_Documentos/frmCartaVerProyectos.php'" >Carta para la Institución</a></li>
				</ul>
			</li>
            <li>
                <a href="javascript:void(0)">Gesti&oacute;n de archivos</a>
                <ul>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Descargas/frmNuevoDocumento.php'" >Nuevo archivo</a></li>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Descargas/frmConsultarDocumentos.php'" >Consultar Archivos</a></li>
		</ul>
            </li>
	    <li>
                <a href="javascript:void(0)">Estadisticas</a>
                <ul>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Estadisticas/frmListaAlumnos.php'" >Hist&oacute;rico de alumnos</a></li>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Estadisticas/frmListaTutores.php'" >Hist&oacute;rico de tutores</a></li>
					<li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Estadisticas/frmListaInstitucion.php'">Hist&oacute;rico de instituciones</a></li>
					<li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Estadisticas/frmListaProyectos.php'" >Hist&oacute;rico de proyectos</a></li>
				</ul>
            </li>
			
			 <li>
                <a href="javascript:void(0)">Reportes</a>
                <ul>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Reportes/ReporteAlumnosConExpediente.php'" >Alumnos con Expediente Abierto</a></li>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Reportes/ReporteAlumnosEnProceso.php'" >Alumnos en Proceso de S.S.</a></li>
					<li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Reportes/ReporteAlumnosFinalizaronSS.php'">Alumnos con Servicio Finalizado</a></li>
					<li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Reportes/ReporteAlumnosPierdenDerecho.php'" >Alumnos que Perdieron %</a></li>
				</ul>
            </li>
			
			<li>
                <a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Ayuda/frmAyudaJefe.php'">Ayuda</a>
            </li>
        </ul>
    </div>
 </div>	
		<?php
	}
   else{
	if($var==2){//coordinador
		$_SESSION['TYPEUSER']=2;
                 echo'<script type="text/javascript" language="Javascript">
                     parent.frames[3].location.href ="../paginas/Inicio/plantilla_pagina.php";
                     </script>';
	   //Mostrar menu coordinador
		?>
		<div>
		<p align="center" style="color:#009; font-weight: bold;">Coordinador</p>
                <center><img src="../imagenes/user.png" alt="Usuario" width="32" height="32"></center><br>
                <p align="center" style="color:#009;">Usuario: <b><?php echo $user?></b>&#32;(<a href="logout.php">Salir</a>)
		<p align="center" style="color:#009;">  
        <br/>
  	<div class="menu">
         <ul>
            <li>
                <a href="javascript:void(0)">Cuenta</a>
                <ul>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Cuenta/frmConfirmarUsuario.php'" >Modificar mi cuenta</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0)">Tutores</a>
                <ul>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Docente/frmIngresarDocente.php'" >Ingresar tutor</a></li>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Docente/frmConsultarDocente.php'" >Consultar tutores</a></li>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Docente/frmProysinTutor.php'" >Asignar tutor</a></li>
					<li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Estadisticas/frmListaTutores.php'" >Hist&oacute;rico de tutores</a></li>
                </ul>
            </li>
	     <li>
                <a href="javascript:void(0)">Emisi&oacute;n de documentos</a>
                <ul>
           <!-- <li><a href="../paginas/Emision_Documentos/frmEmisionDocParcCoor.php" target="PRINCIPAL">Constancia de Servicio Social</a></li> -->
		    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Emision_Documentos/frmEmisionDocCertCoor.php'" >Certificacion de Finalizaci&oacute;n de S.S.</a></li>
	        </ul>
            </li>
	    <li>
                <a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Ayuda/frmAyudaCoordinador.php'" >Ayuda</a>
            </li>
        </ul>
    </div>
 </div>	
		<?php
	}
        /* RESERVADO PARA OTROS USUARIOS ADMINISTRADORES */
        /* Usado para Menu Administrador */
	else{
		$_SESSION['TYPEUSER']=3;
		//mostrar menu de nivel 3
                echo'<script type="text/javascript" language="Javascript">
                     parent.frames[3].location.href ="../paginas/Inicio/plantilla_pagina.php";
                     </script>';
		?>
		<div>
		<p align="center" style="color:#009; font-weight: bold;">Administrador</p>
                <center><img src="../imagenes/user.png" alt="Usuario" width="32" height="32"></center><br>
                <p align="center" style="color:#009;">Usuario: <b><?php echo $user?></b>&#32;(<a href="logout.php">Salir</a>)
		<p align="center" style="color:#009;">  
        <br/>
  	<div class="menu">
         <ul>
            <li>
                <a href="javascript:void(0)">Cuenta</a>
                <ul>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Cuenta/frmConfirmarUsuario.php'" >Modificar mi cuenta</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0)">Gesti&oacute;n de usuarios</a>
                <ul>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Administrador/frmIngresarAdministrador.php'" >Nuevo usuario</a></li>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Administrador/frmConsultarAdministrador.php'" >Consultar usuario</a></li>
				</ul>
            </li>
            <li>
                <a href="javascript:void(0)">Gesti&oacute;n de escuelas</a>
                <ul>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Escuela/frmIngresarEscuela.php'" >Nueva escuela</a></li>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Escuela/frmConsultarEscuela.php'" >Consultar escuelas</a></li>
		</ul>
            </li>
            <li>
                <a href="javascript:void(0)">Gesti&oacute;n de carreras</a>
                <ul>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Carrera/frmIngresarCarrera.php'" >Nueva carrera</a></li>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Carrera/frmConsultarCarrera.php'" >Consultar carreras</a></li>
		</ul>
            </li>
	    <li>
                <a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Ayuda/frmAyudaAdmin.php'">Ayuda</a>
            </li>
        </ul>
    </div>
 </div>	
        <?php
	} 
         
      /*FIN RESERVADO */
   
   }//fin if-else $var==?	
}
    else{
		$consulta="select count(*) from Docente where usuariodocente='$user' and clavedocente=md5('$pass')";
		$sql = pg_query($consulta) or die("No se pudo realizar la consulta TablaDocenteTutor");
		$row = pg_fetch_array($sql);
		if($row[0]<>0){//Docente tutor
			$consulta="select idDocente from Docente where usuarioDocente='$user' and claveDocente=md5('$pass')";
			$sql = pg_query($consulta) or die("No se pudo realizar la consulta usuario(TablaDocente2)");
			$row = pg_fetch_array($sql);
	
		$_SESSION['IDUSER']=$row[0];
		$_SESSION['TYPEUSER']=4;
                echo'<script type="text/javascript" language="Javascript">
                     parent.frames[3].location.href ="../paginas/Inicio/plantilla_pagina.php";
                     </script>';
		//mostrar menu docente tutor
		?>
		<div>
		<p align="center" style="color:#009; font-weight: bold;">Tutor</p>
                <center><img src="../imagenes/user.png" alt="Usuario" width="32" height="32"></center><br>
                <p align="center" style="color:#009;">Usuario: <b><?php echo $user?></b>&#32;(<a href="logout.php">Salir</a>)
		<p align="center" style="color:#009;">  
        <br/>
  	<div class="menu">
         <ul>
            <li>
                <a href="javascript:void(0)">Cuenta</a>
                <ul>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Cuenta/frmConfirmarUsuario.php'" >Modificar mi cuenta</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0)">Proyectos</a>
                <ul>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Docente/frmVerAlumnosTutoria.php'" >Informacion de proyectos</a></li>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Estadisticas/frmEstadisticaTutor.php?id=<?php echo $_SESSION['IDUSER'];?>'" >Historial de proyectos</a></li>
                </ul>
            </li>
	    <li>
                <a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Ayuda/frmAyudaTutor.php'" >Ayuda</a>
            </li>
        </ul>
    </div>
 </div>		
		<?php
		}
		else{
			$consulta="select count(*) from Institucion where emailcontacto='$user' AND claveInstitucion=md5('$pass') AND estadoinstitucion='A'";
			$sql = pg_query($consulta) or die("No se pudo realizar la consulta TablaInstitucion");
			$row = pg_fetch_array($sql);
			if($row[0]<>0){//Institucion
				$consulta="select idInstitucion from Institucion where emailcontacto='$user' and claveInstitucion=md5('$pass')";
				$sql = pg_query($consulta) or die("No se pudo realizar la consulta usuario(Tablainstitucion)");
				$row = pg_fetch_array($sql);
		
				$_SESSION['IDUSER']=$row[0];
				$_SESSION['TYPEUSER']=5;
                               echo'<script type="text/javascript" language="Javascript">
                                parent.frames[3].location.href ="../paginas/Inicio/plantilla_pagina.php";
                                </script>';
				//mostrar menu Institucion
				?>	
		<div>
                <p align="center" style="color:#009; font-weight: bold;">Instituci&oacute;n</p>
                <center><img src="../imagenes/user.png" alt="Usuario" width="32" height="32"></center><br>
                <p align="center" style="color:#009;">Usuario: <b><?php echo $user?></b>&#32;(<a href="logout.php">Salir</a>)
		<p align="center" style="color:#009;">  
        <br/>
  	<div class="menu">
         <ul>
            <li>
                <a href="javascript:void(0)">Cuenta</a>
                <ul>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Cuenta/frmConfirmarUsuario.php'" >Modificar mi cuenta</a></li>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Institucion/frmBajaInstitucion.php'" >Darse de baja</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0)">Proyectos</a>
                <ul>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Proyecto/frmEnviarPropuestaInst.php'" >Nuevo proyecto</a></li>
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Institucion/frmProyectosActuales.php'">Proyectos actuales</a></li>
					<li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Institucion/frmHistorialProyectosInst.php'" >Historial de proyectos</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Ayuda/frmAyudaInstitucion.php'">Ayuda</a>
            </li>
        </ul>
    </div>
 </div>	
		<?php
				
			}
			else{
			//autenticar como alumno
			
			//EMPIEZA AUTENTICACION EN LDAP
		  // require_once '../librerias/ldap.php';			
			//FINALIZA AUTENTICACION LDAP
					
			$consulta="select count(*) from Alumno where carnet='$user'";
			$sql = pg_query($consulta) or die("No se pudo realizar la consulta TablaAlumno");
			$row = pg_fetch_array($sql);
			if($row[0]<>0 )//&& $conex_ldap)//Alumno
			{
                                $consulta="select idAlumno from Alumno where carnet='$user'";
				$sql = pg_query($consulta) or die("No se pudo realizar la consulta usuario(TablaAlumno)");
				$row = pg_fetch_array($sql);
                                
                                $_SESSION['IDUSER']=$row[0];
				$_SESSION['TYPEUSER']=6;
                                //mostrar menu alumno
                                echo'<script type="text/javascript" language="Javascript">
                                parent.frames[3].location.href ="../paginas/Inicio/plantilla_pagina.php";
                                </script>';
					
				?>
		<div>
		<p align="center" style="color:#009; font-weight: bold;">Alumno</p>
                <center><img src="../imagenes/user.png" alt="Usuario" width="32" height="32"></center><br>
                <p align="center" style="color:#009;">Usuario: <b><?php echo $user?></b>&#32;(<a href="logout.php">Salir</a>)
		<p align="center" style="color:#009;">  
        <br/>
  	<div class="menu">
         <ul>
            <li>
                <a href="javascript:void(0)">Perfil</a>
                <ul>
               <!--    <li><a href="../paginas/Alumno/frmIngresarAlumno.php" target="PRINCIPAL">Abrir expediente </a></li> -->
	           <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Alumno/frmVerExpediente.php'">Ver expediente</a></li>
                   <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Cuenta/frmModificaCuenta.php'">Editar informaci&oacute;n</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0)">Informaci&oacute;n de proyectos</a>
                <ul>
                   <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Proyecto/frmConsultarDisponible.php'" >Proyectos disponibles</a></li>
                   <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Alumno/frmRevisionSolicitud.php'">Revisar solicitud</a></li>        
                   <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Proyecto/frmEnviarPropuesta.php'" >Enviar propuesta</a></li>
                   <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Alumno/frmRevisionPropuesta.php'">Revisar propuesta</a></li>
                   <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Alumno/frmVerHistorialProyectos.php'" >Historial de proyectos</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0)">Gestionar proyecto</a>
                <ul>
                    
                    <!-- Acceder directo al registro propio o no mostrarse si no existe!-->
		    <?php 


                    $query="select d.iddocumento, tipodocumento, estadoproyecto 
					from alumno a 
					join alumno_proyecto ap on a.idalumno=ap.idalumno 
					join proyecto p on ap.idproyecto=p.idproyecto 
					join tutoria t on p.idproyecto=t.idproyecto 
					join documento d on t.idtutoria=d.idtutoria 
					join alumno_documento ad on (ad.iddocumento=d.iddocumento and ad.idalumno=a.idalumno)
					where (estadoalumnoproyecto='P' or estadoproyecto='C') and a.idalumno=".$_SESSION['IDUSER']." 
					group by d.iddocumento, estadoproyecto, tipodocumento;
					";
                    $resul1 = pg_query($query) or die("No se pudo realizar la consulta (verificar memoria de labores del proyecto)");
                    if(pg_num_rows($resul1)==0)
                    echo '<li><a href="javascript:void(0)">Ningun proyecto en proceso</a></li>';
                    while($resul2 = pg_fetch_array($resul1)){
                    
					if($resul2['estadoproyecto']=="C"){
					if($resul2['tipodocumento']=="P"){
					?>
					<li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Alumno/frmIngresarActividadesAlumno.php?iddoc=<?php echo $resul2['iddocumento'];?>'" >Plan de trabajo</a></li>
					<?php
					}
					}//if estadoproyecto=="C"
					
					if($resul2['estadoproyecto']=="P"){
					if($resul2['tipodocumento']=="P")
					{
					?>
					<li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Alumno/frmIngresarActividadesAlumno.php?iddoc=<?php echo $resul2['iddocumento'];?>'" >Plan de trabajo</a></li>
					<?php
					}
					
					if($resul2['tipodocumento']=="M")
					{
					?>
					<li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Alumno/frmIngresarActividadesAlumno.php?iddoc=<?php echo $resul2['iddocumento'];?>'" >Memoria de labores</a></li>
					<?php
					}
					}//if estadoproyecto=="P"
					}//while
					?>
               </ul>
            </li>
            
            
          <li>
                <a href="javascript:void(0)">Certificaciones</a>
                <ul>
                  <!--  <li><a href="../paginas/Alumno/frmVerificarConstancia.php" target="PRINCIPAL">Constancia Parcial</a></li> -->
                    <li><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Alumno/frmVerificarCertificacion.php'">Certificacion de Finalizacion</a></li> 
                </ul>
         </li>
		
	    <li>
                <a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Ayuda/frmAyudaAlumno.php'" >Ayuda</a>
            </li>
        </ul>
    </div>
 </div>	
                            <?php	
                            }
							// Aqui agregado para lo de la tabla alumno aux
							else{
                                                            
							$resulAux = pg_query("select count(*) from alumno_aux where carnetaux='$user'") or die("No se realizo la consulta (alumno aux)");
							$rowAux = pg_fetch_array($resulAux);
							if(/*$conex_ldap && */ $rowAux[0] <>0){
                                                        $_SESSION['TYPEUSER']=6; 
                                                        echo'<script type="text/javascript" language="Javascript">
                                                        parent.PRINCIPAL.location.href ="../paginas/Inicio/plantilla_pagina.php";
                                                        </script>';
							?>
							<div>
								<p align="center" style="color:#009; font-weight: bold;">Alumno (Sin Expediente)</p>
								<center><img src="../imagenes/user.png" alt="Usuario" width="32" height="32"></center><br>
								<p align="center" style="color:#009;">Usuario: <b><?php echo $user?></b>&#32;(<a href="logout.php">Salir</a>)
								<p align="center" style="color:#009;">  
								<br/>
								<div class="menu">
									<ul>
										<li>
											<a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../paginas/Inicio/frmAbrirExpediente.php?carnet=<?php echo $user;?>'">Abrir Expediente</a>
										</li>
									</ul>
								</div>
							</div>
							<?php
							
							
							}//if
							
							
							
							
							//hasta aqui agregado tabla aux
                    else{
                            $_SESSION['TYPEUSER']=0;//Usuario general
                            //no se pudo loguear
                            //mostrar menu general
                            $_SESSION['user']='';
                            echo '<script>alert("Error en Datos de Usuario. Verifique sus datos e intente nuevamente")</script>';
                            echo "<script>window.location='Menu.php?Error_U=SI'</script>";
                            }
							
							}//else de la paret agregada en la consulta auxiliar de alumno
			}
		}
		
	}
}
//fin issetRequest(logueo)
else{//usuario general--- no hay logueo hasta el momento
	
   ?>

 <div id="logueo">

   <form name="login" method="post" action="Menu.php" onsubmit="return ValidarUsuario()">
  <center>
      <h2> Usuarios Registrados </h2> <br>
      Entre aqu&iacute; usando su nombre de usuario y contrase&ntilde;a. <br><br> 
  <table width="25%" border="0">
    <tr title="Digite su Usuario.">
      <td>Usuario: 
        <input name="usuario" type="text" id="usuario"></td>
    </tr>
    
    <tr>
      <td  title="Digite su Clave.">Password:
        <input name="pass" type="password" id="pass" onKeyPress="capLock(event)"></td>
       <!--  -->
    </tr>
    <tr>
      <td><center>
       <input type="submit" name="logueo" value="Iniciar Sesion">
      </center>
	  </td>
    </tr>
  </table>
</center>
<div id="caplock" style="visibility:hidden; color: red; text-align:center;">El bloqueo de may&uacute;sculas est&aacute; activado</div>
</form>
  
</div>
<?php
	}
?>
</body>
</html>
