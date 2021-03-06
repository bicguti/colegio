<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) .'/tcpdf/tcpdf.php';
class Pdf1 extends TCPDF
{
	function __construct()
	{
		parent::__construct();
	}

	public function Header() {
		// Logo
		$logo = base_url().'img/logo.jpg';
		$lmb = base_url().'img/lmb.jpg';
		$membrete = base_url().'img/Membrete.jpg';

		$this->Image($logo, 15, 10, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		$this->SetFont('helvetica', 'B', 14);
		$this->Cell(0, 0, '', 0, 1, 'C', 0, '', 0);
		$this->SetTextColor(255,8,0);
		$this->Cell(0, 0, 'COLEGIO CRISTIANO MIXTO PRE-UNIVERSITARIO', 0, 1, 'C', 0, '', 1);
		$this->SetFont('dejavusans', 'B', 14);
		$this->SetTextColor(4,94,0);
		$this->Cell(0, 0, 'PESTALOZZI', 0, 1, 'C', 0, '', 1);
		$this->SetFont('freemono', 'B', 10);
		$this->SetTextColor(13,146,1);
		$this->Cell(0, 0, '8a Calle 5-13 zona 1 Tel. 77669611-77683259-77683335', 0, 1, 'C', 0, '', 1);
		$this->SetFont('helvetica', 'B', 10);
		$this->Cell(0, 0, 'QUETZALTENANGO, GUATEMALA C.A.', 0, 1, 'C', 0, '', 1);
		$this->Image($lmb, 300, 10, 33, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		
		//$this->Image($membrete, 10, 5, 185, 35, 'JPG', 'http://www.colpestalozzi.com', '', true, 150, '', false, false, 0, false, false, false);


		// Set font
	/*	$this->SetFont('helvetica', 'B', 10);
		// Title
		$this->Cell(0, 0, '', 0, 1, 'C', 0, '', 0);
		$this->SetTextColor(255,8,0);
		$this->Cell(0, 0, 'COLEGIO CRISTIANO MIXTO PRE-UNIVERSITARIO', 0, 1, 'C', 0, '', 1);
		$this->SetFont('dejavusans', 'B', 12);
		$this->SetTextColor(4,94,0);
		$this->Cell(0, 0, 'PESTALOZZI', 0, 1, 'C', 0, '', 1);
		$this->SetFont('freemono', 'B', 10);
		$this->SetTextColor(13,146,1);
		$this->Cell(0, 0, '8a Calle 5-13 zona 1 Tel. 77669611-77683259-77683335', 0, 1, 'C', 0, '', 1);
		$this->SetFont('helvetica', 'B', 10);
		$this->Cell(0, 0, 'QUETZALTENANGO, GUATEMALA C.A.', 0, 1, 'C', 0, '', 1);*/
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-25);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$docente = $this->persona;
		$html = '';
		$html .= '<table style="text-align:center;">';
		$html .= '<tr>';
		$html .= '<td>F.________________________</td>';
		$html .= '<td>SELLO</td>';
		$html .= '<td>Vo.Bo________________________</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>'.ucwords($docente).'</td>';
		$html .= '<td></td>';
		$html .= '<td>Dra. en Educación Betty Argueta</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>Docente</td>';
		$html .= '<td></td>';
		$html .= '<td>Directora</td>';
		$html .= '</tr>';
		$html .= '</table>';
		$this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

		//$this->Cell(0, 0, 'Pestalozzi '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0);
		//$this->Cell(0, 0, 'Pestalozzi '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0);
		//$this->Cell(0, 0, 'Pestalozzi '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0);
	}
}
/*application/libraries/Pdf.php*/