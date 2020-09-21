<?php
include_once 'include/clases/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {
	

	public function politica(){		
		$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$this->SetHeaderMargin(PDF_MARGIN_HEADER);		
		$this->SetFont('helvetica', 'B', 18);		
		$this->SetFillColor(108, 192, 115);
		$this->SetTextColor(255, 255, 255);

		$this->Cell(0, 15, 'POLÍTICA DE RECEPCIÓN Y ENTREGA DE VEHÍCULOS', 0, 0, 'C', 1, '', 1,FALSE,'M','M');
		$this->SetFillColor(255, 255, 255);
		$this->SetTextColor(0, 0, 0);
		$this->ln();
		$this->setCellMargins(0, 0, 0, 0);

		$html = '<span style="text-align:justify;"><b>PRIMERA.-</b>EL PRESTADOR DEL SERVICIO, realizará todos las operaciones y servicios, solicitadas por  el CONSUMIDOR que suscribe en la autorización del pedido correspondiente, de acuerdo al estado de éste y las cuales serán realizadas a cargo  y por cuenta del CONSUMIDOR.</span><br/><br/>
    	<span style="text-align:justify;"><b>SEGUNDA.-</b>Ambas partes están de acuerdo en que el precio de la presente operación será cubierta por el consumidor en la forma que suscribe en la autorización del pedido correspondiente.</span><br/><br/>
    	<span style="text-align:justify;"><b>TERCERA.-</b>EL CONSUMIDOR acepta haber tenido a su disposición los precios de los servicios, mano de obra, refacciones y materiales a usar en los servicios ofrecidos por EL PRESTADOR DE SERVICIO, los incrementos que resulten durante el servicio por costo no previsibles y/o incrementos resultantes al momento de la ejecución del servicio ordenado deberán ser autorizadas por EL CONSUMIDOR en forma escrita, siempre y cuando estos excedan al 20% del presupuesto, si el incremento situado es inferior lo podrá autorizar telefónicamente y si el incremento es menor al 5% no se requiere la autorización DEL CONSUMIDOR. El tiempo que en su caso transcurra para requisitar condición se modificará la fecha de entrega en la misma proporción.</span><br/><br/>
    	<span style="text-align:justify;"><b>CUARTA.-</b>EL PRESTADOR DE SERVICIO se reserva la fecha de entrega del producto.</span><br/><br/>
    	<span style="text-align:justify;"><b>QUINTO.-</b>.-EL PRESTADOR DE SERCIVIOS hará entrega de las refacciones, partes o piezas substituidas  en la reparación o servicios del vehículo al momento de la entrega de esta salvo en los siguientes casos A) Cuando EL CONSUMIDOR exprese lo contrario B) Las partes, refacciones o piezas serán cambiadas en uso de garantía C) Se trate de residuos considerados peligrosos de acuerdo con las disposiciones legales aplicables.</span><br/><br/>
    	<span style="text-align:justify;"><b>SEXTA.-</b>Los productos o servicios a que refiere el presupuesto aceptado por el CONSUMIDOR tienen una garantía por escrito de tiempos determinados por cada unos de ellos, dichas garantías se encuentran publicadas en el portal de internet del PRESTADOR DE SERVICIO: http://www.frimax.mx/ en dichas garantías se estipulan los criterios y tiempos de aplicabilidad de las mismas. En partes hechas por EL PRESTADOR DE SERVICIO o mano de obra y en refacciones la especificada por el fabricante, siempre y cuando no se manifieste mal uso, negligencia o descuido, lo anterior de conformidad a lo establecido con el artículo 81 de la ley federal de protección al CONSUMIDOR. Si el producto o servicio es intervenido por un tercero EL PRESTADOR DE SERVICIO no será responsable y la garantía quedará sin efecto. Las reclamaciones por garantía se harán por medio del portal de internet del PRESTADOR DE SERVICIO en el apartado de servicio post-venta: http://www.frimax.mx/servicio-post-ventas.html como se lo indica cada una de las políticas de garantía de los productos y servicios Frimax. EL CONSUMIDOR deberá presentar su unidad en instalaciones del prestador de servicio, las reparaciones por EL PRESTADOR DE SERVICIO en cumplimiento a la garantía correspondiente, serán sin cargo alguno para EL CONSUMIDOR salvo aquellos trabajos que no deriven en las reparaciones aceptadas por el presupuesto. No se computará dentro del plazo de garantía, el tiempo que se lleve la reparación y/o mantenimiento del vehículo para el cumplimiento de la misma.</span><br/><br/>
    	<span style="text-align:justify;"><b>SÉPTIMA.-</b>EL CONSUMIDOR, autoriza el uso del vehículo en zonas aledañas con un radio ilimitado a el área de la planta a efectos de prueba o traslados efectuados, EL PRESTADOR DEL SERVICIO no podrá utilizar el vehículo para uso personal, con fines propios o de terceros.</span><br/><br/>
    	<span style="text-align:justify;"><b>OCTAVA.-</b>EL PRESTADOR DE SERVICIO se hace responsable por los daños causados al vehículo de EL CONSUMIDOR, dentro de las instalaciones del PRESTADOR DE SERVICIO. El riesgo de daños causados al vehículo, equipo y accesorios fuera de las instalaciones del PRESTADOR DE SERVICIO no son responsabilidad de PRESTADOR DE SERVICIO. EL PRESTADOR DE SERVICIO se hace responsable de los daños que sufran el vehículo dentro de sus instalaciones, mientras se encuentre bajo su resguardo y durante el tiempo de servicio. Para tal efecto EL PRESTADOR DE SERVICIO cuenta con un seguro para cubrir dichas eventualidades.</span>
    	<ol style="display:block;list-style-type: lower-latin; margin-top: 1em;margin-bottom: 1em;margin-left: 0;margin-right: 0;padding-left: 40px;">
    	<li style="text-align:justify;">EL PRESTADOR DE SERVICIO  no se hace responsable por la pérdida de objetos dejados en el interior del vehículo, aún con los compartimentos cerrados, salvo que estos hayan sido notificados y puestos bajo su resguardo al momento de la recepción del vehículo.</li>
    	<li style="text-align:justify;">EL PRESTADOR DE SERVICIO no se hace responsable por daños parciales o totales, que se ocasionen como consecuencia de fenómenos naturales como ciclón, huracán, granizo, terremoto, derrumbe de tierra o piedras, caída o derrumbe de construcciones, estructuras u otros objetos, caídas de árboles o sus ramas, alud, incendios, rayo, explosión aún cuando estos daños prevengan de una causa externa al vehículo.</li>
    	</ol>
    	<span style="text-align:justify;"><b>NOVENA.-</b>EL PRESTADOR DE SERVICIO  se obliga a expedir la factura o comprobante de pago por los trabajos ejecutados, en la que se especificarán los precios por productos o servicios y accesorios empleados, conforme al artículo 62 de la ley federal de protección al consumidor. </span><br/><br/>
    	<span style="text-align:justify;"><b>DÉCIMA.-</b>Se establece como pena convencional para EL CONSUMIDOR por incumplimiento el 30% del valor del producto o servicio correspondiente al pedido.</span><br/><br/>
    	<span style="text-align:justify;"><b>DÉCIMA PRIMERA.-</b>En caso de que la unidad no sea recogida por EL CONSUMIDOR en un término de 48 hrs. Posteriores a que se haya notificado, pagará por concepto de deposito un salario mínimo por cada 24 hrs. que transcurran. </span><br/><br/>
    	<span style="text-align:justify;"><b>DÉCIMA SEGUNDA.-</b>El PRESTADOR DEL SERVICIO podrá trasladar el vehículo a sus Talleres Aliados para la instalación de accesorios adicionales en caso de que EL CONSUMIDOR lo requiera y especifique en su pedido. Para los traslados a los Talleres Aliados se recorrerán 25 km. para la instalación de Equipos de refrigeración y 40 km para el refuerzo y/o modificación de muelles del vehículo. Con el anterior antecedente EL CONSUMIDOR está de acuerdo con el recorrido mencionado. Si llegará a suceder algún incidente con el vehículo durante este traslado EL PRESTADOR DEL SERVICIO no será responsable del daño o caso fortuito.</span><br/><br/>
		';
		$this->SetFont('helvetica', '', 8.2,'',true);		
		$this->writeHTML($html, true, false, true, false, '');		
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Alvaro Villarreal');
$pdf->SetTitle('POLÍTICA DE RECEPCIÓN Y ENTREGA DE VEHÍCULOS');
// $pdf->SetFooterMargin(false);

$pdf->AddPage();
$pdf->politica();
//Close and output PDF document
$pdf->Output('POLÍTICA DE RECEPCIÓN Y ENTREGA DE VEHÍCULOS.pdf', 'I');
?>