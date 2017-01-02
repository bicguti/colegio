<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nivelplan_model extends CI_Model {
	public function setNivelplan($nivel, $plan)
	{
		$query = $this->db->query('call nuevo_nivelplan('.$nivel.', '.$plan.')');
		$aux = $query->row();
		$dato = $aux->msg;
		return $dato;
	}
	

}

/* End of file Nivelplan_model.php */
/* Location: ./application/models/Nivelplan_model.php */