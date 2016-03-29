<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Municipio extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Municipio_model');
		$this->load->model('Departamento_model');
	}
	public function index()
	{
		$data['departamento'] = $this->Departamento_model->getDepartamento();
		$data["titulo"] = "Nuevo Municipio";
		$data['activo'] = 'municipio';
		$this->load->view('plantilla/header', $data);
		$this->load->view('secretaria/nmunicipio', $data);
		$this->load->view('plantilla/footer');
	}
	public function municipios()
	{
		$depto=$this->input->get('id');
		//$depto=$_GET['id'];
		$datos=$this->Municipio_model->getMunicipio($depto);
		echo json_encode($datos);
	}
	public function nuevo_municipio()
	{
		$this->form_validation->set_rules('departamento', 'Departamento', 'trim|required');
		$this->form_validation->set_rules('municipio', 'Municipio', 'trim|required|max_length[70]');
		$this->form_validation->set_message('required', 'El campo %s es obligatorio, seleccione una opcion o escriba el texto');
		$this->form_validation->set_message('max_length', 'El campo %s no debe de superar los %d caracteres ');

		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			$municipio = $this->input->post('municipio');
			$departamento =$this->input->post('departamento');
			$data['msg'] = $this->Municipio_model->setMunicipio($municipio, $departamento);

			$data['titulo'] = "Mensaje del Sistema";
			$data['activo'] = 'niguno';
			$this->load->view('plantilla/header', $data);
			$this->load->view('msg/listo', $data);
			$this->load->view('plantilla/footer');
		}
		
	}

}

/* End of file Municipio.php */
/* Location: ./application/controllers/Municipio.php */