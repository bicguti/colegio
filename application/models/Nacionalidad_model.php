<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nacionalidad_model extends CI_Model {
	public function getNacionalidad()
	{
		$query=$this->db->get('NACIONALIDAD');
		return $query->result_array();
	}
	

}

/* End of file Nacionalidad_model.php */
/* Location: ./application/models/Nacionalidad_model.php */