<?php
session_start ();

require_once '../../librerias/crearWord/PHPWord.php';
include '../../librerias/abrir_conexion.php';
include '../../librerias/crearWord/FuncionesPHP.php';
include '../../librerias/crearWord/numerosALetras.class.php';

//creamos un objeto numerosAletras para usar el metodo conversion posteriormente.
$n = new numerosALetras (0) ;

$jefe=pg_fetch_array(pg_query("select nombreadmin from administrador where idadministrador=".$_SESSION['IDUSER']));

//estado=pg_fetch_array(pg_query(""));

$query="
select nombreescuela, nombrecarrera, codcarrera, apellidosalumno||' '||nombrealumno nomalumno, carnet,
horas, nomproyecto, iniciotutoria,fintutoria, horasrequeridas, ap.idalumno, ap.idproyecto, revision
from escuela e
join carrera c on e.idescuela=c.idescuela
join alumno a on c.idcarrera=a.idcarrera
join alumno_proyecto ap on a.idalumno=ap.idalumno
join proyecto p on ap.idproyecto=p.idproyecto
join se_convierte sc on p.idproyecto=sc.idproyecto
join propuesta_proyecto pp on sc.idpropuesta=pp.idpropuesta
join tutoria t on p.idproyecto=t.idproyecto
join tutoria_alumno ta on (ta.idtutoria=t.idtutoria and ta.idalumno=a.idalumno)
where a.idalumno=".$_GET['ida'].";
";
$resul=pg_query($query);

$band=false; //variable bandera utilizada para saber si la constancia ya habia sido impresa 
				//con anterioridad, y marcar su condicion de reposicion en su generacion

while($row = pg_fetch_array($resul)){
$nombreescuela=$row['nombreescuela'];
$nombrecarrera=$row['nombrecarrera'];
$codcarrera=$row['codcarrera'];
$nombrealumno=$row['nomalumno'];
$carnet=$row['carnet'];
$horasrequeridas=$row['horasrequeridas'];


if($row['revision']==3)
$band=true;

if($row['revision']==1||$row['revision']==2){
pg_fetch_array(pg_query("update alumno_proyecto set revision=3 where idalumno=".$row['idalumno']." and idproyecto=".$row['idproyecto'].";"));
}//if
}



// Nuevo documento de word
$PHPWord = new PHPWord();

//establecemos el tipo y tamaño de texto para el doc (originalmente es arial con font 10)
$PHPWord->setDefaultFontName('Arial');
$PHPWord->setDefaultFontSize(12);

//propiedades del documento a generar
$properties = $PHPWord->getProperties();
$properties->setCreator('Unidad de Proyeccion Social'); 
$properties->setCompany('Facultad Jurisprudencia y Ciencias Sociales (UES)');
$properties->setTitle('Certificacion del Servicio Social');

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
$section->addText($codcarrera.'/001/'.date('Y'), array('bold'=>true),array('align'=>'right'));
$section->addTextBreak(1);

//a?adiendo elementos de texto
$PHPWord->addFontStyle('rStyle', array('bold'=>true, 'size'=>12));
$PHPWord->addParagraphStyle('pStyle', array('align'=>'center', 'spaceAfter'=>10));

//jefe Unidad
if($_SESSION['TYPEUSER']==1){
$cargo="Jefe de la Unidad";
}

//coordinador
if($_SESSION['TYPEUSER']==2){
$cargo="Coordinador de la Subunidad";
}

$section->addText('El Suscrito Jefe de la Unidad de Proyección Social de la Facultad de
Jurisprudencia y Ciencias Sociales de la Universidad de El Salvador CERTIFICA:
Que el (la) Bachiller '.strtoupper($nombrealumno).' con carné N° '.strtoupper($carnet).', estudiante de la carrera 
de '.strtoupper($nombrecarrera).', ha concluido satisfactoriamente '.trim(strtoupper($n->convertir($horasrequeridas))).' ('.$horasrequeridas.') HORAS de
Servicio Social, de conformidad a lo establecido en los artículos sesenta y uno de
la Constitución de la República, diecinueve de la Ley de Educación Superior,
cuarenta y dos Ley Orgánica de la Universidad de El Salvador, sesenta del
Reglamento General de la Ley Orgánica de la Universidad de El Salvador, treinta y
uno y siguientes del Reglamentos General de Proyección Social de la Universidad
de El Salvador y Manual de Procedimientos para la Ejecución del Servicio Social,
como requisito previo para optar a su respectivo grado Académico, desarrollando
el(los) Proyecto(s): ',null,array('align'=>'both','spacing'=>100));

pg_result_seek($resul,0);
while($row=pg_fetch_array($resul)){
$section->addText('- '.$row['nomproyecto'].' habiendo iniciado el día: '.fecha2letra($row['iniciotutoria'],1).', y finalizado el '.fecha2letra($row['fintutoria'],1).'.', null,array('align'=>'both'));
}

$section->addText('POR TANTO: se extiende y firma la presente CERTIFICACION para los
consiguientes trámites de graduación, en Ciudad Universitaria, '.fecha2letra(date('Y-m-d'),1).'.-',null,array('align'=>'both','spacing'=>100));

$section->addTextBreak(1);
$section->addTextBreak(1);

// Añadiendo tabla
$table = $section->addTable();
$table->addRow();
$fila=$table->addCell(16000);//8000
$fila->addText('_______________________________', null,'pStyle');
$fila->addText($jefe['nombreadmin'], null,'pStyle');
$fila->addText('Jefe de Proyección Social', null,'pStyle');
/*
$fila=$table->addCell(8000);
$fila->addText('_______________________________', null,'pStyle');
$fila->addText('alguien', null,'pStyle');
$fila->addText('Coordinador de Subunidad', null,'pStyle');
*/

if($band==true){
$section->addTextBreak(1);
$section->addTextBreak(1);
$section->addText('REPOSICION',array('bold'=>true),array('align'=>'left'));
}

// Guardar Archivo
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$objWriter->save('certificacionSS.docx');

include '..\..\librerias\cerrar_conexion.php';


$documento = 'certificacionSS.docx'; $nombredoc="Certificacion Finalizacion Servicio Social.docx";
header('Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment; filename="'.$nombredoc.'"');
readfile($documento);

?>