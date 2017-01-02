<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nivelplan extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Nivel_model');
		$this->load->model('Plan_model');
		$this->load->model('Nivelplan_model');
	}
	public function index()
	{
		$data['plan'] = $this->Plan_model->getPlan();
		$data['nivel'] = $this->Nivel_model->getNivel();
		$data['titulo']="Nuevo Nivel-Plan";
		$data['activo'] = 'nivel';
		$this->load->view('plantilla/header', $data);
		$this->load->view('secretaria/nnivel_plan', $data);
		$this->load->view('plantilla/footer');
	}
	public function nuevo_nivelplan()
	{
		$this->form_validation->set_rules('nivel', 'Nivel', 'trim|required');
		$this->form_validation->set_rules('plan', 'Plan', 'trim|required');
		$this->form_validation->set_message('required', 'Debe seleccionar una opcion valida en %s');
		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			$nivel = $this->input->post('nivel');
			$plan = $this->input->post('plan');

			$data['msg']= $this->Nivelplan_model->setNivelplan($nivel, $plan);
			$data['titulo'] = "Mensaje del sistema";
			$data['activo'] = 'ninguno';
			$this->load->view('plantilla/header', $data);
			$this->load->view('msg/listo', $data);
			$this->load->view('plantilla/footer');
		}
	}

	/*
		metodo que muestra el formulario de edicion de un plan
	*/
	public function editar_nivel()
	{
		$data['nivel'] = $this->Nivel_model->getNivel();
		$data['titulo'] = 'Editar Nivel';
		$data['activo'] = 'nivel';
		$this->load->view('plantilla/header', $data);
		$this->load->view('editar/editarnivel', $data);
		$this->load->view('plantilla/footer', $data);
	}

	/*
		metodo para guardar los cambios de edicion de un nivel
	*/
	public function guardar_edicion_nivel()
	{
		$this->form_validation->set_rules('nivel', 'Nivel', 'trim|required');
		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|max_length[20]');

		$this->form_validation->set_message('required', 'El campo %s es requerido, por favor seleccione una opción valida o llene el campo.');
		$this->form_validation->set_message('max_length', 'El campo %s no puede tener mas de %d caracteres.');

		if ($this->form_validation->run() == FALSE) {
			$this->editar_nivel();
		} else {
			$nivel = $this->input->post('nivel');
			$nombre = mb_strtolower($this->input->post('nombre'));	
			$this->Nivel_model->updateNivel($nivel, $nombre);
		}

		$data['msg'] = 'El nombre del nivel a sido editado exitosamente';
		$data['titulo'] = 'Mensaje del Sistema';
		$data['activo'] = '';
		$this->load->view('plantilla/header', $data);
		$this->load->view('msg/listo', $data);
		$this->load->view('plantilla/footer');

	}

	/*
		metodo que muestra el formulario para eliminación lógica de un nivel
	*/
	public function eliminar_nivel()
	{	
		$data['nivel'] = $this->Nivel_model->getTNiveles();
		$data['titulo'] = 'Eliminar Nivel';
		$data['activo'] = 'nivel';
		$this->load->view('plantilla/header', $data);
		$this->load->view('eliminar/eliminarnivel', $data);
		$this->load->view('plantilla/footer');
	}

	/*
		metodo para buscar un nivel
	*/
	public function buscar_nivel()
	{
		$nivel = $this->input->get('nivel');
		$datos = $this->Nivel_model->buscar_nivel($nivel);
		echo json_encode($datos);
	}

	/*
		metodo para guardar el cambio de estado de un nivel
	*/
	public function guardar_eliminar_nivel()
	{
		$this->form_validation->set_rules('nivel', 'Nivel', 'trim|required');
		$this->form_validation->set_message('required', 'El campo %s es requrerido, por favor seleccione una opción valida');

		if ($this->form_validation->run() == FALSE) {
			$this->eliminar_nivel();
		} else {
			$nivel = $this->input->post('nivel');
			$estado = $this->input->post('estado');
			if ($estado == true) {
				$this->Nivel_model->deleteNivel($nivel, true);
				$data['msg'] = 'Se a habilitado el nivel exitosamente, ya lo puede utilizar en las operaciones donde lo necesite.';
			} else {
				$this->Nivel_model->deleteNivel($nivel, false);
				$data['msg'] = 'Se a deshabilitado el nivel exitosamente, ya no podra utlizar este nivel en las operaciones donde se necesit. Si desea volver a utilizar este nivel solo vuelva a habilitarlo.';
			}
			
			$data['titulo'] = 'Mensaje del Sistema';
			$data['activo'] = '';
			$this->load->view('plantilla/header', $data);
			$this->load->view('msg/listo', $data);
			$this->load->view('plantilla/footer', $data);

		}
	}

}

/* End of file Nivelplan.php */
/* Location: ./application/controllers/Nivelplan.php */