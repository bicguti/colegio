<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Docentes extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Nivel_model');
		$this->load->model('Docente_model');
		$this->load->model('Gradocarrera_model');
	}
	public function index()
	{
		$data['nivel'] = $this->Nivel_model->getNivel();
		$data['titulo'] = 'Nuevo Docente Guía';
		$data['activo'] = 'docente';
		$this->load->view('plantilla/header', $data);
		$this->load->view('secretaria/nguia', $data);
		$this->load->view('plantilla/footer');
	}

	/*
		metodo para buscar un nuevo docente para ser guia o titular de unn grado
		retorna un json
	*/
	public function buscar_docente()
	{
		$docente = $this->input->get('persona');
		$datos = $this->Docente_model->getDocente($docente);
		echo json_encode($datos);
	}

	public function nuevo_guia()
	{
		$this->form_validation->set_rules('seleccion', 'Seleccione', 'trim|required');
		$this->form_validation->set_rules('nivel', 'Nivel', 'trim|required');
		$this->form_validation->set_rules('grado', 'Grado', 'trim|required');

		$this->form_validation->set_message('required', 'El campo %s es obligatorio, por favor seleccione una opcion valida');

		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			$persona = $this->input->post('seleccion');
			$nivel = $this->input->post('nivel');
			$grado = $this->input->post('grado');

			if ($nivel == 4) {
				$carrera = $this->input->post('carrera');
				$datos = $this->Gradocarrera_model->getGradoCarrera($grado, $carrera);
				$gradocarrera = $datos[0]['id_grado_carrera'];

				$this->Docente_model->setGuiaC($persona, $gradocarrera);

			} else {
				$this->Docente_model->setGuia($persona, $nivel, $grado);
			}
			
			$data['msg'] = 'Se a registrado al nuevo docente como guia o títular';
			$data['titulo'] = 'Mensaje del Sistema';
			$data['activo'] = '';
			$this->load->view('plantilla/header', $data);
			$this->load->view('msg/listo', $data);
			$this->load->view('plantilla/footer');
		}
	}

}

/* End of file Docentes.php */
/* Location: ./application/controllers/Docentes.php */