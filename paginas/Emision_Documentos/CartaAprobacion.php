<?php
session_start ();

require_once '../../librerias/crearWord/PHPWord.php';
require_once '../../librerias/abrir_conexion.php';
require_once '../../librerias/crearWord/FuncionesPHP.php';
require_once '../../librerias/crearWord/numerosALetras.class.php';

//creamos un objeto numerosAletras para usar el metodo conversion posteriormente.
$n = new numerosALetras (0) ;

$jefe=pg_fetch_array(pg_query("select nombreadmin from administrador where idadministrador=".$_SESSION['IDUSER']));


//Recibimos el id de la propuesta para verificar si es realizada por un alumno o por institucion
$idpropuesta=$_GET['idp'];
$idalumno=$_GET['ida'];

$esInstRegistrada=pg_fetch_array(pg_query("select count(*) from propuesta_proyecto pp join institucion i on (pp.idinstitucion=i.idinstitucion) where pp.idpropuesta=".$idpropuesta));

if($esInstRegistrada[0]>0) // propuesta tiene asignada una institucion registrada
{
$esPropAlumno=pg_fetch_array(pg_query("select count(*) from hace where idpropuesta=".$idpropuesta));

if($esPropAlumno[0]>0)// la propuesta fue realizada por un alumno
{
$query="select nombrealumno ||' '|| apellidosalumno nombre, carnet, nominstitucion institucion, nomcontacto contacto, null cargo, nombrecarrera
from alumno a 
join alumno_proyecto ap on (a.idalumno=ap.idalumno)
join proyecto p on (ap.idproyecto=p.idproyecto)
join se_convierte sc on (p.idproyecto=sc.idproyecto)
join propuesta_proyecto pp on (sc.idpropuesta=pp.idpropuesta)
join carrera c on (c.idcarrera=a.idcarrera)
where a.idalumno=".$idalumno." and pp.idpropuesta=".$idpropuesta;
}

if($esPropAlumno[0]==0) // la propuesta no fue realizada por alumno, sino por institucion
{
$query="select nombrealumno ||' '|| apellidosalumno nombre, carnet, nombreinstitucion institucion, nombrecontacto contacto, cargocontacto cargo, nombrecarrera
from alumno a 
join alumno_proyecto ap on (a.idalumno=ap.idalumno)
join proyecto p on (ap.idproyecto=p.idproyecto)
join se_convierte sc on (p.idproyecto=sc.idproyecto)
join propuesta_proyecto pp on (sc.idpropuesta=pp.idpropuesta)
join institucion i on (pp.idinstitucion=i.idinstitucion)
join carrera c on (c.idcarrera=a.idcarrera)
where a.idalumno=".$idalumno." and pp.idpropuesta=".$idpropuesta;
}

}//fin if externo

if($esInstRegistrada[0]==0) // propuesta no tiene asignada una institucion registrada
{
$query="select nombrealumno ||' '|| apellidosalumno nombre, carnet, nominstitucion institucion, nomcontacto contacto, null cargo, nombrecarrera
from alumno a 
join alumno_proyecto ap on (a.idalumno=ap.idalumno)
join proyecto p on (ap.idproyecto=p.idproyecto)
join se_convierte sc on (p.idproyecto=sc.idproyecto)
join propuesta_proyecto pp on (sc.idpropuesta=pp.idpropuesta)
join carrera c on (c.idcarrera=a.idcarrera)
where a.idalumno=".$idalumno." and pp.idpropuesta=".$idpropuesta;
}

$resul=pg_fetch_array(pg_query($query));

// Nuevo documento de word
$PHPWord = new PHPWord();

//establecemos el tipo y tamaño de texto para el doc (originalmente es arial con font 10)
$PHPWord->setDefaultFontName('Arial');
$PHPWord->setDefaultFontSize(11);

//propiedades del documento a generar
$properties = $PHPWord->getProperties();
$properties->setCreator('Unidad de Proyeccion Social'); 
$properties->setCompany('Facultad Jurisprudencia y Ciencias Sociales (UES)');
$properties->setTitle('Carta de Aprobacion de Servicio Social');

// New portrait section
$section = $PHPWord->createSection();

// Add header
$header = $section->createHeader();
$table = $header->addTable();
$table->addRow();
$table->addCell(4500)->addImage('../../imagenes/UPSJurisprudencia.jpg', array('width'=>600, 'height'=>100, 'align'=>'center'));

//añadiendo elementos de texto
$PHPWord->addFontStyle('rStyle', array('bold'=>true, 'size'=>12));
$PHPWord->addParagraphStyle('pStyle', array('align'=>'center', 'spaceAfter'=>10));

// el NOJEKE asumo es el codigo de la carrera del alumno 
$section->addText('REF.UPS-/'.date('Y'), array('bold'=>true),array('align'=>'left'));
//$section->addTextBreak(1);

$section->addText('Ciudad Universitaria, '.fecha2letra(date('Y-m-d'),1), array('bold'=>false),array('align'=>'right'));
//$section->addTextBreak(1);

//a?adiendo elementos de texto
$PHPWord->addFontStyle('rStyle', array('bold'=>true, 'size'=>12));
$PHPWord->addParagraphStyle('pStyle', array('align'=>'center', 'spaceAfter'=>10));

$section->addText($resul['contacto'],array('bold'=>true),array('align'=>'left','spaceAfter'=>10));
$section->addText($resul['cargo'],array('bold'=>true),array('align'=>'left','spaceAfter'=>10));
$section->addText($resul['institucion'],array('bold'=>true),array('align'=>'left','spaceAfter'=>10));
$section->addText("Presente.-",array('bold'=>true),array('align'=>'left','spaceAfter'=>10));

$section->addTextBreak(1);

$section->addText('	Sirva la presente para saludarle y desearle éxitos en sus labores profesionales.',null,array('align'=>'both','spacing'=>100));
$section->addText('Aprovecho la ocasión para manifestarle que el (la) Bachiller: '.strtoupper($resul['nombre']).', carné nº '.$resul['carnet'].', 
estudiante de la carrera de '.$resul['nombrecarrera'].', me ha informado su deseo de realizar el servicio social en la 
unidad que usted dignamente dirige, por lo que con todo respeto a usted solicito conceda un espacio para que el (la) Bachiller 
antes mencionado/a, pueda desempeñar su actividad.',null,array('align'=>'both','spacing'=>100));

$section->addText('Sin más por el momento, agradezco su atención, y expreso mis muestras de consideración y estima.',null,array('align'=>'both','spacing'=>100));

$section->addText('Atentamente,',null,array('align'=>'both','spacing'=>100));

$section->addText('"HACIA LA LIBERTAD POR LA CULTURA"', array('bold'=>true),array('align'=>'left'));

$section->addTextBreak(2);

// Añadiendo tabla
$table = $section->addTable();
$table->addRow();
$fila=$table->addCell(16000);//8000
$fila->addText('_______________________________', array('bold'=>true),'pStyle');
$fila->addText($jefe['nombreadmin'], array('bold'=>true),'pStyle');
$fila->addText('Jefe Unidad de Proyección Social', array('bold'=>true),'pStyle');


// Guardar Archivo
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$objWriter->save('cartaAprobacion.docx');

include '..\..\librerias\cerrar_conexion.php';


$documento = 'cartaAprobacion.docx'; $nombredoc="Carta de aprobacion de proyecto.docx";
header('Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment; filename="'.$nombredoc.'"');
readfile($documento);

?>
