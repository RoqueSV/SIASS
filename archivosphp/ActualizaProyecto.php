<?php //Mantto solicitud-proyecto  sp_mantto_solicitudproyecto

session_start();
include "../librerias/abrir_conexion.php";

$operacion=$_GET['operacion'];

if ($operacion == 1){
$fechasolicitud = date('Y-m-d');
$idalumno=$_SESSION['IDUSER'];   
$idproyecto=$_GET['id'];
$comentario=$_POST['comentario'];
$estado='P';   
}

if($operacion==2){
$nomproyecto=$_POST['nombre'];
$idpropuesta=$_POST['idpropuesta'];
$nominstitucion=$_POST['institucion'];
$descripcion=$_POST['descripcion'];
$idproyecto=$_GET['id'];
$estudiantes=$_POST['estrequeridos'];
$duracion=$_POST['durestimada'];
$nomcontacto=$_POST['contacto'];
$correo=$_POST['correo'];
$comentarioprop=$_POST['comentario'];
$idpropuesta=$_POST['idpropuesta'];
$idinstitucion=$_POST['idinstitucion'];
$estadoprop=$_POST['estadoprop'];

// $estadoProyecto=$_POST['estadoProyecto'];
//UPDATE--aqui!
$instruccion_actualiza ="select * FROM sp_mantto_propuesta(
                                                '$operacion',
                                                '$idpropuesta',
                                                '$idinstitucion',
												'$nominstitucion',
												'$nomproyecto',
                                                '$descripcion', 
												'$estudiantes', 
												'$duracion', 
												'$nomcontacto', 
												'$correo',
												'$estadoprop',
												'$comentarioprop');";

// $instruccion_actualiza2="SELECT * FROM sp_mantto_proyecto('$operacion','$idproyecto','$estadoProyecto');";

$resultado_solicitud= pg_query($instruccion_actualiza) or die ("<SPAN CLASS='error'>Fallo en consulta sp_mantto_propuesta!!</SPAN>".pg_last_error());
// $resultado_solicitud2= pg_query($instruccion_actualiza2) or die ("<SPAN CLASS='error'>Fallo en consulta sp_mantto_proyecto!!</SPAN>".pg_last_error());
$respuesta=  pg_fetch_array($resultado_solicitud);
$row=$respuesta[0];

}
 //muestra pagina de fondo mientras esta activo el cuadro de dialogo


include "plantilla_fondo.php";
        

echo "    
        <script language='JavaScript'>
        alert('$row');
        window.location = '../paginas/Proyecto/frmConsultarProyecto.php';
        </script>";

include "../librerias/cerrar_conexion.php";
?>