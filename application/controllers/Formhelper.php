<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Formhelper extends CI_Controller {

	public function index()
	{
		$data['titulo'] = 'Form Helper';
		$data['activo'] = 'ninguno';
		$this->load->view('plantilla/header', $data);	
		$this->load->view('secretaria/formhelper', $data);
		$this->load->view('plantilla/footer');
	}

}

/* End of file Formhelper.php */
/* Location: ./application/controllers/Formhelper.php */