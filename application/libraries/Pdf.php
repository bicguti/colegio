<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) .'/tcpdf/tcpdf.php';
class Pdf extends TCPDF
{
	function __construct()
	{
		parent::__construct();
	}

	public function Header() {
		// Logo
		$logo = base_url().'img/LogoNG.jpg';
		$lmb = base_url().'img/lmb.jpg';
		$membrete = base_url().'img/membrete.jpg';

		$this->Image($logo, 5, 10, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		$this->Image($membrete, 38, 5, 135, 35, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		$this->Image($lmb, 175, 10, 33, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-40);
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
