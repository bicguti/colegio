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
		del nivel básico por madurez.
	*/
	public function notas_consolidadoM($bloque, $nivel, $grado, $ciclo)
	{
		$this->db->select('e.codigo_personal_estudiante, e.apellidos_estudiante, e.nombre_estudiante, a.nombre_area, c.total_bloque, g.nombre_grado, n.nombre_nivel, b.nombre_bloque_madurez as nombre_bloque, c.habitos_orden, c.punt_asist');
		$this->db->from('CUADROS_MADUREZ c');
		$this->db->join('ESTUDIANTE e', 'c.id_estudiante = e.id_estudiante', 'inner');
		$this->db->join('ASIGNACION_AREA aa', 'c.id_asignacion_area = aa.id_asignacion_area', 'inner');
		$this->db->join('AREAS a', 'aa.id_area = a.id_area', 'inner');
		$this->db->join('BLOQUE_MADUREZ b', 'c.id_bloque_madurez = b.id_bloque_madurez', 'inner');
		$this->db->join('GRADO g', 'e.id_grado = g.id_grado', 'inner');
		$this->db->join('NIVEL n', 'e.id_nivel = n.id_nivel', 'inner');
		$this->db->where('b.id_bloque_madurez', $bloque);
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

	//metodo para buscar la nomina de estudiantes de un determinado grado  del nivel pre-primario, primario y básico
	public function getNominaEstudiantes($nivel , $grado)
	{
		$this->db->select('e.id_estudiante, e.nombre_estudiante, e.apellidos_estudiante, e.codigo_personal_estudiante');
		$this->db->from('ESTUDIANTE e');
		$this->db->where('e.id_nivel', $nivel);
		$this->db->where('e.id_grado', $grado);
		$this->db->order_by('e.apellidos_estudiante', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	//metodo para buscar la nomina de estudiantes de un determinado grado y carrera del nivel diversificado
	public function getNominaEstudiantesC($grado, $carrera)
	{
		$this->db->select('ec.id_estudiante_carrera as id_estudiante, e.codigo_personal_estudiante, e.apellidos_estudiante, e.nombre_estudiante');
		$this->db->from('ESTUDIANTE_CARRERA ec');
		$this->db->join('ESTUDIANTE e', 'ec.id_estudiante = e.id_estudiante', 'INNER');
		$this->db->where('ec.id_carrera', $carrera);
		$this->db->where('e.id_grado', $grado);
		$this->db->order_by('e.apellidos_estudiante', 'asc');
		$query = $this->db->get();
		return $query->result();
	}
	/*
	SELECT e.id_estudiante, e.apellidos_estudiante, e.nombre_estudiante
FROM ESTUDIANTE_CARRERA ec INNER JOIN ESTUDIANTE e
ON ec.id_estudiante = e.id_estudiante
WHERE ec.id_carrera = 6 AND e.id_grado = 7
ORDER BY e.apellidos_estudiante
	*/

	//metodo para buscar los datos de un grado
	public function getGrado($id)
	{
		$this->db->select('*');
		$this->db->from('GRADO');
		$this->db->where('id_grado', $id);
		$query = $this->db->get();
		return $query->result();
	}

	//metodo para obtener los datos de una carrera
	public function getCarrera($id)
	{
		$this->db->select('*');
		$this->db->from('CARRERA');
		$this->db->where('id_carrera', $id);
		$query = $this->db->get();
		return $query->result();
	}

	//metodo para obtener los datos de un nivel
	public function getNivel($id)
	{
		$this->db->select('*');
		$this->db->from('NIVEL');
		$this->db->where('id_nivel', $id);
		$query = $this->db->get();
		return $query->result();
	}

	//metodo para buscar las notas de un estudiante de un bloque en un area especifica del nivel pre-primario, primario y básico
	public function getNotasBloques($estudiante, $bloque, $asignacion)
	{
		$this->db->select('c.total_bloque');
		$this->db->from('CUADROS c');
		$this->db->where('c.id_bloque', $bloque);
		$this->db->where('c.id_estudiante', $estudiante);
		$this->db->where('c.id_asignacion_area', $asignacion);
		$query = $this->db->get();
		return $query->result();
	}

	//metodo para buscar las notas de un estudiante de un bloque en un area especifica del nivel básico por madurez
	public function getNotasBloquesM($estudiante, $bloque, $asignacion)
	{
		$this->db->select('c.total_bloque');
		$this->db->from('CUADROS_MADUREZ c');
		$this->db->where('c.id_bloque_madurez', $bloque);
		$this->db->where('c.id_estudiante', $estudiante);
		$this->db->where('c.id_asignacion_area', $asignacion);
		$query = $this->db->get();
		return $query->result();
	}

	//metodo para buscar las notas de un estudiante de un bloque en area especifica del nivel diversificado
	public function getNotasBloquesC($estudiante, $bloque, $asignacion)
	{
		$this->db->select('c.total_bloque');
		$this->db->from('CUADROS_CARRERAS c');
		$this->db->where('c.id_bloque', $bloque);
		$this->db->where('c.id_estudiante_carrera', $estudiante);
		$this->db->where('c.id_asignacion_areac', $asignacion);
		$query = $this->db->get();
		return $query->result();
	}
	/*
	SELECT* FROM CUADROS c
WHERE c.id_bloque = 1 AND c.id_estudiante = 90 AND c.id_asignacion_area = 15
	*/

	//metodo para buscar los cursos que tiene asignado un grado de los niveles pre-primario, primario y básico
	public function getCursosGrado($nivel, $grado)
	{
		$this->db->select('aa.id_asignacion_area, a.nombre_area');
		$this->db->from('ASIGNACION_AREA aa');
		$this->db->join('AREAS a', 'aa.id_area = a.id_area', 'INNER');
		$this->db->where('aa.id_nivel', $nivel);
		$this->db->where('aa.id_grado', $grado);
		$query = $this->db->get();
		return $query->result();
	}

	//metodo para buscar los cursos que tiene asignado un grado del nivel diversificado
	public function getCursosGradoC($grado, $carrera)
	{
		$this->db->select('aac.id_asignacion_areac as id_asignacion_area, a.nombre_area');
		$this->db->from('ASIGNACION_AREA_CARRERA aac');
		$this->db->join('GRADO_CARRERA gc', 'aac.id_grado_carrera = gc.id_grado_carrera', 'INNER');
		$this->db->join('AREAS a', 'aac.id_area = a.id_area', 'INNER');
		$this->db->where('gc.id_grado', $grado);
		$this->db->where('gc.id_carrera', $carrera);
		$query = $this->db->get();
		return $query->result();
	}
	/*
	SELECT aac.id_asignacion_areac, a.nombre_area
FROM ASIGNACION_AREA_CARRERA aac INNER JOIN GRADO_CARRERA gc
ON aac.id_grado_carrera = gc.id_grado_carrera INNER JOIN AREAS a
ON aac.id_area = a.id_area
WHERE gc.id_grado = 6 AND gc.id_carrera = 6
	*/
}

/* End of file Consolidados_model.php */
/* Location: ./application/models/Consolidados_model.php */
