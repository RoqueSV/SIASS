<?php
require('../../librerias/CrearPdf/fpdf.php');

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
   	$this->Cell(30,10,'LISTADO DE ALUMNOS EN PROCESO DE SERVICIO SOCIAL.',0,1,'C');
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
$query="select carnet, apellidosalumno|| ', '||nombrealumno nombre, porcentaje, codcarrera  
from alumno a join carrera c on  a.idcarrera=c.idcarrera
where a.porcentaje >= c.porcentajecarrera and (a.idalumno in (select idalumno from solicitud_proyecto) or a.idalumno in (select idalumno from alumno_proyecto)) 
and ((select coalesce(sum(horas),0) from alumno_proyecto where idalumno=a.idalumno and estadoalumnoproyecto='F') < 
(select horasrequeridas from carrera c join alumno a2 on (c.idcarrera=a2.idcarrera) where a2.idalumno=a.idalumno))
order by codcarrera, carnet;";
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
if(count($data)>0)
$pdf->Output();
else
include "plantilla_sindatos.php";
?>