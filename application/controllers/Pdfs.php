<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdfs extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		
	}
	public function index()
	{
		
	}

	public function generar()
	{
		$this->load->library('Pdf');

		$pdf=new Pdf('P','mm','A4','true','UTF-8',false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Byron Castro');
		$pdf->SetTitle('Ejemplo de provincias con TCPDF');
		$pdf->SetSubject('Tutorial TCPDF');
		$pdf->SetKeywords('TCPDF,PDF, example, test, guide');
		//datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE. ' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
		$pdf->setFooterData($tc=array(0,64,0), $lc=array(0,64,128));
		//datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de liabraries/config
		$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(array(PDF_FONT_NAME_DATA,'',PDF_FONT_SIZE_DATA));
		//se pueden modificar en el archivo tcṕdf_config.php de libraries/config
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		//se puede modificar en el archivo tcpdf_config.php de libraries/config
		$pdf->SetMargins(PDF_MARGIN_LEFT,PDF_MARGIN_TOP,PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		//se pueden modificar en le archivo tcpdf_config.php de libraries/config
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		//relación utilizada para ajustar la conversion de los píxeles
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		//-----------------------------------------
		//Establecer el modo de fuente por defecto
		$pdf->setFontSubsetting(TRUE);
		//establecer el tipo de letra
		//si tienes que imprimir carácteres ASCII estándar, puede utilizar las fuentes basicas como
		//Helvetica para reducir el tamaño del archivo
		$pdf->SetFont('freemono', '', 14, '', true);
		//añadir una página
		//este metodo tiene varias opciones, consultar la documentación para mas información
		$pdf->AddPage();
		//fijar efecto de sombra en el texto
		$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));



		//aqui es donce debemos de recibir el contenido para el PDF

		$html ='<h2 class="text-center">Mi PDF</h2>';

		//imprimimos el texto con writeHTMLCell()
		$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
		//-----------------------------------------------------------------------------
		//cerrar el documento pdf y preparamos la salida
		//este metodo tiene varias opciones, consulte la documentación para más información.
		$nombre_archivo = utf8_decode("Listado Personal.pdf");
		$pdf->Output($nombre_archivo,'I');
	}

}

/* End of file Pdfs.php */
/* Location: ./application/controllers/Pdfs.php */