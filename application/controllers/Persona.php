<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Persona extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Departamento_model');
		$this->load->model('Nacionalidad_model');
		$this->load->model('Genero_model');
		$this->load->model('Lateralidad_model');
		$this->load->model('Estadocivil_model');
		$this->load->model('Puesto_model');
		$this->load->model('Tituloactual_model');
		$this->load->model('Persona_model');
	}
	public function index()
	{
		$data['depto']=$this->Departamento_model->getDepartamento();
		$data['nacionalidad']=$this->Nacionalidad_model->getNacionalidad();
		$data['genero']=$this->Genero_model->getGenero();
		$data['lateralidad']=$this->Lateralidad_model->getLateralidad();
		$data['estadocivil']=$this->Estadocivil_model->getEstadocivil();
		$data['puesto']=$this->Puesto_model->getPuesto();
		$data['titulo']=$this->Tituloactual_model->getTituloactual();
		$dato['titulo']="Nueva Persona";
		$dato['activo'] = 'persona';
		$this->load->view('plantilla/header', $dato);
		$this->load->view('secretaria/npersona', $data);
		$this->load->view('plantilla/footer');		
	}

	public function nueva_persona()
	{
		$this->form_validation->set_rules('nombres', 'Nombres', 'required|max_length[50]');
		$this->form_validation->set_rules('apellidos', 'Apellidos', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('deptoresidencia', 'Depto. Residencia', 'trim|required');
		$this->form_validation->set_rules('muniresidencia', 'Muni. Residencia', 'trim|required');
		$this->form_validation->set_rules('direccion', 'Direccion', 'trim|required|max_length[40]');
		$this->form_validation->set_rules('nacionalidad', 'Nacionalidad', 'trim|required');
		$this->form_validation->set_rules('deptonaci', 'Depto. Nacimiento', 'trim|required');
		$this->form_validation->set_rules('muninaci', 'Muni. Nacimiento', 'trim|required');
		$this->form_validation->set_rules('fechanaci', 'Fecha Nacimiento', 'trim|required');
		$this->form_validation->set_rules('genero', 'Genero', 'trim|required');
		$this->form_validation->set_rules('lateralidad', 'Lateralidad', 'trim|required');
		$this->form_validation->set_rules('estadocivil', 'Estado Civil', 'trim|required');
		$this->form_validation->set_rules('dpi', 'CUI/DPI', 'trim|required|max_length[16]');
		$this->form_validation->set_rules('tel1', 'No. Telefono', 'trim|required|min_length[8]|max_length[9]');
		$this->form_validation->set_rules('correo', 'Email', 'trim|required|max_length[320]');
		$this->form_validation->set_rules('fechainicio', 'fieldlabel', 'trim|required');
		$this->form_validation->set_rules('puesto', 'Puesto que Ocupa', 'trim|required');
		$this->form_validation->set_rules('titulo', 'Titulo Actual', 'trim|required');
		$this->form_validation->set_rules('institucion', 'Institucion', 'trim|required|max_length[100]');

		$this->form_validation->set_message('required','El campo %s es obligatorio, no puedo quedar vacio, sin seleccionarse o chequear al menos una opción');
		$this->form_validation->set_message('max_length','El campo %s no puede superar los $d caracteres');
		$this->form_validation->set_message('min_lenght','El campo %s debe de tener como minimo %d caracteres');

		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			$nombres=$this->input->post('nombres');
			$apellidos=$this->input->post('apellidos');
			$deptoresidencia=$this->input->post('deptoresidencia');
			$muniresidencia=$this->input->post('muniresidencia');
			$direccion=$this->input->post('direccion');
			$nacionalidad=$this->input->post('nacionalidad');
			$deptonaci=$this->input->post('deptonaci');
			$muninaci=$this->input->post('muninaci');
			$fechanaci=$this->input->post('fechanaci');
			$genero=$this->input->post('genero');
			$lateralidad=$this->input->post('lateralidad');
			$estadocivil=$this->input->post('estadocivil');
			$dpi=$this->input->post('dpi');
			$tel1=$this->input->post('tel1');
			$tel2=$this->input->post('tel2');
			$nit=$this->input->post('nit');
			$correo=$this->input->post('correo');
			$fechainicio=$this->input->post('fechainicio');
			$puesto=$this->input->post('puesto');
			$titulo=$this->input->post('titulo');
			$institucion=$this->input->post('institucion');

			$existe=$this->Persona_model->existePersona($dpi);
			if ($existe == 0) {
				$idnacimiento = $this->Persona_model->setNacimiento($fechanaci, $muninaci);
				$iddireccion = $this->Persona_model->setDireccion($direccion,$muniresidencia);
				$this->Persona_model->setPersona($puesto, $nombres, $apellidos, $dpi, $tel1, $tel2, $correo, $nit, $genero, $iddireccion, $idnacimiento, $nacionalidad, $lateralidad, $estadocivil, $titulo, $institucion, $fechainicio);

				$data['titulo']="Mensaje del sistema";
				$data['msg']="Se ha registrado exitosamente a: ".$nombres." ".$apellidos." "."en la base de datos";
				$data['activo'] = 'ninguno';
				$this->load->view('plantilla/header', $data);
				$this->load->view('msg/listo', $data);
				$this->load->view('plantilla/footer');
			}
			else
			{
				$data['titulo'] = "Mensaje del sistema";
				$data['msg'] = "No se registro a: ".$nombres." ".$apellidos." en la base de datos porque ya existe una persona con el mismo numero de dpi, ".$dpi;
				$data['activo'] = 'ninguno';
				$this->load->view('plantilla/header', $data);
				$this->load->view('msg/listo', $data);
				$this->load->view('plantilla/footer');
			}
		}
	}

	public function listado_personas()
	{
		$data['titulo'] = 'Listado de Personal';
		$data['activo'] = 'persona';
		$data['persona'] = $this->Persona_model->getPersonas();
		$this->load->view('plantilla/header', $data);
		$this->load->view('reportes/listadopersonas', $data);
		$this->load->view('plantilla/footer');

	}

	public function exportar_pdf()//metodo que exporta a pdf el el listado de personas
	{
		$this->load->library('Pdf1');

		$pdf = new Pdf1('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Byron Castro');
		$pdf->SetTitle('Nomina de Docentes');
		$pdf->SetSubject('Tutorial TCPDF');
		$pdf->SetKeywords('TCPDF,PDF, example, test, guide');
		//datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
		$pdf->setFooterData($tc=array(0,64,0), $lc=array(0,64,128));
		//datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de liabraries/config
		$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(array(PDF_FONT_NAME_DATA,'',PDF_FONT_SIZE_DATA));
		//se pueden modificar en el archivo tcṕdf_config.php de libraries/config
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		//se puede modificar en el archivo tcpdf_config.php de libraries/config
		$pdf->SetMargins(PDF_MARGIN_LEFT,40,PDF_MARGIN_RIGHT);
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
		$pdf->SetFont('times', '', 11, '', true);
		//añadir una página
		//este metodo tiene varias opciones, consultar la documentación para mas información
		$pdf->AddPage('L', array(355.6, 215.9));
		//fijar efecto de sombra en el texto
		//$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

		
		//aqui es donce debemos de recibir el contenido para el PDF
		$pdf->persona = 'Secretaría Pestalozzi';
		$datos = $this->Persona_model->getPersonas();
		$html = '';
		$html .= '<style type="text/css"> h3{text-align:center;} table{border: 1px solid #000;} th{text-align:center; font-weight:bold} table{width: 100%; max-width:100%; border-collapse: collapse;} table th, td{ border: 1px solid #000; widht: auto;}</style>';
		$html .='<h3>Nomina de Docentes</h3>';
		$html .= '<table>';
		$html .= '<thead>';
		$html .= '<tr>';
		$html .= '	<th style="width: 11%;">NOMBRES</th>';
		$html .= '	<th style="width: 11%;">APELLIDOS</th>';
		$html .= '	<th style="width: 11%">DPI</th>';
		$html .= '	<th style="width: 11%">FECHA DE INICIO</th>';
		$html .= '	<th style="width: 11%">PUESTO</th>';
		$html .= '	<th style="width: 11%">TELEFONO</th>';
		$html .= '	<th style="width: 11%">NIT</th>';
		$html .= '	<th style="width: 20%">CORREO</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';

			 foreach ($datos as $value) {
			 	$html .='<tr>';
				$html .= '<td nowrap="nowrap" style="width:11%;"> '.ucwords($value['nombre_persona']) .' </td>';
				$html .='<td nowrap="nowrap" style="width:11%;">'.  ucwords($value['apellidos_persona']) .'</td>';
				$html .='<td nowrap="nowrap" style="width:11%;"> '. $value['cui_dpi_persona'] .'</td>';
				$html .='<td nowrap="nowrap" style="width:11%;"> '.  $value['fecha_inicio'] .'</td>';
				$html .='<td nowrap="nowrap" style="width:11%;"> '.  ucwords($value['nombre_puesto']).'</td>';
				$html .='<td nowrap="nowrap" style="width:11%;"> '.  $value['no_telefono'] .'</td>';
				$html .='<td nowrap="nowrap" style="width:11%;"> '.  $value['nit_persona'] .'</td>';
				$html .='<td nowrap="nowrap"style="width:20%;"> '.  $value['correo_electr_persona'] .'</td>';
			$html .='</tr>';
		}

		$html .= '</tbody></table>';

		//imprimimos el texto con writeHTMLCell()
		$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
		//-----------------------------------------------------------------------------
		//cerrar el documento pdf y preparamos la salida
		//este metodo tiene varias opciones, consulte la documentación para más información.
		$nombre_archivo = utf8_decode("Nomina de Personal.pdf");
		$pdf->Output($nombre_archivo,'I');
	}

	/*metodo que muestra el formulario para la edición de datos de la persona*/
	public function editar_persona()
	{
		$data['titulo'] = 'Editar Persona';
		$data['activo'] = 'persona';
		$this->load->view('plantilla/header', $data);
		$this->load->view('editar/editarpersona', $data);
		$this->load->view('plantilla/footer');
	}
}

/* End of file Persona.php */
/* Location: ./application/controllers/Persona.php */