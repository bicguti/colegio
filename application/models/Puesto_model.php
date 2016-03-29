<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Puesto_model extends CI_Model {

	/*
		metodo que extrae todos los puestos que esten activos para ser utlizados en una operación
	*/
	public function getPuesto()
	{
		$query=$this->db->get_where('PUESTO', array('estado_puesto'=>TRUE));
		return $query->result_array();
	}

	/*
		metodo que obtiene todos los puestos independientemente del estado del puesto
	*/
	public function getTPuestos()
	{
		$query = $this->db->get('PUESTO');
		return $query->result_array();
	}
	
	/*
		metodo que agrega un nuevo puesto a la base de datos
	*/
	public function setPuesto($nombre)
	{
		$query = $this->db->query('call nuevo_puesto("'.$nombre.'")');
		$aux = $query->row();
		$dato = $aux->msg;
		return $dato;
	}

	/*
		metodo que edita el nombre de un puesto
	*/
	public function updatePuesto($nombre, $id)
	{
		$this->db->query('call editar_puesto("'.$nombre.'", '.$id.');');
	}

	/*
		metodo que elimina lógicamente un puesto en la base de datos
	*/
	public function deletePuesto($id, $estado)
	{
		$this->db->query('call eliminar_puesto('.$id.', "'.$estado.'");');
	}

	/*
		 metodo que obtien el estado de un puesto en especifico
	*/

	public function getEstadoPuesto($id)
	{
		$query = $this->db->get_where('PUESTO', array('id_puesto'=>$id));
		return $query->result_array();
	}
}

/* End of file Puesto_model.php */
/* Location: ./application/models/Puesto_model.php */