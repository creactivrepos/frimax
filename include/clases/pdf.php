<?php 
include_once 'fpdf/fpdf.php';
class PDF extends FPDF
{
	// Cabecera de página
	function Header()
	{
		$this->Image('fondo.jpg',0,0,205, 300);
		//$this->SetFont('Arial','B',15);
		//$this->Cell(80);
		//$this->Cell(30,10,'Title',1,0,'C');
		//$this->Ln(20);
	}
	
}