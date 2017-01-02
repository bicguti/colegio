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
		$this->load->model('Grado_model', 'grados');
		$this->load->model('Nivel_model', 'niveles');
		$this->load->model('Carrera_model', 'carreras');
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
				//$totales = $this->Consolidados_model->notas_consolidadoC($bloque, $grado, $ciclo, $carrera);
				$estudiantes = $this->estudiantes->findEstudiantesDiversificado($nivel, $grado, $carrera, $ciclo);
				$nGuia = $this->docente->getNombresGuiaC($grado, $carrera);
				if (count($nGuia) == 0) {
					$aux = 'Ninguno';
				} else {
					$aux = $nGuia[0]['nombre_persona'].' '.$nGuia[0]['apellidos_persona'];//concatenamos los nombres y apellidos de la persona guía del grado
				}//fin del if else
				$nombreGrado = $this->grados->getNombreGrado($grado);//obtenemos el nombre del grado
				$nombreCarrera = $this->carreras->getNombreCarrera($carrera);//obtenemos el nombre de la carrera
				$Grado = $nombreGrado[0]['nombre_grado'].' '.$nombreCarrera[0]['nombre_carrera'];
				$this->exportar_pdf($estudiantes, $nivel, $aux, $ciclo, $bloque, $Grado);
			} else {
				if ($nivel == 5) {//para el nivel básico por madurez
					/*############### Básico madurez ####################*/
					//$totales = $this->puntos->getTotalBB($bloque, $ciclo, $grado, $nivel);
					$estudiantes = $this->estudiantes->findEstudiantesBasicoM($nivel, $grado, $ciclo);

					$nGuia = $this->docente->getNombresGuia($grado, $nivel);
					if (count($nGuia) == 0) {
						$aux = 'Ninguno';
					} else {
						$aux = $nGuia[0]['nombre_persona'].' '.$nGuia[0]['apellidos_persona'];
					}//fin del if else
					$nombreGrado = $this->grados->getNombreGrado($grado);
					$nombreNivel = $this->niveles->getNombreNivel($nivel);
					$Grado = $nombreGrado[0]['nombre_grado'].' '.$nombreNivel[0]['nombre_nivel'];
					$this->exportar_pdf($estudiantes, $nivel, $aux, $ciclo, $bloque, $Grado);

					/*############### Fin básico madurez ####################*/
				} else {//para el resto de niveles
					//$totales = $this->puntos->getTotalBB($bloque, $ciclo, $grado, $nivel);
					$estudiantes = $this->estudiantes->findEstudiantesBasico($nivel, $grado, $ciclo);
					$nGuia = $this->docente->getNombresGuia($grado, $nivel);
					if (count($nGuia) == 0) {
						$aux = 'Ninguno';
					} else {
						$aux = $nGuia[0]['nombre_persona'].' '.$nGuia[0]['apellidos_persona'];
					}//fin del if else
					$nombreGrado = $this->grados->getNombreGrado($grado);
					$nombreNivel = $this->niveles->getNombreNivel($nivel);
					$Grado = $nombreGrado[0]['nombre_grado'].' '.$nombreNivel[0]['nombre_nivel'];
					$this->exportar_pdf($estudiantes, $nivel, $aux, $ciclo, $bloque, $Grado);
				}//fin del if else
			}//fin del if else

		}//fin del if else
	}

	private function exportar_pdf($estudiantes, $nivel, $nGuia, $ciclo, $bloque, $Grado)
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
$puntosBloque = array();
$clave = 1;
$cantNomina = count($estudiantes);
if ($nivel == 4) {
		foreach ($estudiantes as $key => $estudiante) {//recoremos la nomina de los estudiantes
			//echo $estudiante['id_estudiante'].' '.$estudiante['nombre_estudiante'].' '.$estudiante['apellidos_estudiante'].' '.$estudiante['id_estudiante_carrera'].'<br />	';
			$temp = $this->estudiantes->buscar_puntuacionC($estudiante['id_estudiante_carrera'], $ciclo); // buscamos el total de bloque de todaslas áreas para el estudiante

			foreach ($temp as $key => $value) {//recorremos los datos obtenido de la consulta
				$aux = array('nombre_area' => $value['nombre_area'], 'total_bloque' => $value['total_bloque'], 'habitos_orden' => $value['habitos_orden'], 'punt_asist' => $value['punt_asist']);//obtenmos el nombre del área y el total de bloque de esa área
				array_push($puntosBloque, $aux);//lo agregamos a un array
			}//fin del foreach

			$puntos = $this->crearTabla_datos($puntosBloque);//enviamos los datos este metodo para que crea una tabla de valores
			$pdf->SetFont('freesans', '', 10, '', true);
			$this->cuerpo_tarjeta($pdf, $puntos, $estudiante['apellidos_estudiante'].', '.$estudiante['nombre_estudiante'], $nGuia, $clave, $Grado, $estudiante['codigo_personal_estudiante']);//escribimos el contenido del documento
			$clave++;
			$puntosBloque = array(); //limpiamos el array para obtener nuevos datos de otro estudiante
			if ($clave <= $cantNomina) {
				$pdf->AddPage();
			}


		}//fin del foreach para recorrer la nomina de los estudiantes
} else {
		if ($nivel == 5) {//para el nivel básico por madurez

			foreach ($estudiantes as $key => $estudiante) {
				//echo $estudiante['id_estudiante'].' '.$estudiante['nombre_estudiante'].' '.$estudiante['apellidos_estudiante'].'<br />	';
				$temp = $this->estudiantes->buscar_puntuacionM($estudiante['id_estudiante'], $bloque, $ciclo); // buscamos el total de bloque de todaslas áreas para el estudiante
			//$cantidadAreas = count($temp);//obtenemops el la cantidad de áreas
			foreach ($temp as $key => $value) {//recorremos los datos obtenido de la consulta
				$aux = array('nombre_area' => $value['nombre_area'], 'total_bloque' => $value['total_bloque'], 'habitos_orden' => $value['habitos_orden'], 'punt_asist' => $value['punt_asist']);//obtenmos el nombre del área y el total de bloque de esa área
				array_push($puntosBloque, $aux);//lo agregamos a un array
			}//fin del foreach

			$puntos = $this->crearTabla_datosMadurez($puntosBloque);//enviamos los datos este metodo para que crea una tabla de valores
			/*echo $estudiante['nombre_estudiante'].' '.$estudiante['apellidos_estudiante'].'<br />	';
			foreach ($puntos as $key => $value) {//recorremos los datos obtenidos del metodo
				echo $value['nombre_area'].' '.$value['b1'].' '.$value['b2'].' '.$value['b3'].' '.$value['b4'].' '.$value['b5'].'<br />	';
			}*/

			$pdf->SetFont('freesans', '', 10, '', true);
			$this->cuerpo_tarjeta($pdf, $puntos, $estudiante['apellidos_estudiante'].', '.$estudiante['nombre_estudiante'], $nGuia, $clave, $Grado, $estudiante['codigo_personal_estudiante']);//escribimos el contenido del documento
			$clave++;
			$puntosBloque = array(); //limpiamos el array para obtener nuevos datos de otro estudiante
			if ($clave <= $cantNomina) {
				$pdf->AddPage();
			}
				}//fin del foreach para recorrer a los estudiantes

		} else {//para el nivel básico plan diario

			foreach ($estudiantes as $key => $estudiante) {
				//echo $estudiante['id_estudiante'].' '.$estudiante['nombre_estudiante'].' '.$estudiante['apellidos_estudiante'].'<br />	';
				$temp = $this->estudiantes->buscar_puntuacion($estudiante['id_estudiante'], $bloque, $ciclo); // buscamos el total de bloque de todaslas áreas para el estudiante
			//$cantidadAreas = count($temp);//obtenemops el la cantidad de áreas
			foreach ($temp as $key => $value) {//recorremos los datos obtenido de la consulta
				$aux = array('nombre_area' => $value['nombre_area'], 'total_bloque' => $value['total_bloque'], 'habitos_orden' => $value['habitos_orden'], 'punt_asist' => $value['punt_asist']);//obtenmos el nombre del área y el total de bloque de esa área
				array_push($puntosBloque, $aux);//lo agregamos a un array
			}//fin del foreach

			$puntos = $this->crearTabla_datos($puntosBloque);//enviamos los datos este metodo para que crea una tabla de valores
			/*echo $estudiante['nombre_estudiante'].' '.$estudiante['apellidos_estudiante'].'<br />	';
			foreach ($puntos as $key => $value) {//recorremos los datos obtenidos del metodo
				echo $value['nombre_area'].' '.$value['b1'].' '.$value['b2'].' '.$value['b3'].' '.$value['b4'].' '.$value['b5'].'<br />	';
			}*/
			$pdf->SetFont('freesans', '', 10, '', true);
			$this->cuerpo_tarjeta($pdf, $puntos, $estudiante['apellidos_estudiante'].', '.$estudiante['nombre_estudiante'], $nGuia, $clave, $Grado, $estudiante['codigo_personal_estudiante']);//escribimos el contenido del documento
			$clave++;
			$puntosBloque = array(); //limpiamos el array para obtener nuevos datos de otro estudiante
			if ($clave <= $cantNomina) {
				$pdf->AddPage();
			}
				}//fin del foreach para recorrer a los estudiantes

		}//fin del if else
}//fin del if else


		//-----------------------------------------------------------------------------
		//cerrar el documento pdf y preparamos la salida
		//este metodo tiene varias opciones, consulte la documentación para más información.
		$nombre_archivo = utf8_decode("tarjetas de calificacion.pdf");
		$pdf->Output($nombre_archivo,'I');
	}//fin del metodo exportar_pdf

	private function crearTabla_datos($puntosBloque)//metodo que se encarga de crear una tabla para las puntuaciones del estudiante de los cinco bloques
	{
		$contador = 1;
		$tablaDatos =		array();
		$aux = '';
		$bloque = 0;
		$hab = array();
		$punt =		array();
		foreach ($puntosBloque as $key => $value) {
			if ($bloque < 5) {
				$hab[$bloque] = $value['habitos_orden'];
				$punt[$bloque] = $value['punt_asist'];
			}
			if ($contador == 5) {
				//echo ' Bloque: '.$contador.' '.$value['total_bloque'].'<br />	';
				$aux .= $value['total_bloque'];//string concatenado separado poc comas
				//echo $aux.'<br />';
				$array = explode(',', $aux);//convertimos en array el estring indecandole al metodp que veifique las comas
				//echo 'nombre_area'.' '.$array[0].' '.'b1'.' '.$array[1].' '.'b2'.' '.$array[2].' '.'b3'.' '.$array[3].' '.'b4'.' '.$array[4].' '.'b5'.' '.$array[5].'<br />';
				$temp = array('nombre_area' => $array[0], 'b1' => $array[1], 'b2' => $array[2], 'b3' => $array[3], 'b4' => $array[4], 'b5' => $array[5], 'hab1' => $hab[0], 'hab2' => $hab[1], 'hab3' => $hab[2], 'hab4' => $hab[3], 'hab5' => $hab[4], 'punt1' => $punt[0], 'punt2' => $punt[1], 'punt3' => $punt[2], 'punt4' => $punt[3], 'punt5' => $punt[4] );//creamos un array
				array_push($tablaDatos, $temp);//lo agregamos al attay de tabla datos
				$contador = 0;//reiniciamos el contador a  0
			} else {
				if ($contador ==	1) {
					//echo $value['nombre_area'].' Bloque: '.$contador.' '.$value['total_bloque'];
					$aux = $value['nombre_area'].','.$value['total_bloque'].',';//creamos un string y cada dato los separamos por comas
				}else {
					//echo ' Bloque: '.$contador.' '.$value['total_bloque'];
					$aux .= $value['total_bloque'].',';//concatenamos los demas datos para que se cree un string separado por comas

				}//fin del if else
			}//fin del if else
			$contador++;
			$bloque++;
		}//fin del foreach
		return $tablaDatos;//retornamos los datos ya convertidos en tabla
	}


	private function crearTabla_datosMadurez($puntosBloque)//metodo que se encarga de crear una tabla para las puntuaciones del estudiante de los cinco bloques
	{
		$contador = 1;
		$tablaDatos =		array();
		$aux = '';
		$bloque = 0;
		$hab = array();
		$punt =		array();
		foreach ($puntosBloque as $key => $value) {
			if ($bloque < 4) {
				$hab[$bloque] = $value['habitos_orden'];
				$punt[$bloque] = $value['punt_asist'];
			}
			if ($contador == 4) {
				//echo ' Bloque: '.$contador.' '.$value['total_bloque'].'<br />	';
				$aux .= $value['total_bloque'];//string concatenado separado poc comas
				$array = explode(',', $aux);//convertimos en array el estring indecandole al metodp que veifique las comas
				$array[4] = '';
				$hab[4] = '';
				$punt[4] = '';
				//echo $array[0].'<br />';
				if (isset($array[5])) {
					$temp = array('nombre_area' => $array[0], 'b1' => $array[1], 'b2' => $array[2], 'b3' => $array[3], 'b4' => $array[4], 'b5' => $array[5], 'hab1' => $hab[0], 'hab2' => $hab[1], 'hab3' => $hab[2], 'hab4' => $hab[3], 'hab5' => $hab[4], 'punt1' => $punt[0], 'punt2' => $punt[1], 'punt3' => $punt[2], 'punt4' => $punt[3], 'punt5' => $punt[4] );//creamos un array
				} else {
					$temp = array('nombre_area' => $array[0], 'b1' => $array[1], 'b2' => $array[2], 'b3' => $array[3], 'b4' => $array[4], 'b5' => '', 'hab1' => $hab[0], 'hab2' => $hab[1], 'hab3' => $hab[2], 'hab4' => $hab[3], 'hab5' => $hab[4], 'punt1' => $punt[0], 'punt2' => $punt[1], 'punt3' => $punt[2], 'punt4' => $punt[3], 'punt5' => $punt[4] );//creamos un array
				}


				array_push($tablaDatos, $temp);//lo agregamos al attay de tabla datos
				$contador = 0;//reiniciamos el contador a  0
			} else {
				if ($contador ==	1) {
					//echo $value['nombre_area'].' Bloque: '.$contador.' '.$value['total_bloque'];
					$aux = $value['nombre_area'].','.$value['total_bloque'].',';//creamos un string y cada dato los separamos por comas
				}else {
					//echo ' Bloque: '.$contador.' '.$value['total_bloque'];
					$aux .= $value['total_bloque'].',';//concatenamos los demas datos para que se cree un string separado por comas

				}//fin del if else
			}//fin del if else
			$contador++;
			$bloque++;
		}//fin del foreach
		return $tablaDatos;//retornamos los datos ya convertidos en tabla
	}



	private function cuerpo_tarjeta($pdf, $puntos, $nEstudiante, $nGuia, $clave, $Grado, $codigo)
	{
		//aqui es donce debemos de recibir el contenido para el PDF
		$pdf->MultiCell(103, 0, 'Estudiante: '.ucwords($nEstudiante), 0, 'L', 0, 0, '', '', true, 0, false, false, 0);

	$pdf->MultiCell(53, 0, 'Clave: '.$clave, 0, 'R', 0, 1, '', '', true, 0, false, true, 40);
	$pdf->MultiCell(103, 0, 'Código Personal: '.$codigo, 0, 'L', 0, 1, '', '', true, 0, false, true, 40);

	$pdf->MultiCell(143, 0, 'Grado: '.ucwords($Grado), 0, 'L', 0, 0, '', '', true, 0, false, true, 40);
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
	foreach ($puntos as $key => $value) {
		//$pdf->MultiCell(39.6, 10, $value['nombre'], 1, 'L', 1, 1, '', '', true, 0, false, true, 10, 'M');
		$pdf->Cell(39.6, 10, ucwords($value['nombre_area']), 1, 1, 'C', 1, '', 1);
		//$pdf->SetXY(5, $y);
		//$y = $y + 10;
	}

$pdf->Cell(39.6, 10, 'Puntualidad y Asistencia', 1, 1, 'C', 1, '', 1);
$pdf->Cell(39.6, 10, 'Hábitos de Limpieza', 1, 1, 'C', 1, '', 1);
	$pdf->StopTransform();
	$pdf->Ln(1);

	$pdf->setY(-81);
	$pdf->writeHTMLCell(17.8, 5, '', '', 'Bloque I', 1, 0, 1, true, 'C', true);
	for ($i=0; $i < count($puntos); $i++) {
		if ($puntos[$i]['b1'] < 60) {
			$pdf->writeHTMLCell(10, 5, '', '', '<span color="red">'.$puntos[$i]['b1'].'</span>', 1, 0, 1, true, 'C', true);
		} else {
			$pdf->writeHTMLCell(10, 5, '', '', $puntos[$i]['b1'], 1, 0, 1, true, 'C', true);
		}//fin del if else
		$habitos = $puntos[$i]['hab1'];
		$puntualidad = $puntos[$i]['punt1'];
	}//fin del for

	$pdf->writeHTMLCell(10, 5, '', '', mb_strtoupper($puntualidad), 1, 0, 1, true, 'C', true);
	$pdf->writeHTMLCell(10, 5, '', '', mb_strtoupper($habitos), 1, 0, 1, true, 'C', true);
	$pdf->Ln(5);

	$pdf->writeHTMLCell(17.8, 5, '', '', 'Bloque II', 1, 0, 1, true, 'C', true);
	for ($i=0; $i < count($puntos); $i++) {
		if ($puntos[$i]['b2'] < 60) {
			$pdf->writeHTMLCell(10, 5, '', '', '<span color="red">'.$puntos[$i]['b2'].'</span>', 1, 0, 1, true, 'C', true);
		} else {
			$pdf->writeHTMLCell(10, 5, '', '', $puntos[$i]['b2'], 1, 0, 1, true, 'C', true);
		}//fin del if else
		$habitos = $puntos[$i]['hab2'];
		$puntualidad = $puntos[$i]['punt2'];
	}//fin del for
	$pdf->writeHTMLCell(10, 5, '', '', mb_strtoupper($puntualidad), 1, 0, 1, true, 'C', true);
	$pdf->writeHTMLCell(10, 5, '', '', mb_strtoupper($habitos), 1, 0, 1, true, 'C', true);
	$pdf->Ln(5);

	$pdf->writeHTMLCell(17.8, 5, '', '', 'Bloque III', 1, 0, 1, true, 'C', true);
	for ($i=0; $i < count($puntos); $i++) {
		if ($puntos[$i]['b3'] < 60) {
			$pdf->writeHTMLCell(10, 5, '', '', '<span color="red">'.$puntos[$i]['b3'].'</span>', 1, 0, 1, true, 'C', true);
		} else {
			$pdf->writeHTMLCell(10, 5, '', '', $puntos[$i]['b3'], 1, 0, 1, true, 'C', true);
		}//fin del if else
		$habitos = $puntos[$i]['hab3'];
		$puntualidad = $puntos[$i]['punt3'];
	}//fin del for
	$pdf->writeHTMLCell(10, 5, '', '', mb_strtoupper($puntualidad), 1, 0, 1, true, 'C', true);
	$pdf->writeHTMLCell(10, 5, '', '', mb_strtoupper($habitos), 1, 0, 1, true, 'C', true);
	$pdf->Ln(5);

	$pdf->writeHTMLCell(17.8, 5, '', '', 'Bloque IV', 1, 0, 1, true, 'C', true);
	for ($i=0; $i < count($puntos); $i++) {
		if ($puntos[$i]['b4'] < 60) {
			$pdf->writeHTMLCell(10, 5, '', '', '<span color="red">'.$puntos[$i]['b4'].'</span>', 1, 0, 1, true, 'C', true);
		} else {
			$pdf->writeHTMLCell(10, 5, '', '', $puntos[$i]['b4'], 1, 0, 1, true, 'C', true);
		}//fin del if else
		$habitos = $puntos[$i]['hab4'];
		$puntualidad = $puntos[$i]['punt4'];
	}//fin del for
	$pdf->writeHTMLCell(10, 5, '', '', mb_strtoupper($puntualidad), 1, 0, 1, true, 'C', true);
	$pdf->writeHTMLCell(10, 5, '', '', mb_strtoupper($habitos), 1, 0, 1, true, 'C', true);
	$pdf->Ln(5);

	$pdf->writeHTMLCell(17.8, 5, '', '', 'Bloque V', 1, 0, 1, true, 'C', true);
	for ($i=0; $i < count($puntos); $i++) {
		if ($puntos[$i]['b5'] < 60) {
			$pdf->writeHTMLCell(10, 5, '', '', '<span color="red">'.$puntos[$i]['b5'].'</span>', 1, 0, 1, true, 'C', true);
		} else {
			$pdf->writeHTMLCell(10, 5, '', '', $puntos[$i]['b5'], 1, 0, 1, true, 'C', true);
		}//fin del if else
		$habitos = $puntos[$i]['hab5'];
		$puntualidad = $puntos[$i]['punt5'];
	}//fin del for
	$pdf->writeHTMLCell(10, 5, '', '', mb_strtoupper($puntualidad), 1, 0, 1, true, 'C', true);
	$pdf->writeHTMLCell(10, 5, '', '', mb_strtoupper($habitos), 1, 0, 1, true, 'C', true);
	$pdf->Ln(5);

	$pdf->writeHTMLCell(17.8, 5, '', '', 'Promedio', 1, 0, 1, true, 'C', true);
	for ($i=0; $i < count($puntos); $i++) {
			$pdf->writeHTMLCell(10, 5, '', '', '', 1, 0, 1, true, 'C', true);
	}
	$pdf->writeHTMLCell(10, 5, '', '', '', 1, 0, 1, true, 'C', true);
	$pdf->writeHTMLCell(10, 5, '', '', '', 1, 0, 1, true, 'C', true);
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

	//metodo para crear las tarjetas finales
	public function finales()
	{
		$data['niveles'] = $this->Nivel_model->getNivel();
		$data['activo'] = 'reportes';
		$data['titulo'] = 'Tarjetas de Calificaciones Finales';
		$this->load->view('plantilla/header', $data);
		$this->load->view('reportes/finales', $data);
		$this->load->view('plantilla/footer');
	}

	//metodo para obtener los datos del nivel indicado y crear un archivo con los datos en formato PDF
	public function exportar_finales()
	{
		$this->form_validation->set_rules('nivel', 'Nivel', 'trim|required');
		$this->form_validation->set_rules('grado', 'Grado', 'trim|required');

		$this->form_validation->set_message('required', 'El campo %s es requerido, elija un opcion valida.');

		if ($this->form_validation->run() == FALSE) {
			$this->finales();
		} else {
			$nivel = $this->input->post('nivel');
			$grado = $this->input->post('grado');
				if ($nivel == 4) {
					$carrera = $this->input->post('carrera');
					$estudiantes = $this->Consolidados_model->getNominaEstudiantesC($grado, $carrera);
					$nGrado = $this->Consolidados_model->getGrado($grado);
					$nNivel = $this->Consolidados_model->getNivel($nivel);
					$nCarrera = $this->Consolidados_model->getCarrera($carrera);
					$this->exportar_finales_pdf($estudiantes, $nGrado, $nNivel, $nCarrera, $nivel, $grado, $carrera);
				} else {
					if ($nivel ==5) {
						$estudiantes = $this->Consolidados_model->getNominaEstudiantes($nivel, $grado);
						$nGrado = $this->Consolidados_model->getGrado($grado);
						$nNivel = $this->Consolidados_model->getNivel($nivel);
						$nCarrera = '';
						$carrera = 0;
						$this->exportar_finales_pdf($estudiantes, $nGrado, $nNivel, $nCarrera, $nivel, $grado, $carrera);
					} else {
						$estudiantes = $this->Consolidados_model->getNominaEstudiantes($nivel, $grado);
						$nGrado = $this->Consolidados_model->getGrado($grado);
						$nNivel = $this->Consolidados_model->getNivel($nivel);
						$nCarrera = '';
						$carrera = 0;
						$this->exportar_finales_pdf($estudiantes, $nGrado, $nNivel, $nCarrera, $nivel, $grado, $carrera);
					}//fin del if else

				}//fin del if else

		}//fin del if else
	}//fin del metodo exportar_finales

	//metodo para exporta los datos a un archivo pdf de las notas finales
	public function exportar_finales_pdf($estudiantes, $nGrado, $nNivel, $nCarrera, $nivel, $grado, $carrera)
	{
		$this->load->library('Pdfe');
		$pdf = new Pdfe(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Colegio Pestalozzi');
		$pdf->SetTitle('Tarjetas Finales');
		$pdf->SetSubject('Tarjetas');
		$pdf->SetKeywords('Tarjetas, PDF, Finales, Anual, Colegio');
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
		$pdf->AddPage('P',array(355.6, 215.9));

		//obtner los cursos del grado
		//lista de cursos que el  grado lleva asignado
		if ($nivel == 4) {
			$cursos = $this->Consolidados_model->getCursosGradoC($grado, $carrera);
		} else {
			if ($nivel ==5) {
				$cursos = $this->Consolidados_model->getCursosGrado($nivel, $grado);
			} else {
				$cursos = $this->Consolidados_model->getCursosGrado($nivel, $grado);
			}//fin del if else
		}//fin del if else
		//fin

		$tabla = array();
		$promedio = 0;
		$total = 0;
		$notas = array();
		$areas = '';
		switch ($nivel) {
			case 4:
						foreach ($estudiantes as $key => $estudiante) {
							foreach ($cursos as $key => $curso) {
								for ($i=1; $i <= 5 ; $i++) {
									$temp = $this->Consolidados_model->getNotasBloquesC($estudiante->id_estudiante, $i, $curso->id_asignacion_area);
									$total = $total + $temp[0]->total_bloque;
								}//fin del for
								$promedio = $total/5;
								$aux = array('curso'=>$curso->nombre_area, 'promedio'=>round($promedio, 1));
								array_push($notas, $aux);
								$total = 0;
								$promedio = 0;
								$areas .= $curso->nombre_area.',';
							}//fin del foreach de cursos
							//estructuramos los datos para el estudiante
							$aux2 = '';
							foreach ($notas as $key => $row) {
								$aux2 .= $row['promedio'];
								if (count($notas) != $key) {
									$aux2 .= ',';
								}//fin del if
							}//fin del foreach
							$tamaño = strlen($aux2);
							$aux2[$tamaño-1] = '';
							$tamaño = strlen($areas);
							$areas[$tamaño-1] = '';
							$temp = array('codigo_personal_estudiante'=>$estudiante->codigo_personal_estudiante, 'estudiante'=>$estudiante->apellidos_estudiante.', '.$estudiante->nombre_estudiante, 'promedio'=>$aux2, 'cursos'=>$areas);
							array_push($tabla, $temp);
							$aux2 = '';
							$notas = array();
							$areas = '';
						}//fin del foreach de estudiantes
				break;
			case 5:
						foreach ($estudiantes as $key => $estudiante) {
							foreach ($cursos as $key => $curso) {
								for ($i=1; $i <= 4 ; $i++) {
									//echo $curso->id_asignacion_area.'<br />';
									$temp = $this->Consolidados_model->getNotasBloquesM($estudiante->id_estudiante, $i, $curso->id_asignacion_area);
									$total = $total + $temp[0]->total_bloque;
								}//fin del for
								$promedio = $total/4;
								$aux = array('curso'=>$curso->nombre_area, 'promedio'=>round($promedio, 1));
								array_push($notas, $aux);
								$total = 0;
								$promedio = 0;
								$areas .= $curso->nombre_area.',';
							}//fin del foreach de cursos
							//estructuramos los datos para el estudiante
							//estructuramos los datos para el estudiante
							$aux2 = '';
							foreach ($notas as $key => $row) {
								$aux2 .= $row['promedio'];
								if (count($notas) != $key) {
									$aux2 .= ',';
								}//fin del if
							}//fin del foreach
							$tamaño = strlen($aux2);
							$aux2[$tamaño-1] = '';
							$tamaño = strlen($areas);
							$areas[$tamaño-1] = '';
							$temp = array('codigo_personal_estudiante'=>$estudiante->codigo_personal_estudiante, 'estudiante'=>$estudiante->apellidos_estudiante.', '.$estudiante->nombre_estudiante, 'promedio'=>$aux2, 'cursos'=>$areas);
							array_push($tabla, $temp);
							$aux2 = '';
							$notas = array();
							$areas = '';
						}//fin del foreach de estudiantes
				break;

			default:
							foreach ($estudiantes as $key => $estudiante) {
								foreach ($cursos as $key => $curso) {
									for ($i=1; $i <= 5 ; $i++) {
										$temp = $this->Consolidados_model->getNotasBloques($estudiante->id_estudiante, $i, $curso->id_asignacion_area);
										$total = $total + $temp[0]->total_bloque;
									}//fin del for
									$promedio = $total/5;
									$aux = array('curso'=>$curso->nombre_area, 'promedio'=>round($promedio, 1));
									array_push($notas, $aux);
									$total = 0;
									$promedio = 0;
									$areas .= $curso->nombre_area.',';
								}//fin del foreach de cursos
								//estructuramos los datos para el estudiante
								$aux2 = '';
								foreach ($notas as $key => $row) {
									$aux2 .= $row['promedio'];
									if (count($notas) != $key) {
										$aux2 .= ',';
									}//fin del if
								}//fin del foreach
								$tamaño = strlen($aux2);
								$aux2[$tamaño-1] = '';
								$tamaño = strlen($areas);
								$areas[$tamaño-1] = '';
								$temp = array('codigo_personal_estudiante'=>$estudiante->codigo_personal_estudiante, 'estudiante'=>$estudiante->apellidos_estudiante.', '.$estudiante->nombre_estudiante, 'promedio'=>$aux2, 'cursos'=>$areas);
								array_push($tabla, $temp);
								$aux2 = '';
								$notas = array();
								$areas = '';
							}//fin del foreach de estudiantes
				break;
		}//fin del switch


	  	foreach ($tabla as $key => $row) {
				$this->cuerpo_final($row['estudiante'], $row['cursos'], $row['promedio'], $nGrado, $nNivel, $nCarrera, $nivel, $pdf);
			}//fin del foreach

			$nombre_archivo = utf8_decode("Tarjetas Finales.pdf");
			$pdf->Output($nombre_archivo,'I');
	}//fin del metodo

	//crea el cuerpo de la tarjeta con los datos del estudiante
	public function cuerpo_final($estudiante, $cursos, $promedio, $nGrado, $nNivel, $nCarrera, $nivel, $pdf)
	{
		$cArray = explode(',', $cursos);
		$pArray = explode(',', $promedio);
		//echo ucwords($estudiante).'<br />';
		$pdf->MultiCell(0, 10, '<b>Nombre del Estudiante:</b> '.ucwords($estudiante), 0, 'L', 0, 1, '', '', true, 0, true, true, 40);
		if ($nivel == 4) {
			$pdf->MultiCell(0, 10, '<b>Grado:</b> '.ucwords($nGrado[0]->nombre_grado.' '.$nCarrera[0]->nombre_carrera), 0, 'L', 0, 1, '', '', true, 0, true, true, 40);
		} else {
			$pdf->MultiCell(0, 10, '<b>Grado:</b> '.ucwords($nGrado[0]->nombre_grado.' '.$nNivel[0]->nombre_nivel), 0, 'L', 0, 1, '', '', true, 0, true, true, 40);
		}

		//$pdf->MultiCell(153, 10, '1', 0, 'J', 0, 1, '', '', true, 0, false, true, 40);
		$pdf->MultiCell(25, 5, '<b>No.</b>', 1, 'C', 0, 0, '', '', true, 0, true, true, 0);
		$pdf->MultiCell(100, 5, '<b>Asignaturas</b>', 1, 'C', 0, 0, '', '', true, 0, true, true, 0);
		$pdf->MultiCell(50, 5, '<b>Nota Final</b>', 1, 'C', 0, 1, '', '', true, 0, true, true, 0);
		for ($i=0; $i < count($cArray) ; $i++) {
			//echo mb_strtoupper($cArray[$i]).' '.$pArray[$i].'<br />';
			$pdf->MultiCell(25, 5, ($i+1), 1, 'C', 0, 0, '', '', true, 0, true, true, 0);
			$pdf->MultiCell(100, 5, ucwords($cArray[$i]), 1, 'L', 0, 0, '', '', true, 0, true, true, 0);
			if ($pArray[$i] < 60 && $pArray[$i] > 1) {
				$pdf->MultiCell(50, 5, '<span color="red">'.$pArray[$i].'</span>', 1, 'C', 0, 1, '', '', true, 0, true, true, 0);
			} else {
				if ($pArray[$i] == 0) {
					$pdf->MultiCell(50, 5, 'NC', 1, 'C', 0, 1, '', '', true, 0, true, true, 0);
				} else {
					$pdf->MultiCell(50, 5, $pArray[$i], 1, 'C', 0, 1, '', '', true, 0, true, true, 0);
				}

			}
		}
		//linea divisoria
		$pdf->Ln(5);
		$pdf->MultiCell(0, 5, '_______________________________________________________________________________________________________', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);
		$pdf->Ln(5);


		//repetir los datos nuevamente
		$pdf->MultiCell(0, 10, '<b>Nombre del Estudiante:</b> '.ucwords($estudiante), 0, 'L', 0, 1, '', '', true, 0, true, true, 40);
		if ($nivel == 4) {
			$pdf->MultiCell(0, 10, '<b>Grado:</b> '.ucwords($nGrado[0]->nombre_grado.' '.$nCarrera[0]->nombre_carrera), 0, 'L', 0, 1, '', '', true, 0, true, true, 40);
		} else {
			$pdf->MultiCell(0, 10, '<b>Grado:</b> '.ucwords($nGrado[0]->nombre_grado.' '.$nNivel[0]->nombre_nivel), 0, 'L', 0, 1, '', '', true, 0, true, true, 40);
		}

		//$pdf->MultiCell(153, 10, '1', 0, 'J', 0, 1, '', '', true, 0, false, true, 40);
		$pdf->MultiCell(25, 5, '<b>No.</b>', 1, 'C', 0, 0, '', '', true, 0, true, true, 0);
		$pdf->MultiCell(100, 5, '<b>Asignaturas</b>', 1, 'C', 0, 0, '', '', true, 0, true, true, 0);
		$pdf->MultiCell(50, 5, '<b>Nota Final</b>', 1, 'C', 0, 1, '', '', true, 0, true, true, 0);
		for ($i=0; $i < count($cArray) ; $i++) {
			//echo mb_strtoupper($cArray[$i]).' '.$pArray[$i].'<br />';
			$pdf->MultiCell(25, 5, ($i+1), 1, 'C', 0, 0, '', '', true, 0, true, true, 0);
			$pdf->MultiCell(100, 5, ucwords($cArray[$i]), 1, 'L', 0, 0, '', '', true, 0, true, true, 0);
				if ($pArray[$i] < 60 && $pArray[$i] > 1) {
					$pdf->MultiCell(50, 5, '<span color="red">'.$pArray[$i].'</span>', 1, 'C', 0, 1, '', '', true, 0, true, true, 0);
				} else {
					if ($pArray[$i] == 0) {
						$pdf->MultiCell(50, 5, 'NC', 1, 'C', 0, 1, '', '', true, 0, true, true, 0);
					} else {
						$pdf->MultiCell(50, 5, $pArray[$i], 1, 'C', 0, 1, '', '', true, 0, true, true, 0);
					}

				}
		}
		$pdf->Ln(5);
		//area para los datos del tutor del estudiante
		$pdf->MultiCell(0, 10, 'Favor: Llene y Firme ', 0, 'L', 0, 1, '', '', true, 0, true, true, 40);
		$pdf->MultiCell(0, 10, 'Yo ___________________________________________________________________________, que me identifico con Cédula', 0, 'L', 0, 1, '', '', true, 0, true, true, 40);
		$pdf->MultiCell(0, 10, 'de Vecindad ó DPI ______________________________, con teléfono (s) ___________________________________, estoy', 0, 'L', 0, 1, '', '', true, 0, true, true, 40);
		$pdf->MultiCell(0, 10, 'enterado (da) del resultado final de grado.', 0, 'L', 0, 1, '', '', true, 0, true, true, 40);

		$pdf->Ln(5);
		$pdf->MultiCell(0, 10, 'F.______________________________', 0, 'L', 0, 1, '', '', true, 0, true, true, 40);
		$pdf->MultiCell(0, 10, '  Estudiante o encargado (a)', 0, 'L', 0, 1, '', '', true, 0, true, true, 40);
		$pdf->AddPage('P',array(355.6, 215.9));
	}

}//fin de la clase

/* End of file Tarjetas.php */
/* Location: ./application/controllers/Tarjetas.php */
