<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Titulo extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Tituloactual_model');
	}
	public function index()
	{	
		$data['titulo'] = 'Nuevo Título para Persona';
		$data['activo'] = 'persona';
		$this->load->view('plantilla/header', $data);
		$this->load->view('secretaria/ntitulo', $data);
		$this->load->view('plantilla/footer');
	}

	/*
		metodo para guardar un nuevo titulo profesional ya sea de nivel medio o de nivel universitario
	*/
	public function guardar_titulo()
	{
		$this->form_validation->set_rules('nombre', 'Nombre Título', 'trim|required|max_length[100]');

		$this->form_validation->set_message('required', 'El campo %s es requerido, por favor llene el campo.');
		$this->form_validation->set_message('max_length', 'El campo %s no puede superar los %d caracteres.');

		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			$nombre = mb_strtolower($this->input->post('nombre'));
			$msg = $this->Tituloactual_model->setTitulo($nombre);	
		}
		$data['msg'] = $msg;
		$data['activo'] = '';
		$data['titulo'] = 'Mensaje del sistema';
		$this->load->view('plantilla/header', $data);
		$this->load->view('msg/listo', $data);
		$this->load->view('plantilla/footer');
	}

	/*
		metodo que muestra el formulario para la edicion del nombre de un titulo academico
	*/
	public function editar_titulo()
	{
		$data['tacademico'] = $this->Tituloactual_model->getTituloactual();
		$data['titulo'] = 'Editar Título academico';
		$data['activo'] = 'persona';
		$this->load->view('plantilla/header', $data);
		$this->load->view('editar/editartitulo', $data);
		$this->load->view('plantilla/footer');
	}

	/*
		metodo para guardar la edicion del nombre del título
	*/
	public function guardar_edicion_titulo()
	{
		$this->form_validation->set_rules('titulo', 'Titulo', 'trim|required');
		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|max_length[100]');

		$this->form_validation->set_message('required', 'El campo %s es requerido, por favor seleccione una opción valida o llene el campo.');
		$this->form_validation->set_message('max_length', 'El campo %s no puede tener mas de %d caracteres.');

		if ($this->form_validation->run() == FALSE) {
			$this->editar_titulo();
		} else {
			$titulo = $this->input->post('titulo');
			$nombre = $this->input->post('nombre');
			$this->Tituloactual_model->update_titulo($titulo, $nombre);
		}
		$data['msg'] = 'El nombre del título a sido editado exitosamente en la base de datos, ya puede realizar otra operación.';
		$data['titulo'] = 'Mensaje del Sistema';
		$data['activo'] = '';
		$this->load->view('plantilla/header', $data);
		$this->load->view('msg/listo', $data);
		$this->load->view('plantilla/footer');
	}
}

/* End of file Titulo.php */
/* Location: ./application/controllers/Titulo.php */