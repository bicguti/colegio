<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarjetas extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Nivel_model');
		$this->load->model('Bloque_model');
		$this->load->model('Puntos_model', 'puntos');
		$this->load->model('Estudiante_model', 'estudiantes');
		$this->load->model('Docente_model', 'docente');
		$this->load->model('Consolidados_model');
	}
	public function index()
	{
		$data['bloque'] = $this->Bloque_model->getBloques();
		$data['nivel'] = $this->Nivel_model->getNivel();
		$data['activo'] = 'reportes';
		$data['titulo'] = 'Tarjetas de Calificaciones';
		$this->load->view('plantilla/header', $data);
		$this->load->view('reportes/tarjetas', $data);
		$this->load->view('plantilla/footer');
	}

	public function exportar_tarjetas()
	{
		$this->form_validation->set_rules('nivel', 'Nivel', 'trim|required');
		$this->form_validation->set_rules('grado', 'Grado', 'trim|required');
		$this->form_validation->set_rules('bloque', 'Bloque', 'trim|required');

		$this->form_validation->set_message('required', 'El campo %s es requerido, elija un opcion valida.');

		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			$nivel = $this->input->post('nivel');
			$grado = $this->input->post('grado');
			$bloque = $this->input->post('bloque');
			$ciclo = date('Y').'-00-00';
			if ($nivel == 4) {
				$carrera = $this->input->post('carrera');
				//$totales = $this->puntos->getTotalBC($carrera, $bloque, $ciclo, $grado);
				$totales = $this->Consolidados_model->notas_consolidadoC($bloque, $grado, $ciclo, $carrera);
				$nGuia = $this->docente->getNombresGuiaC($grado, $carrera);
				if (count($nGuia) == 0) {
					$aux = 'Ninguno';
				} else {
					$aux = $nGuia[0]['nombre_persona'].' '.$nGuia[0]['apellidos_persona'];
				}

				$this->exportar_pdf($totales, $nivel, $aux);
			} else {
				$totales = $this->puntos->getTotalBB($bloque, $ciclo, $grado, $nivel);
				$nGuia = $this->docente->getNombresGuia($grado, $nivel);
				if (count($nGuia) == 0) {
					$aux = 'Ninguno';
				} else {
					$aux = $nGuia[0]['nombre_persona'].' '.$nGuia[0]['apellidos_persona'];
				}

				$this->exportar_pdf($totales, $nivel, $aux);
			}

		}
	}

	private function exportar_pdf($puntos, $nivel, $nGuia)
	{
		$this->load->library('Pdft');

		$pdf = new Pdft(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Colegio Pestalozzi');
		$pdf->SetTitle('Tarjetas Calificaciones');
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
		$pdf->SetMargins(5,18,5);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(10);
		//se pueden modificar en le archivo tcpdf_config.php de libraries/config
		$pdf->SetAutoPageBreak(FALSE, 0);
		//relación utilizada para ajustar la conversion de los píxeles
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		//-----------------------------------------
		//Establecer el modo de fuente por defecto
		//$pdf->setFontSubsetting(TRUE);
		//establecer el tipo de letra
		//si tienes que imprimir carácteres ASCII estándar, puede utilizar las fuentes basicas como
		//Helvetica para reducir el tamaño del archivo
		$pdf->SetFont('freesans', '', 10, '', true);
		//añadir una página
		//este metodo tiene varias opciones, consultar la documentación para mas información
		$pdf->AddPage('L', array(157,210), false);
		//$pdf->AddPage('P', array(210,148), true);
		//$pdf->AddPage('L', 'A5', false);
		//fijar efecto de sombra en el texto
		//$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
$pdf->SetFillColor(255, 255, 255);
	$nAreas = array();
	foreach ($puntos as $key => $value) {
		$temp = array('nombre'=>$value['nombre_area']);
		if (in_array($temp, $nAreas) == false) {
			array_push($nAreas, $temp);
		}
	}//fin del foreach
	$pEstudiante = '';
	$cont = $clave = 1;
	$nEstudiantes = array();
	foreach ($puntos as $key => $value) {

		$pEstudiante = $pEstudiante.','.$value['total_bloque'];
		if ($cont == count($nAreas)) {
			if ($nivel == 4) {
				$nombres = $this->estudiantes->findEstudiante($value['id_estudiante']);
			} else {
				$nombres = $this->estudiantes->findEstudianteBP($value['id_estudiante']);
			}


			$aux = $nombres[0]['apellidos_estudiante'].', '.$nombres[0]['nombre_estudiante'];
			if (isset($nombres[0]['nombre_carrera'])) {
				$carrera = $nombres[0]['nombre_carrera'];
			} else {
				$carrera = '';
			}
			if ($nivel == 4) {
				$grado = $nombres[0]['nombre_grado'];
			} else {
				$grado = $nombres[0]['nombre_grado'].' '.$nombres[0]['nombre_nivel'];
			}

			$temp = array('estudiante'=>$aux, 'notas'=>$pEstudiante, 'punt_asist'=>$value['punt_asist'], 'habitos_orden'=>$value['punt_asist'], 'codigo'=>$nombres[0]['codigo_personal_estudiante'], 'grado'=>$grado, 'carrera'=>$carrera);
			array_push($nEstudiantes, $temp);
			$pEstudiante = '';
			$cont = 0;
		}
		$cont++;
	}
sort($nEstudiantes);
	foreach ($nEstudiantes as $key => $value) {

			$pdf->SetFont('freesans', '', 10, '', true);
			$this->cuerpo_tarjeta($pdf, $nAreas, $value['notas'], $value['punt_asist'], $value['habitos_orden'], $clave, $value['estudiante'], $value['codigo'], $value['grado'], $value['carrera'], $nGuia);//escribimos el contenido del documento

			if ($clave < count($nEstudiantes)) {
				$pdf->AddPage('L', array(157,210), false);
			}
			$cont = 0;
			$clave++;

	}

		//-----------------------------------------------------------------------------
		//cerrar el documento pdf y preparamos la salida
		//este metodo tiene varias opciones, consulte la documentación para más información.
		$nombre_archivo = utf8_decode("tarjetas de calificacion.pdf");
		$pdf->Output($nombre_archivo,'I');
	}//fin del metodo exportar_pdf

	private function cuerpo_tarjeta($pdf, $nAreas, $pEstudiante, $puntualidad, $habitos, $clave, $estudiante, $codigo, $grado, $carrera, $nGuia)
	{
		//aqui es donce debemos de recibir el contenido para el PDF
		$pdf->MultiCell(103, 0, 'Estudiante: '.ucwords($estudiante), 0, 'L', 0, 0, '', '', true, 0, false, false, 0);

	$pdf->MultiCell(53, 0, 'Clave: '.$clave, 0, 'R', 0, 1, '', '', true, 0, false, true, 40);
	$pdf->MultiCell(103, 0, 'Código Personal: '.$codigo, 0, 'L', 0, 1, '', '', true, 0, false, true, 40);

	$pdf->MultiCell(143, 0, 'Grado: '.ucwords($grado).' '.ucwords($carrera), 0, 'L', 0, 0, '', '', true, 0, false, true, 40);
	$pdf->MultiCell(43, 0, 'Ciclo Academico '.date('Y'), 0, 'R', 0, 1, '', '', true, 0, false, true, 40);
	$pdf->MultiCell(143, 0, 'Maestro(a) Guía: '.ucwords($nGuia), 0, 'L', 0, 0, '', '', true, 0, false, true, 40);
	$nMes = date('F');
	$nMes = $this->traslateMonth($nMes);
	$pdf->MultiCell(43, 0, date('d').' de '.$nMes, 0, 'R', 0, 1, '', '', true, 0, false, true, 40);
	//$pdf->MultiCell(122.5, 55, 'Consolidado Anual', 1, 'C', 1, 0, '', '', true, 0, false, true, 50, 'M');
	//$y = $pdf->getY();
	//$pdf->SetXY(5, 83.5);
	$pdf->setY(-81);
	$pdf->SetFont('freesans', '', 8, '', true);
	$pdf->StartTransform();
	$pdf->SetXY(5, 75.8);
	$pdf->Rotate(90);
	//$pdf->Rotate(90, 19, 59.5);

	$pdf->writeHTMLCell(39.6, 15, '', '', '-DE 60 A 100 PUNTOS SE APRUEBA EL ÁREA <br><br> -DE 0 A 59 PUNTOS SE REPRUEBA EL ÁREA', 1, 1, 1, true, 'C', true);
	$y = 103.8;
	foreach ($nAreas as $key => $value) {
		//$pdf->MultiCell(39.6, 10, $value['nombre'], 1, 'L', 1, 1, '', '', true, 0, false, true, 10, 'M');
		$pdf->Cell(39.6, 10, ucwords($value['nombre']), 1, 1, 'C', 1, '', 1);
		//$pdf->SetXY(5, $y);
		//$y = $y + 10;
	}

$pdf->Cell(39.6, 10, 'Puntualidad y Asistencia', 1, 1, 'C', 1, '', 1);
$pdf->Cell(39.6, 10, 'Hábitos de Limpieza', 1, 1, 'C', 1, '', 1);
	$pdf->StopTransform();
	$pdf->Ln(1);

	$array = explode(',', $pEstudiante);

	$pdf->setY(-81);
	$pdf->writeHTMLCell(17.8, 5, '', '', 'Bloque I', 1, 0, 1, true, 'C', true);
	for ($i=1; $i < count($array); $i++) {
		if ($array[$i] < 60) {
			$pdf->writeHTMLCell(10, 5, '', '', '<span color="red">'.$array[$i].'</span>', 1, 0, 1, true, 'C', true);
		} else {
			$pdf->writeHTMLCell(10, 5, '', '', $array[$i], 1, 0, 1, true, 'C', true);
		}//fin del if else
	}//fin del ciclo for
	$pdf->writeHTMLCell(10, 5, '', '', mb_strtoupper($puntualidad), 1, 0, 1, true, 'C', true);
	$pdf->writeHTMLCell(10, 5, '', '', mb_strtoupper($habitos), 1, 0, 1, true, 'C', true);
	$pdf->Ln(5);
	$pdf->writeHTMLCell(17.8, 5, '', '', 'Bloque II', 1, 0, 1, true, 'C', true);
	for ($i=0; $i < count($array)+1; $i++) {
			$pdf->writeHTMLCell(10, 5, '', '', '', 1, 0, 1, true, 'C', true);
	}
	$pdf->Ln(5);
	$pdf->writeHTMLCell(17.8, 5, '', '', 'Bloque III', 1, 0, 1, true, 'C', true);
	for ($i=0; $i < count($array)+1; $i++) {
			$pdf->writeHTMLCell(10, 5, '', '', '', 1, 0, 1, true, 'C', true);
	}
	$pdf->Ln(5);
	$pdf->writeHTMLCell(17.8, 5, '', '', 'Bloque IV', 1, 0, 1, true, 'C', true);
	for ($i=0; $i < count($array)+1; $i++) {
			$pdf->writeHTMLCell(10, 5, '', '', '', 1, 0, 1, true, 'C', true);
	}
	$pdf->Ln(5);
	$pdf->writeHTMLCell(17.8, 5, '', '', 'Bloque V', 1, 0, 1, true, 'C', true);
	for ($i=0; $i < count($array)+1; $i++) {
			$pdf->writeHTMLCell(10, 5, '', '', '', 1, 0, 1, true, 'C', true);
	}
	$pdf->Ln(5);
	$pdf->writeHTMLCell(17.8, 5, '', '', 'Promedio', 1, 0, 1, true, 'C', true);
	for ($i=0; $i < count($array)+1; $i++) {
			$pdf->writeHTMLCell(10, 5, '', '', '', 1, 0, 1, true, 'C', true);
	}
	$pdf->Ln(6);
	$pdf->writeHTMLCell(0, 5, '', '', 'E: Excelente MB: Muy Bueno B: Bueno R: Regular A: Asistió NA: No Asistio', 0, 1, 1, true, 'C', true);

	$pdf->writeHTMLCell(90, 5, '', '', 'Observación de Bloque', 0, 1, 1, true, 'L', true);
	$pdf->writeHTMLCell(90, 5, '', '', 'Nota: Retornar la tarjeta de Calificaciones, 3 días despues de recibirlo', 0, 1, 1, true, 'L', true);

	}//fin del metodo cuerpo_tarjeta

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

}

/* End of file Tarjetas.php */
/* Location: ./application/controllers/Tarjetas.php */
