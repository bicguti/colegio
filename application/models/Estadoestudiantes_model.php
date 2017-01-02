<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estadoestudiantes_model extends CI_Model {
	public function getIdestadoestudiantes()
	{
		$query = $this->db->query('select obtener_idestadoestudiante("inscrito") as id;');
		$aux = $query->row();
		$dato = $aux->id;
		return $dato;
	}
	

}

/* End of file Estadoestudiantes_model.php */
/* Location: ./application/models/Estadoestudiantes_model.php */