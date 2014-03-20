<?php
session_start ();

require_once '../../librerias/crearWord/PHPWord.php';
require_once '../../librerias/abrir_conexion.php';
require_once '../../librerias/crearWord/FuncionesPHP.php';
require_once '../../librerias/crearWord/numerosALetras.class.php';

//creamos un objeto numerosAletras para usar el metodo conversion posteriormente.
$n = new numerosALetras (0) ;

$jefe=pg_fetch_array(pg_query("select nombreadmin from administrador where idadministrador=".$_SESSION['IDUSER']));

$query="
select nombreescuela, nombrecarrera, apellidosalumno||' '||nombrealumno nomalumno, carnet,
horas, nomproyecto, iniciotutoria,fintutoria, horas
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
$horas_ganadas=0;
while($row = pg_fetch_array($resul)){
$nombreescuela=$row['nombreescuela'];
$nombrecarrera=$row['nombrecarrera'];
$nombrealumno=$row['nomalumno'];
$carnet=$row['carnet'];
$horas_ganadas=$horas_ganadas + $row['horas'];
}


// Nuevo documento de word
$PHPWord = new PHPWord();

//establecemos el tipo y tamaï¿½o de texto para el doc (originalmente es arial con font 10)
$PHPWord->setDefaultFontName('Arial');
$PHPWord->setDefaultFontSize(12);

//propiedades del documento a generar
$properties = $PHPWord->getProperties();
$properties->setCreator('Unidad de Proyeccion Social'); 
$properties->setCompany('Facultad Jurisprudencia y Ciencias Sociales (UES)');
$properties->setTitle('Constancia del Servicio Social');

// New portrait section
$section = $PHPWord->createSection();

//a?adiendo elementos de texto
$PHPWord->addFontStyle('rStyle', array('bold'=>true, 'size'=>12));
$PHPWord->addParagraphStyle('pStyle', array('align'=>'center', 'spaceAfter'=>10));
// Add table
// Add header
$header = $section->createHeader();
$table = $header->addTable();
$table->addRow();
$table->addCell(4500)->addImage('../../imagenes/UPSJurisprudencia.jpg', array('width'=>600, 'height'=>100, 'align'=>'center'));



/*
$table = $section->addTable();
$table->addRow();
$fila=$table->addCell(10000);
$fila->addText('UNIVERSIDAD DE EL SALVADOR', 'rStyle','pStyle');
$fila->addText('FACULTAD DE JURISPRUDENCIA Y CIENCIAS SOCIALES', 'rStyle','pStyle');
$fila->addText(strtoupper($nombreescuela), 'rStyle','pStyle');
$fila->addText('SUBUNIDAD DE PROYECCION SOCIAL', 'rStyle','pStyle');
$table->addCell(500)->addImage('..\..\imagenes\minerva.png', array('width'=>80, 'height'=>100, 'align'=>'right'));
*/

$section->addTextBreak(1);
//jefe Unidad
if($_SESSION['TYPEUSER']==1){
$cargo="Jefe de la Unidad";
}

//coordinador
if($_SESSION['TYPEUSER']==2){
$cargo="Coordinador de la Subunidad";
}

$section->addText('EL SUSCRITO JEFE DE LA UNIDAD DE PROYECCION SOCIAL, FACULTAD DE JURISPRUDENCIA Y CIENCIAS SOCIALES DE LA UNIVERSIDAD DE EL SALVADOR HACE CONSTAR: ', null,array('align'=>'both','spacing'=>100));

$section->addTextBreak(1);

$section->addText('Que  el (la) Bachiller: '.strtoupper($nombrealumno).', con carné nº: '.strtoupper($carnet).', estudiante de la Carrera de '.strtoupper($nombrecarrera).', ha realizado: '.trim(strtoupper($n->convertir($horas_ganadas))).' ('.$horas_ganadas.') HORAS de su Servicio Social, realizando el (los) proyecto(s):', null,array('align'=>'both','spacing'=>100));

pg_result_seek($resul,0);
while($row=pg_fetch_array($resul)){
$section->addText('- "'.strtoupper($row['nomproyecto']).'" iniciado el día: '.fecha2letra($row['iniciotutoria'],1).', y finalizado el '.fecha2letra($row['fintutoria'],1).'.', null,array('align'=>'both'));
}
$mes_ano=explode(' del ',fecha2letra(date('Y-m-d'),2));
$section->addTextBreak(1);
$section->addText('Y para efectos de continuar su Servicio Social en el tiempo establecido en el Reglamento de Proyección Social, extiendo, firmo y sello la presente en ciudad Universitaria, '.strtolower($mes_ano[0]).' de '.$n->convertir($mes_ano[1]), null,array('align'=>'both','spacing'=>100));

$section->addTextBreak(1);
$section->addText('"HACIA LA LIBERTAD POR LA CULTURA"', null,null);
$section->addTextBreak(1);
$section->addTextBreak(1);
$section->addText('_______________________________', null,'pStyle');
$section->addText($jefe['nombreadmin'], null,'pStyle');
$section->addText($cargo.' de Proyección Social', null,'pStyle');


// Guardar Archivo
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$objWriter->save('constanciaSS.docx');

include '..\..\librerias\cerrar_conexion.php';


$documento = 'constanciaSS.docx'; $nombredoc="Constancia Servicio Social.docx";
header('Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment; filename="'.$nombredoc.'"');
readfile($documento);

?>
