<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportesdocentes extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Asignaciondocente_model');
		$this->load->model('Cuadros_model');
		$this->load->model('Docente_model');
		$this->load->model('Bloque_model');
		$this->load->model('Estudiante_model');
		$this->load->model('Calendario_model', 'calendario');
	}
	public function index()
	{
		$persona = $_SESSION['nombreautenticado'];
		foreach ($persona as $value) {
			$id = $value['id'];
		}
		$data['areas'] = $this->Asignaciondocente_model->findAreasAsignadasDocente($id);//areas asignadas de pre-primaria, primaria y básicos
		$data['areasD'] = $this->Asignaciondocente_model->findAreasAsignadasDocenteD($id);

		$data['titulo'] = 'Generacion Cuadros Bloque';
		$data['activo'] = 'reportes';
		$this->load->view('plantilla/header', $data);
		$this->load->view('reportes/cdocentes', $data);
		$this->load->view('plantilla/footer');
	}

	public function crear_cuadros()
	{
		$this->form_validation->set_rules('area[]', 'Seleccionar', 'trim|required');
		$this->form_validation->set_message('required', 'El campo %s es obligatorio, debe seleccionar al menos un area.');

		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {

			$areas = $this->input->post('area[]');

			$this->total_bloque($areas);//calculamos e insertamos el nuevo total en la base de datos

			$fecha = date('Y-m-d');
			$ciclo = date('Y').'-00-00';
			$tipoarch = $this->input->post('tipo');
			foreach ($areas as $key => $value) {
				$temp = $areas[$key];
				$array = explode(',', $temp);
				if ($array[0] == 'diversificado') {
					$datos = $this->Cuadros_model->datos_cuadrosC($array[1], $fecha, $ciclo);
				} else {
					$datos = $this->Cuadros_model->datos_cuadros($array[1], $fecha, $ciclo);
				}
				$this->exportar_pdf($datos, $tipoarch);
			}

		}//fin del else
	}//fin del metodo

	private function total_bloque($areas)
	{
		foreach ($areas as $key => $value) {
				$fecha = date('Y-m-d');
				$ciclo = date('Y').'-00-00';
				//$fecha = '2015-12-17';
				//$ciclo = '2015-00-00';
				$cont = 1;
				$temp = $areas[$key];
				$array = explode(',', $temp);

				if ($array[0] == 'diversificado') {
					$datos = $this->Cuadros_model->getExamenPuntosC($array[1], $fecha, $ciclo);
				} else {
					$datos = $this->Cuadros_model->getExamenPuntos($array[1], $fecha, $ciclo);
				}//fin del else
				$zona = 0;
				foreach ($datos as $value) {
					$puntos = $value['puntos_acreditacion'];

					$zona = $zona + $puntos;
					$evaluacion = round($value['evaluacion_bloque']);

					if ($cont == 6) {
						$idCuadro = $value['id_cuadros'];
						$total =  round($zona) + $evaluacion;
						if ($array[0] == 'diversificado') {
							$this->Cuadros_model->total_bloque_c($idCuadro, $total);
						} else {
							$this->Cuadros_model->total_bloque($idCuadro, $total);
						}//fin del else

						$cont = 0;
						$zona = 0;
					}//fin del if
					$cont++;
				}//fin del foreach

			}//fin del foreach
	}

	private function exportar_pdf($datos, $salida)
	{
		$this->load->library('Pdf');

		$pdf = new Pdf('P', PDF_UNIT, 'LETTER', true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Colegio Pestalozzi');
		//$pdf->SetTitle('Cuadro de Bloque');
		$pdf->SetSubject('Formato PDF');
		$pdf->SetKeywords('Exportar,PDF, cuadro, bloque, área ');
		//datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
		//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE. ' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
		//$pdf->setFooterData($tc=array(0,64,0), $lc=array(0,64,128));
		//datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de liabraries/config
		$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
		//$pdf->setFooterFont(array(PDF_FONT_NAME_DATA,'',PDF_FONT_SIZE_DATA));
		//se pueden modificar en el archivo tcṕdf_config.php de libraries/config
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		//se puede modificar en el archivo tcpdf_config.php de libraries/config
		$pdf->SetMargins(10,40,10);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(10);
		//se pueden modificar en le archivo tcpdf_config.php de libraries/config
		$pdf->SetAutoPageBreak(TRUE, 15);
		//relación utilizada para ajustar la conversion de los píxeles
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		//-----------------------------------------
		$pdf->setPrintFooter(false);
		//Establecer el modo de fuente por defecto
		//$pdf->setFontSubsetting(TRUE);
		//establecer el tipo de letra
		//si tienes que imprimir carácteres ASCII estándar, puede utilizar las fuentes basicas como
		//Helvetica para reducir el tamaño del archivo
		$pdf->SetFont('times', '', 11, '', true);
		//añadir una página
		//este metodo tiene varias opciones, consultar la documentación para mas información
		$pdf->AddPage('P',array(355.6, 215.9));
		//fijar efecto de sombra en el texto
		//$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));


		//contenido para PDF
		$contenido = array();
		$acreditaciones = array();
		$cabecera = array();
		$aux = 1;
		$bandera = false;
		foreach ($datos as $value) {
			switch ($aux) {
				case 1:
						$n1 = $value['puntos_acreditacion'];
						$na1 = $value['nombre_acreditacion'];
					break;
				case 2:
						$n2=$value['puntos_acreditacion'];
						$na2 = $value['nombre_acreditacion'];
					break;
				case 3:
						$n3=$value['puntos_acreditacion'];
						$na3 = $value['nombre_acreditacion'];
					break;
				case 4:
						$n4=$value['puntos_acreditacion'];
						$na4 = $value['nombre_acreditacion'];
					break;
				case 5:
						$n5=$value['puntos_acreditacion'];
						$na5 = $value['nombre_acreditacion'];
					break;
				case 6:
						$n6=$value['puntos_acreditacion'];
						$na6 = $value['nombre_acreditacion'];
					break;
			}
			if ($aux == 6) {
				$bloque = $value['total_bloque'];
				$evaluacion = round($value['evaluacion_bloque']);
				$zona = $bloque - $evaluacion;
				$temp = array('estudiante'=>$value['apellidos_estudiante'].', '.$value['nombre_estudiante'], 'n1'=>$n1, 'n2'=>$n2, 'n3'=>$n3, 'n4'=>$n4, 'n5'=>$n5, 'n6'=>$n6, 'zona'=>$zona, 'examen'=>$evaluacion, 'total'=>$bloque);

				array_push($contenido, $temp);


				if ($bandera == false) {
					$temp = array('a1'=>$na1, 'a2'=>$na2, 'a3'=>$na3, 'a4'=>$na4, 'a5'=>$na5, 'a6'=>$na6);
					array_push($acreditaciones, $temp);
					if (isset($value['nombre_carrera'])) {
						$carrera = $value['nombre_carrera'];
					} else {
						$carrera = '';
					}

					$temp2 = $value['nombre_bloque'];

					$array2 = explode(' ', $temp2);

					$temp = array('grado'=>$value['nombre_grado'], 'nivel'=>$value['nombre_nivel'], 'area'=>$value['nombre_area'], 'bloque'=>$array2[1], 'carrera'=>$carrera);
					array_push($cabecera, $temp);
					$bandera = true;
				}//fin del if

				$aux = 0;
			}//fin del if
			$aux++;

		}

		$persona = $_SESSION['nombreautenticado'];
		$docente = '';
		foreach ($persona as $value) {
			$docente = $value['nombre'].' '.$value['apellidos'];
		}
		$pdf->SetFont('times', 'B', 14, '', true);
		$pdf->writeHTMLCell(0, 0, '', '', '<u><b>CUADRO DE CONTROL EVALUATIVO DE BLOQUE</b></u>', 0, 1, 0, FALSE, 'C', false);
		$html = '';
		$html .= '<style type="text/css"> h3{text-align:center;} .centro{text-align:center;}  .borde{ border: 1px solid #000; widht: auto;}</style>';

		//$html .= '<h2 style="text-align: center; text-decoration: underline;">CUADRO DE CONTROL EVALUATIVO DE BLOQUE</h2>';
		$pdf->SetFont('times', '', 11, '', true);
		foreach ($cabecera as $value) {
		$pdf->writeHTMLCell(50, 0, '', '', '<b>NIVEL:</b> '.ucwords($value['nivel']), 0, 0, 0, true, 'L', true);
		$pdf->writeHTMLCell(150, 0, '', '', '<b>CARRERA:</b> '.ucwords($value['carrera']), 0, 1, 0, true, 'L', true);
		$pdf->writeHTMLCell(50, 0, '', '', '<b>GRADO:</b> '.ucwords($value['grado']), 0, 0, 0, true, 'L', true);
		$pdf->writeHTMLCell(115, 0, '', '', '<b>ÁREA:</b> '.ucwords($value['area']), 0, 0, 0, true, 'L', true);
		$pdf->writeHTMLCell(60, 0, '', '', '<b>BLOQUE:</b> '.mb_strtoupper($value['bloque']), 0, 1, 0, true, 'L', true);
		$pdf->writeHTMLCell(50, 0, '', '', '<b>FECHA:</b> '.date('d/m/y'), 0, 0, 0, true, 'L', true);
		$pdf->writeHTMLCell(90, 0, '', '', '<b>DOCENTE:</b> '.ucwords($docente), 0, 0, 0, true, 'L', true);
		$pdf->writeHTMLCell(60, 0, '', '', '<b>CICLO ACADEMICO:</b> '.date('Y'), 0, 1, 0, true, 'L', true);

		}
		$txt = "\nLas calificaciones aprobadas se escriben con tinta negra.";
		$txt .= "\nLas calificaciones reprobadas se escriben con tinta roja.";
		$txt .= "\nEl trazo de los números debe ser exacto";
		$txt .= "\nPor ninguna causa se autorizará el atraso de entrega de cuadros a la Directora, son únicas fechas y horas.";
		$txt .= "\nLlene correctamente el: Grado, nivel, bloque, fecha, área, carrera; sus nombres y apellidos.";
		$txt .= "\nFirme sus cuadros antes de entregarlos.";
		$txt .= "\nAl no cumplir estrictamente con cada rubro, la Directora hará repetir los cuadros al Docente en 15 minutos.";
		$pdf->Ln(2);
		$pdf->writeHTMLCell(0, 0, '', '', 'Nota: LA ZONA ES DE 60 PUNTOS, LA EVALUACIÓN DE 40 PUNTOS, DANDO UN TOTAL DE 100 PUNTOS.', 0, 1, 0, true, 'L', true);
		$pdf->SetFont('times', '', 8, '', true);
		$pdf->MultiCell(8, 50.8, "A)\nB)\nC)\nD)\n\nE)\n\nF)\nG)\n ", 1, 'R', 0, 0, '', '', true, 0, false, true, 50, 'B');
		$pdf->MultiCell(80, 50.8, 'INSTRUCCIONES:'.$txt, 1, 'L', 0, 0, '', '', true, 0, false, true, 50, 'B');

		$pdf->SetFont('times', '', 11, '', true);
		$pdf->writeHTMLCell(60, 10, '', '', 'Acreditación de las Estrategias de Aprendizaje', 1, 1, 0, true, 'C', true);

		$pdf->SetFont('times', '', 9, '', true);
		$pdf->StartTransform();
		$pdf->SetXY(98, 118.5);
		$pdf->Rotate(90);
		foreach ($acreditaciones as $value) {
		$pdf->MultiCell(40.6, 10, $value['a1'], 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
		//$pdf->writeHTMLCell(40, 10, '', '', $value['a1'], 1, 1, 0, true, 'L', true);
		$pdf->SetXY(98, 128.5);
		$pdf->MultiCell(40.6, 10, $value['a2'], 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
		//$pdf->writeHTMLCell(40, 0, '', '', $value['a2'], 1, 1, 0, true, 'L', true);
		$pdf->SetXY(98, 138.5);
		$pdf->MultiCell(40.6, 10, $value['a3'], 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
		//$pdf->writeHTMLCell(40, 0, '', '', $value['a3'], 1, 1, 0, true, 'L', true);
		$pdf->SetXY(98, 148.5);
		$pdf->MultiCell(40.6, 10, $value['a4'], 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
		//$pdf->writeHTMLCell(40, 0, '', '', $value['a4'], 1, 1, 0, true, 'L', true);
		$pdf->SetXY(98, 158.5);
		$pdf->MultiCell(40.6, 10, $value['a5'], 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
		//$pdf->writeHTMLCell(40, 0, '', '', $value['a5'], 1, 1, 0, true, 'L', true);
		$pdf->SetXY(98, 168.5);
		$pdf->MultiCell(40.6, 10, $value['a6'], 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
		//$pdf->writeHTMLCell(40, 0, '', '', $value['a6'], 1, 1, 0, true, 'L', true);

		}
		$pdf->SetFont('times', 'B', 11, '', true);
		$pdf->SetXY(93, 178.5);
		$pdf->MultiCell(55.8, 10, 'Total de Zona', 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
		//$pdf->writeHTMLCell(40, 10, '', '', '<b>Total de Zona</b>', 1, 1, 0, true, 'L', true, 10, 'M');
		$pdf->SetXY(93, 188.5);
		$pdf->MultiCell(55.8, 10, 'Evaluación - Bloque', 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
		//$pdf->writeHTMLCell(40, 10, '', '', '<b>Evaluación - Bloque</b>', 1, 1, 0, true, 'L', true, 10, 'M');
		$pdf->SetXY(93, 198.5);
		$pdf->MultiCell(55.8, 10, 'Gran Total', 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
		//$pdf->writeHTMLCell(40, 10, '', '', '<b>Gran Total</b>', 1, 1, 0, true, 'L', true, 10, 'M');
		$pdf->SetXY(93, 208.5);
		$pdf->MultiCell(55.8, 10, 'APROBADO', 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
		//$pdf->writeHTMLCell(40, 10, '', '', '<b>APROBADO</b>', 1, 1, 0, true, 'L', true, 10, 'M');
		$pdf->SetXY(93, 218.5);
		$pdf->MultiCell(55.8, 10, 'REPROBADO', 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');

		$pdf->StopTransform();
		$pdf->SetFont('times', '', 11, '', true);
		$pdf->SetY(118.5);
		//$pdf->writeHTMLCell(113, 42, '', '', 'OPcion', 'LRTB', 1, 0, true, 'L', true);
		$pdf->writeHTMLCell(8, 0, '', '', 'No', 1, 0, 0, true, 'C', true);
		$pdf->writeHTMLCell(80, 0, '', '', 'NOMBRE DE LOS ESTUDIANTES', 1, 0, 0, true, 'C', true);
		$pdf->writeHTMLCell(10, 0, '', '', '1', 1, 0, 0, true, 'C', true);
		$pdf->writeHTMLCell(10, 0, '', '', '2', 1, 0, 0, true, 'C', true);
		$pdf->writeHTMLCell(10, 0, '', '', '3', 1, 0, 0, true, 'C', true);
		$pdf->writeHTMLCell(10, 0, '', '', '4', 1, 0, 0, true, 'C', true);
		$pdf->writeHTMLCell(10, 0, '', '', '5', 1, 0, 0, true, 'C', true);
		$pdf->writeHTMLCell(10, 0, '', '', '6', 1, 1, 0, true, 'C', true);


			$cont = 1;
			sort($contenido);
			 foreach ($contenido as $value) {
			 	$pdf->writeHTMLCell(8, 0, '', '', $cont, 1, 0, 0, true, 'C', true);
			 	$pdf->writeHTMLCell(80, 0, '', '', ucwords($value['estudiante']), 1, 0, 0, true, 'L', true);
				if ($value['n1'] == 0) {
					$pdf->writeHTMLCell(10, 0, '', '', '', 1, 0, 0, true, 'C', true);
				} else {
					$pdf->writeHTMLCell(10, 0, '', '', intval($value['n1']), 1, 0, 0, true, 'C', true);
				}
				if ($value['n2'] == 0) {
					$pdf->writeHTMLCell(10, 0, '', '', '', 1, 0, 0, true, 'C', true);
				} else {
					$pdf->writeHTMLCell(10, 0, '', '', intval($value['n2']), 1, 0, 0, true, 'C', true);
				}
				if ($value['n3'] == 0) {
					$pdf->writeHTMLCell(10, 0, '', '', '', 1, 0, 0, true, 'C', true);
				} else {
					$pdf->writeHTMLCell(10, 0, '', '', intval($value['n3']), 1, 0, 0, true, 'C', true);
				}
				if ($value['n4'] == 0) {
					$pdf->writeHTMLCell(10, 0, '', '', '', 1, 0, 0, true, 'C', true);
				} else {
					$pdf->writeHTMLCell(10, 0, '', '', intval($value['n4']), 1, 0, 0, true, 'C', true);
				}
				if ($value['n5'] == 0) {
					$pdf->writeHTMLCell(10, 0, '', '', '', 1, 0, 0, true, 'C', true);
				} else {
					$pdf->writeHTMLCell(10, 0, '', '', intval($value['n5']), 1, 0, 0, true, 'C', true);
				}
				if ($value['n6'] == 0) {
					$pdf->writeHTMLCell(10, 0, '', '', '', 1, 0, 0, true, 'C', true);
				} else {
					$pdf->writeHTMLCell(10, 0, '', '', intval($value['n6']), 1, 0, 0, true, 'C', true);
				}
				if ($value['zona'] == 0) {
					$pdf->writeHTMLCell(10, 0, '', '', '', 1, 0, 0, true, 'C', true);
				} else {
					$pdf->writeHTMLCell(10, 0, '', '', intval($value['zona']), 1, 0, 0, true, 'C', true);
				}
				if ($value['examen'] == 0) {
					$pdf->writeHTMLCell(10, 0, '', '', '', 1, 0, 0, true, 'C', true);
				} else {
					$pdf->writeHTMLCell(10, 0, '', '', $value['examen'], 1, 0, 0, true, 'C', true);
				}



			 	if ($value['total'] <60) {
					if ($value['total'] == 0) {
						$pdf->writeHTMLCell(10, 0, '', '', '', 1, 0, 0, true, 'C', true);
					} else {
						$pdf->writeHTMLCell(10, 0, '', '', '<p style="color:red">'.$value['total'].'</p>', 1, 0, 0, true, 'C', true);
					}


			 	} else {
			 		$pdf->writeHTMLCell(10, 0, '', '', $value['total'], 1, 0, 0, true, 'C', true);
			 	}


				if ($value['total'] >= 60) {

					$pdf->writeHTMLCell(10, 0, '', '', '<p>X</p>', 1, 0, 0, true, 'C', true);
					$pdf->writeHTMLCell(10, 0, '', '', '', 1, 1, 0, true, 'C', true);

				} else {
					if ($value['total'] == 0) {
						$pdf->writeHTMLCell(10, 0, '', '', '', 1, 0, 0, true, 'C', true);
						$pdf->writeHTMLCell(10, 0, '', '', '', 1, 1, 0, true, 'C', true);
					} else {
						$pdf->writeHTMLCell(10, 0, '', '', '', 1, 0, 0, true, 'C', true);
						$pdf->writeHTMLCell(10, 0, '', '', '<p style="color:red">X</p>', 1, 1, 0, true, 'C', true);
					}

				}

				if ($cont > 28) {
					$pdf->setPrintHeader(false);
					$pdf->SetMargins(10,35,10);
				}
				$cont++;
				if ($cont == 39) {
					$pdf->AddPage('P',array(355.6, 215.9));
					$pdf->SetY(10);
					$pdf->SetFont('times', '', 8, '', true);
						$pdf->MultiCell(8, 50.8, "A)\nB)\nC)\nD)\n\nE)\n\nF)\nG)\n ", 1, 'R', 0, 0, '', '', true, 0, false, true, 50, 'B');
						$pdf->MultiCell(80, 50.8, 'INSTRUCCIONES:'.$txt, 1, 'L', 0, 0, '', '', true, 0, false, true, 50, 'B');

						$pdf->SetFont('times', '', 11, '', true);
						$pdf->writeHTMLCell(60, 10, '', '', 'Acreditación de las Estrategias de Aprendizaje', 1, 1, 0, true, 'C', true);

						$pdf->SetFont('times', '', 9, '', true);
						$pdf->StartTransform();
						$pdf->SetXY(98, 60.8);
						$pdf->Rotate(90);
						foreach ($acreditaciones as $value) {
						$pdf->MultiCell(40.6, 10, $value['a1'], 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
						//$pdf->writeHTMLCell(40, 10, '', '', $value['a1'], 1, 1, 0, true, 'L', true);
						$pdf->SetXY(98, 70.8);
						$pdf->MultiCell(40.6, 10, $value['a2'], 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
						//$pdf->writeHTMLCell(40, 0, '', '', $value['a2'], 1, 1, 0, true, 'L', true);
						$pdf->SetXY(98, 80.8);
						$pdf->MultiCell(40.6, 10, $value['a3'], 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
						//$pdf->writeHTMLCell(40, 0, '', '', $value['a3'], 1, 1, 0, true, 'L', true);
						$pdf->SetXY(98, 90.8);
						$pdf->MultiCell(40.6, 10, $value['a4'], 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
						//$pdf->writeHTMLCell(40, 0, '', '', $value['a4'], 1, 1, 0, true, 'L', true);
						$pdf->SetXY(98, 100.8);
						$pdf->MultiCell(40.6, 10, $value['a5'], 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
						//$pdf->writeHTMLCell(40, 0, '', '', $value['a5'], 1, 1, 0, true, 'L', true);
						$pdf->SetXY(98, 110.8);
						$pdf->MultiCell(40.6, 10, $value['a6'], 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
						//$pdf->writeHTMLCell(40, 0, '', '', $value['a6'], 1, 1, 0, true, 'L', true);

						}
						$pdf->SetFont('times', 'B', 11, '', true);
						$pdf->SetXY(93, 120.8);
						$pdf->MultiCell(55.8, 10, 'Total de Zona', 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
						//$pdf->writeHTMLCell(40, 10, '', '', '<b>Total de Zona</b>', 1, 1, 0, true, 'L', true, 10, 'M');
						$pdf->SetXY(93, 130.8);
						$pdf->MultiCell(55.8, 10, 'Evaluación - Bloque', 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
						//$pdf->writeHTMLCell(40, 10, '', '', '<b>Evaluación - Bloque</b>', 1, 1, 0, true, 'L', true, 10, 'M');
						$pdf->SetXY(93, 140.85);
						$pdf->MultiCell(55.8, 10, 'Gran Total', 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
						//$pdf->writeHTMLCell(40, 10, '', '', '<b>Gran Total</b>', 1, 1, 0, true, 'L', true, 10, 'M');
						$pdf->SetXY(93, 150.8);
						$pdf->MultiCell(55.8, 10, 'APROBADO', 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
						//$pdf->writeHTMLCell(40, 10, '', '', '<b>APROBADO</b>', 1, 1, 0, true, 'L', true, 10, 'M');
						$pdf->SetXY(93, 160.8);
						$pdf->MultiCell(55.8, 10, 'REPROBADO', 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');

						$pdf->StopTransform();
						$pdf->SetFont('times', '', 11, '', true);
						$pdf->SetY(60.8);
						//$pdf->writeHTMLCell(113, 42, '', '', 'OPcion', 'LRTB', 1, 0, true, 'L', true);
						$pdf->writeHTMLCell(8, 0, '', '', 'No', 1, 0, 0, true, 'C', true);
						$pdf->writeHTMLCell(80, 0, '', '', 'NOMBRE DE LOS ESTUDIANTES', 1, 0, 0, true, 'C', true);
						$pdf->writeHTMLCell(10, 0, '', '', '1', 1, 0, 0, true, 'C', true);
						$pdf->writeHTMLCell(10, 0, '', '', '2', 1, 0, 0, true, 'C', true);
						$pdf->writeHTMLCell(10, 0, '', '', '3', 1, 0, 0, true, 'C', true);
						$pdf->writeHTMLCell(10, 0, '', '', '4', 1, 0, 0, true, 'C', true);
						$pdf->writeHTMLCell(10, 0, '', '', '5', 1, 0, 0, true, 'C', true);
						$pdf->writeHTMLCell(10, 0, '', '', '6', 1, 1, 0, true, 'C', true);
				}
			//$html .='</tr>';
		}//fin del foreach

		if ($cont < 60) {
$pdf->setPrintHeader(false);
			for ($i=$cont; $i <= 60; $i++) {
			$pdf->writeHTMLCell(8, 0, '', '', $i, 1, 0, 0, true, 'C', true);
			$pdf->writeHTMLCell(80, 0, '', '', '', 1, 0, 0, true, 'C', true);
			$pdf->writeHTMLCell(10, 0, '', '', '', 1, 0, 0, true, 'C', true);
			$pdf->writeHTMLCell(10, 0, '', '', '', 1, 0, 0, true, 'C', true);
			$pdf->writeHTMLCell(10, 0, '', '', '', 1, 0, 0, true, 'C', true);
			$pdf->writeHTMLCell(10, 0, '', '', '', 1, 0, 0, true, 'C', true);
			$pdf->writeHTMLCell(10, 0, '', '', '', 1, 0, 0, true, 'C', true);
			$pdf->writeHTMLCell(10, 0, '', '', '', 1, 0, 0, true, 'C', true);
			$pdf->writeHTMLCell(10, 0, '', '', '', 1, 0, 0, true, 'C', true);
			$pdf->writeHTMLCell(10, 0, '', '', '', 1, 0, 0, true, 'C', true);
			$pdf->writeHTMLCell(10, 0, '', '', '', 1, 0, 0, true, 'C', true);
			$pdf->writeHTMLCell(10, 0, '', '', '', 1, 0, 0, true, 'C', true);
			$pdf->writeHTMLCell(10, 0, '', '', '', 1, 1, 0, true, 'C', true);

				if ($i == 38) {
				$pdf->AddPage('P',array(355.6, 215.9));
					$pdf->SetY(10);
					$pdf->SetFont('times', '', 8, '', true);
						$pdf->MultiCell(8, 50.8, "A)\nB)\nC)\nD)\n\nE)\n\nF)\nG)\n ", 1, 'R', 0, 0, '', '', true, 0, false, true, 50, 'B');
						$pdf->MultiCell(80, 50.8, 'INSTRUCCIONES:'.$txt, 1, 'L', 0, 0, '', '', true, 0, false, true, 50, 'B');

						$pdf->SetFont('times', '', 11, '', true);
						$pdf->writeHTMLCell(60, 10, '', '', 'Acreditación de las Estrategias de Aprendizaje', 1, 1, 0, true, 'C', true);

						$pdf->SetFont('times', '', 9, '', true);
						$pdf->StartTransform();
						$pdf->SetXY(98, 60.8);
						$pdf->Rotate(90);
						foreach ($acreditaciones as $value) {
						$pdf->MultiCell(40.6, 10, $value['a1'], 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
						//$pdf->writeHTMLCell(40, 10, '', '', $value['a1'], 1, 1, 0, true, 'L', true);
						$pdf->SetXY(98, 70.8);
						$pdf->MultiCell(40.6, 10, $value['a2'], 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
						//$pdf->writeHTMLCell(40, 0, '', '', $value['a2'], 1, 1, 0, true, 'L', true);
						$pdf->SetXY(98, 80.8);
						$pdf->MultiCell(40.6, 10, $value['a3'], 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
						//$pdf->writeHTMLCell(40, 0, '', '', $value['a3'], 1, 1, 0, true, 'L', true);
						$pdf->SetXY(98, 90.8);
						$pdf->MultiCell(40.6, 10, $value['a4'], 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
						//$pdf->writeHTMLCell(40, 0, '', '', $value['a4'], 1, 1, 0, true, 'L', true);
						$pdf->SetXY(98, 100.8);
						$pdf->MultiCell(40.6, 10, $value['a5'], 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
						//$pdf->writeHTMLCell(40, 0, '', '', $value['a5'], 1, 1, 0, true, 'L', true);
						$pdf->SetXY(98, 110.8);
						$pdf->MultiCell(40.6, 10, $value['a6'], 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
						//$pdf->writeHTMLCell(40, 0, '', '', $value['a6'], 1, 1, 0, true, 'L', true);

						}
						$pdf->SetFont('times', 'B', 11, '', true);
						$pdf->SetXY(93, 120.8);
						$pdf->MultiCell(55.8, 10, 'Total de Zona', 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
						//$pdf->writeHTMLCell(40, 10, '', '', '<b>Total de Zona</b>', 1, 1, 0, true, 'L', true, 10, 'M');
						$pdf->SetXY(93, 130.8);
						$pdf->MultiCell(55.8, 10, 'Evaluación - Bloque', 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
						//$pdf->writeHTMLCell(40, 10, '', '', '<b>Evaluación - Bloque</b>', 1, 1, 0, true, 'L', true, 10, 'M');
						$pdf->SetXY(93, 140.85);
						$pdf->MultiCell(55.8, 10, 'Gran Total', 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
						//$pdf->writeHTMLCell(40, 10, '', '', '<b>Gran Total</b>', 1, 1, 0, true, 'L', true, 10, 'M');
						$pdf->SetXY(93, 150.8);
						$pdf->MultiCell(55.8, 10, 'APROBADO', 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
						//$pdf->writeHTMLCell(40, 10, '', '', '<b>APROBADO</b>', 1, 1, 0, true, 'L', true, 10, 'M');
						$pdf->SetXY(93, 160.8);
						$pdf->MultiCell(55.8, 10, 'REPROBADO', 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');

						$pdf->StopTransform();
						$pdf->SetFont('times', '', 11, '', true);
						$pdf->SetY(60.8);
						//$pdf->writeHTMLCell(113, 42, '', '', 'OPcion', 'LRTB', 1, 0, true, 'L', true);
						$pdf->writeHTMLCell(8, 0, '', '', 'No', 1, 0, 0, true, 'C', true);
						$pdf->writeHTMLCell(80, 0, '', '', 'NOMBRE DE LOS ESTUDIANTES', 1, 0, 0, true, 'C', true);
						$pdf->writeHTMLCell(10, 0, '', '', '1', 1, 0, 0, true, 'C', true);
						$pdf->writeHTMLCell(10, 0, '', '', '2', 1, 0, 0, true, 'C', true);
						$pdf->writeHTMLCell(10, 0, '', '', '3', 1, 0, 0, true, 'C', true);
						$pdf->writeHTMLCell(10, 0, '', '', '4', 1, 0, 0, true, 'C', true);
						$pdf->writeHTMLCell(10, 0, '', '', '5', 1, 0, 0, true, 'C', true);
						$pdf->writeHTMLCell(10, 0, '', '', '6', 1, 1, 0, true, 'C', true);
				}


			}//fin del for
		}//fin del if
		$pdf->Ln(3);
		$pdf->SetFont('times', 'U', 12, '', true);
		$pdf->MultiCell(0, 0, "CALENDARIO PARA ENTREGA DE CUADROS DE CALIFICACIONES DE BLOQUE Y ANUAL\n A LA DIRECTORA DRA. EN EDUCACIÓN BETTY ARGUETA\n CICLO ACADEMICO ".date('Y'), 0, 'C', 0, 1, '', '', true, 0, false, true, 0, 'B');
		$pdf->SetFont('times', '', 10, '', true);
		$pdf->Ln(3);
		$html = '<table border="1">';
		$html .= '<tr>';
		$html .= '<td width="30">NO</td><td width="140">ÁREAS Y NIVELES</td> <td width="80">BLOQUE</td> <td width="150">FECHA DE ENTREGA</td><td width="180"><table border="1"><tr><td>HORA</td></tr><tr><td width="90">MATUTINA</td><td width="90">VESPERTINA</td></tr></table></td> <td><i>Recibe toda la Papelería</i></td>';
		$html .= '</tr>';
		$datos = 	$this->calendario->getCalendario();
		$b1 = $datos[0]['buno_complementario'];
	  $b2 = $datos[0]['bdos_complementario'];
	  $b3 = $datos[0]['btres_complementario'];
	  $b4 = $datos[0]['bcuatro_complementario'];
	  $b1p = $datos[0]['buno_primaria'];
	  $b2p = $datos[0]['bdos_primaria'];
	  $b3p = $datos[0]['btres_primaria'];
	  $b4p = $datos[0]['bcuatro_primaria'];
	  $b1c = $datos[0]['buno_bc'];
	  $b2c = $datos[0]['bdos_bc'];
	  $b3c = $datos[0]['btres_bc'];
	  $b4c = $datos[0]['bcuatro_bc'];
		$html .= '<tr><td> <br> <br> <br>1</td> <td><b>Pre-Primaria y Primaria Áreas Complementarias:</b> Educación Física-Inglés Computación-K´iche a)Archivo de exámenes Cuadernos de Asistencia</td> <td><table border="1"><tr><td>I BLOQUE</td></tr> <tr><td>II BLOQUE</td></tr> <tr><td>III BLOQUE</td></tr> <tr><td>IV BLOQUE</td></tr> <tr><td><br> <br>V BLOQUE</td></tr></table></td> <td><table border="1"><tr><td>'.$b1.'</td></tr> <tr><td>'.$b2.'</td></tr> <tr><td>'.$b3.'</td></tr> <tr><td>'.$b4.'</td></tr> <tr><td>Al día siguiente después de evaluar</td></tr></table></td> <td><table border="1"><tr><td>9:00 AM</td> <td>14:00 Hrs.</td></tr> <tr><td>9:00 AM</td> <td>14:00 Hrs.</td></tr> <tr><td>9:00 AM</td> <td>14:00 Hrs.</td></tr> <tr><td>9:00 AM</td> <td>14:00 Hrs.</td></tr> <tr><td> <br> <br>9:00AM</td> <td>  <br> <br>14:00 Hrs.</td></tr></table></td> <td><table border="1"><tr><td>DIRECTORA</td></tr> <tr><td>DIRECTORA</td></tr> <tr><td>DIRECTORA</td></tr> <tr><td>DIRECTORA</td></tr> <tr><td> <br> <br>DIRECTORA</td></tr></table></td></tr>';
		$html .= '<tr><td> <br> <br> <br>2</td> <td><b>Pre-Primaria y Primaria:</b> a)Folder de archivo de Exámenes. <br> b)Tarjetas de Calificaciones <br> c)Cuadernos de Asistencia</td> <td><table border="1"><tr><td>I BLOQUE</td></tr> <tr><td>II BLOQUE</td></tr> <tr><td>III BLOQUE</td></tr> <tr><td>IV BLOQUE</td></tr> <tr><td><br> <br>V BLOQUE</td></tr></table></td> <td><table border="1"><tr><td>'.$b1p.'</td></tr> <tr><td>'.$b2p.'</td></tr> <tr><td>'.$b3p.'</td></tr> <tr><td>'.$b4.'</td></tr> <tr><td>Al día siguiente después de evaluar</td></tr></table></td> <td><table border="1"><tr><td>9:00 AM</td> <td>14:00 Hrs.</td></tr> <tr><td>9:00 AM</td> <td>14:00 Hrs.</td></tr> <tr><td>9:00 AM</td> <td>14:00 Hrs.</td></tr> <tr><td>9:00 AM</td> <td>14:00 Hrs.</td></tr> <tr><td> <br> <br>9:00AM</td> <td>  <br> <br>14:00 Hrs.</td></tr></table></td> <td><table border="1"><tr><td>DIRECTORA</td></tr> <tr><td>DIRECTORA</td></tr> <tr><td>DIRECTORA</td></tr> <tr><td>DIRECTORA</td></tr> <tr><td> <br> <br>DIRECTORA</td></tr></table></td></tr>';
		$html .= '<tr><td> <br> <br> <br>3</td> <td> <br><br><b>Básico y Diversificado:</b> a)Folder de archivo de Evaluación por área. <br> b)Cuadernos de asistencia</td> <td><table border="1"><tr><td>I BLOQUE</td></tr> <tr><td>II BLOQUE</td></tr> <tr><td>III BLOQUE</td></tr> <tr><td>IV BLOQUE</td></tr> <tr><td><br> <br>V BLOQUE</td></tr></table></td> <td><table border="1"><tr><td>'.$b1c.'</td></tr> <tr><td>'.$b2c.'</td></tr> <tr><td>'.$b3c.'</td></tr> <tr><td>'.$b4c.'</td></tr> <tr><td>Al día siguiente después de evaluar</td></tr></table></td> <td><table border="1"><tr><td>9:00 AM</td> <td>14:00 Hrs.</td></tr> <tr><td>9:00 AM</td> <td>14:00 Hrs.</td></tr> <tr><td>9:00 AM</td> <td>14:00 Hrs.</td></tr> <tr><td>9:00 AM</td> <td>14:00 Hrs.</td></tr> <tr><td> <br> <br>9:00AM</td> <td>  <br> <br>14:00 Hrs.</td></tr></table></td> <td><table border="1"><tr><td>DIRECTORA</td></tr> <tr><td>DIRECTORA</td></tr> <tr><td>DIRECTORA</td></tr> <tr><td>DIRECTORA</td></tr> <tr><td> <br> <br>DIRECTORA</td></tr></table></td></tr>';
		$html .= '</table>';
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'C', true);
		$pdf->SetFont('times', '', 12, '', true);
		$html = 'Observaciones:__________________________________________________________________________________________________________________________________________________________________________';
		$pdf->Ln(3);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'L', true);

		//-----------------------------------------------------------------------------

		$pdf->persona = $docente;
		$pdf->setPrintFooter(true);

		//cerrar el documento pdf y preparamos la salida
		//este metodo tiene varias opciones, consulte la documentación para más información.
		$nombreArch = '';
		if (!isset($cabecera)) {


		if ($cabecera[0]['nivel'] == 'diversificado') {
			$nombreArch = $cabecera[0]['grado'].' '.$cabecera[0]['carrera'];
		} else {
			$nombreArch = $cabecera[0]['grado'].' '.$cabecera[0]['nivel'];
		}
		}
			$pdf->SetTitle('Cuadro de Bloque: '.$nombreArch);
		if ($salida == 'v') {
			$nombre_archivo = utf8_decode("Cuadro-Bloque ".$nombreArch.".pdf");
			$pdf->Output($nombre_archivo,'I');
		} else {
			$nombre_archivo = utf8_decode("Cuadro-Bloque ".$nombreArch.".pdf");
			$pdf->Output($nombre_archivo,'D');
		}


	}//fin del metodo

	public function anual_areas()
	{
		$persona = $_SESSION['nombreautenticado'];
		foreach ($persona as $value) {
			$id = $value['id'];
		}
		$data['areas'] = $this->Asignaciondocente_model->findAreasAsignadasDocente($id);//areas asignadas de pre-primaria, primaria y básicos
		$data['areasD'] = $this->Asignaciondocente_model->findAreasAsignadasDocenteD($id);

		$data['titulo'] = 'Generacion Cuadros Bloque';
		$data['activo'] = 'reportes';
		$this->load->view('plantilla/header', $data);
		$this->load->view('reportes/adocentes', $data);
		$this->load->view('plantilla/footer');
	}

	public function crear_anual()
	{
		$this->form_validation->set_rules('area', 'Seleccionar', 'trim|required');
		$this->form_validation->set_message('required', 'El campo %s es obligatorio debe seleccionar una opcion.');

		if ($this->form_validation->run() == FALSE) {
			$this->anual_areas();
		} else {
			$dato = $this->input->post('area');
			$ciclo = date('Y').'-00-00';
			$tipoarch = $this->input->post('tipo');
				$array = explode(',', $dato);
				if ($array[0] == 'diversificado') {
					$datos = $this->Cuadros_model->cuadro_anualC($array[1], $ciclo);
				 $this->exportar_anual_pdf($datos, $tipoarch);
				} else {
					$datos = $this->Cuadros_model->cuadro_anual($array[1], $ciclo);
					$this->exportar_anual_pdf($datos, $tipoarch);
				}//fin del if else

		}//fin del if else
	}//fin del metodo

	private function exportar_anual_pdf($datos, $salida)
	{
		$this->load->library('Pdf');

		$pdf = new Pdf('P', PDF_UNIT, 'LETTER', true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Colegio Pestalozzi');
		$pdf->SetTitle('Cuadro Anual de Áreas');
		$pdf->SetSubject('PDF');
		$pdf->SetKeywords('Exportar,PDF, Anual, Áreas, super');
		//datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE. ' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
		//$pdf->setFooterData($tc=array(0,64,0), $lc=array(0,64,128));
		//datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de liabraries/config
		$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
		//$pdf->setFooterFont(array(PDF_FONT_NAME_DATA,'',PDF_FONT_SIZE_DATA));
		//se pueden modificar en el archivo tcṕdf_config.php de libraries/config
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		//se puede modificar en el archivo tcpdf_config.php de libraries/config
		$pdf->SetMargins(10,40,10);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		//se pueden modificar en le archivo tcpdf_config.php de libraries/config
		$pdf->SetAutoPageBreak(TRUE, 10);
		//relación utilizada para ajustar la conversion de los píxeles
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		//-----------------------------------------
		//Establecer el modo de fuente por defecto
		$pdf->setFontSubsetting(TRUE);
		$pdf->setPrintFooter(false);
		//establecer el tipo de letra
		//si tienes que imprimir carácteres ASCII estándar, puede utilizar las fuentes basicas como
		//Helvetica para reducir el tamaño del archivo
		$pdf->SetFont('times', '', 11, '', true);
		//añadir una página
		//este metodo tiene varias opciones, consultar la documentación para mas información
		$pdf->AddPage('P',array(355.6, 215.9));
		//fijar efecto de sombra en el texto
		//$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
		$cont = 1;
		$bandera = false;
		$cuadro = array();
		$cabecera = array();
		$b1 = $b2 = $b3 = $b4 = $b5 = '';
		foreach ($datos as $value) {
			if ($value['nombre_bloque'] == 'bloque i') {
				$b1 = $value['total_bloque'];
			}//fin del if
			if ($value['nombre_bloque'] == 'bloque ii') {
				$b2 = $value['total_bloque'];
			}//fin del if
			if ($value['nombre_bloque'] == 'bloque iii') {
				$b3 = $value['total_bloque'];
			}//fin del if
			if ($value['nombre_bloque'] == 'bloque iv') {
				$b4 = $value['total_bloque'];
			}//fin del if
			if ($value['nombre_bloque'] == 'bloque v') {
				$b5 = $value['total_bloque'];
			}//fin del if
			$promedio = round(($b1+$b2+$b3+$b4+$b5)/5);
			if ($promedio == 0) {
				$promedio = '';
			}
			$estudiante = $value['apellidos_estudiante'].', '.$value['nombre_estudiante'];
			$temp = array('b1'=>$b1, 'b2'=>$b2, 'b3'=>$b3, 'b4'=>$b4 , 'b5'=>$b5, 'estudiante'=>$estudiante, 'promedio'=>$promedio);
			array_push($cuadro, $temp);
			if ($bandera == false) {
				if (isset($value['nombre_carrera'])) {
					$carrera = $value['nombre_carrera'];
				}else{
					$carrera = '';
				}//fin del if else
				$temp = array('nivel'=>$value['nombre_nivel'], 'area'=>$value['nombre_area'], 'carrera'=>$carrera, 'grado'=>$value['nombre_grado']);
				array_push($cabecera, $temp);
				$bandera = true;
		}
			if ($cont == 5) {
				//$promedio = round(($b1+$b2+$b3+$b4+$b5)/5);
				//$estudiante = $value['apellidos_estudiante'].', '.$value['nombre_estudiante'];
				//$temp = array('b1'=>$b1, 'b2'=>$b2, 'b3'=>$b3, 'b4'=>$b4 , 'b5'=>$b5, 'estudiante'=>$estudiante, 'promedio'=>$promedio);
				//array_push($cuadro, $temp);
				/*if ($bandera == false) {
					if (isset($value['nombre_carrera'])) {
						$carrera = $value['nombre_carrera'];
					}else{
						$carrera = '';
					}//fin del if else
					$temp = array('nivel'=>$value['nombre_nivel'], 'area'=>$value['nombre_area'], 'carrera'=>$carrera, 'grado'=>$value['nombre_grado']);
					array_push($cabecera, $temp);
					$bandera = true;
				}*///fin del if
				$cont = 0;
			}//fin del if
			$temp = '';
			$cont++;
		}//fin del foreach

		$persona = $_SESSION['nombreautenticado'];
		$docente = '';
		foreach ($persona as $value) {
			$docente = $value['nombre'].' '.$value['apellidos'];
		}//fin del foreach

		$persona = $_SESSION['nombreautenticado'];
		$docente = '';
		foreach ($persona as $value) {
			$docente = $value['nombre'].' '.$value['apellidos'];
		}
		$pdf->SetFont('times', 'B', 14, '', true);
		$pdf->writeHTMLCell(0, 0, '', '', '<u><b>CUADRO DE CONTROL EVALUATIVO ANUAL</b></u>', 0, 1, 0, FALSE, 'C', false);
		$html = '';
		$html .= '<style type="text/css"> h3{text-align:center;} .centro{text-align:center;}  .borde{ border: 1px solid #000; widht: auto;}</style>';

		//$html .= '<h2 style="text-align: center; text-decoration: underline;">CUADRO DE CONTROL EVALUATIVO DE BLOQUE</h2>';
		$pdf->SetFont('times', '', 11, '', true);

		foreach ($cabecera as $value) {
		$pdf->writeHTMLCell(50, 0, '', '', '<b>NIVEL:</b> '.ucwords($value['nivel']), 0, 0, 0, true, 'L', true);
		$pdf->writeHTMLCell(90, 0, '', '', '<b>CARRERA:</b> '.ucwords($value['carrera']), 0, 1, 0, true, 'L', true);
		$pdf->writeHTMLCell(50, 0, '', '', '<b>GRADO:</b> '.ucwords($value['grado']), 0, 0, 0, true, 'L', true);
		$pdf->writeHTMLCell(80, 0, '', '', '<b>ÁREA:</b> '.ucwords($value['area']), 0, 0, 0, true, 'L', true);
		$pdf->writeHTMLCell(60, 0, '', '', '<b>BLOQUE:</b> I II III IV V', 0, 1, 0, true, 'L', true);
		$pdf->writeHTMLCell(50, 0, '', '', '<b>FECHA:</b> '.date('d/m/y'), 0, 0, 0, true, 'L', true);
		$pdf->writeHTMLCell(80, 0, '', '', '<b>DOCENTE:</b> '.ucwords($docente), 0, 0, 0, true, 'L', true);
		$pdf->writeHTMLCell(60, 0, '', '', '<b>CICLO ACADEMICO:</b> '.date('Y'), 0, 1, 0, true, 'L', true);

	}

		$html = '';


		$txt = "\nLas calificaciones aprobadas se escriben con tinta negra.";
		$txt .= "\nLas calificaciones reprobadas se escriben con tinta roja.";
		$txt .= "\nEl trazo de los números debe ser exacto";
		$txt .= "\nPor ninguna causa se autorizará el atraso de entrega de cuadros a la Directora, son únicas fechas y horas.";
		$txt .= "\nLlene correctamente el: Grado, nivel, bloque, fecha, área, carrera; sus nombres y apellidos.";
		$txt .= "\nFirme sus cuadros antes de entregarlos.";
		$txt .= "\nAl no cumplir estrictamente con cada rubro, la Directora hará repetir los cuadros al Docente en 15 minutos.";
		$pdf->Ln(2);
		$pdf->writeHTMLCell(0, 0, '', '', 'Nota: LA ZONA ES DE 60 PUNTOS, LA EVALUACIÓN DE 40 PUNTOS, DANDO UN TOTAL DE 100 PUNTOS.', 0, 1, 0, true, 'L', true);
		$pdf->SetFont('times', '', 8, '', true);
		$pdf->MultiCell(8, 50.8, "A)\nB)\nC)\nD)\n\nE)\n\nF)\nG)\n ", 1, 'R', 0, 0, '', '', true, 0, false, true, 50, 'B');
		$pdf->MultiCell(80, 50.8, 'INSTRUCCIONES:'.$txt, 1, 'L', 0, 0, '', '', true, 0, false, true, 50, 'B');

		$pdf->SetFont('times', '', 9, '', true);
		$pdf->MultiCell(75, 10, 'Acreditación de las Estrategias de Aprendizaje', 1, 'C', 0, 1, '', '', true, 0, false, true, 10, 'M');
		//$pdf->writeHTMLCell(75, 10, '', '', 'Acreditación de las Estrategias de Aprendizaje', 1, 1, 0, true, 'C', true);
		$pdf->writeHTMLCell(15, 45.8, 98, '', 'I BLOQUE', 1, 0, 0, true, 'C', true);
		$pdf->writeHTMLCell(15, 45.8, 113, '', 'II BLOQUE', 1, 0, 0, true, 'C', true);
		$pdf->writeHTMLCell(15, 45.8, 128, '', 'III BLOQUE', 1, 0, 0, true, 'C', true);
		$pdf->writeHTMLCell(15, 45.8, 143, '', 'IV BLOQUE', 1, 0, 0, true, 'C', true);
		$pdf->writeHTMLCell(15, 45.8, 158, '', 'V BLOQUE', 1, 1, 0, true, 'C', true);

		$pdf->SetFont('times', 'B', 12, '', true);
		$pdf->StartTransform();

		$pdf->SetXY(173, 123.6);
		$pdf->Rotate(90);
		$pdf->MultiCell(55.8, 10, 'PROMEDIO', 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
		$pdf->SetXY(173, 133.6);
		$pdf->MultiCell(55.8, 10, 'APROBADO', 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
		$pdf->SetXY(173, 143.6);
		$pdf->MultiCell(55.8, 10, 'REPROBADO', 1, 'L', 0, 1, '', '', true, 0, false, true, 10, 'M');
		$pdf->StopTransform();


		//$pdf->SetY(120);

		$pdf->SetFont('times', '', 11, '', true);
		$pdf->SetY(118.5);
		//$pdf->writeHTMLCell(113, 42, '', '', 'OPcion', 'LRTB', 1, 0, true, 'L', true);
		$pdf->writeHTMLCell(8, 0, '', '', 'No', 1, 0, 0, true, 'C', true);
		$pdf->writeHTMLCell(80, 0, '', '', 'NOMBRE DE LOS ESTUDIANTES', 1, 1, 0, true, 'C', true);

		$cont = 1;
		sort($cuadro);
		foreach ($cuadro as $value) {
		$pdf->writeHTMLCell(8, 0, '', '', $cont, 1, 0, 0, true, 'C', true);
		$pdf->writeHTMLCell(80, 0, '', '', ucwords($value['estudiante']), 1, 0, 0, true, 'L', true);
		$pdf->writeHTMLCell(15, 0, '', '', $value['b1'], 1, 0, 0, true, 'C', true);
		$pdf->writeHTMLCell(15, 0, '', '', $value['b2'], 1, 0, 0, true, 'C', true);
		$pdf->writeHTMLCell(15, 0, '', '', $value['b3'], 1, 0, 0, true, 'C', true);
		$pdf->writeHTMLCell(15, 0, '', '', $value['b4'], 1, 0, 0, true, 'C', true);
		$pdf->writeHTMLCell(15, 0, '', '', $value['b5'], 1, 0, 0, true, 'C', true);
		if ($value['promedio'] < 60) {
			$pdf->writeHTMLCell(10, 0, '', '', '<p style="color:red">'.$value['promedio'].'</p>', 1, 0, 0, true, 'C', true);
		} else {
			$pdf->writeHTMLCell(10, 0, '', '', $value['promedio'], 1, 0, 0, true, 'C', true);
		}

		if ($value['promedio'] >=60) {
			$pdf->writeHTMLCell(10, 0, '', '', 'X', 1, 0, 0, true, 'C', true);
			$pdf->writeHTMLCell(10, 0, '', '', '', 1, 1, 0, true, 'C', true);
			//$html .= '<th style="width: 4%; text-align:center">X</th>';
			//$html .= '<th style="width: 4%; text-align:center"></th>';
		}else{
			if ($value['promedio'] != 0) {
				$pdf->writeHTMLCell(10, 0, '', '', '', 1, 0, 0, true, 'C', true);
				$pdf->writeHTMLCell(10, 0, '', '', '<p style="color:red">X</p>', 1, 1, 0, true, 'C', true);

			} else {
				$pdf->writeHTMLCell(10, 0, '', '', '', 1, 0, 0, true, 'C', true);
				$pdf->writeHTMLCell(10, 0, '', '', '', 1, 1, 0, true, 'C', true);

			}

						//$html .= '<th style="width: 4%; text-align:center"></th>';
			//$html .= '<th style="width: 4%; text-align:center; color: red;">X</th>';
		}//fin del if else

		$html .= '</tr>';
		if ($cont >32) {
			$pdf->setPrintHeader(false);
		}
		$cont++;
			if ($cont == 39) {
				$pdf->AddPage('P',array(355.6, 215.9));
				$pdf->SetY(10);
				$txt = "\nLas calificaciones aprobadas se escriben con tinta negra.";
				$txt .= "\nLas calificaciones reprobadas se escriben con tinta roja.";
				$txt .= "\nEl trazo de los números debe ser exacto";
				$txt .= "\nPor ninguna causa se autorizará el atraso de entrega de cuadros a la Directora, son únicas fechas y horas.";
				$txt .= "\nLlene correctamente el: Grado, nivel, bloque, fecha, área, carrera; sus nombres y apellidos.";
				$txt .= "\nFirme sus cuadros antes de entregarlos.";
				$txt .= "\nAl no cumplir estrictamente con cada rubro, la Directora hará repetir los cuadros al Docente en 15 minutos.";
				//$pdf->Ln(2);
				//$pdf->writeHTMLCell(0, 0, '', '', 'Nota: LA ZONA ES DE 60 PUNTOS, LA EVALUACIÓN DE 40 PUNTOS, DANDO UN TOTAL DE 100 PUNTOS.', 0, 1, 0, true, 'L', true);
				$pdf->SetFont('times', '', 8, '', true);
				$pdf->MultiCell(8, 50.8, "A)\nB)\nC)\nD)\n\nE)\n\nF)\nG)\n ", 1, 'R', 0, 0, '', '', true, 0, false, true, 50, 'B');
				$pdf->MultiCell(80, 50.8, 'INSTRUCCIONES:'.$txt, 1, 'L', 0, 0, '', '', true, 0, false, true, 50, 'B');

				$pdf->SetFont('times', '', 9, '', true);
				$pdf->MultiCell(75, 10, 'Acreditación de las Estrategias de Aprendizaje', 1, 'C', 0, 1, '', '', true, 0, false, true, 10, 'M');
				//$pdf->writeHTMLCell(75, 10, '', '', 'Acreditación de las Estrategias de Aprendizaje', 1, 1, 0, true, 'C', true);
				$pdf->writeHTMLCell(15, 45.8, 98, '', 'I BLOQUE', 1, 0, 0, true, 'C', true);
				$pdf->writeHTMLCell(15, 45.8, 113, '', 'II BLOQUE', 1, 0, 0, true, 'C', true);
				$pdf->writeHTMLCell(15, 45.8, 128, '', 'III BLOQUE', 1, 0, 0, true, 'C', true);
				$pdf->writeHTMLCell(15, 45.8, 143, '', 'IV BLOQUE', 1, 0, 0, true, 'C', true);
				$pdf->writeHTMLCell(15, 45.8, 158, '', 'V BLOQUE', 1, 1, 0, true, 'C', true);

				$pdf->SetFont('times', 'B', 12, '', true);
				$pdf->StartTransform();

				$pdf->SetXY(173, 65.8);
				$pdf->Rotate(90);
				$pdf->MultiCell(55.8, 10, 'PROMEDIO', 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
				$pdf->SetXY(173, 75.8);
				$pdf->MultiCell(55.8, 10, 'APROBADO', 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
				$pdf->SetXY(173, 85.8);
				$pdf->MultiCell(55.8, 10, 'REPROBADO', 1, 'L', 0, 1, '', '', true, 0, false, true, 10, 'M');
				$pdf->StopTransform();


				//$pdf->SetY(120);

				$pdf->SetFont('times', '', 11, '', true);
				$pdf->SetY(60.8);
				//$pdf->writeHTMLCell(113, 42, '', '', 'OPcion', 'LRTB', 1, 0, true, 'L', true);
				$pdf->writeHTMLCell(8, 0, '', '', 'No', 1, 0, 0, true, 'C', true);
				$pdf->writeHTMLCell(80, 0, '', '', 'NOMBRE DE LOS ESTUDIANTES', 1, 1, 0, true, 'C', true);
			}

		}//fin del foreach



		if ($cont < 60) {

			for ($i=$cont; $i <= 60; $i++) {

				$pdf->writeHTMLCell(8, 0, '', '', $i, 1, 0, 0, true, 'C', true);
				$pdf->writeHTMLCell(80, 0, '', '', '', 1, 0, 0, true, 'L', true);
				$pdf->writeHTMLCell(15, 0, '', '', '', 1, 0, 0, true, 'C', true);
				$pdf->writeHTMLCell(15, 0, '', '', '', 1, 0, 0, true, 'C', true);
				$pdf->writeHTMLCell(15, 0, '', '', '', 1, 0, 0, true, 'C', true);
				$pdf->writeHTMLCell(15, 0, '', '', '', 1, 0, 0, true, 'C', true);
				$pdf->writeHTMLCell(15, 0, '', '', '', 1, 0, 0, true, 'C', true);
				$pdf->writeHTMLCell(10, 0, '', '', '', 1, 0, 0, true, 'C', true);
				$pdf->writeHTMLCell(10, 0, '', '', '', 1, 0, 0, true, 'C', true);
			    $pdf->writeHTMLCell(10, 0, '', '', '', 1, 1, 0, true, 'C', true);

				if ($i == 38) {
					$pdf->AddPage('P',array(355.6, 215.9));
					$pdf->SetY(15);
					$txt = "\nLas calificaciones aprobadas se escriben con tinta negra.";
					$txt .= "\nLas calificaciones reprobadas se escriben con tinta roja.";
					$txt .= "\nEl trazo de los números debe ser exacto";
					$txt .= "\nPor ninguna causa se autorizará el atraso de entrega de cuadros a la Directora, son únicas fechas y horas.";
					$txt .= "\nLlene correctamente el: Grado, nivel, bloque, fecha, área, carrera; sus nombres y apellidos.";
					$txt .= "\nFirme sus cuadros antes de entregarlos.";
					$txt .= "\nAl no cumplir estrictamente con cada rubro, la Directora hará repetir los cuadros al Docente en 15 minutos.";
					//$pdf->Ln(2);
					//$pdf->writeHTMLCell(0, 0, '', '', 'Nota: LA ZONA ES DE 60 PUNTOS, LA EVALUACIÓN DE 40 PUNTOS, DANDO UN TOTAL DE 100 PUNTOS.', 0, 1, 0, true, 'L', true);
					$pdf->SetFont('times', '', 8, '', true);
					$pdf->MultiCell(8, 50.8, "A)\nB)\nC)\nD)\n\nE)\n\nF)\nG)\n ", 1, 'R', 0, 0, '', '', true, 0, false, true, 50, 'B');
					$pdf->MultiCell(80, 50.8, 'INSTRUCCIONES:'.$txt, 1, 'L', 0, 0, '', '', true, 0, false, true, 50, 'B');

					$pdf->SetFont('times', '', 9, '', true);
					$pdf->MultiCell(75, 10, 'Acreditación de las Estrategias de Aprendizaje', 1, 'C', 0, 1, '', '', true, 0, false, true, 10, 'M');
					//$pdf->writeHTMLCell(75, 10, '', '', 'Acreditación de las Estrategias de Aprendizaje', 1, 1, 0, true, 'C', true);
					$pdf->writeHTMLCell(15, 45.8, 98, '', 'I BLOQUE', 1, 0, 0, true, 'C', true);
					$pdf->writeHTMLCell(15, 45.8, 113, '', 'II BLOQUE', 1, 0, 0, true, 'C', true);
					$pdf->writeHTMLCell(15, 45.8, 128, '', 'III BLOQUE', 1, 0, 0, true, 'C', true);
					$pdf->writeHTMLCell(15, 45.8, 143, '', 'IV BLOQUE', 1, 0, 0, true, 'C', true);
					$pdf->writeHTMLCell(15, 45.8, 158, '', 'V BLOQUE', 1, 1, 0, true, 'C', true);

					$pdf->SetFont('times', 'B', 12, '', true);
					$pdf->StartTransform();

					$pdf->SetXY(173, 70.8);
					$pdf->Rotate(90);
					$pdf->MultiCell(55.8, 10, 'PROMEDIO', 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
					$pdf->SetXY(173, 80.8);
					$pdf->MultiCell(55.8, 10, 'APROBADO', 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
					$pdf->SetXY(173, 90.8);
					$pdf->MultiCell(55.8, 10, 'REPROBADO', 1, 'L', 0, 1, '', '', true, 0, false, true, 10, 'M');
					$pdf->StopTransform();
					$pdf->SetY(65.8);
					$pdf->SetFont('times', '', 11, '', true);
					$pdf->writeHTMLCell(8, 0, '', '', 'No', 1, 0, 0, true, 'C', true);
					$pdf->writeHTMLCell(80, 0, '', '', 'NOMBRE DE LOS ESTUDIANTES', 1, 1, 0, true, 'C', true);
					$pdf->SetY(71);
				}
				if ($i >32) {
			$pdf->setPrintHeader(false);
		}

			}
		}
		//$html .= '</tbody>';
		//$html .= '</table>';




		//imprimimos el texto con writeHTMLCell()
	//	$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
		//-----------------------------------------------------------------------------

		$pdf->Ln(3);
		$pdf->SetFont('times', 'U', 12, '', true);
		$pdf->MultiCell(0, 0, "CALENDARIO PARA ENTREGA DE CUADROS DE CALIFICACIONES DE BLOQUE Y ANUAL\n A LA DIRECTORA DRA. EN EDUCACIÓN BETTY ARGUETA\n CICLO ACADEMICO ".date('Y'), 0, 'C', 0, 1, '', '', true, 0, false, true, 0, 'B');
		$pdf->SetFont('times', '', 10, '', true);
		$pdf->Ln(3);
		$html = '<table border="1">';
		$html .= '<tr>';
		$html .= '<td width="30">NO</td><td width="140">ÁREAS Y NIVELES</td> <td width="80">BLOQUE</td> <td width="150">FECHA DE ENTREGA</td><td width="180"><table border="1"><tr><td>HORA</td></tr><tr><td width="90">MATUTINA</td><td width="90">VESPERTINA</td></tr></table></td> <td><i>Recibe toda la Papelería</i></td>';
		$html .= '</tr>';
		$datos = 	$this->calendario->getCalendario();
		$b1 = $datos[0]['buno_complementario'];
		$b2 = $datos[0]['bdos_complementario'];
		$b3 = $datos[0]['btres_complementario'];
		$b4 = $datos[0]['bcuatro_complementario'];
		$b1p = $datos[0]['buno_primaria'];
		$b2p = $datos[0]['bdos_primaria'];
		$b3p = $datos[0]['btres_primaria'];
		$b4p = $datos[0]['bcuatro_primaria'];
		$b1c = $datos[0]['buno_bc'];
		$b2c = $datos[0]['bdos_bc'];
		$b3c = $datos[0]['btres_bc'];
		$b4c = $datos[0]['bcuatro_bc'];
		$html .= '<tr><td> <br> <br> <br>1</td> <td><b>Pre-Primaria y Primaria Áreas Complementarias:</b> Educación Física-Inglés Computación-K´iche a)Archivo de exámenes Cuadernos de Asistencia</td> <td><table border="1"><tr><td>I BLOQUE</td></tr> <tr><td>II BLOQUE</td></tr> <tr><td>III BLOQUE</td></tr> <tr><td>IV BLOQUE</td></tr> <tr><td><br> <br>V BLOQUE</td></tr></table></td> <td><table border="1"><tr><td>'.$b1.'</td></tr> <tr><td>'.$b2.'</td></tr> <tr><td>'.$b3.'</td></tr> <tr><td>'.$b4.'</td></tr> <tr><td>Al día siguiente después de evaluar</td></tr></table></td> <td><table border="1"><tr><td>9:00 AM</td> <td>14:00 Hrs.</td></tr> <tr><td>9:00 AM</td> <td>14:00 Hrs.</td></tr> <tr><td>9:00 AM</td> <td>14:00 Hrs.</td></tr> <tr><td>9:00 AM</td> <td>14:00 Hrs.</td></tr> <tr><td> <br> <br>9:00AM</td> <td>  <br> <br>14:00 Hrs.</td></tr></table></td> <td><table border="1"><tr><td>DIRECTORA</td></tr> <tr><td>DIRECTORA</td></tr> <tr><td>DIRECTORA</td></tr> <tr><td>DIRECTORA</td></tr> <tr><td> <br> <br>DIRECTORA</td></tr></table></td></tr>';
		$html .= '<tr><td> <br> <br> <br>2</td> <td><b>Pre-Primaria y Primaria:</b> a)Folder de archivo de Exámenes. <br> b)Tarjetas de Calificaciones <br> c)Cuadernos de Asistencia</td> <td><table border="1"><tr><td>I BLOQUE</td></tr> <tr><td>II BLOQUE</td></tr> <tr><td>III BLOQUE</td></tr> <tr><td>IV BLOQUE</td></tr> <tr><td><br> <br>V BLOQUE</td></tr></table></td> <td><table border="1"><tr><td>'.$b1p.'</td></tr> <tr><td>'.$b2p.'</td></tr> <tr><td>'.$b3p.'</td></tr> <tr><td>'.$b4.'</td></tr> <tr><td>Al día siguiente después de evaluar</td></tr></table></td> <td><table border="1"><tr><td>9:00 AM</td> <td>14:00 Hrs.</td></tr> <tr><td>9:00 AM</td> <td>14:00 Hrs.</td></tr> <tr><td>9:00 AM</td> <td>14:00 Hrs.</td></tr> <tr><td>9:00 AM</td> <td>14:00 Hrs.</td></tr> <tr><td> <br> <br>9:00AM</td> <td>  <br> <br>14:00 Hrs.</td></tr></table></td> <td><table border="1"><tr><td>DIRECTORA</td></tr> <tr><td>DIRECTORA</td></tr> <tr><td>DIRECTORA</td></tr> <tr><td>DIRECTORA</td></tr> <tr><td> <br> <br>DIRECTORA</td></tr></table></td></tr>';
		$html .= '<tr><td> <br> <br> <br>3</td> <td> <br><br><b>Básico y Diversificado:</b> a)Folder de archivo de Evaluación por área. <br> b)Cuadernos de asistencia</td> <td><table border="1"><tr><td>I BLOQUE</td></tr> <tr><td>II BLOQUE</td></tr> <tr><td>III BLOQUE</td></tr> <tr><td>IV BLOQUE</td></tr> <tr><td><br> <br>V BLOQUE</td></tr></table></td> <td><table border="1"><tr><td>'.$b1c.'</td></tr> <tr><td>'.$b2c.'</td></tr> <tr><td>'.$b3c.'</td></tr> <tr><td>'.$b4c.'</td></tr> <tr><td>Al día siguiente después de evaluar</td></tr></table></td> <td><table border="1"><tr><td>9:00 AM</td> <td>14:00 Hrs.</td></tr> <tr><td>9:00 AM</td> <td>14:00 Hrs.</td></tr> <tr><td>9:00 AM</td> <td>14:00 Hrs.</td></tr> <tr><td>9:00 AM</td> <td>14:00 Hrs.</td></tr> <tr><td> <br> <br>9:00AM</td> <td>  <br> <br>14:00 Hrs.</td></tr></table></td> <td><table border="1"><tr><td>DIRECTORA</td></tr> <tr><td>DIRECTORA</td></tr> <tr><td>DIRECTORA</td></tr> <tr><td>DIRECTORA</td></tr> <tr><td> <br> <br>DIRECTORA</td></tr></table></td></tr>';
		$html .= '</table>';
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'C', true);
		$pdf->SetFont('times', '', 12, '', true);
		$html = 'Observaciones:__________________________________________________________________________________________________________________________________________________________________________';
		$pdf->Ln(3);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'L', true);


		$pdf->persona = $docente;
		$pdf->setPrintFooter(true);
		//cerrar el documento pdf y preparamos la salida
		//este metodo tiene varias opciones, consulte la documentación para más información.
		if ($salida == 'v') {
			$nombre_archivo = utf8_decode("cuadro anual.pdf");
			$pdf->Output($nombre_archivo,'I');
		} else {
			$nombre_archivo = utf8_decode("cuadro anual.pdf");
			$pdf->Output($nombre_archivo,'D');
		}


	}

/*
metodo que muestra la opcion de generación de tarjetas para el nivel primario y preprimario
*/
	public function tarjetas()
	{
		$persona = $_SESSION['nombreautenticado'];
		$idpersona = $persona[0]['id'];
		//$idpersona = 3;
		$datos = $this->Docente_model->getTitular($idpersona);
		//echo count($datos);
		if (count($datos) == 0) {
			$data['permiso'] = false;
		} else {
			$data['permiso'] = true;
		}
		$data['bloque'] = $this->Bloque_model->getBloques();
		$data['titulo'] = 'Generar Tarjetas de Calificaciones PRE-PRIMARIA - PRIMARIA';
		$data['activo'] = 'Reportes';
		$this->load->view('plantilla/header', $data);
		$this->load->view('reportes/tprimaria', $data);
		$this->load->view('plantilla/footer');
	}

/*
	metodo para exportar las tarjetas del nivel pre-primnario y primario
*/
	public function exportar_tarjetas()
	{
		$this->form_validation->set_rules('bloque', 'Bloque', 'trim|required');

		$this->form_validation->set_message('required', 'El campo %s es obligatorio, por favor seleccione una opcion valida.');

		if ($this->form_validation->run() == FALSE) {
			$this->tarjetas();
		} else {
			$bloque = $this->input->post('bloque');
			$tipoarch = $this->input->post('tipo');
			$persona = $_SESSION['nombreautenticado'];
			$idpersona = $persona[0]['id'];
			//$idpersona = 3;
			$datos = $this->Docente_model->getTitular($idpersona);
			//echo count($datos);
			$this->exportar_tarjetas_pdf($datos, $bloque, $tipoarch);
		}
	}

	/*
		metodo para exportar a formato pdf las tarjetas del nivel primario y pre-primario
	*/

	public function exportar_tarjetas_pdf($datos, $bloque, $salida)
	{
		$this->load->library('Pdf');

		$pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Byron Castro');
		//$pdf->SetTitle('Tarjetas Nivel Pre-Primaria y Primaria');
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
		$pdf->SetMargins(5,40,5);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(10);
		//se pueden modificar en le archivo tcpdf_config.php de libraries/config
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		//relación utilizada para ajustar la conversion de los píxeles
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		//-----------------------------------------
		//Establecer el modo de fuente por defecto
		//$pdf->setFontSubsetting(TRUE);
		//establecer el tipo de letra
		//si tienes que imprimir carácteres ASCII estándar, puede utilizar las fuentes basicas como
		//Helvetica para reducir el tamaño del archivo
		$pdf->SetFont('times', '', 12, '', true);
		//añadir una página
		//este metodo tiene varias opciones, consultar la documentación para mas información
		$pdf->AddPage('P',array(355.6, 215.9));
		//fijar efecto de sombra en el texto
		//$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
		$pdf->SetFillColor(255, 255, 255);

		$persona = $_SESSION['nombreautenticado'];
		$pdf->persona = ucwords($persona[0]['nombre'].' '.$persona[0]['apellidos']);
		//aqui es donce debemos de recibir el contenido para el PDF
		$nivel = 0;
		$grado = 0;
		$ngrado = '';
		$nnivel = '';
		foreach ($datos as  $value) {
			$ngrado = $value['nombre_grado'];
			$nnivel = $value['nombre_nivel'];
			$nivel = $value['id_nivel'];
			$grado = $value['id_grado'];
		}
		$ciclo = date('Y').'-00-00';
		$fecha = date('Y-m-d');
		$estudiantes = $this->Estudiante_model->getNominaEstudiantes($nivel, $grado, $ciclo, $fecha);
		$nestudiante = '';
		foreach ($estudiantes as $key => $value) {
			$nestudiante = $value['apellidos_estudiante'].', '.$value['nombre_estudiante'];
			$idest = $value['id_estudiante'];
			$puntos = $this->Estudiante_model->buscar_puntuacion($idest, $bloque, $ciclo);
			$habitos = $this->Estudiante_model->buscar_punt_habitos($idest, $ciclo, $fecha);
			$this->agregar_cuerpo_tarjeta($pdf, $nnivel, $ngrado, $nivel, $persona, $nestudiante, $puntos, $bloque, $habitos);
				if ($key < count($estudiantes)-1) {
					$pdf->AddPage();
				}
			$pdf->SetFont('times', '', 12, '', true);
		}

		$nArchivo = '';
		if ($nnivel == 'pre-primaria') {
			$nArchivo = $ngrado;
		} else {
			$nArchivo = $ngrado.' '.$nnivel;
		}


		$pdf->SetTitle('Tarjetas '.$nArchivo);
		if ($salida == 'v') {
			$nombre_archivo = utf8_decode("Tarjetas ".$nArchivo.".pdf");
			$pdf->Output($nombre_archivo,'I');
		} else {
			$nombre_archivo = utf8_decode("Tarjetas ".$nArchivo.".pdf");
			$pdf->Output($nombre_archivo,'D');
		}


	}

	private function agregar_cuerpo_tarjeta($pdf, $nnivel, $ngrado, $nivel, $persona, $estudiante, $puntos, $bloque, $mhabitos)
	{
		$pdf->writeHTMLCell(120, 0, '', '', '<b>Estudiante:</b> '.ucwords($estudiante), 0, 0, 1, true, 'L', true);
		if ($nivel == 1) {
			$pdf->writeHTMLCell(75, 0, '', '', '<b>Grado:</b> '.ucfirst($ngrado), 0, 1, 1, true, 'L', true);
		}else{
			$pdf->writeHTMLCell(75, 0, '', '', '<b>Grado:</b> '.ucfirst($ngrado).' '.ucwords($nnivel), 0, 1, 1, true, 'L', true);
		}

		$pdf->writeHTMLCell(120, 0, '', '', '<b>Maestro(a) Guía:</b> '.ucwords($persona[0]['nombre'].' '.$persona[0]['apellidos']), 0, 0, 1, true, 'L', true);
		$pdf->writeHTMLCell(75, 0, '', '', '<b>Ciclo Academico:</b> <u>'.date('Y').'</u>', 0, 1, 1, true, 'L', true);
		if ($ngrado == 'párvulos') {
				$pdf->writeHTMLCell(195, 0, '', '', '<b>Referencia: Azul = 90 Amarillo = 70 A 89 Verde = 0 A 69</b>', 0, 1, 1, true, 'L', true);
		} else {
			$pdf->writeHTMLCell(195, 0, '', '', '', 0, 1, 1, true, 'L', true);
		}



		$html = '<table><tr><td><ul><li>De 60 a 100 Puntos <br> Se Aprueba el Área</li></ul></td></tr> <br> <tr><td><ul><li>De 0 a 59 Puntos <br> Se Reprueba el Área</li></ul></td></tr></table>';
		$pdf->Ln(1);
		$pdf->writeHTMLCell(90, 30, '', '', $html, 1, 0, 1, true, 'C', true);

		$html = '<table border="1" style="padding: 15 0 15 0"><tr ><td >I BLOQUE</td></tr> <tr><td>II BLOQUE</td></tr> <tr><td>III BLOQUE</td></tr> <tr><td>IV BLOQUE</td></tr> <tr><td>V BLOQUE</td></tr> <tr><td>PROMEDIO</td></tr> <tr><td>APROBADO</td></tr> <tr><td>REPROBADO</td></tr></table>';
		$pdf->StartTransform();
		$pdf->Rotate(90, 110.1, 72.3);
		$pdf->writeHTMLCell(31.5, 106, '', '', '<b>'.$html.'</b>', 0, 1, 0, true, 'L', true);

		$pdf->StopTransform();

		$this->transformar_ac($pdf, $nnivel, $ngrado);

		$b1 = $b2 = $b3 = $b4 = $b5 = $promedio = $puntualidad = $habitos = '';
		$pdf->SetXY(10.5, 86.5);
		//$pdf->writeHTMLCell(31.5, 106, '', '', '<b>'.count($puntos).'</b>', 0, 1, 0, true, 'L', true);
		$perdidos = false;
		foreach ($puntos as  $value) {
			$pdf->SetX(10.5);
			$pdf->writeHTMLCell(84.1, 5, '', '', ucwords($value['nombre_area']), 1, 0, 1, true, 'L', true);

			switch ($bloque) {
				case 1:
					$b1 = $value['total_bloque'];
					if ($b1 <60 ) {

						$perdidos = true;
					}
					if ($ngrado == 'párvulos') {
						if ($b1 >=90 && $b1<=100) {
								$b1 = '<span color="blue">XXX</span>';
						}elseif ($b1 >= 70 && $b1 <= 89) {
							$b1 = '<span color="yellow">XXX</span>';
							}else{
							$b1 = '<span color="green">XXX</span>';
						}
					}else{
						if ($b1 < 60) {
							$b1 = '<span color="red">'.$b1.'</span>';
						}
					}
					break;
				case 2:
					$b2 = $value['total_bloque'];
					if ($b2 < 60) {
						$perdidos = true;
					}
					if ($ngrado == 'párvulos') {
						if ($b2 >=90 && $b2<=100) {
								$b2 = '<span color="blue">XXX</span>';
						}elseif ($b2 >= 70 && $b2 <= 89) {
							$b2 = '<span color="yellow">XXX</span>';
							}else{
							$b2 = '<span color="green">XXX</span>';
						}
					}else {
						if ($b2 < 60) {
							$b2 = '<span color="red">'.$b2.'</span>';
						}
					}
					break;
				case 3:
					$b3 = $value['total_bloque'];
					if ($b3 < 60) {

						$perdidos = true;
					}
					if ($ngrado == 'párvulos') {
						if ($b3 >=90 && $b3<=100) {
								$b3 = '<span color="blue">XXX</span>';
						}elseif ($b3 >= 70 && $b3 <= 89) {
							$b3 = '<span color="yellow">XXX</span>';
							}else{
							$b3 = '<span color="green">XXX</span>';
						}
					}else {
						if ($b3 < 60) {
							$b3 = '<span color="red">'.$b3.'</span>';
						}
					}
					break;
				case 4:
					$b4 = $value['total_bloque'];
					if ($b4 < 60) {

						$perdidos = true;
					}
					if ($ngrado == 'párvulos') {
						if ($b4 >=90 && $b4<=100) {
								$b4 = '<span color="blue">XXX</span>';
						}elseif ($b4 >= 70 && $b4 <= 89) {
							$b4 = '<span color="yellow">XXX</span>';
							}else{
							$b4 = '<span color="blue">XXX</span>';
						}
					}else{
						if ($b4 < 60) {
							$b4 = '<span color="red">'.$b4.'</span>';
						}
					}
					break;
				case 5:
					$b5 = $value['total_bloque'];
					if ($b5 < 60) {

						$perdidos = true;
					}
					if ($ngrado == 'párvulos') {
						if ($b5 >=90 && $b5<=100) {
								$b5 = '<span color="blue">XXX</span>';
						}elseif ($b5 >= 70 && $b5 <= 89) {
							$b5 = '<span color="yellow">XXX</span>';
							}else{
							$b5 = '<span color="green">XXX</span>';
						}
					}else{
						if ($b5 < 60) {
							$b5 = '<span color="red">'.$b5.'</span>';
						}
					}
					break;
			}//fin del switch

			$pdf->writeHTMLCell(13.8, 5, '', '', $b1, 1, 0, 1, true, 'C', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', $b2, 1, 0, 1, true, 'C', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', $b3, 1, 0, 1, true, 'C', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', $b4, 1, 0, 1, true, 'C', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', $b5, 1, 0, 1, true, 'C', true);
			if ($bloque == 5) {
				if ($ngrado == 'párvulos') {
						if ($promedio >= 90 && $promedio <= 100) {
							$pdf->writeHTMLCell(13.8, 5, '', '', '<span color="blue">XXX</span>', 1, 0, 1, true, 'L', true);
						} elseif($promedio >= 70 && $promedio <= 89) {
							$pdf->writeHTMLCell(13.8, 5, '', '', '<span color="yellow">XXX</span>', 1, 0, 1, true, 'L', true);
						}else{
							$pdf->writeHTMLCell(13.8, 5, '', '', '<span color="green">XXX</span>', 1, 0, 1, true, 'L', true);
						}

				} else {
					$pdf->writeHTMLCell(13.8, 5, '', '', $promedio, 1, 0, 1, true, 'L', true);
				}
				if ($promedio >=60) {
					$pdf->writeHTMLCell(13.8, 5, '', '', '<span>X</span>', 1, 0, 1, true, 'L', true);
					$pdf->writeHTMLCell(13.8, 5, '', '', '', 1, 1, 1, true, 'L', true);
				}else {
					$pdf->writeHTMLCell(13.8, 5, '', '', '', 1, 0, 1, true, 'L', true);
					$pdf->writeHTMLCell(13.8, 5, '', '', '<span color="red">X</span>', 1, 1, 1, true, 'L', true);
				}

			} else {
				$pdf->writeHTMLCell(13.8, 5, '', '', '', 1, 0, 1, true, 'L', true);
				$pdf->writeHTMLCell(13.8, 5, '', '', '', 1, 0, 1, true, 'L', true);
				$pdf->writeHTMLCell(13.8, 5, '', '', '', 1, 1, 1, true, 'L', true);
			}


		}//fin del foreach
		$puntualidad = strtoupper($mhabitos[0]['punt_asist']);
			$pdf->SetX(10.5);
			switch ($bloque) {
				case 1:
					$b1 = $puntualidad;
					break;
				case 2:
					$b2 = $puntualidad;
					break;
				case 3:
					$b3 = $puntualidad;
					break;
				case 4:
					$b4 = $puntualidad;
					break;
				case 5:
					$b5 = $puntualidad;
					break;
			}
			$pdf->writeHTMLCell(84.1, 5, '', '', 'Puntualidad y Asistencia a Clases', 1, 0, 1, true, 'L', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', $b1, 1, 0, 1, true, 'C', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', $b2, 1, 0, 1, true, 'C', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', $b3, 1, 0, 1, true, 'C', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', $b4, 1, 0, 1, true, 'C', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', $b5, 1, 0, 1, true, 'C', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', '', 1, 0, 1, true, 'C', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', '', 1, 0, 1, true, 'C', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', '', 1, 1, 1, true, 'C', true);

			$pdf->SetX(10.5);
			$habitos = strtoupper($mhabitos[0]['habitos_orden']);
			switch ($bloque) {
				case 1:
					$b1 = $habitos;
					break;
				case 2:
					$b2 = $habitos;
					break;
				case 3:
					$b3 = $habitos;
					break;
				case 4:
					$b4 = $habitos;
					break;
				case 5:
					$b5 = $habitos;
					break;
			}
			$pdf->writeHTMLCell(84.1, 5, '', '', 'Hábitos de Orden y Limpieza', 1, 0, 1, true, 'L', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', $b1, 1, 0, 1, true, 'C', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', $b2, 1, 0, 1, true, 'C', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', $b3, 1, 0, 1, true, 'C', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', $b4, 1, 0, 1, true, 'C', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', $b5, 1, 0, 1, true, 'C', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', '', 1, 0, 1, true, 'C', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', '', 1, 0, 1, true, 'C', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', '', 1, 1, 1, true, 'C', true);

			$pdf->SetX(10.5);
			$pdf->writeHTMLCell(84.1, 5, '', '', 'Asistencia de Padres a Sesión', 1, 0, 1, true, 'L', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', '', 1, 0, 1, true, 'C', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', '', 1, 0, 1, true, 'C', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', '', 1, 0, 1, true, 'C', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', '', 1, 0, 1, true, 'C', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', '', 1, 0, 1, true, 'C', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', '', 1, 0, 1, true, 'C', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', '', 1, 0, 1, true, 'C', true);
			$pdf->writeHTMLCell(13.8, 5, '', '', '', 1, 1, 1, true, 'C', true);


		$pdf->SetFont('times', 'I', 8, '', true);
		$pdf->Ln(1);
		$pdf->SetX(20);
		$pdf->writeHTMLCell(0, 5, '', '', '<b>E:Excelente MB:Muy Bueno B:Bueno R:Regular A:Asistió NA:No Asistió</b>', 0, 1, 1, true, 'C', true);

//$pdf->setFormDefaultProp(array('lineWidth'=>1, 'borderStyle'=>'solid', 'fillColor'=>array(255, 255, 255), 'strokeColor'=>array(0, 0, 0)));




		$pdf->SetFont('times', '', 12, '', true);

		$observacion = '';
		if ($perdidos == true) {
				$observacion = 'Necesitas empeño y dedicación en la(s) área(s) perdida(s), Dios te Bendiga.';
		} else {
			$observacion = 'Felicidades por tu excelente rendimiento academico, Dios te Bendiga.';
		}

		switch ($bloque) {
			case 1:
			$pdf->writeHTMLCell(190, 5, '', '', 'I BLOQUE: '.$observacion, 0, 1, 1, true, 'L', true);
			$pdf->writeHTMLCell(190, 5, '', '', 'II BLOQUE:', 0, 1, 1, true, 'L', true);
			$pdf->writeHTMLCell(190, 5, '', '', 'III BLOQUE:', 0, 1, 1, true, 'L', true);
			$pdf->writeHTMLCell(190, 5, '', '', 'IV BLOQUE:', 0, 1, 1, true, 'L', true);
			$pdf->writeHTMLCell(190, 5, '', '', 'V BLOQUE:', 0, 1, 1, true, 'L', true);
			$pdf->writeHTMLCell(190, 5, '', '', 'RESULTADO FINAL:', 0, 1, 1, true, 'L', true);
				break;

			case 2:
			$pdf->writeHTMLCell(190, 5, '', '', 'I BLOQUE: ', 0, 1, 1, true, 'L', true);
			$pdf->writeHTMLCell(190, 5, '', '', 'II BLOQUE: '.$observacion, 0, 1, 1, true, 'L', true);
			$pdf->writeHTMLCell(190, 5, '', '', 'III BLOQUE:', 0, 1, 1, true, 'L', true);
			$pdf->writeHTMLCell(190, 5, '', '', 'IV BLOQUE:', 0, 1, 1, true, 'L', true);
			$pdf->writeHTMLCell(190, 5, '', '', 'V BLOQUE:', 0, 1, 1, true, 'L', true);
			$pdf->writeHTMLCell(190, 5, '', '', 'RESULTADO FINAL:', 0, 1, 1, true, 'L', true);
				break;

			case 3:
			$pdf->writeHTMLCell(190, 5, '', '', 'I BLOQUE: ', 0, 1, 1, true, 'L', true);
			$pdf->writeHTMLCell(190, 5, '', '', 'II BLOQUE: ', 0, 1, 1, true, 'L', true);
			$pdf->writeHTMLCell(100, 5, '', '', 'III BLOQUE: '.$observacion, 0, 1, 1, true, 'L', true);
			$pdf->writeHTMLCell(190, 5, '', '', 'IV BLOQUE:', 0, 1, 1, true, 'L', true);
			$pdf->writeHTMLCell(190, 5, '', '', 'V BLOQUE:', 0, 1, 1, true, 'L', true);
			$pdf->writeHTMLCell(190, 5, '', '', 'RESULTADO FINAL:', 0, 1, 1, true, 'L', true);
			break;

			case 4:
					# code...
			break;

			case 5:
						# code...
			break;
			default:
				# code...
				break;
		}




		$pdf->writeHTMLCell(190, 5, '', '', 'FIRMA DE LOS PADRES', 0, 1, 1, true, 'C', true);
		$pdf->writeHTMLCell(190, 5, '', '', 'RECOMENDACION: <i>Reflexionar padre e hijo sobre el rendimiento académico de cada bloque a efecto de facilitar o contribuir a superar la deficiencia. "Todo lo puedo en Cristo que me Fortalece Filipenses 4:13"</i>', 0, 1, 1, true, 'C', true);

		$pdf->Ln(2);
		$pdf->writeHTMLCell(68, 8, '', '', 'I Bloque <u>______________________</u>', 0, 0, 1, true, 'L', true);
		$pdf->writeHTMLCell(68, 8, '', '', 'II Bloque <u>______________________</u>', 0, 0, 1, true, 'L', true);
		$pdf->writeHTMLCell(68, 8, '', '', 'III Bloque <u>____________________</u>', 0, 1, 1, true, 'L', true);
		$pdf->writeHTMLCell(68, 8, '', '', 'IV Bloque <u>_____________________</u>', 0, 0, 1, true, 'L', true);
		$pdf->writeHTMLCell(68, 8, '', '', 'V Bloque <u>______________________</u>', 0, 0, 1, true, 'L', true);

		$pdf->SetFont('times', '', 8, '', true);
		$pdf->writeHTMLCell(68, 8, '', '', 'Nota: Su Asistencia a las sesiones <br> tendrá 5 puntos en determinadas asignaturas', 0, 1, 1, true, 'L', true);
		$pdf->Ln(3);
		$pdf->SetFont('times', '', 10, '', true);
		$this->agregar_pensum($pdf, $ngrado, $nnivel);

	}

	private function transformar_ac($aux, $nivel, $grado)
	{
		switch ($nivel) {
			case 'pre-primaria':
				$aux->SetXY(5, 141.5);

				$aux->StartTransform();
				$aux->Rotate(90);
				$aux->writeHTMLCell(55, 0, '', '', '<i>ÁREAS CURRICULARES</i>', 1, 0, 1, true, 'C', true);
				$aux->StopTransform();
				break;
			case 'primaria':
					if ($grado == 'primero' || $grado == 'segundo' || $grado == 'tercero') {
						$aux->SetXY(5, 152.4);

						$aux->StartTransform();
						$aux->Rotate(90);
						$aux->writeHTMLCell(65.9, 0, '', '', '<i>ÁREAS CURRICULARES</i>', 1, 0, 1, true, 'C', true);
						$aux->StopTransform();
					}
					if ($grado == 'cuarto' || $grado == 'quinto' || $grado == 'sexto') {
						$aux->SetXY(5, 168.9);

						$aux->StartTransform();
						$aux->Rotate(90);
						$aux->writeHTMLCell(82.4, 0, '', '', '<i>ÁREAS CURRICULARES</i>', 1, 0, 1, true, 'C', true);
						$aux->StopTransform();
					}
				break;
			default:
				# code...
				break;
		}

	}

	public function agregar_pensum($aux, $grado, $nivel)
	{
		switch ($nivel) {
			case 'pre-primaria':
					if ($grado == 'párvulos') {
						$html = '<table border="1" style="text-align: left">';
						$html .= '<tr>';
						$html .= '<th width="50" style="text-align: center">No</th> <th width="286" style="text-align: center">ÁREAS CURRICULARES ACTUALES</th>';
						$html .= '<th width="50" style="text-align: center">No</th> <th width="300" style="text-align: center">ANTERIOR PENSUM DE ESTUDIOS</th>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">1</td> <td>Comunicación y Lenguaje L-1</td>';
						$html .= '<td style="text-align: center">1</td> <td>Prelectura Prescritura Inicial</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">2</td> <td>Comunicación y Lenguaje L-2</td>';
						$html .= '<td style="text-align: center">2</td> <td>Inglés</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">3</td> <td>Destrezas de Aprendizaje</td>';
						$html .= '<td style="text-align: center">3</td> <td>Iniciación Matemática</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">4</td> <td>Medio Social y Natural</td>';
						$html .= '<td style="text-align: center">4</td> <td>Conocimiento del medio, Adaptación Social y Formación de Hábitos</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">5</td> <td>Expresión Artistica</td>';
						$html .= '<td style="text-align: center">5</td> <td>Arte, Manualidad y Canto</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">6</td> <td>Educación Física</td>';
						$html .= '<td style="text-align: center">6</td> <td>Juegos y Rondas</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">7</td> <td>Biblia</td>';
						$html .= '<td style="text-align: center">7</td> <td>Biblia</td>';
						$html .= '</tr>';
						$html .= '</table>';
					} else {
						$html = '<table border="1" style="text-align: left">';
						$html .= '<tr>';
						$html .= '<th width="50" style="text-align: center">No</th> <th width="286" style="text-align: center">ÁREAS CURRICULARES ACTUALES</th>';
						$html .= '<th width="50" style="text-align: center">No</th> <th width="300" style="text-align: center">ANTERIOR PENSUM DE ESTUDIOS</th>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">1</td> <td>Lenguaje y Comunicación L-1</td>';
						$html .= '<td style="text-align: center">1</td> <td>Prelectura Prescritura Inicial</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">2</td> <td>Lenguaje y Comunicación L-2</td>';
						$html .= '<td style="text-align: center">2</td> <td>Inglés</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">3</td> <td>Destrezas de Aprendizaje</td>';
						$html .= '<td style="text-align: center">3</td> <td>Iniciación Matemática</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">4</td> <td>Medio Social y Natural</td>';
						$html .= '<td style="text-align: center">4</td> <td>Estudios Sociales y Ciencias Naturales</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">5</td> <td>Expresión Artistica</td>';
						$html .= '<td style="text-align: center">5</td> <td>Formación Musical y Artes Plásticas</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">6</td> <td>Educación Física</td>';
						$html .= '<td style="text-align: center">6</td> <td>Educación Física</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">7</td> <td>Biblia</td>';
						$html .= '<td style="text-align: center">7</td> <td>Biblia</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">8</td> <td>Computación</td>';
						$html .= '<td style="text-align: center">8</td> <td>Computación</td>';
						$html .= '</tr>';
						$html .= '</table>';
					}

				break;
			case 'primaria':
					if ($grado == 'primero' || $grado == 'segundo' || $grado == 'tercero') {
						$html = '<table border="1" style="text-align: left">';
						$html .= '<tr>';
						$html .= '<th width="50" style="text-align: center">No</th> <th width="286" style="text-align: center">ÁREAS CURRICULARES ACTUALES</th>';
						$html .= '<th width="50" style="text-align: center">No</th> <th width="300" style="text-align: center">ANTERIOR PENSUM DE ESTUDIOS</th>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">1</td> <td>Comunicación y Lenguaje L-1</td>';
						$html .= '<td style="text-align: center">1</td> <td>Idioma Español</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">2</td> <td>Comunicación y Lenguaje L-2</td>';
						$html .= '<td style="text-align: center">2</td> <td>K´ich´e</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">3</td> <td>Comunicación y Lenguaje L-3</td>';
						$html .= '<td style="text-align: center">3</td> <td>Inglés</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">4</td> <td>Matemática</td>';
						$html .= '<td style="text-align: center">4</td> <td>Matemática</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">5</td> <td>Medio Social y Natural</td>';
						$html .= '<td style="text-align: center">5</td> <td>Ciencias Naturales, Estudios Sociales, Salud, Seguridad, Educación para el Hogar y Agricultura</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">6</td> <td>Expresión Artística</td>';
						$html .= '<td style="text-align: center">6</td> <td>Formación Musical y Artes Plásticas</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">7</td> <td>Educación Física</td>';
						$html .= '<td style="text-align: center">7</td> <td>Educación Física</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">8</td> <td>Formación Ciudadana</td>';
						$html .= '<td style="text-align: center">8</td> <td>Civismo</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">9</td> <td>Computación</td>';
						$html .= '<td style="text-align: center">9</td> <td>Computación</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">10</td> <td>Biblia</td>';
						$html .= '<td style="text-align: center">10</td> <td>Biblia</td>';
						$html .= '</tr>';
						$html .= '</table>';
					} else {
						$html = '<table border="1" style="text-align: left">';
						$html .= '<tr>';
						$html .= '<th width="50" style="text-align: center">No</th> <th width="286" style="text-align: center">ÁREAS CURRICULARES ACTUALES</th>';
						$html .= '<th width="50" style="text-align: center">No</th> <th width="300" style="text-align: center">ANTERIOR PENSUM DE ESTUDIOS</th>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">1</td> <td>Comunicación y Lenguaje L-1</td>';
						$html .= '<td style="text-align: center">1</td> <td>Idioma Español</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">2</td> <td>Comunicación y Lenguaje L-2</td>';
						$html .= '<td style="text-align: center">2</td> <td>K´ich´e</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">3</td> <td>Comunicación y Lenguaje L-3</td>';
						$html .= '<td style="text-align: center">3</td> <td>Inglés</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">4</td> <td>Matemática</td>';
						$html .= '<td style="text-align: center">4</td> <td>Matemática</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">5</td> <td>Ciencias Naturales y Tecnología</td>';
						$html .= '<td style="text-align: center">5</td> <td>Ciencias Naturales</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">6</td> <td>Ciencias Sociales</td>';
						$html .= '<td style="text-align: center">6</td> <td>Estudios Sociales</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">7</td> <td>Expresión Artística</td>';
						$html .= '<td style="text-align: center">7</td> <td>Música y Artes Plásticas</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">8</td> <td>Educación Física</td>';
						$html .= '<td style="text-align: center">8</td> <td>Educación Física</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">9</td> <td>Productividad y Desarrollo</td>';
						$html .= '<td style="text-align: center">9</td> <td>Agricultura y Hogar</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">10</td> <td>Formación Ciudadana</td>';
						$html .= '<td style="text-align: center">10</td> <td>Civismo</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">11</td> <td>Biblia</td>';
						$html .= '<td style="text-align: center">11</td> <td>Biblia</td>';
						$html .= '</tr>';
						$html .= '<tr>';
						$html .= '<td style="text-align: center">12</td> <td>Computación</td>';
						$html .= '<td style="text-align: center">12</td> <td>Computación</td>';
						$html .= '</tr>';
						$html .= '</table>';
					}

				break;

		}

		$aux->writeHTMLCell(0, 8, '', '', $html, 0, 0, 1, true, 'C', false);

	}
}

/* End of file Reportesdocentes.php */
/* Location: ./application/controllers/Reportesdocentes.php */
