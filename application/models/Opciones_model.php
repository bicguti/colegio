<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Opciones_model extends CI_Model {
	public function getOpciones()//obtiene todas las opciones disponibles del menu
	{
		$query = $this->db->get_where('OPCIONES',array('estado_opcion'=>true));
		return $query->result_array();
	}
	
	public function findSubOpcion($opcion)//busca las subopciones deacuerdo a la opcion enviada
	{
		$query = $this->db->get_where('SUB_OPCIONES', array('id_opcion'=>$opcion));
		return $query->result_array();
	}
}

/* End of file Opciones_model.php */
/* Location: ./application/models/Opciones_model.php */