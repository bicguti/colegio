<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grado_model extends CI_Model {
	public function getGrado()
	{
		$query = $this->db->get('GRADO');
		return $query->result_array();
	}

	public function findPreprimaria()//Selecciona unicamente los grados párvulos y preparatoria
	{
		$query = $this->db->query('select* from GRADO where nombre_grado = "párvulos" or nombre_grado = "preparatoria";');
		return $query->result_array();
	}
	public function findPrimaria()//Selecciona unicamente los grados de primero a sexto.
	{
		$query = $this->db->query('select* from GRADO where nombre_grado != "párvulos" and nombre_grado != "preparatoria";');
		return $query->result_array();
	}
	public function findBasico()//Selecciona unicamente los grados de primero a sexto
	{
		$query = $this->db->query('select* from GRADO where nombre_grado = "primero" or nombre_grado = "segundo" or nombre_grado = "tercero";');
		return $query->result_array();
	}
	public function findDiversificado()//Selecciona unicamento los grados de cuarto a sexto
	{
		$query = $this->db->query('select* from GRADO where nombre_grado = "cuarto" or nombre_grado = "quinto" or nombre_grado = "sexto";');
		return $query->result_array();
	}

	public function findDiversificado2()
	{
		$query = $this->db->query('select* from GRADO where nombre_grado = "cuarto" or nombre_grado = "quinto";');
		return $query->result_array();
	}

	/* obtener el nombre de grado por su ID*/
	public function getNombreGrado($id)
	{
		$this->db->select('g.nombre_grado');
		$this->db->from('GRADO g');
		$this->db->where('g.id_grado', $id);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*metodo para obtener los grados de básico por madurez*/
	public function findMadurez()
	{
		$query = $this->db->query('select* from GRADO where nombre_grado = "primero" or nombre_grado = "segundo";');
		return $query->result_array();
	}
}

/* End of file Grado_model.php */
/* Location: ./application/models/Grado_model.php */
