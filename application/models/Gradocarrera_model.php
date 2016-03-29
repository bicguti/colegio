<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gradocarrera_model extends CI_Model {
	public function setGradocarrera($grado, $carrera)
	{
		$query = $this->db->query('call nuevo_gradocarrera('.$grado.','.$carrera.');');
		$aux = $query->row();
		$dato = $aux->id;
		$query->next_result();
		return $dato;
	}
	
	public function getGradoCarrera($grado, $carrera)
	{
		$query = $this->db->get_where('GRADO_CARRERA', array('id_grado'=>$grado, 'id_carrera'=>$carrera));
		return $query->result_array();
	}
}

/* End of file Gradocarrera_model.php */
/* Location: ./application/models/Gradocarrera_model.php */