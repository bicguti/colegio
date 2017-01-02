<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Genero_model extends CI_Model {
	public function getGenero()
	{
		$query=$this->db->get('GENERO');
		return $query->result_array();
	}
	

}

/* End of file Genero_model.php */
/* Location: ./application/models/Genero_model.php */