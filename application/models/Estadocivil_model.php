<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estadocivil_model extends CI_Model {
	public function getEstadocivil()
	{
		$query=$this->db->get('ESTADO_CIVIL');
		return $query->result_array();
	}
	

}

/* End of file Estadocivil_model.php */
/* Location: ./application/models/Estadocivil_model.php */