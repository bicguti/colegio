<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bloque_model extends CI_Model {
	public function getBloques()//metodo que extrare todos los bloques
	{
		$query = $this->db->get('BLOQUE');
		return $query->result_array();
	}
	

}

/* End of file Bloque_model.php */
/* Location: ./application/models/Bloque_model.php */