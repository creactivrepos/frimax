<?php
//include_once 'include/fpdf/fpdf.php';
include_once 'include/clases/fpdf/fpdf.php';
class PDF extends FPDF
{
	// Cabecera de página
	function Header()
	{
		$this->Image('images/fondo.jpg',0,0,205, 300);
		//$this->SetFont('Arial','B',15);
		//$this->Cell(80);
		//$this->Cell(30,10,'Title',1,0,'C');
		//$this->Ln(20);
	}
	public function informacion(){
		$this->SetFont('Arial','',10);
		$this->Ln(40);
		$this->MultiCell(100,10,'Title',1,1,0,1,'C');
		$this->MultiCell(135, 5, 'Catálogo:', 1,0, 'J', 1, 1, '', '120');
		$this->MultiCell(46,7, 'Como integrante: ', 1, 'L', 1, 1, '15', '146', true);
	}
	public function accesorios(){

	}
	public function adicionales(){

	}
}

// Creación del objeto de la clase heredada

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->informacion();
$pdf->Output();
?>
