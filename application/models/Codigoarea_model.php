<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Codigoarea_model extends CI_Model {
	public function getCodigoarea()
	{
		$query = $this->db->get('CODIGO_AREA');
		return $query->result_array();
	}
	

}

/* End of file Codigoarea_model.php */
/* Location: ./application/models/Codigoarea_model.php */