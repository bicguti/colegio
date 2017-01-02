<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lateralidad_model extends CI_Model {
	public function getLateralidad()
	{
		$query=$this->db->get('LATERALIDAD');
		return $query->result_array();
	}
	

}

/* End of file Lateralidad_model.php */
/* Location: ./application/models/Lateralidad_model.php */