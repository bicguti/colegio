<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Puntos_model extends CI_Model {
	public function getPuntos($asigarea)
	{
		$this->db->select('*');
		$this->db->from('PUNTOS p');
		$this->db->join('CUADROS c', 'p.id_cuadros = c.id_cuadros', 'inner');
		$this->db->where('c.id_asignacion_area', $asigarea);
		$query = $this->db->get();
		return $query->resulta_array();
	}

	/*
		Metodo que busca el identificador de los cuadro que han sido creados para el nivel
		pre-primario, primario y básico
	*/
	public function findIdCuadros($asigarea, $fecha, $anio)
	{
		$this->db->select('c.id_cuadros');
		$this->db->from('CUADROS c');
		$this->db->join('BLOQUE b', 'c.id_bloque = b.id_bloque', 'inner');
		$this->db->join('FECHA_DISPONIBLE fd', 'b.id_bloque = fd.id_bloque', 'inner');
		$this->db->where('c.id_asignacion_area', $asigarea);
		$this->db->where('fd.fecha_inicio <=', $fecha);
		$this->db->where('fd.fecha_final >=', $fecha);
		$this->db->where('c.ciclo_academico', $anio);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		Metodo que busca el identificador de los cuadros que han sido creados para el nivel
		diversificado
	*/
	public function findIdCuadrosC($asignarea, $fecha, $anio)
	{
		$this->db->select('cc.id_cuadros_carreras');
		$this->db->from('CUADROS_CARRERAS cc ');
		$this->db->join('BLOQUE b', 'cc.id_bloque = b.id_bloque', 'inner');
		$this->db->join('FECHA_DISPONIBLE fd', 'b.id_bloque = fd.id_bloque', 'inner');
		$this->db->where('cc.id_asignacion_areac', $asignarea);
		$this->db->where('cc.ciclo_academico', $anio);
		$this->db->where('fd.fecha_inicio <=', $fecha);
		$this->db->where('fd.fecha_final >=', $fecha);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
	*  Metodo que busca si existe en la tabla PUNTOS si ya fue creado los puntos
	* esto es para el nivel pre-primario, primario y básico
	*/
	public function existe_notas($asigarea, $fecha)
	{
		$this->db->select('*');
		$this->db->from('CUADROS c');
		$this->db->join('PUNTOS p', 'c.id_cuadros = p.id_cuadros', 'inner');
		$this->db->join('BLOQUE b', 'c.id_bloque = b.id_bloque', 'inner');
		$this->db->join('FECHA_DISPONIBLE fd', 'b.id_bloque = fd.id_bloque', 'inner');
		$this->db->where('c.id_asignacion_area', $asigarea);
		$this->db->where('fd.fecha_inicio <=', $fecha);
		$this->db->where('fd.fecha_final >=', $fecha);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
	*  Metodo que busca si existe en la tabla PUNTOS_CARRERA si ya fue creado los puntos
	* esto es para el nivel diversificado
	*/
	public function existe_notasc($asignarea, $fecha)
	{
		$this->db->select('*');
		$this->db->from('CUADROS_CARRERAS cc');
		$this->db->join('PUNTOS_CARRERA pc', 'cc.id_cuadros_carreras = pc.id_cuadros_carreras', 'inner');
		$this->db->join('BLOQUE b', 'cc.id_bloque = b.id_bloque', 'inner');
		$this->db->join('FECHA_DISPONIBLE fd', 'b.id_bloque = fd.id_bloque', 'inner');
		$this->db->where('cc.id_asignacion_areac', $asignarea);
		$this->db->where('fd.fecha_inicio <=', $fecha);
		$this->db->where('fd.fecha_final >=', $fecha);
		$query = $this->db->get();
		return $query->result_array();

	}

	/*
		agrega un nuevo nombre de acreditacion para el nivel pre-primariop, primario, básico y diversificado
	*/
	public function setNuevaAcreditacion($nombre)
	{
		$query = $this->db->query('call nueva_acreditacion("'.$nombre.'")');
		$aux = $query->row();
		$temp = $aux->id;
		$query->next_result();
		return $temp;
	}

	/*
		crea la asignacion de puntos para el nivel pre-prmario, primario y básico.
	*/
	public function setNuevosPuntos($cuadro, $acreditacion)
	{
		$this->db->query('call nuevos_puntos('.$cuadro.', '.$acreditacion.');');
	}

	/*
		Crea la asignacon de puntos para el nivel diversificado
	*/
	public function setNuevosPuntosC($cuadro, $acreditacion)
	{
		$this->db->query('call nuevos_puntos_c('.$acreditacion.', '.$cuadro.');');
	}

	/*
		actualiza los puntos del estudiante en un determinado bloque y area
		del nivel pre-primario, primario y básico
	*/
	public function agregar_puntos($idPuntos, $puntos)
	{
		$this->db->query('call agregar_puntos('.$idPuntos.', '.$puntos.');');
	}

	/*
		actuliza los puntos del estudiante en un determinado bloque y area
		del nivel diversificado
	*/
	public function agregar_puntosc($idPuntos, $puntos)
	{
		$this->db->query('call agregar_puntos_c('.$idPuntos.', '.$puntos.');');
	}

	/*
		Metodo que busca el identificador de cada punto asignado al estudiante
		en un ciclo academico y en un determinado bloque del nivel
		pre-primario, primario y básico.
	*/
	public function findNotasEstudiante($asignarea, $ciclo, $estudiante, $bloque)
	{
		$this->db->select('p.id_puntos, ab.nombre_acreditacion, e.id_nivel, p.puntos_acreditacion');
		$this->db->from('CUADROS c');
		$this->db->join('PUNTOS p', 'c.id_cuadros = p.id_cuadros', 'inner');
		$this->db->join('ACREDITACIONES_BLOQUE ab', 'p.id_acreditacion = ab.id_acreditacion', 'inner');
		$this->db->join('ESTUDIANTE e', 'c.id_estudiante = e.id_estudiante', 'inner');
		$this->db->where('c.id_asignacion_area', $asignarea);
		$this->db->where('c.ciclo_academico', $ciclo);
		$this->db->where('c.id_estudiante', $estudiante);
		$this->db->where('c.id_bloque', $bloque);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		Metodo que busca el identificador de cada punto asignado al estuudiante
		en un ciclo academico y en un determinado bloque del nivel
		diversificado.
	*/
	public function findNotasEstudianteC($asignarea, $ciclo, $estudiante, $bloque)
	{
		$this->db->select('pc.id_puntos_carrera as id_puntos, ab.nombre_acreditacion, e.id_nivel, pc.puntos_acreditacion');
		$this->db->from('CUADROS_CARRERAS cc');
		$this->db->join('PUNTOS_CARRERA pc', 'cc.id_cuadros_carreras = pc.id_cuadros_carreras', 'inner');
		$this->db->join('ACREDITACIONES_BLOQUE ab', 'pc.id_acreditacion = ab.id_acreditacion', 'inner');
		$this->db->join('ESTUDIANTE_CARRERA ec', 'cc.id_estudiante_carrera = ec.id_estudiante_carrera', 'inner');
		$this->db->join('ESTUDIANTE e', 'ec.id_estudiante = e.id_estudiante', 'inner');
		$this->db->join('BLOQUE b', 'cc.id_bloque = b.id_bloque', 'inner');
		$this->db->where('e.id_estudiante', $estudiante);
		$this->db->where('cc.id_asignacion_areac', $asignarea);
		$this->db->where('cc.ciclo_academico', $ciclo);
		$this->db->where('b.id_bloque', $bloque);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo para editar los registros de puntualidad y habitos de un estudiante
		de nivel pre-primario, primario y básico
	*/
	public function update_punt_habitos($cuadro, $puntualidad, $habitos)
	{
		$this->db->query('call nueva_punt_habitos('.$cuadro.', "'.$puntualidad.'", "'.$habitos.'");');
	}

	/*
		metodo para editar los registros de puntualidad y hábitos de un estudiante
		del nivel diversificado
	*/
	public function update_punt_habitosC($cuadro, $puntualidad, $habitos)
	{
		$this->db->query('call nueva_punt_habitosC('.$cuadro.', "'.$puntualidad.'", "'.$habitos.'");');
	}

	/*
		metodo que obtiene el nombre de todas las acreditaciones de un bloque, área, grado y del ciclo academico actual
		para que puedan editarse, del nivel pre-primario, primario y básico
	*/
	public function getAcreditaciones($asignarea, $ciclo, $fecha)
	{
		$this->db->select('ab.id_acreditacion, ab.nombre_acreditacion');
		$this->db->from('ACREDITACIONES_BLOQUE ab');
		$this->db->join('PUNTOS p', 'ab.id_acreditacion = p.id_acreditacion', 'inner');
		$this->db->join('CUADROS c', 'p.id_cuadros = c.id_cuadros', 'inner');
		$this->db->join('ASIGNACION_AREA aa', 'c.id_asignacion_area = aa.id_asignacion_area', 'inner');
		$this->db->join('FECHA_DISPONIBLE fd', 'c.id_bloque = fd.id_bloque', 'inner');
		$this->db->where('aa.id_asignacion_area', $asignarea);
		$this->db->where('c.ciclo_academico', $ciclo);
		$this->db->where('fd.fecha_inicio <=', $fecha);
		$this->db->where('fd.fecha_final >=', $fecha);
		$this->db->group_by('ab.id_acreditacion');
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo que obtine el nombre de todas las acreditaciones de un bloque, área, grado y carrera del
		ciclo academico actuañ, para poder ser editado del niel diversificado
	*/
	public function getAcreditacionesC($asignarea, $ciclo, $fecha)
	{
		$this->db->select('ab.id_acreditacion, ab.nombre_acreditacion');
		$this->db->from('ACREDITACIONES_BLOQUE ab');
		$this->db->join('PUNTOS_CARRERA pc', 'ab.id_acreditacion = pc.id_acreditacion', 'inner');
		$this->db->join('CUADROS_CARRERAS cc', 'pc.id_cuadros_carreras = cc.id_cuadros_carreras', 'inner');
		$this->db->join('ASIGNACION_AREA_CARRERA aac', 'cc.id_asignacion_areac = aac.id_asignacion_areac', 'inner');
		$this->db->join('FECHA_DISPONIBLE fd', 'cc.id_bloque = fd.id_bloque', 'inner');
		$this->db->where('cc.id_asignacion_areac', $asignarea);
		$this->db->where('cc.ciclo_academico', $ciclo);
		$this->db->where('fd.fecha_inicio <=', $fecha);
		$this->db->where('fd.fecha_final >=', $fecha);
		$this->db->group_by('ab.id_acreditacion');
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo para actualizar el nombre de una acreditación
	*/
	public function updateAcreditacion($id, $nombre)
	{
		$this->db->query('call editar_nombre_acreditacion('.$id.', "'.$nombre.'");');
	}

	/*
		metodo que busca todas las notas totales en cada area de un determinado bloque,
		para una determinada carrera y un grado del nivel diversificado
	*/
	public function getTotalBC($carrera, $bloque, $ciclo, $grado)
	{
	/*	$this->db->select('ec.id_estudiante, a.nombre_area, cc.total_bloque, cc.punt_asist, cc.habitos_orden');
		$this->db->from('CUADROS_CARRERAS cc');
		$this->db->join('ESTUDIANTE_CARRERA ec', 'cc.id_estudiante_carrera = ec.id_estudiante_carrera', 'inner');
		$this->db->join('CARRERA c', 'ec.id_carrera = c.id_carrera', 'inner');
		$this->db->join('ASIGNACION_AREA_CARRERA aac', 'cc.id_asignacion_areac = aac.id_asignacion_areac', 'inner');
		$this->db->join('AREAS a', 'aac.id_area = a.id_area', 'inner');
		$this->db->join('GRADO_CARRERA gc', 'c.id_carrera = gc.id_carrera', 'inner');
		$this->db->join('GRADO g', 'gc.id_grado = g.id_grado', 'inner');
		$this->db->where('gc.id_carrera', $carrera);
		$this->db->where('cc.id_bloque', $bloque);
		$this->db->where('cc.ciclo_academico', $ciclo);
		$this->db->where('gc.id_grado', $grado);*/
		$this->db->select('ec.id_estudiante, a.nombre_area, cc.total_bloque, cc.punt_asist, cc.habitos_orden');
		$this->db->from('CUADROS_CARRERAS cc');
		$this->db->join('PUNTOS_CARRERA pc', 'cc.id_cuadros_carreras = pc.id_cuadros_carreras', 'inner');
		$this->db->join('ACREDITACIONES_BLOQUE ab', 'pc.id_acreditacion = ab.id_acreditacion', 'inner');
		$this->db->join('ESTUDIANTE_CARRERA ec', 'cc.id_estudiante_carrera = ec.id_estudiante_carrera', 'inner');
		$this->db->join('CARRERA c', 'ec.id_carrera = c.id_carrera', 'inner');
		$this->db->join('ESTUDIANTE e', 'ec.id_estudiante = e.id_estudiante', 'inner');
		$this->db->join('ASIGNACION_AREA_CARRERA aac', 'cc.id_asignacion_areac = aac.id_asignacion_areac', 'inner');
		$this->db->join('AREAS a', 'aac.id_area = a.id_area', 'inner');
		$this->db->where('c.id_carrera', $carrera);
		$this->db->where('cc.id_bloque', $bloque);
		$this->db->where('e.id_grado', $grado);
		$this->db->where('cc.ciclo_academico', $ciclo);
		$query = $this->db->get();
		return $query->result_array();
	}
	/*
		metodo que busca todas las notas totales en cada area de un determinado bloque,
		para un determinada grado del nivel básico
	*/
	public function getTotalBB($bloque, $ciclo, $grado, $nivel)
	{
		$this->db->select('c.id_estudiante, a.nombre_area, c.total_bloque, c.punt_asist, c.habitos_orden');
		$this->db->from('CUADROS c');
		$this->db->join('ASIGNACION_AREA aa', 'c.id_asignacion_area = aa.id_asignacion_area', 'inner');
		$this->db->join('AREAS a', 'aa.id_area = a.id_area', 'inner');
		$this->db->join('ESTUDIANTE e', 'c.id_estudiante = e.id_estudiante', 'inner');
		$this->db->where('e.id_grado', $grado);
		$this->db->where('c.ciclo_academico', $ciclo);
		$this->db->where('c.id_bloque', $bloque);
		$this->db->where('e.id_nivel', $nivel);
		$query = $this->db->get();
		return $query->result_array();
	}

}

/* End of file Puntos_model.php */
/* Location: ./application/models/Puntos_model.php */
