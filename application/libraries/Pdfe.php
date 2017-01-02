<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once dirname(__FILE__) .'/tcpdf/tcpdf.php';
class Pdfe extends TCPDF {

	public function __construct()
	{
		parent::__construct();

	}

	/*public function Header() {
		// Logo
		$logo = base_url().'img/logo.jpg';
		$logo2 = base_url().'img/LogoNG.jpg';
		//$lmb = base_url().'img/lmb.jpg';
		$this->Image($logo2, 180, 5, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		//$this->Image($lmb, 170, 10, 33, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('helvetica', 'B', 10);
		// Title
		$this->Cell(0, 0, '', 0, 1, 'C', 0, '', 0);
		$this->Cell(0, 0, 'COLEGIO CRISTIANO MIXTO PRE-UNIVERSITARIO PESTALOZZI', 0, 1, 'C', 0, '', 0);
		$this->SetFont('times', '', 8);
		$this->Cell(0, 0, '8a Calle 5-13 Zona 1, QUETZALTENANGO, GUATEMALA C.A. ', 0, 1, 'C', 0, '', 1);
		//$this->SetFont('helvetica', 'B', 10);
		//$this->Cell(0, 0, 'QUETZALTENANGO, GUATEMALA C.A.', 0, 1, 'C', 0, '', 1);
	}

	// Page footer
	public function Footer() {
		$logo = base_url().'img/FirmaDra.png';
		// Position at 15 mm from bottom
		$this->SetY(-25);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$html = '';
		$html .= '<table style="text-align:center;">';
		$html .= '<tr>';
		$html .= '<td>F.__________________________</td>';

		//$html .= '<td>Vo.Bo__________________________</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>Firma del Padre o</td>';

		//$html .= '<td>Dra. en Educación Betty Argueta</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>Encargado</td>';

		//$html .= '<td>Directora</td>';
		$html .= '</tr>';
		$html .= '</table>';
		$this->writeHTMLCell($w = 70, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
		$this->Image($logo, 120, 103, 90, 60, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		//$this->Cell(0, 0, 'Pestalozzi '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0);
		//$this->Cell(0, 0, 'Pestalozzi '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0);
		//$this->Cell(0, 0, 'Pestalozzi '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0);
	}*/

}

/* End of file Pdfc.php */
/* Location: ./application/libraries/Pdfc.php */
