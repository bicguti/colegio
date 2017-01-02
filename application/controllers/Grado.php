<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grado extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Grado_model');
	}
	public function index()
	{

	}

	public function buscar_grados()
	{
		$identificador = $this->input->get('id');

		switch ($identificador) {
			case 1:
				$dato = $this->Grado_model->findPreprimaria();
				echo json_encode($dato);
				break;
			case 2:
				$dato = $this->Grado_model->findPrimaria();
				echo json_encode($dato);
				break;
			case 3:
				$dato = $this->Grado_model->findBasico();
				echo json_encode($dato);
				break;
			case 4:
				$dato = $this->Grado_model->findDiversificado();
				echo json_encode($dato);
				break;
			case 5:
				$dato = $this->Grado_model->findMadurez();
				echo json_encode($dato);
				break;
			case 6:
				$dato = $this->Grado_model->findDiversificado2();
				echo json_encode($dato);
				break;
		}

	}
}

/* End of file Grado.php */
/* Location: ./application/controllers/Grado.php */
