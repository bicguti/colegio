<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once dirname(__FILE__) .'/tcpdf/tcpdf.php';
class Pdfc extends TCPDF {

	public function __construct()
	{
		parent::__construct();

	}

	public function Header() {
		// Logo
		$logo = base_url().'img/LogoNG.jpg';
		$membrete = base_url().'img/membrete.jpg';
		$lmb = base_url().'img/lmb.jpg';
		$this->Image($logo, 15, 10, 30, 30, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		$this->Image($membrete, 90, 8, 150, 40, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		$this->Image($lmb, 295, 8, 35, 35, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		//$this->SetFont('helvetica', 'B', 12);
		// Title
		/*$this->Cell(0, 0, '', 0, 1, 'C', 0, '', 0);
		$this->Cell(0, 0, 'COLEGIO CRISTIANO MIXTO', 0, 1, 'C', 0, '', 0);
		$this->SetTextColor(255,8,0);
		$this->Cell(0, 0, 'PRE-UNIVERSITARIO', 0, 1, 'C', 0, '', 1);
		$this->SetFont('dejavusans', 'B', 12);
		$this->SetTextColor(4,94,0);
		$this->Cell(0, 0, 'PESTALOZZI', 0, 1, 'C', 0, '', 1);
		$this->SetFont('freemono', 'B', 10);
		$this->SetTextColor(13,146,1);
		$this->Cell(0, 0, '8a Calle 5-13 zona 1 Telefax 77669611 - QUETZALTENANGO, GUATEMALA C.A. ', 0, 1, 'C', 0, '', 1);*/	//$this->SetFont('helvetica', 'B', 10);
		//$this->Cell(0, 0, 'QUETZALTENANGO, GUATEMALA C.A.', 0, 1, 'C', 0, '', 1);
	}

}

/* End of file Pdfc.php */
/* Location: ./application/libraries/Pdfc.php */
