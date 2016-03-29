<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipoarea_model extends CI_Model {
	public function getTipoarea()
	{
		$query = $this->db->get('TIPO_AREA');
		return $query->result_array();
	}
	

}

/* End of file Tipoarea_model.php */
/* Location: ./application/models/Tipoarea_model.php */