
<?php

//probando convertir a pdf

/*

require('fpdf.php');

//$pdf = new FPDF();
$pdf = new FPDF('P','mm','letter');

//Añadimos una nueva pagina al documento
$pdf->AddPage();

//establecemos la fuente que sera utilizada en adelante.
//(titulo de la pagina)
$pdf->SetFont('Arial','B',14);
$pdf->Cell(40,10,'ALUMNOS CUYO % DE CARRERA BAJO A MENOS DEL REQUERIDO.',0,1);
$pdf->Cell(40,10,'PARA REALIZAR SU SERVICIO SOCIAL.',0,1);

//Fuente para el cuerpo del documento
$pdf->SetFont('Arial','B',10);


$pdf->Output();
*/
?>





<?php /*
require('fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('../../imagenes/minerva.png',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(30,10,'Title',1,0,'C');
    // Salto de línea
    $this->Ln(20);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
for($i=1;$i<=40;$i++)
    $pdf->Cell(0,10,'Imprimiendo línea número '.$i,0,1);
$pdf->Output();
*/ ?>



<?php
require('fpdf.php');

class PDF extends FPDF
{

// Cabecera de página
function Header()
{
    // Logo
    $this->Image('../../imagenes/logo_minerva.png',10,8,25);
    // Arial bold 15
    $this->SetFont('Arial','B',12);
    
    // Título
  	// Movernos a la derecha
	$this->Cell(90);
	$this->Cell(30,10,'UNIVERSIDAD DE EL SALVADOR',0,0,'C');
	$this->Ln();
	$this->Cell(90);
	$this->Cell(30,10,'FACULTAD DE JURISPRUDENCIA Y CIENCIAS SOCIALES',0,0,'C');
	$this->Ln();
	  $this->Cell(90);
	$this->Cell(30,10,'UNIDAD DE PROYECCION SOCIAL',0,0,'C');
	
	 $this->SetFont('Arial','BU',10);
	$this->Ln(20);
	$this->Cell(80);
   	$this->Cell(30,10,'ALUMNOS QUE PIERDEN EL DERECHO PARA REALIZAR Y/O CONTINUAR SU SERVICIO SOCIAL.',0,1,'C');
	//SALTO DE LINEA
	$this->Ln(5);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
}


// Cargar los datos
function LoadData()
{
include "../../librerias/abrir_conexion.php";
//consulta para obtener los datos a mostrar
/*$query="select carnet, apellidosalumno|| ', '||nombrealumno nombre, porcentaje, codcarrera  
from alumno a join carrera c on  a.idcarrera=c.idcarrera 
where a.porcentaje < c.porcentajecarrera order by nombrecarrera;";*/
$query="select carnet, apellidosalumno|| ', '||nombrealumno nombre, porcentaje, codcarrera  from alumno, carrera, alumno_proyecto";
$resul=pg_query($query);

$data = array();
$i=1;
while ($row = pg_fetch_array($resul)){
$data[]=explode(';',$i.";".$row[0].";".$row[1].";".$row[2].";".$row[3]);
$i++;
}
    return $data;
}


// Tabla coloreada
function FancyTable($header, $data)
{
    // Colores, ancho de línea y fuente en negrita
    $this->SetFillColor(100,140,150);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Cabecera
    $w = array(10,25, 100, 30, 25);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Restauración de colores y fuentes
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Datos
    $fill = false;
    foreach($data as $row)
    {
		$this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,$row[2],'LR',0,'L',$fill);
        $this->Cell($w[3],6,$row[3]."%",'LR',0,'R',$fill);
        $this->Cell($w[4],6,$row[4],'LR',0,'R',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Línea de cierre
    $this->Cell(array_sum($w),0,'','T');
}
}

$pdf = new PDF();
//$pdf = new FPDF('P','mm','letter');
$pdf->AliasNbPages();

// Títulos de las columnas
$header = array('N°','Carnet', 'Alumno', 'Porcentaje', 'Carrera');
// Carga de datos
$data = $pdf->LoadData();
$pdf->SetFont('Arial','',12);

$pdf->AddPage();
$pdf->FancyTable($header,$data);
$pdf->Output();
?>