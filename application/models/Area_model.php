<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area_model extends CI_Model {
	public function setArea($nombre, $tipoarea)
	{
		$query = $this->db->query('call nueva_area("'.$nombre.'", '.$tipoarea.');');
		$aux = $query->row();
		$dato = $aux->msg;
		$query->next_result();
		return $dato;
	}
	
	/*
		metodo que obtiene unicamente las areas que tienen el estado true
	*/
	public function getArea()
	{
		$query = $this->db->get_where('AREAS', array('estado_area'=>TRUE));
		return $query->result_array();
	}

	public function getListadoarea()
	{
		$query = $this->db->query('select a.id_area, a.nombre_area, a.estado_area,t.nombre_tipo_area from AREAS a inner join TIPO_AREA t
on a.id_tipo_area = t.id_tipo_area');
		return $query->result_array();
	}

	/*
		metodo que busca los datos de un area para se editado
	*/
	public function buscar_area($area)
	{
		$query = $this->db->get_where('AREAS', array('id_area'=>$area));
		return $query->result_array();
	}

	/*
		metodo para guardar los datos editados de una área en la base de datos.
	*/
	public function updateArea($area, $nombre, $tipo)
	{
		$this->db->query('call editar_area('.$area.', "'.$nombre.'", '.$tipo.');');
	}

	/*
		metodo que obtiene todas las areas no importando su estado
	*/
	public function getTAreas()
	{
		$query = $this->db->get('AREAS');
		return $query->result_array();
	}

	/*
		metodo para cambiar el estado de un área en la base de datos
	*/
	public function deleteArea($id, $estado)
	{
		$this->db->query('call eliminar_area('.$id.', "'.$estado.'");');
	}
}

/* End of file Area_model.php */
/* Location: ./application/models/Area_model.php */