<?php
include_once 'include/clases/tcpdf/tcpdf.php';

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		$this->conect();
	}
	public function setImagen($tipo){
		$image_file = $tipo == 1 ? 'images/bg.jpg' : 'images/bg_2.jpg';
		$this->SetAutoPageBreak(false, 0);
        $this->Image($image_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
	}
	public function informacion(){
		$this->SetFont('dejavusans', '', 10, '', true);
		$this->responsable().
		$this->cliente().
		$this->asesorComercial().
		$this->fecha().
		$this->hora().
		$this->noPedido().
		$this->noOperacion().
		$this->noSerie().
		$this->chasis().
		$this->modelo().
		$this->anio().
		$this->placa();
		
	}
	/*BEGIN: Métodos para imprimir la información de la parte superior de la hoja*/
		private function responsable(){

			$this->writeHTMLCell(100, 0, 52, 47, $this->info['usuarioRec'], 0, 1, 0, true, '', true);
		}
		private function cliente(){

			$this->writeHTMLCell(100, 0, 52, 54, $this->info['nombre'], 0, 1, 0, true, '', true);
		}
		private function asesorComercial(){

			$this->writeHTMLCell(100, 0, 52, 60, $this->info['usuarioAsigna'], 0, 1, 0, true, '', true);
		}
		private function fecha(){

			$this->writeHTMLCell(40, 0, 165, 47, $this->fecha, 0, 1, 0, true, '', true);
		}
		private function hora(){

			$this->writeHTMLCell(20, 0, 175, 62, $this->hora, 0, 1, 0, true, '', true);
		}
		private function noPedido(){

			$this->SetFont('dejavusans', '', 9, '', true);
			$this->writeHTMLCell(23, 0, 37, 68, $this->info['noPedido'], 0, 1, 0, true, '', true);
		}
		private function noOperacion(){

			$this->writeHTMLCell(30, 0, 73, 68, $this->info['noOperacion'], 0, 1, 0, true, '', true);	
		}
		private function noSerie(){

			$this->writeHTMLCell(75, 0, 125, 68, $this->info['noSerie'], 0, 1, 0, true, '', true);	
		}
		private function chasis(){

			$this->writeHTMLCell(33, 0, 25, 74, $this->info['chasis'], 0, 1, 0, true, '', true);	
		}
		private function modelo(){

			$this->writeHTMLCell(30, 0, 73, 74, $this->info['modelo'], 0, 1, 0, true, '', true);	
		}
		private function anio(){

			$this->writeHTMLCell(30, 0, 112, 74, $this->info['anio'], 0, 1, 0, true, '', true);	
		}
		private function placa(){

			$this->writeHTMLCell(35, 0, 163, 74, $this->info['placa'], 0, 1, 0, true, '', true);	
		}
	/*END: Métodos para imprimir la información de la parte superior de la hoja*/
	public function accesorios(){
		$this->colOne();
		$this->colTwo();
		$this->colThree();
		
	}
	/*BEGIN: Métodos para mostrar la lista de accesorios*/
		private function colOne(){
			$x = 4.3;
			$alt = 90;
			$acc = $this->query('
				SELECT controlAccesorios.idEstatus, controlAccesorios.idAccesorio 
				FROM controlAccesorios 
				INNER JOIN in_accesorios ON in_accesorios.id = controlAccesorios.idAccesorio AND in_accesorios.columna = 1
				WHERE controlAccesorios.idControlRecibe = "'.$this->folio.'"');
			while($dat = $this->fetch_array($acc)){
				$pos = $dat['idEstatus'] == "1" ? 50 : ($dat['idEstatus'] == "2" ? 58 : 66);
				$alt = $alt + $x; 
				$this->writeHTMLCell(5, 0, $pos, $alt, "x", 0, 1, 0, true, '', true);	
			}
		}
		private function colTwo(){
			$x = 4.3;
			$alt = 90;
			$acc = $this->query('
				SELECT controlAccesorios.idEstatus, controlAccesorios.idAccesorio 
				FROM controlAccesorios 
				INNER JOIN in_accesorios ON in_accesorios.id = controlAccesorios.idAccesorio AND in_accesorios.columna = 2
				WHERE controlAccesorios.idControlRecibe = "'.$this->folio.'"');
			while($dat = $this->fetch_array($acc)){
				$pos = $dat['idEstatus'] == "1" ? 113 : ($dat['idEstatus'] == "2" ? 120 : 128);
				$alt = $alt + $x; 
				$this->writeHTMLCell(5, 0, $pos, $alt, "x", 0, 1, 0, true, '', true);	
			}
		}
		private function colThree(){
			$x = 4.3;
			$alt = 90;
			$acc = $this->query('
				SELECT controlAccesorios.idEstatus, controlAccesorios.idAccesorio 
				FROM controlAccesorios 
				INNER JOIN in_accesorios ON in_accesorios.id = controlAccesorios.idAccesorio AND in_accesorios.columna = 3
				WHERE controlAccesorios.idControlRecibe = "'.$this->folio.'"');
			while($dat = $this->fetch_array($acc)){
				$pos = $dat['idEstatus'] == "1" ? 175 : ($dat['idEstatus'] == "2" ? 182 : 189);
				$alt = $alt + $x; 
				$this->writeHTMLCell(5, 0, $pos, $alt, "x", 0, 1, 0, true, '', true);	
			}
		}
	/*END: Métodos para mostrar la lista de accesorios*/
	public function adicionales(){

	}
	public function inferior(){
		$this->SetFont('dejavusans', '', 10, '', true);
		$this->tablero().
		$this->alarma().
		$this->otro().
		$this->observaciones().
		$this->kilometraje().
		$this->reversa();
	}
	/*BEGIN: Métodos para imprimir la información de la parte inferior de la hoja*/
		private function tablero(){

			$x = $this->info['tablero'] == 1 ? 40 : 50;

			$this->writeHTMLCell(5, 0, $x, 182, "x", 0, 1, 0, true, 'C', true);	
		}
		private function alarma(){

			$x = $this->info['alarma'] == 1 ? 99 : 109;
			$this->writeHTMLCell(5, 0, $x, 182, "x", 0, 1, 0, true, 'C', true);	
		}
		private function reversa(){

			$this->SetFont('dejavusans', '', 14, '', true);
			$x = $this->info['reversa'] == 1 ? 177 : 183;
			$this->writeHTMLCell(5, 0, $x, 203, "x", 0, 1, 0, true, 'C', true);	
		}
		private function otro(){

			$this->writeHTMLCell(80, 0, 127, 182, $this->info['otro'], 0, 1, 0, true, '', true);	
		}
		private function observaciones(){
			$this->SetFont('dejavusans', '', 8, '', true);
			$this->writeHTMLCell(60, 10, 80, 197, $this->info['observaciones'], 0, 1, 0, true, '', true);	
		}
		private function kilometraje(){
			$this->SetFont('dejavusans', '', 10, '', true);
			$this->writeHTMLCell(25, 0, 175, 196, $this->info['kilometraje'], 0, 1, 0, true, '', true);	
		}
	/*END: Métodos para imprimir la información de la parte inferior de la hoja*/
	private function query($value){
		$this->total_query++;
		$result = mysql_query($value, $this->link);
		if (!$result){
			echo 'MySQL Error: '.mysql_error();
			exit;
		}
		return $result;
	}
	private function fetch_array($value){
		return mysql_fetch_array($value);
	}
	private function conect(){
		date_default_timezone_set("America/Mexico_City");
		$this->local = FALSE;
		$this->folio = $_GET['folio'];
		if($this->local){
			$this->user  		= 'consorcio';
			$this->password 	= 'kFdE-ixlWQDG%I1+';
			$this->server 		= 'localhost';
			$this->port			= '3306';
			$this->database 	= 'recepcion_logistica';
		}
		else{
			$this->user         = 'dbo686363322';
            $this->password     = 'MsEQK#W+!9VV';
            $this->server       = 'db686363322.db.1and1.com';
            $this->port         = '3306';
            $this->database     = 'db686363322';
		}
		$this->link = mysql_connect($this->server, $this->user, $this->password) or die(mysql_error());
		mysql_select_db($this->database, $this->link) or die(mysql_error());

		$this->info = $this->fetch_array($this->query('SELECT controlRecibe.fecha, controlRecibe.folio, controlVehiculo.noPedido, controlVehiculo.noOperacion, controlVehiculo.noSerie, controlVehiculo.chasis, controlVehiculo.modelo, controlVehiculo.anio, controlVehiculo.placa, controlAdicional.tablero, controlAdicional.alarma, controlAdicional.reversa, controlAdicional.kilometraje, controlAdicional.otro, controlAdicional.observaciones, in_clientes.nombre, CONCAT(userRecibe.nombre, " ", userRecibe.paterno," ",userRecibe.materno) AS usuarioRec, CONCAT(userAsigna.nombre, " ", userAsigna.paterno," ",userAsigna.materno) AS usuarioAsigna, controlRecibe.usuarioAsignado, controlRecibe.usuarioRecibe
			FROM controlRecibe
            INNER JOIN controlAdicional ON controlAdicional.idControlRecibe = controlRecibe.folio
            INNER JOIN controlVehiculo ON controlVehiculo.idControlRecibe = controlRecibe.folio
            INNER JOIN in_clientes ON in_clientes.id = controlRecibe.idCliente
            INNER JOIN usuarios AS userRecibe ON userRecibe.id = controlRecibe.usuarioRecibe
            INNER JOIN usuarios AS userAsigna ON userAsigna.id = controlRecibe.usuarioAsignado
            WHERE controlRecibe.id = "'.$this->folio.'"'));

		$this->separaFecha($this->info['fecha']);
	}
	private function separaFecha($fecha){
		$f = explode(" ", $fecha);

		$this->fecha = $f[0];
		$this->hora = $f[1];
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Daniel Huerta');
$pdf->SetTitle('Formato de Recepcion de unidad');


$pdf->AddPage();
$pdf->setImagen(1);
$pdf->SetFont('Times','',12);
$pdf->informacion();
$pdf->accesorios();
$pdf->inferior();
$pdf->AddPage();
$pdf->setImagen(2);
//Close and output PDF document
$pdf->Output('Formato de Recepcion de unidad.pdf', 'I');
?>