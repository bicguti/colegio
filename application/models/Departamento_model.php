<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departamento_model extends CI_Model {
	public function getDepartamento()
	{
		$query=$this->db->get('DEPARTAMENTO');
		return $query->result_array();
	}
	

}

/* End of file Departamento_model.php */
/* Location: ./application/models/Departamento_model.php */