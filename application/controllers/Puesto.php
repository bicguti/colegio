<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Puesto extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Puesto_model');
	}
	public function index()
	{
		$data['titulo'] = "Nuevo Puesto";
		$data['activo'] = 'puesto';
		$this->load->view('plantilla/header', $data);
		$this->load->view('secretaria/npuesto', $data);
		$this->load->view('plantilla/footer');
	}
	public function nuevo_puesto()
	{
		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|max_length[15]');
		$this->form_validation->set_message('required', 'El campo %s es obligatorio');
		$this->form_validation->set_message('max_length', 'El campo %s no debe superar los %d caracteres');

		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			$nombre = strtolower($this->input->post('nombre'));
			$data['msg'] = $this->Puesto_model->setPuesto($nombre);

			$data['titulo'] = "Mensaje del sistema";
			$data['activo'] = 'ninguno';
			$this->load->view('plantilla/header', $data);
			$this->load->view('msg/listo', $data);
			$this->load->view('plantilla/footer');
		}
	}

	/*
		metodo que muestra el formulario para la edicion de un puesto
	*/
	public function editar_puesto()
	{
		$data['puesto'] = $this->Puesto_model->getPuesto();
		$data['titulo'] = 'Editar un Puesto';
		$data['activo'] = 'puesto';
		$this->load->view('plantilla/header', $data);
		$this->load->view('editar/epuesto', $data);
		$this->load->view('plantilla/footer');
	}

	/*
		metodo para guardar los cambios de la edicion de un puesto
	*/
	public function guardar_edicion_puesto()
	{
		$this->form_validation->set_rules('puesto', 'Puesto', 'trim|required');
		$this->form_validation->set_rules('nnombre', 'Nombre', 'trim|required|max_length[15]');

		$this->form_validation->set_message('required', 'El campo %s es requrerido, por favor llene el campo o seleccione una opcion valida');
		$this->form_validation->set_message('max_length', 'El campo %s no puede tener mas de %d caracteres.');

		if ($this->form_validation->run() == FALSE) {
			$this->editar_puesto();
		} else {
			$puesto = $this->input->post('puesto');
			$nombre = mb_strtolower($this->input->post('nnombre'));
			$this->Puesto_model->updatePuesto($nombre, $puesto);

			$data['msg'] = 'Se ha editado exitosamente el nombre del puesto en la base de datos';
			$data['titulo'] = 'Mensaje del Sistema';
			$data['activo'] = '';
			$this->load->view('plantilla/header', $data);
			$this->load->view('msg/listo', $data);
			$this->load->view('plantilla/footer');
		}
	}

	/*
		metodo que muestra el formulario para la eliminación logica de un puesto
	*/
	public function eliminar_puesto()
	{
		$data['puesto'] = $this->Puesto_model->getTPuestos();
		$data['titulo'] = 'Eliminar Puesto';
		$data['activo'] = 'puesto';
		$this->load->view('plantilla/header', $data);
		$this->load->view('eliminar/eliminarpuesto', $data);
		$this->load->view('plantilla/footer');
	}

	/*
		metodo para guardar el nuevo estado de un puesto 
	*/
	public function guardar_estado_puesto()
	{
		$this->form_validation->set_rules('puesto', 'Puesto', 'trim|required');

		$this->form_validation->set_message('required', 'El campo %s es requerido, por favor seleccione una opción valida');
		
		if ($this->form_validation->run() == FALSE) {
			$this->eliminar_puesto();
		} else {
			$puesto = $this->input->post('puesto');
			$estado = $this->input->post('estadopuesto');
			if ($estado == 0) {
				
				$msg = 'El puesto ha sido dado de baja';
				$this->Puesto_model->deletePuesto($puesto, FALSE);
			}

			if ($estado == 1) {

				$msg = 'El puesto ha sido dado de alta para ser utilizado';
				$this->Puesto_model->deletePuesto($puesto, TRUE);
			}

			

			$data['msg'] = $msg;
			$data['titulo'] = 'Mensaje del Sistema';
			$data['activo'] = '';
			$this->load->view('plantilla/header', $data);
			$this->load->view('msg/listo', $data);
			$this->load->view('plantilla/footer');
			
		}
	}

	/*
	 metodo para buscar el estado que tiene un puesto
	*/
	 public function buscar_estado_puesto()
	 {
	 	$puesto = $this->input->get('puesto');
	 	$datos = $this->Puesto_model->getEstadoPuesto($puesto);
	 	echo json_encode($datos);
	 }
}

/* End of file Puesto.php */
/* Location: ./application/controllers/Puesto.php */