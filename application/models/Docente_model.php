<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Docente_model extends CI_Model {
	/*
	 metodo que busca a todos los docentes que esten habilitados para elegirlos como guías
	*/
	public function getDocente($ape)
	{
		$this->db->select('pe.nombre_persona, pe.apellidos_persona, p.nombre_puesto, pe.id_persona');
		$this->db->from('PERSONA pe');
		$this->db->join('PUESTO p', 'pe.id_puesto = p.id_puesto', 'inner');
		$this->db->like('pe.apellidos_persona', $ape, 'after');
		$this->db->where('p.nombre_puesto', 'docente');
		$this->db->where('pe.estado_persona', true);
		$query = $this->db->get();
		return $query->result_array();
	}
	/*
		metodo para agregar un nuevo docente guia o titular de los niveles
		de pre-primaria, primaria y básico, en la base de datos
	*/
	public function setGuia($persona, $nivel, $grado)
	{
		$this->db->query('call nuevo_guia_titular('.$persona.', '.$nivel.', '.$grado.');');
	}

	/*
		metodo para agregar un nuevo docente guia del nivel
		de diversificado de una carrera en especifico, en la base de datos
	*/
	public function setGuiaC($persona, $gradocarrera)
	{
		$this->db->query('call nuevo_guia_carrera('.$persona.', '.$gradocarrera.');');
	}

	/*
		obtiene el nivel y grado donde el docente logueado en el sistema es
		 titular de un grado de pre-primaria, primario o básico
	*/
	public function getTitular($persona)
	{
		$this->db->select('n.id_nivel, g.id_grado, n.nombre_nivel, g.nombre_grado');
		$this->db->from('GUIAS_TITULARES gt');
		$this->db->join('NIVEL n', 'gt.id_nivel = n.id_nivel', 'inner');
		$this->db->join('GRADO g', 'gt.id_grado = g.id_grado', 'inner');
		$this->db->where('gt.id_persona', $persona);
		$this->db->where('gt.estado_gt', TRUE);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		obtiene el grado y carrera donde el docente logueado en el sistema es
		 guía
	*/
	public function getTitularC($persona)
	{
		$this->db->select('g.id_grado, c.id_carrera, g.nombre_grado, c.nombre_carrera');
		$this->db->from('GUIAS_CARRERAS gc');
		$this->db->join('GRADO_CARRERA gyc', 'gc.id_grado_carrera = gyc.id_grado_carrera', 'inner');
		$this->db->join('GRADO g', 'gyc.id_grado = g.id_grado', 'inner');
		$this->db->join('CARRERA c', 'gyc.id_carrera = c.id_carrera', 'inner');
		$this->db->where('gc.id_persona', $persona);
		$this->db->where('gc.estado_gc', TRUE);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo que obtiene los nombres y apellidos del docente guia
		de un grado y carrera del nivel diversificado
	*/
	public function getNombresGuiaC($grado, $carrera)
	{
		$this->db->select('p.apellidos_persona, p.nombre_persona');
		$this->db->from('GUIAS_CARRERAS guc');
		$this->db->join('GRADO_CARRERA gc', 'guc.id_grado_carrera = gc.id_grado_carrera', 'inner');
		$this->db->join('PERSONA p', 'guc.id_persona = p.id_persona', 'inner');
		$this->db->where('gc.id_grado', $grado);
		$this->db->where('gc.id_carrera', $carrera);
		$this->db->where('guc.estado_gc', TRUE);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo para obtener los nombres y apellidos del docente guía de un
		grado del nivel básico, primario o pre-primaria.
	*/
	public function getNombresGuia($grado, $nivel)
	{
		$this->db->select('p.apellidos_persona, p.nombre_persona');
		$this->db->from('GUIAS_TITULARES gt');
		$this->db->join('PERSONA p', 'gt.id_persona = p.id_persona', 'inner');
		$this->db->where('gt.id_nivel', $nivel);
		$this->db->where('gt.id_grado', $grado);
		$this->db->where('gt.estado_gt', TRUE);
		$query = $this->db->get();
		return $query->result_array();
	}
}

/* End of file Docente_model.php */
/* Location: ./application/models/Docente_model.php */
