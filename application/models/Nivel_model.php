<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nivel_model extends CI_Model {
	/*
		metodo que obtiene todos los niveles con estado true
	*/
	public function getNivel()
	{
		$query = $this->db->get_where('NIVEL', array('estado_nivel'=>true));
		return $query->result_array();
	}
	

	public function getNivel2()//funcion que obtiene todos los niveles menos el de diversificado
	{
		$nivel="diversificado";
		$query = $this->db->query('select* from NIVEL where nombre_nivel != "'.$nivel.'"');
		return $query->result_array();
	}

	public function getNivel3()//obtiene el nivel diversificado unicamente
	{
		$query = $this->db->query('select* from NIVEL where nombre_nivel = "diversificado";');
		return $query->result_array();
	}

	/*
		metodo que obtiene todos los niveles independientemente de su estado
	*/
	public function getTNiveles()
	{
		$query = $this->db->get('NIVEL');
		return $query->result_array();
	}

	/*
		metodo para editar el nombre de un nivel
	*/
	public function updateNivel($nivel, $nombre)
	{
		$this->db->query('call editar_nivel('.$nivel.', "'.$nombre.'");');
	}

	/*
		metodo para buscar un nivel
	*/
	public function buscar_nivel($nivel)
	{
		$query = $this->db->get_where('NIVEL', array('id_nivel'=>$nivel));
		return $query->result_array();
	}

	/*
		metodo para cambiar el estado de un nivel en la base de datos
	*/
	public function deleteNivel($nivel, $estado)
	{
		$this->db->query('call eliminar_nivel('.$nivel.', "'.$estado.'");');
	}
}

/* End of file Nivel_model.php */
/* Location: ./application/models/Nivel_model.php */