<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Tipoarea_model');
		$this->load->model('Codigoarea_model');
		$this->load->model('Nivel_model');
		$this->load->model('Area_model');
		$this->load->model('Asignacionarea_model');
		$this->load->model('Grado_model');
		$this->load->model('Carrera_model');
	}
	public function index()
	{
		$data['activo'] = 'area';
		$data['nivel'] = $this->Nivel_model->getNivel2();
		$data['codigoarea'] = $this->Codigoarea_model->getCodigoarea();
		$data['tipoarea'] = $this->Tipoarea_model->getTipoarea();
		$data['titulo'] = "Nueva Area P-B";
		$this->load->view('plantilla/header', $data);
		$this->load->view('secretaria/narea', $data);
		$this->load->view('plantilla/footer');
	}
	public function nueva_area()//metodo para agregar una nueva area al nivel preprimario, primario y básico.
	{
		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|max_length[60]');
		$this->form_validation->set_rules('tipoarea', 'Tipo de Area', 'trim|required');
		$this->form_validation->set_message('required', 'El campo %s el obligatorio, llene el campo o seleccione una opción segun sea el caso.');
		$this->form_validation->set_message('max_length', 'El campo %s no puede sobrepasar los %d caracteres');
		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			$nombre = strtolower($this->input->post('nombre'));
			$tipoarea = $this->input->post('tipoarea');

			$data['msg'] = $this->Area_model->setArea($nombre, $tipoarea);
					$data['titulo'] = 'Mensaje del sistema';
					$data['activo'] = '';
					$this->load->view('plantilla/header', $data);
					$this->load->view('msg/listo', $data);
					$this->load->view('plantilla/footer');
		

		}
	}

	public function listado()
	{
		$dato['activo'] = 'area';
		$data['area'] = $this->Area_model->getListadoarea();
		$dato['titulo'] = 'Listado Areas';
		$this->load->view('plantilla/header', $dato);
		$this->load->view('secretaria/listadoareas', $data);
		$this->load->view('plantilla/footer');
	}

	/*
		metodo para que muestra el formulario para editar los datos de una area
	*/
	public function editar_area()
	{	
		$data['areas'] = $this->Area_model->getArea();
		$data['titulo'] = 'Editar Área';
		$data['activo'] = 'area';
		$this->load->view('plantilla/header', $data);
		$this->load->view('editar/editararea', $data);
		$this->load->view('plantilla/footer');
	}

	/*
		metodo que busca los datos de una area en especifico
	*/
	public function buscar_area()
	{
		$area = $this->input->get('area');
		$datos = $this->Area_model->buscar_area($area);
		echo json_encode($datos);
	}

	/*
		metodo para guardar los datos editados de un area
	*/
	public function guardar_edicion_area()
	{
		$this->form_validation->set_rules('area', 'Área', 'trim|required');
		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|max_length[60]');
		$this->form_validation->set_rules('tipoarea', 'Tipo Área', 'trim|required');
		$this->form_validation->set_message('required', 'El campo %s es obligatorio, por favor seleccione una opción valida o llene el campo.');
		$this->form_validation->set_message('max_length', 'El campo %s no puede tener mas de %d caracteres.');

		if ($this->form_validation->run() == FALSE) {
			$this->editar_area();
		} else {
			$area = $this->input->post('area');
			$nombre = mb_strtolower($this->input->post('nombre'));
			$tipo = $this->input->post('tipoarea');

			$this->Area_model->updateArea($area, $nombre, $tipo);

			$data['msg'] = 'Se han editado los datos del area exitosamente';
			$data['titulo'] = 'Mensaje del Sistema';
 			$data['activo'] = '';
			$this->load->view('plantilla/header', $data);
			$this->load->view('msg/listo', $data);
			$this->load->view('plantilla/footer');
		}
	}

	public function eliminar_area()
	{
		$data['areas'] = $this->Area_model->getTAreas();
		$data['titulo'] = 'Eliminar Area';
		$data['activo'] = 'area';
		$this->load->view('plantilla/header', $data);
		$this->load->view('eliminar/eliminararea', $data);
		$this->load->view('plantilla/footer');
	}

	public function guardar_eliminar_area()
	{
		$area = $this->input->post('area');
		$estado = $this->input->post('estadoarea');
		if ($estado == true) {
			$this->Area_model->deleteArea($area, true);
			$data['msg'] = 'El área ha sido habilitado exitosamente, ya lo puede utilizar en sus operaciones. ';
		}else{
			$this->Area_model->deleteArea($area, false);
			$data['msg'] = 'El área ha si deshabilitado exitosamente, ya no podra utilizar esta área en sus operaciones, si desea puede volver a habilitarlo si desea utilizarlo en sus operaciones.';
		}
		
		$data['titulo'] = 'Mensaje del Sistema';
		$data['activo'] = '';
		$this->load->view('plantilla/header', $data);
		$this->load->view('msg/listo', $data);
		$this->load->view('plantilla/footer');
	}
}

/* End of file Area.php */
/* Location: ./application/controllers/Area.php */