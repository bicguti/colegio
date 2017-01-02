<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Municipio_model extends CI_Model {
	public function getMunicipio($depto)
	{
		$query=$this->db->get_where('MUNICIPIO', array('id_depto'=>$depto));
		return $query->result_array();
	}
	
	public function setMunicipio($nombre, $depto)
	{
		$query = $this->db->query('call nuevo_municipio("'.$nombre.'",'.$depto.')');
		$aux = $query->row();
		$dato = $aux->msg;
		return $dato;
	}
}

/* End of file Municipio_model.php */
/* Location: ./application/models/Municipio_model.php */