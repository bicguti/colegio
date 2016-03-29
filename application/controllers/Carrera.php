<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carrera extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Carrera_model');
		$this->load->model('Plan_model');
		$this->load->model('Nivel_model');
	}
	public function index()
	{
		$data['nivel'] = $this->Nivel_model->getNivel3();
		$data['plan'] = $this->Plan_model->getPlan();
		$data['titulo'] = "Nueva Carrera";
		$data['activo'] = 'carrera';
		$this->load->view('plantilla/header', $data);
		$this->load->view('secretaria/ncarrera', $data);
		$this->load->view('plantilla/footer');
	}

	public function nueva_carrera()
	{
		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|max_length[70]');
		$this->form_validation->set_rules('plan', 'Plan', 'trim|required');
		$this->form_validation->set_message('required', 'El campo %s es obligatorio');
		$this->form_validation->set_message('max_length', 'El campo %s no puede superar los %d caracteres');
		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			$nombre = strtolower($this->input->post('nombre'));
			$nivel = 4;//id del nivel
			$plan = $this->input->post('plan');
			$idnivelplan = $this->Carrera_model->idNivelplan($plan, $nivel);
			$data['msg'] = $this->Carrera_model->setCarrera($nombre, $idnivelplan);
			
			$data['activo'] = 'ninguno';
			$data['titulo'] = "Mensaje del sistema";
			$this->load->view('plantilla/header', $data);
			$this->load->view('msg/listo', $data);
			$this->load->view('plantilla/footer');
			
		}
	}

	/*
		metodo que obtiene las carreras que estan en la base de datos y luego devuelve un json
	*/
	public function carreras()
	{
		$datos = $this->Carrera_model->getCarrera();
		echo json_encode($datos);
	}

	/*
		metodo que muestra el formulario para la edición de una carrera
	*/
	public function editar_carrera()
	{
		$data['plan'] = $this->Plan_model->getPlan();
		$data['carrera'] = $this->Carrera_model->getCarrera();
		$data['titulo'] = 'Editar Carrera';
		$data['activo'] = 'carrera';
		$this->load->view('plantilla/header', $data);
		$this->load->view('editar/editarcarrera', $data);
		$this->load->view('plantilla/footer');
	}

	/*
		metodo que busca los datos de una carrera y devuelve un json
	*/
	public function buscar_carrera()
	{
		$carrera = $this->input->get('carrera');
		$datos = $this->Carrera_model->buscarCarrera($carrera);
		echo json_encode($datos);
	}

	/*
		metodo para guardar la edicion de los datos de una carrera
	*/
	public function guardar_edicion_carrera()
	{
		$this->form_validation->set_rules('carrera', 'Carrera', 'trim|required');
		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|max_length[60]');
		$this->form_validation->set_rules('plan', 'Plan', 'trim|required');

		$this->form_validation->set_message('required', 'El campo %s es requerido, por favor seleccion una opción valida o llene el camṕo.');
		$this->form_validation->set_message('max_length', 'EL campo %s no puede tener mas de %d caracteres.');

		if ($this->form_validation->run() == FALSE) {
			$this->editar_carrera();
		} else {
			$carrera = $this->input->post('carrera');
			$nombre = $this->input->post('nombre');
			$plan = $this->input->post('plan');

			$this->Carrera_model->updateCarrera($carrera, $nombre, $plan);

			$data['msg'] = 'Se actualizaron los datos de la carrera exitosamente.';
			$data['titulo'] = 'Mensaje del Sistema';
			$data['activo'] = '';
			$this->load->view('plantilla/header', $data);
			$this->load->view('msg/listo', $data);
			$this->load->view('plantilla/footer');
		}

	}

	/*
		metodo para mostrar el formulario de eliminación lógica de una carrera
	*/
	public function eliminar_carrera()
	{
		$data['carrera'] = $this->Carrera_model->getTCarreras();
		$data['titulo'] = 'Eliminar Carrera';
		$data['activo'] = 'carrera';
		$this->load->view('plantilla/header', $data);
		$this->load->view('eliminar/eliminarcarrera', $data);
		$this->load->view('plantilla/footer', $data);
	}

	/*
		metodo que guarda el cambio de estado de una carrera
	*/
	public function guardar_eliminar_carrera()
	{
		$this->form_validation->set_rules('carrera', 'Carrera', 'trim|required');
		$this->form_validation->set_message('required', 'El campo %s el requerido, por favor seleccione una opción valida.');
		
		if ($this->form_validation->run() == FALSE) {
			$this->eliminar_carrera();
		} else {
			
			$carrera = $this->input->post('carrera');
			$estado = $this->input->post('estado');	
			
			if ($estado == true) {
				$this->Carrera_model->deleteCarrera($carrera, true);
				$data['msg'] = 'La carrera ha sido habilitado exitosamente, ahora ya puede utilizarlo en las operaciones donde lo necesite.';
			} else {
				$this->Carrera_model->deleteCarrera($carrera, false);
				$data['msg'] = 'La carrera a sido deshabilitado exitosamente, sí desea utilizar nuevamente esta carrera en sus operaciones, por favor vuelva a habilitarlo.';
			}
			

			$data['titulo'] = 'Mensaje del Sistema';
			$data['activo'] = '';
			$this->load->view('plantilla/header', $data);
			$this->load->view('msg/listo', $data);
			$this->load->view('plantilla/footer');
		}
		
	}
}

/* End of file Carrera.php */
/* Location: ./application/controllers/Carrera.php */