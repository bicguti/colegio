<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estudiantecarrera_model extends CI_Model {
	public function setEstudiantecarrera($estudiante, $carrera)
	{
		$query = $this->db->query('call nuevo_estudianteCarrera('.$estudiante.', '.$carrera.')');
		$aux = $query->row();
		$dato = $aux->respuesta;
		$query->next_result();
		return $dato;
	}
	
	public function getEstudianteCarrera($estudiante)
	{
		$query = $this->db->get_where('ESTUDIANTE_CARRERA', array('id_estudiante'=>$estudiante));
		//$this->db->select('field1, field2');
		return $query->result_array();
	}
}

/* End of file Estudiantecarrera_model.php */
/* Location: ./application/models/Estudiantecarrera_model.php */