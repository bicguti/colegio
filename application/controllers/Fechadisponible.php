<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fechadisponible extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Bloque_model');
		$this->load->model('Fechadisponible_model');
	}
	public function index()
	{
		$data['fechaDisponible'] = $this->Fechadisponible_model->getFechaDisponible();
		$data['titulo'] = 'Nueva Fecha Disponibilidad';
		$data['activo'] = 'cuadros';
		$this->load->view('plantilla/header', $data);
		$this->load->view('secretaria/nfechadisponible', $data);
		$this->load->view('plantilla/footer');
	}

	public function nueva_fechadisponible()
	{
		$this->form_validation->set_rules('fechainicio[]', 'Fecha Inicio', 'trim|required');
		$this->form_validation->set_rules('fechafin[]', 'Fecha Fin', 'trim|required');
		$this->form_validation->set_message('required','EL campo %s es obligatorio');

		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			$inicio = $this->input->post('fechainicio');
			$fin = $this->input->post('fechafin');

			for ($i=0; $i < count($inicio); $i++) { 
				$this->Fechadisponible_model->setFechadisponible($inicio[$i], $fin[$i], $i+1);
			}

			$data['msg'] = 'Se han registrado exitosamente las fechas de disponibilidad de los bloques';
			$data['titulo'] = 'Mensaje del sistema';
			$data['activo'] = 'ninguno';
			$this->load->view('plantilla/header', $data);
			$this->load->view('msg/listo', $data);
			$this->load->view('plantilla/footer');
		}
	}
}

/* End of file Fechadisponible.php */
/* Location: ./application/views/secretaria/Fechadisponible.php */