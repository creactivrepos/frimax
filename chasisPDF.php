<?php
include_once 'include/clases/tcpdf/tcpdf.php';
include_once 'include/clases/tcpdf/tcpdf_include.php';
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	public $total_query;
	public $hora;
	public $fecha;
	

	//Page header
	public function Header() {
		$this->conect();		
	}



	public function setImagen(){
		// get the current page break margin
		$bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
		$auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
		$this->SetAutoPageBreak(false, 0);
        // set bacground image
		$img_file =$this->info['rodado'] == 1 ? './images/Dimensiones_Chasis.jpg' : './images/Dimensiones_Chasis_02.jpg' ;
		$this->Image($img_file, 0, 0, 300, 200 , '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
		$this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
		$this->setPageMark();
	}
	public function informacion(){
		$this->SetFont('dejavusans', '', 10, '', true);
		$this->cliente().		
		$this->fecha().
		$this->folio().
		$this->dimensionesChasis();
		
	}
	/*BEGIN: Métodos para imprimir la información de la parte superior de la hoja*/
	
	private function cliente(){

		$this->writeHTMLCell(100, 0, 167, 117, $this->info['nombre'], 0, 1, 0, true, '', true);
	}
	
	private function fecha(){

		$this->writeHTMLCell(40, 0, 167, 130, $this->fecha, 0, 1, 0, true, '', true);
	}
	private function folio(){

		$this->writeHTMLCell(40, 0, 242, 130, $this->info['noPedido'], 0, 1, 0, true, '', true);
	}
	
	private function dimensionesChasis(){
		$this->writeHTMLCell(40, 0, 90, 109, $this->info['lCarrozable'], 0, 1, 0, true, '', true);
		$this->writeHTMLCell(40, 0, 90, 116, $this->info['aPLarguero'], 0, 1, 0, true, '', true);
		$this->writeHTMLCell(40, 0, 90, 122, $this->info['aLarguero'], 0, 1, 0, true, '', true);
		$this->writeHTMLCell(40, 0, 90, 129, $this->info['alturaLar'], 0, 1, 0, true, '', true);
		$this->writeHTMLCell(40, 0, 90, 135, $this->info['pLarguero'], 0, 1, 0, true, '', true);
		$this->writeHTMLCell(40, 0, 90, 141, $this->info['altCabina'], 0, 1, 0, true, '', true);
		$this->writeHTMLCell(40, 0, 90, 148, $this->info['dEjes'], 0, 1, 0, true, '', true);
		$this->writeHTMLCell(40, 0, 90, 156, $this->info['diCabCenEjeTras'], 0, 1, 0, true, '', true);
		$this->writeHTMLCell(40, 0, 90, 164, $this->info['diCabCenEjeDelan'], 0, 1, 0, true, '', true);
		$this->writeHTMLCell(40, 0, 90, 172, $this->info['volTras'], 0, 1, 0, true, '', true);
		$this->writeHTMLCell(40, 0, 90, 179, $this->info['lTotalChas'], 0, 1, 0, true, '', true);

		
	}

	private function query($value){
		$this->total_query++;
		$result = $this->link->query($value);
		if (!$result){
			echo 'MySQL Error: '.$this->link->error;
			exit;
		}
		return $result;
	}
	private function fetch_array($value){
		return mysqli_fetch_array($value);
	}
	private function conect(){
		date_default_timezone_set("America/Mexico_City");
		$this->local = FALSE;
		$this->folio = $_GET['folio'];
		$this->esquema = 'local';
		if($this->esquema == 'local'){
			$this->user  		= 'root';
			$this->password 	= '';
			$this->server 		= 'localhost';
			$this->port			= '3306';
			$this->database 	= 'frimax';
		}
		elseif($this->esquema == 'productivo'){
			$this->user         = 'dbo686363322';
			$this->password     = 'MsEQK#W+!9VV';
			$this->server       = 'db686363322.db.1and1.com';
			$this->port         = '3306';
			$this->database     = 'db686363322';
		}
		elseif($this->esquema == 'pruebas'){
			$this->user         = 'tdesyxwd_frimax';
			$this->password     = 'Moro1983582001';
			$this->server       = 'localhost';
			$this->port         = '3306';
			$this->database     = 'tdesyxwd_recepcion_frimax';
		}

		$this->link = mysqli_connect($this->server,$this->user, $this->password) or die(mysql_error());
		mysqli_select_db( $this->link, $this->database) or die($this->link->error);

		$this->info = mysqli_fetch_array($this->link->query('SELECT controlRecibe.id, controlRecibe.fecha, controlRecibe.folio,  controlVehiculo.noPedido, in_clientes.nombre, controlchasis.rodado , controlchasis.lCarrozable, controlchasis.aPLarguero, controlchasis.aLarguero, controlchasis.alturaLar, controlchasis.pLarguero, controlchasis.altCabina, controlchasis.dEjes, controlchasis.diCabCenEjeTras, controlchasis.diCabCenEjeDelan, controlchasis.volTras, controlchasis.lTotalChas FROM controlRecibe LEFT JOIN controlchasis ON controlchasis.idControlRecibe = controlRecibe.id LEFT JOIN controlVehiculo ON controlVehiculo.idControlRecibe = controlRecibe.id LEFT JOIN in_clientes ON in_clientes.id = controlRecibe.idCliente WHERE controlRecibe.folio = "'.$this->folio.'"'));

		$this->separaFecha($this->info['fecha']);
		
	}

	private function separaFecha($fecha){    
		$f = explode(' ', $fecha);
		$this->fecha = $f[0];
		$this->hora = $f[1];
	}

}

// create new PDF document
$width= 320;
$heigth = 240;
$pageLayout =array($width,$heigth);
$pdf = new MYPDF('PDF_PAGE_ORIENTATION', PDF_UNIT, $pageLayout, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Alvaro Villarreal');
$pdf->SetTitle('Formato de Dimensiones del Chasis');
$pdf->SetFooterMargin(false);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');

$pdf->AddPage('L', 'A4');
$pdf->setImagen();
$pdf->SetFont('Times','',12);
$pdf->informacion();

//Close and output PDF document
$pdf->Output('Formato de Recepcion de unidad.pdf', 'I');
?>
