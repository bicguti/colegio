<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consolidados extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Nivel_model');
		$this->load->model('Bloque_model');
		$this->load->model('Consolidados_model');
	}

	public function index()
	{
		$data['bloque'] = $this->Bloque_model->getBloques();
		$data['nivel'] = $this->Nivel_model->getNivel();
		$data['activo'] = 'reportes';
		$data['titulo'] = 'Generacion de Consolidados';
		$this->load->view('plantilla/header', $data);
		$this->load->view('reportes/consolidados', $data);
		$this->load->view('plantilla/footer', $data);
	}

	/*
		metodo que exporta los datos de consolidado
	*/
	public function exportar_consolidado()
	{
		$this->form_validation->set_rules('nivel', 'Nivel', 'trim|required');
		$this->form_validation->set_rules('grado', 'Grado', 'trim|required');
		$this->form_validation->set_rules('bloque', 'Bloque', 'trim|required');

		$this->form_validation->set_message('required', 'El campo %s es obligatorio, seleccióne una opcion valida.');

		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			$nivel = $this->input->post('nivel');
			$grado = $this->input->post('grado');
			$bloque = $this->input->post('bloque');

			$ciclo = date('Y').'-00-00';
			//$ciclo = '2015-00-00';
			if ($nivel == 4) {
				$carrera = $this->input->post('carrera');
				$datos = $this->Consolidados_model->notas_consolidadoC($bloque, $grado, $ciclo, $carrera);
				$this->exportar_pdf($datos);
				//echo json_encode($datos);

			} else {
				$datos = $this->Consolidados_model->notas_consolidado($bloque, $nivel, $grado, $ciclo);
				//echo json_encode($datos);
				$this->exportar_pdf($datos);
			}

		}

	}

	private function exportar_pdf($datos)
	{
		$this->load->library('Pdfc');

		$pdf = new Pdfc(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Colegio Pestalozzi');
		//$pdf->SetTitle('Reporte de Consolidado de Bloque');
		$pdf->SetSubject('Tutorial TCPDF');
		$pdf->SetKeywords('TCPDF,PDF, example, test, guide');
		//datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
		//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE. ' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
		$pdf->setFooterData($tc=array(0,64,0), $lc=array(0,64,128));
		//datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de liabraries/config
		$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(array(PDF_FONT_NAME_DATA,'',PDF_FONT_SIZE_DATA));
		//se pueden modificar en el archivo tcṕdf_config.php de libraries/config
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		//se puede modificar en el archivo tcpdf_config.php de libraries/config
		//$pdf->SetMargins(PDF_MARGIN_LEFT,38,5);
		$pdf->SetMargins(10, 34, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		//se pueden modificar en le archivo tcpdf_config.php de libraries/config
		$pdf->SetAutoPageBreak(FALSE, 0);

		//relación utilizada para ajustar la conversion de los píxeles
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		//-----------------------------------------
		$pdf->setPrintFooter(false);

		$pdf->SetFont('times', '', 15, '', true);
		//añadir una página
		//este metodo tiene varias opciones, consultar la documentación para mas información

		//$pdf->AddPage('L', 'OFFICE');
		$pdf->AddPage('L',array(355.6, 215.9));

		$areas = array();
		$estudiante = array();
		$grado = $bloque = 'null';
		foreach ($datos as $value) {
				$temp = array('area'=>$value['nombre_area']);
				$grado = $value['nombre_grado'];
				$bloque = $value['nombre_bloque'];
				if (isset($value['nombre_nivel'])) {
					$grado .= ' '.$value['nombre_nivel'];
				}
				if (isset($value['nombre_carrera'])) {
					$grado .= ' '.$value['nombre_carrera'];
				}
			if (in_array($temp, $areas) == FALSE) {

				array_push($areas, $temp);
			}

		}
		$careas = count($areas);
		$cont = 1;
		$notas = '';
		foreach ($datos as $value) {
			$aux = $value['apellidos_estudiante'].', '.$value['nombre_estudiante'];
			$codigo = $value['codigo_personal_estudiante'];
			$habitos = $value['habitos_orden'];
			$puntualidad = $value['punt_asist'];
			if ($cont == $careas) {
				$notas .= ','.$value['total_bloque'];
				$temp = array('estudiante'=>$aux, 'notas'=>$notas, 'codigo'=>$codigo, 'punt'=>$puntualidad, 'habit'=>$habitos);
				array_push($estudiante, $temp);
				$notas = '';
				$cont = 0;
			} else{
				$notas .= ','.$value['total_bloque'];
			}//fin del if else
			$cont++;
		}//fin del foreach
$pdf->SetFillColor(255, 255, 255);
		$pdf->MultiCell(153, 10, '', 0, 'J', 0, 0, '', '', true, 0, false, true, 40);


$pdf->MultiCell(133, 10, 'Ciclo Academico '.date('Y'), 0, 'R', 0, 1, '', '', true, 0, false, true, 40);
$pdf->MultiCell(193, 10, 'Grado: '.'<strong>'.ucwords($grado).'</strong>', 0, 'L', 0, 0, '', '', true, 0, true, true, 40);

$nMes = date('F');
$nDia = date('l');
$nMes = $this->traslateMonth($nMes);
$nDia = $this->traslateDay($nDia);
$pdf->MultiCell(95, 10, $nDia.' '.date('d').' de '.$nMes, 0, 'R', 0, 1, '', '', true, 0, false, true, 40);
$pdf->SetFont('freesans', 'B', 15);
$pdf->MultiCell(122.5, 55, 'Consolidado '.mb_strtoupper($bloque), 1, 'C', 1, 0, '', '', true, 0, false, true, 50, 'M');

$pdf->Ln(1);
$pdf->SetFont('freesans', 'B', 10);
//$pdf->SetFont('pdfahelvetica', 'B', 10);
//$pdf->SetFont('times', 'B', 7);
//$pdf->SetFont('times', '', 8);

// $pdf->SetXY(137.5,90);
// $pdf->StartTransform();
// $pdf->Rotate(90);
// for ($stretching = 90; $stretching <= 110; $stretching += 10) {
// 	for ($spacing = -0.254; $spacing <= 0.254; $spacing += 0.254) {

// 		// set general stretching (scaling) value
// 		$pdf->setFontStretching($stretching);

// 		// set general spacing value
// 		$pdf->setFontSpacing($spacing);

// 		$pdf->Cell(0, 15, 'Stretching '.$stretching.'%, Spacing '.sprintf('%+.3F', $spacing).'mm, no stretch', 1, 1, 'C', 0, '', 0);
// 		//$pdf->Ln(2);
// 	}
// }
// $pdf->StopTransform();


$pdf->StartTransform();

$pdf->Rotate(90, 98,21);
// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

foreach ($areas as $key => $value) {
	//$pdf->Cell(55, 15, 'Tecnología de la información y Comunicación de compu', 1, 1, 'C', 1, '', 1);
	//$pdf->Cell(55, 15, 'Tecnología de la información y Comunicación', 1, 1, 'C', 0, '', 1);
	//$pdf->setFontSpacing(0.454);


	//$pdf->Cell(55, 10, ucwords($value['area']), 1, 1, 'C', 1, '', 1);

	if ($key > 15) {
		$pdf->Cell(55, 10, ucwords($value['area']), 1, 1, 'C', 0, '', 1);
	}else {
			$pdf->MultiCell(55, 10, ucwords($value['area']), 1, 'C', 1, 1, '', '', true, 0, false, true, 10, 'M');
	}

	//$pdf->Cell(55, 10, ucwords($value['area']), 1, 1, 'C', 1, '', 0);
	//$pdf->Cell(55, 15, 'Tecnología de la información y Comunicación', 1, 1, 'L', 1, '', 0, false, '', 'M');
	//$pdf->MultiCell(55, 30, ucwords($value['area']), 1, 'C', 0, 1, '', '', true, 0, false, true, 10, 'M');
		}

			/*$pdf->Cell(55, 15, 'Nombre del área', 1, 1, 'C', 0, '', 0);
		$pdf->Cell(55, 15, 'Nombre del área', 1, 1, 'C', 0, '', 0);
		$pdf->Cell(55, 15, 'Nombre del área', 1, 1, 'C', 0, '', 0);
		$pdf->Cell(55, 15, 'Nombre del área', 1, 1, 'C', 0, '', 0);
		$pdf->Cell(55, 15, 'Nombre del área', 1, 1, 'C', 0, '', 0);
		$pdf->Cell(55, 15, 'Puntualidad y Asistencia a Clases', 1, 1, 'C', 0, '', 0);
	$pdf->MultiCell(55, 10, 'Nombre del área', 1, 'C', 1, 1, '', '', true, 0, false, true, 10, 'M');
/*	$pdf->MultiCell(55, 10, 'Nombre del área', 1, 'C', 1, 1, '', '', true, 0, false, true, 10, 'M');
	$pdf->MultiCell(55, 10, 'Nombre del área', 1, 'C', 1, 1, '', '', true, 0, false, true, 10, 'M');
	$pdf->MultiCell(55, 10, 'Nombre del área', 1, 'C', 1, 1, '', '', true, 0, false, true, 10, 'M');
	$pdf->MultiCell(55, 10, 'Nombre del área', 1, 'C', 1, 1, '', '', true, 0, false, true, 10, 'M');
	$pdf->MultiCell(55, 10, 'Puntualidad y Asistencia a Clases', 1, 'C', 1, 1, '', '', true, 0, false, true, 10, 'M');
	$pdf->MultiCell(55, 10, 'Hábitos de Orden', 1, 'C', 1, 1, '', '', true, 0, false, true, 10, 'M');
*/
	$pdf->Cell(55, 10, 'Puntualidad y Asistencia a Clases', 1, 1, 'C', 0, '', 1);
	$pdf->Cell(55, 10, 'Hábitos de Orden', 1, 1, 'C', 0, '', 1);

	//$pdf->MultiCell(55, 10, 'Puntualidad y Asistencia a Clases', 1, 'C', 1, 1, '', '', true, 0, false, true, 10, 'M');
	//$pdf->MultiCell(55, 10, 'Hábitos de Orden', 1, 'C', 1, 1, '', '', true, 0, false, true, 10, 'M');





$pdf->StopTransform();

$pdf->SetFont('Helvetica', 'B', 10);
$pdf->SetXY(10,109);
$pdf->MultiCell(8, 15, 'No', 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->MultiCell(20, 15, 'Codigo Personal', 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(94, 15, 'Apellidos y Nombres', 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'B');
for ($i=1; $i <= count($areas)+2; $i++) {
	$pdf->MultiCell(10, 10, $i, 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'B');

}
$pdf->Ln(10);
$pdf->SetFont('Helvetica', '', 10);

	sort($estudiante);//ordenamos la lista de los estudiantes

foreach ($estudiante as $key => $value) {

		$pdf->MultiCell(8, 5, $key+1, 1, 'C', 1, 0, '', '', true, 0, false, true, 0, 'M');
		$pdf->MultiCell(20, 5, $value['codigo'], 1, 'C', 1, 0, '', '', true, 0, false, true, 0, 'M');
		$pdf->MultiCell(94, 5, ucwords($value['estudiante']), 1, 'L', 1, 0, '', '', true, 0, false, true, 0, 'B');
		$temp = $value['notas'];
			$array = explode(',', $temp);

			for ($i=1; $i < count($array); $i++) {

				if ($array[$i] <60) {
					$pdf->SetTextColor(255,25,0);
				}
				else{
					$pdf->SetTextColor(0,0,0);
				}
				$pdf->MultiCell(10, 5, $array[$i], 1, 'C', 1, 0, '', '', true, 0, false, true, 0, 'M');
				//$html .= '<td style="width: 3%">'.$array[$i].'</td>';
			}
			$pdf->SetTextColor(0,0,0);
		$pdf->MultiCell(10, 5, strtoupper($value['punt']), 1, 'C', 1, 0, '', '', 0, false, true, 0, 'M');
		$pdf->MultiCell(10, 5, strtoupper($value['habit']), 1, 'C', 1, 0, '', '', 0, false, true, 0, 'M');
			$pdf->SetTextColor(0,0,0);
			$pdf->Ln(5);
			if ($key == 16 || $key == 49) {
				$pdf->setPrintHeader(false);
				$pdf->AddPage('L',array(355.6, 215.9));
				$pdf->setY(10);
			}
		}//fin del foreach


$pdf->Ln(10);

			//-----------------------------------------------------------------------------
		//cerrar el documento pdf y preparamos la salida
		//este metodo tiene varias opciones, consulte la documentación para más información.
		$pdf->SetTitle('Consolidado '.$grado);
		$nombre_archivo = utf8_decode("Consolidado Bloque.pdf");
		$pdf->Output($nombre_archivo,'I');
	}

	public function consolidado_anual()
	{
		$data['nivel'] = $this->Nivel_model->getNivel();
		$data['activo'] = 'reportes';
		$data['titulo'] = 'Generacion de Consolidados';
		$this->load->view('plantilla/header', $data);
		$this->load->view('reportes/consolidadosa', $data);
		$this->load->view('plantilla/footer', $data);
	}

	public function exportar_consolidado_anual($value='')
	{
		$this->form_validation->set_rules('nivel', 'Nivel', 'trim|required');
		$this->form_validation->set_rules('grado', 'Grado', 'trim|required');

		$this->form_validation->set_message('required', 'El campo %s es obligatorio, seleccióne una opcion valida.');

		if ($this->form_validation->run() == FALSE) {
			$this->consolidado_anual();
		} else {
			$nivel = $this->input->post('nivel');
			$grado = $this->input->post('grado');

			$ciclo = date('Y').'-00-00';
			//$ciclo = '2015-00-00';
			if ($nivel == 4) {
				$carrera = $this->input->post('carrera');
				//$datos = $this->Consolidados_model->notas_consolidadoC($bloque, $grado, $ciclo, $carrera);
				//$this->exportar_pdf($datos);
				//echo json_encode($datos);

			} else {
				//$datos = $this->Consolidados_model->notas_consolidado($bloque, $nivel, $grado, $ciclo);
				//echo json_encode($datos);
				//$this->exportar_pdf($datos);
				$this->exportar_anual_pdf();
			}

		}
	}

	private function exportar_anual_pdf($value='')
	{
		$this->load->library('Pdfc');

		$pdf = new Pdfc(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Byron Castro');
		$pdf->SetTitle('Consolidado de Bloque TCPDF');
		$pdf->SetSubject('Tutorial TCPDF');
		$pdf->SetKeywords('TCPDF,PDF, example, test, guide');
		//datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
		//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE. ' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
		$pdf->setFooterData($tc=array(0,64,0), $lc=array(0,64,128));
		//datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de liabraries/config
		$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(array(PDF_FONT_NAME_DATA,'',PDF_FONT_SIZE_DATA));
		//se pueden modificar en el archivo tcṕdf_config.php de libraries/config
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		//se puede modificar en el archivo tcpdf_config.php de libraries/config
		//$pdf->SetMargins(PDF_MARGIN_LEFT,38,5);
		$pdf->SetMargins(PDF_MARGIN_LEFT, 34, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		//se pueden modificar en le archivo tcpdf_config.php de libraries/config
		$pdf->SetAutoPageBreak(TRUE, 10);

		//relación utilizada para ajustar la conversion de los píxeles
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		//-----------------------------------------
		$pdf->setPrintFooter(false);

		$pdf->SetFont('times', '', 15, '', true);

		$pdf->AddPage('L', 'OFFICE');


		$pdf->SetFillColor(255, 255, 255);
		$pdf->MultiCell(133, 10, '', 0, 'J', 0, 0, '', '', true, 0, false, true, 40);

	$pdf->MultiCell(133, 10, 'Ciclo Academico '.date('Y'), 0, 'R', 0, 1, '', '', true, 0, false, true, 40);
	$pdf->MultiCell(133, 10, 'Grado: ', 0, 'L', 0, 0, '', '', true, 0, false, true, 40);
	$pdf->MultiCell(133, 10, date('l d').' de '.date('F'), 0, 'R', 0, 1, '', '', true, 0, false, true, 40);

	$pdf->MultiCell(122.5, 55, 'Consolidado Anual', 1, 'C', 1, 0, '', '', true, 0, false, true, 50, 'M');

	$pdf->Ln(1);
	//$pdf->SetFont('freesans', 'B', 7);
	$pdf->SetFont('pdfahelvetica', 'B', 7);
	//$pdf->SetFont('times', 'B', 7);
	//$pdf->SetFont('times', '', 8);
	$pdf->StartTransform();

	$pdf->Rotate(90, 103,21);

	//foreach ($areas as $value) {
		for ($i=1; $i <= 16; $i++) {
			$pdf->MultiCell(55, 8, 'Nombre del Area de Grado-Nivel', 1, 'C', 1, 1, '', '', true, 0, false, true, 10, 'M');
		}

	//}
		$pdf->MultiCell(55, 8, 'Puntualidad y Asistencia a Clases', 1, 'C', 1, 1, '', '', true, 0, false, true, 10, 'M');
		$pdf->MultiCell(55, 8, 'Hábitos de Orden', 1, 'C', 1, 1, '', '', true, 0, false, true, 10, 'M');
$pdf->StopTransform();

$pdf->SetFont('Helvetica', 'B', 10);
$pdf->SetXY(15,109);
$y = $pdf->getY();
$left_column = '<b>No</b> ';
$right_column = '<b>Código Personal</b>';

$pdf->writeHTMLCell(8, 10, '', $y, '<b></b><br><b>No</b>', 1, 0, 1, true, 'C', true);
$pdf->writeHTMLCell(20, 10, '', '', '<b>Código Personal</b>', 1, 0, 1, true, 'C', true);
$pdf->writeHTMLCell(94, 10, '', '', '<b></b><br><b>Apellidos y Nombres</b>', 1, 0, 1, true, 'C', true);
for ($i=1; $i <= 16 ; $i++) {
	$pdf->writeHTMLCell(8, 10, '', '', '<b></b><br><b>'.$i.'</b>', 1, 0, 1, true, 'C', true);
}
$pdf->writeHTMLCell(8, 10, '', '', '<b></b><br><b>17</b>', 1, 0, 1, true, 'C', true);
$pdf->writeHTMLCell(8, 10, '', '', '<b></b><br><b>18</b>', 1, 1, 1, true, 'C', true);

//$html = '<table><tr><td>60</td><td>ABC1XYZ</td></tr></table>';
$pdf->SetFont('Helvetica', '', 10);
//$pdf->writeHTMLCell(8, 0, '', '', '60', 1, 0, 1, true, 'C', true);
//$pdf->writeHTMLCell(20, 0, '', '', 'ABC1XYZ', 1, 0, 1, true, 'C', true);
//$pdf->writeHTMLCell(94, 0, '', '', 'Byron Ismael Castro Gutiérrez', 1, 0, 1, true, 'C', true);

for ($i=1; $i <= 60; $i++) {
	$pdf->writeHTMLCell(8, 0, '', '', $i, 1, 0, 1, true, 'C', true);
$pdf->writeHTMLCell(20, 0, '', '', 'ABC1XYZ', 1, 0, 1, true, 'C', true);
$pdf->writeHTMLCell(94, 0, '', '', 'Byron Ismael Castro Gutiérrez', 1, 0, 1, true, 'L', true);
	for ($j=1; $j <=17 ; $j++) {
		$pdf->writeHTMLCell(8, 0, '', '', '100', 1, 0, 1, true, 'C', true);
	}
	$pdf->writeHTMLCell(8, 0, '', '', '100', 1, 1, 1, true, 'C', true);
	//$pdf->Ln(5);
}
		//cerrar el documento pdf y preparamos la salida
		//este metodo tiene varias opciones, consulte la documentación para más información.
		$nombre_archivo = utf8_decode("Consolidado Anual.pdf");
		$pdf->Output($nombre_archivo,'I');

	}

	/*
		metodo auxiliar para trasladar en nombre de un mes del ingles al español
	*/
	private function traslateMonth($nMes)
	{
		switch ($nMes) {
			case 'January':
				$nMes = 'Enero';
				break;
			case 'February':
				$nMes = 'Febrero';
				break;
			case 'March':
				$nMes = 'Marzo';
				break;
			case 'April':
				$nMes = 'Abril';
				break;
			case 'May':
				$nMes = 'Mayo';
				break;
			case 'June':
				$nMes = 'Junio';
				break;
			case 'July':
				$nMes = 'Julio';
				break;
			case 'August':
				$nMes = 'Agosto';
				break;
			case 'September':
				$nMes = 'Septiembre';
				break;
			case 'October':
				$nMes = 'Octubre';
				break;
			case 'November':
				$nMes = 'Noviembre';
				break;
			case 'December':
				$nMes = 'Diciembre';
				break;
		}
		return $nMes;
	}

	/*
		metodo para trasladar en nombre de un dia del ingles al español
	*/
	private function traslateDay($nDia)
	{
		switch ($nDia) {
			case 'Monday':
				$nDia = 'Lunes';
				break;
			case 'Tuesday':
				$nDia = 'Martes';
				break;
			case 'Wednesday':
				$nDia = 'Miercoles';
				break;
			case 'Thursday':
				$nDia = 'Jueves';
				break;
			case 'Friday':
				$nDia = 'Viernes';
				break;
			case 'Saturday':
				$nDia = 'Sabado';
				break;
			case 'Sunday':
				$nDia = 'Domingo';
				break;
		}
		return $nDia;
	}


}

/* End of file Consolidados.php */
/* Location: ./application/controllers/Consolidados.php */
