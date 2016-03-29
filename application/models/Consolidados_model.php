<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consolidados_model extends CI_Model {

	/*
		metodo que se encarga de extrar los datos para generar el cuadro
		de consolidado de un bloque determinado de un ciclo academico
		del nivel pre-primario, primario y básico.
	*/
	public function notas_consolidado($bloque, $nivel, $grado, $ciclo)
	{
		$this->db->select('e.codigo_personal_estudiante, e.apellidos_estudiante, e.nombre_estudiante, a.nombre_area, c.total_bloque, g.nombre_grado, n.nombre_nivel, b.nombre_bloque, c.habitos_orden, c.punt_asist');
		$this->db->from('CUADROS c');
		$this->db->join('ESTUDIANTE e', 'c.id_estudiante = e.id_estudiante', 'inner');
		$this->db->join('ASIGNACION_AREA aa', 'c.id_asignacion_area = aa.id_asignacion_area', 'inner');
		$this->db->join('AREAS a', 'aa.id_area = a.id_area', 'inner');
		$this->db->join('BLOQUE b', 'c.id_bloque = b.id_bloque', 'inner');
		$this->db->join('GRADO g', 'e.id_grado = g.id_grado', 'inner');
		$this->db->join('NIVEL n', 'e.id_nivel = n.id_nivel', 'inner');
		$this->db->where('b.id_bloque', $bloque);
		$this->db->where('e.id_nivel', $nivel);
		$this->db->where('e.id_grado', $grado);
		$this->db->where('c.ciclo_academico', $ciclo);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo que se encarga de extrar los datos para generar el cuadro
		de consolidado de un bloque determinado de un ciclo academico
		del nivel pre-primario, primario y básico.
	*/

	public function notas_consolidadoC($bloque, $grado, $ciclo, $carrera)
	{
		$this->db->select('e.id_estudiante,e.codigo_personal_estudiante, e.apellidos_estudiante, e.nombre_estudiante, cc.total_bloque, a.nombre_area, g.nombre_grado, c.nombre_carrera, b.nombre_bloque, cc.punt_asist, cc.habitos_orden');
		$this->db->from('CUADROS_CARRERAS cc');
		$this->db->join('ESTUDIANTE_CARRERA ec', 'cc.id_estudiante_carrera = ec.id_estudiante_carrera', 'inner');
		$this->db->join('ESTUDIANTE e', 'ec.id_estudiante = e.id_estudiante', 'inner');
		$this->db->join('GRADO g', 'e.id_grado = g.id_grado', 'inner');
		$this->db->join('CARRERA c', 'ec.id_carrera = c.id_carrera', 'inner');
		$this->db->join('BLOQUE b', 'cc.id_bloque = b.id_bloque', 'inner');
		$this->db->join('ASIGNACION_AREA_CARRERA aac', 'cc.id_asignacion_areac = aac.id_asignacion_areac', 'inner');
		$this->db->join('AREAS a', 'aac.id_area = a.id_area', 'inner');
		$this->db->where('e.id_grado', $grado);
		$this->db->where('c.id_carrera', $carrera);
		$this->db->where('cc.id_bloque', $bloque);
		$this->db->where('cc.ciclo_academico', $ciclo);
		$query = $this->db->get();
		return $query->result_array();
	}

}

/* End of file Consolidados_model.php */
/* Location: ./application/models/Consolidados_model.php */
