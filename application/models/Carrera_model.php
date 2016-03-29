<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carrera_model extends CI_Model {
	public function idNivelplan($plan, $nivel)
	{
		$query = $this->db->query('select id_nivel_plan as id from NIVEL n inner join NIVEL_PLAN np
on n.id_nivel = np.id_nivel
inner join PLAN p
on p.id_plan = np.id_plan
where p.id_plan = '.$plan.' and n.id_nivel = '.$nivel);
		$aux = $query->row();
		$dato=$aux->id;
		return $dato;
	}
	public function setCarrera($nombre, $nivel)
	{
		$query = $this->db->query('call nueva_carrera("'.$nombre.'",'.$nivel.');');
		$aux = $query->row();
		$dato = $aux->msg;
		return $dato;
	}

	public function getCarrera()//obtiene todas las carrera registradas en la base de datos y que tengan el estado true
	{
		$query = $this->db->get_where('CARRERA', array('estado_carrera'=>true));
		return $query->result_array();
	}

	/*
		metodo que obtiene todas las carreras registradas en la base de datos independientemente
		de su estado
	*/
	public function getTCarreras()
	{
		$query = $this->db->get('CARRERA');
		return $query->result_array();
	}

	/*
		metodo para buscar los datos de una carrera que se encuentra activa
	*/
	public function buscarCarrera($carrera)
	{
		$this->db->select('c.nombre_carrera, np.id_plan, c.estado_carrera');
		$this->db->from('CARRERA c');
		$this->db->join('NIVEL_PLAN np', 'c.id_nivel_plan = np.id_nivel_plan', 'inner');
		$this->db->where('c.id_carrera', $carrera);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo para editar los datos de una carrera
	*/
	public function updateCarrera($carrera, $nombre, $plan)
	{
		$this->db->query('call editar_carrera('.$carrera.', "'.$nombre.'", '.$plan.');');
	}

	/*
		metodo para cambiar el estado de una carrera
	*/
	public function deleteCarrera($carrera, $estado)
	{
		$this->db->query('call eliminar_carrera('.$carrera.', "'.$estado.'");');
	}
}

/* End of file Carrera_model.php */
/* Location: ./application/models/Carrera_model.php */