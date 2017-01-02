<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fechadisponible_model extends CI_Model {
	public function setFechadisponible($inicio, $fin, $bloque)//Agrega las fechas en las que estaran disponibles las fechas de subida de notas de cada bloque
	{
		$query = $this->db->query('call nueva_fechadisponible("'.$inicio.'", "'.$fin.'",'.$bloque.');');
	}

	public function getFechaDisponible()
	{
		$query = $this->db->get('FECHA_DISPONIBLE');
		return $query->result_array();
	}

	/*
		Metodo para obtener las fechas disponibles del nivel básico por madurez
	*/
	public function getFechaDisponibleM()
	{
		$query = $this->db->get('FECHA_DISPONIBLE_MADUREZ');
		return $query->result_array();
	}

	/*
			actualizar las fechas del calendario del nivel básico por madurez
	*/
	public function setFechadisponibleM($inicio, $fin, $bloque)//Agrega las fechas en las que estaran disponibles las fechas de subida de notas de cada bloque
	{
		$query = $this->db->query('call nueva_fechadisponibleM("'.$inicio.'", "'.$fin.'",'.$bloque.');');
	}

}

/* End of file Fechadisponible.php */
/* Location: ./application/models/Fechadisponible.php */
