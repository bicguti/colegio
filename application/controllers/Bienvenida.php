<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bienvenida extends CI_Controller {

	public function index()
	{
		$data['activo'] = 'ninguno';
		$data['titulo']="Secretaria Pestalozzi";
		$this->load->view('plantilla/header', $data);
		$this->load->view('secretaria/index');
		$this->load->view('plantilla/footer');		
	}

}

/* End of file Index.php */
/* Location: ./application/controllers/Index.php */