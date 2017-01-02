<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cuadros_model extends CI_Model {
	public function setCuadrosPB($estudiante, $bloque, $asignacion, $ciclo)//crea un nuevo registro para el cuadro de estudiante del nivel preprimario, primario y básico
	{
		$query = $this->db->query('call nuevo_cuadroPB('.$estudiante.','.$bloque.','.$asignacion.', "'.$ciclo.'");');
	}

	/*
		Metodo para crear un cuadro del nivel básico por madurez del ciclo academico actual
	*/

	public function setCuadrosBM($estudiante, $bloque, $asignacion, $ciclo)
	{
		$query = $this->db->query('call nuevo_cuadroBM('.$estudiante.','.$bloque.','.$asignacion.',"'.$ciclo.'");');
	}

	public function setCuadrosD($asignacionarea, $bloque, $estudiantecarrera, $ciclo)//crea un nuevo registro para el cuadro de estudiantes del nivel diversificado
	{
		$query = $this->db->query('call nuevo_cuadroD('.$asignacionarea.', '.$bloque.', '.$estudiantecarrera.', "'.$ciclo.'");');
	}

	/**
	* Metodo que busca a todos los estudiantes que tienen el curso asignado que se especidifca
	* en el parametro del metodo, esto es para el nivel pre-primario, primario y básico
	**/
	public function findEstudiantes($id, $fecha, $ciclo)
	{
		$this->db->select('b.id_bloque, e.id_estudiante, c.id_asignacion_area, e.nombre_estudiante, e.apellidos_estudiante, a.nombre_area, b.nombre_bloque, e.id_nivel');
		$this->db->from('CUADROS c');
		$this->db->join('BLOQUE b', 'c.id_bloque = b.id_bloque', 'inner');
		$this->db->join('FECHA_DISPONIBLE fd', 'b.id_bloque = fd.id_bloque', 'inner');
		$this->db->join('ESTUDIANTE e', 'c.id_estudiante = e.id_estudiante', 'inner');
		$this->db->join('ASIGNACION_AREA aa', 'c.id_asignacion_area = aa.id_asignacion_area', 'inner');
		$this->db->join('AREAS a', 'aa.id_area = a.id_area', 'inner');
		$this->db->where('fd.fecha_inicio <=', $fecha);
		$this->db->where('fd.fecha_final >=', $fecha);
		$this->db->where('c.id_asignacion_area', $id);
		$this->db->where('c.ciclo_academico', $ciclo);
		$this->db->order_by('e.apellidos_estudiante', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	/**
	* Metodo que busca a todos los estudiantes que tienen el curso asignado que se especidifca
	* en el parametro del metodo, esto es para el nivel básico por madurez
	**/
	public function findEstudiantesM($id, $fecha, $ciclo)
	{
		$this->db->select('b.id_bloque_madurez as id_bloque, e.id_estudiante, c.id_asignacion_area, e.nombre_estudiante, e.apellidos_estudiante, a.nombre_area, b.nombre_bloque_madurez as nombre_bloque, e.id_nivel');
		$this->db->from('CUADROS_MADUREZ c');
		$this->db->join('BLOQUE_MADUREZ b', 'c.id_bloque_madurez = b.id_bloque_madurez', 'inner');
		$this->db->join('FECHA_DISPONIBLE_MADUREZ fd', 'b.id_bloque_madurez = fd.id_bloque_madurez', 'inner');
		$this->db->join('ESTUDIANTE e', 'c.id_estudiante = e.id_estudiante', 'inner');
		$this->db->join('ASIGNACION_AREA aa', 'c.id_asignacion_area = aa.id_asignacion_area', 'inner');
		$this->db->join('AREAS a', 'aa.id_area = a.id_area', 'inner');
		$this->db->where('fd.fecha_inicio_madurez <=', $fecha);
		$this->db->where('fd.fecha_final_madurez >=', $fecha);
		$this->db->where('c.id_asignacion_area', $id);
		$this->db->where('c.ciclo_academico', $ciclo);
		$this->db->order_by('e.apellidos_estudiante', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	/**
	* Metodo que busca a todos los estudiantes que tienen el curso asignado que se especifica
	* en el parametro del metodo, esto es para el nivel diversificado
	**/
	public function findEstudiantesC($id, $fecha, $ciclo)
	{
		$this->db->select('b.id_bloque, e.id_estudiante, cc.id_asignacion_areac, e.nombre_estudiante, e.apellidos_estudiante, a.nombre_area, b.nombre_bloque, e.id_nivel');
		$this->db->from('CUADROS_CARRERAS cc');
		$this->db->join('ESTUDIANTE_CARRERA ec', 'cc.id_estudiante_carrera = ec.id_estudiante_carrera', 'inner');
		$this->db->join('ESTUDIANTE e', 'ec.id_estudiante = e.id_estudiante', 'inner');
		$this->db->join('ASIGNACION_AREA_CARRERA aac', 'cc.id_asignacion_areac = aac.id_asignacion_areac', 'inner');
		$this->db->join('AREAS a', 'aac.id_area = a.id_area', 'inner');
		$this->db->join('BLOQUE b', 'cc.id_bloque = b.id_bloque', 'inner');
		$this->db->join('FECHA_DISPONIBLE fd', 'b.id_bloque = fd.id_bloque', 'inner');
		$this->db->where('cc.id_asignacion_areac = ', $id);
		$this->db->where('fd.fecha_inicio <=', $fecha);
		$this->db->where('fd.fecha_final >=', $fecha);
		$this->db->where('cc.ciclo_academico', $ciclo);
		$this->db->order_by('e.apellidos_estudiante', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo que busca los cuadros pertenecientes a un estudiante en un determinado bloque,
		del nivel pre-primaria, primaria y básico.
	*/
	public function findCuadrosEstudiantes($asignarea, $fecha, $anio)
	{
		$this->db->select('a.nombre_area, e.id_estudiante, e.nombre_estudiante, e.apellidos_estudiante, b.id_bloque, b.nombre_bloque, c.id_asignacion_area, e.id_nivel');
		$this->db->from('CUADROS c');
		$this->db->join('ESTUDIANTE e', 'c.id_estudiante = e.id_estudiante', 'inner');
		$this->db->join('BLOQUE b', 'c.id_bloque = b.id_bloque', 'inner');
		$this->db->join('FECHA_DISPONIBLE fd', 'b.id_bloque = fd.id_bloque', 'inner');
		$this->db->join('ASIGNACION_AREA aa', 'c.id_asignacion_area = aa.id_asignacion_area', 'inner');
		$this->db->join('AREAS a', 'aa.id_area = a.id_area', 'inner');
		$this->db->where('c.id_asignacion_area', $asignarea);
		$this->db->where('fd.fecha_inicio <=', $fecha);
		$this->db->where('fd.fecha_final >=', $fecha);
		$this->db->where('c.ciclo_academico', $anio);
		$this->db->order_by('e.apellidos_estudiante', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo que busca los cuadros pertenecientes a un estudiante en un determinado bloque,
		del básico madurez.
	*/
	public function findCuadrosEstudiantesM($asignarea, $fecha, $anio)
	{
		$this->db->select('a.nombre_area, e.id_estudiante, e.nombre_estudiante, e.apellidos_estudiante, b.id_bloque_madurez as id_bloque, b.nombre_bloque_madurez as nombre_bloque, c.id_asignacion_area, e.id_nivel');
		$this->db->from('CUADROS_MADUREZ c');
		$this->db->join('ESTUDIANTE e', 'c.id_estudiante = e.id_estudiante', 'inner');
		$this->db->join('BLOQUE_MADUREZ b', 'c.id_bloque_madurez = b.id_bloque_madurez', 'inner');
		$this->db->join('FECHA_DISPONIBLE_MADUREZ fd', 'b.id_bloque_madurez = fd.id_bloque_madurez', 'inner');
		$this->db->join('ASIGNACION_AREA aa', 'c.id_asignacion_area = aa.id_asignacion_area', 'inner');
		$this->db->join('AREAS a', 'aa.id_area = a.id_area', 'inner');
		$this->db->where('c.id_asignacion_area', $asignarea);
		$this->db->where('fd.fecha_inicio_madurez <=', $fecha);
		$this->db->where('fd.fecha_final_madurez >=', $fecha);
		$this->db->where('c.ciclo_academico', $anio);
		$this->db->order_by('e.apellidos_estudiante', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo que busca los cuadros pertenecientes a un estudiante en un determinado bloque
		del nivel diversificado
	*/
	public function findCuadrosEstudiantesC($asignarea, $fecha, $anio)
	{
		$this->db->select('a.nombre_area, e.id_estudiante, e.nombre_estudiante, e.apellidos_estudiante, b.id_bloque, b.nombre_bloque, cc.id_asignacion_areac as id_asignacion_area, e.id_nivel');
		$this->db->from('CUADROS_CARRERAS cc');
		$this->db->join('ESTUDIANTE_CARRERA ec', 'cc.id_estudiante_carrera = ec.id_estudiante_carrera', 'inner');
		$this->db->join('ESTUDIANTE e', 'ec.id_estudiante = e.id_estudiante', 'inner');
		$this->db->join('ASIGNACION_AREA_CARRERA aac', 'cc.id_asignacion_areac = aac.id_asignacion_areac', 'inner');
		$this->db->join('AREAS a', 'aac.id_area = a.id_area', 'inner');
		$this->db->join('BLOQUE b', 'cc.id_bloque = b.id_bloque', 'inner');
		$this->db->join('FECHA_DISPONIBLE fd', 'b.id_bloque = fd.id_bloque', 'inner');
		$this->db->where('cc.id_asignacion_areac', $asignarea);
		$this->db->where('cc.ciclo_academico', $anio);
		$this->db->where('fd.fecha_inicio <=', $fecha);
		$this->db->where('fd.fecha_final >=', $fecha);
		$this->db->order_by('e.apellidos_estudiante', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo que se encarga de extraer la nota asignada a la evaluacion
		de un estudiante en un determinado bloque, en una determinada area
		del nivel pre-primario, primario y básico
	*/
	public function findCuadroEvaluacionE($asignarea, $ciclo, $estudiante, $bloque)
	{
		$this->db->select('c.id_cuadros, c.evaluacion_bloque, e.id_nivel');
		$this->db->from('CUADROS c');
		$this->db->join('ESTUDIANTE e', 'c.id_estudiante = e.id_estudiante', 'inner');
		$this->db->where('c.id_bloque', $bloque);
		$this->db->where('c.ciclo_academico', $ciclo);
		$this->db->where('c.id_estudiante', $estudiante);
		$this->db->where('c.id_asignacion_area', $asignarea);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo que se encarga de extraer la nota asignada a la evaluacion
		de un estudiante en un determinado bloque, en una determinada area
		del nivel básico madurez
	*/
	public function findCuadroEvaluacionEM($asignarea, $ciclo, $estudiante, $bloque)
	{
		$this->db->select('c.id_cuadros_madurez as id_cuadros, c.evaluacion_bloque, e.id_nivel');
		$this->db->from('CUADROS_MADUREZ c');
		$this->db->join('ESTUDIANTE e', 'c.id_estudiante = e.id_estudiante', 'inner');
		$this->db->where('c.id_bloque_madurez', $bloque);
		$this->db->where('c.ciclo_academico', $ciclo);
		$this->db->where('c.id_estudiante', $estudiante);
		$this->db->where('c.id_asignacion_area', $asignarea);
		$query = $this->db->get();
		return $query->result_array();
	}


	/*
		metodo que se encarga de extraer la nota asignada a la evaluacion
		de un estudiante en un determinado bloque, en una determinada area
		del nivel diversificado
	*/
	public function findCuadroEvaluacionEC($asignarea, $ciclo, $estudiante, $bloque)
	{
		$this->db->select('cc.id_cuadros_carreras as id_cuadros, cc.evaluacion_bloque, e.id_nivel');
		$this->db->from('CUADROS_CARRERAS cc');
		$this->db->join('ESTUDIANTE_CARRERA ec', 'cc.id_estudiante_carrera = ec.id_estudiante_carrera', 'inner');
		$this->db->join('ESTUDIANTE e', 'ec.id_estudiante = e.id_estudiante', 'inner');
		$this->db->where('cc.id_asignacion_areac', $asignarea);
		$this->db->where('cc.id_bloque', $bloque);
		$this->db->where('cc.ciclo_academico', $ciclo);
		$this->db->where('e.id_estudiante', $estudiante);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo que se encarga de editar la nota de examen de un determinado estudiante
		en el bloque actual, del nivel pre-primario, primario y básico
	*/
	public function setNotaExamen($cuadro, $nota)
	{
		$this->db->query('call agregar_nota_examen('.$cuadro.', '.$nota.');');
	}

	/*
		metodo que se encarga de editar la nota de examen de un determinado estudiante
		en el bloque actual, del nivel básico madurez
	*/
	public function setNotaExamenM($cuadro, $nota)
	{
		$this->db->query('call agregar_nota_examenM('.$cuadro.', '.$nota.');');
	}

	/*
		metodo que se encarga de editar la nota de examen de un determinado estudiante
		en el bloque actual, del nivel diversificado
	*/
	public function setNotaExamenC($cuadro, $nota)
	{
		$this->db->query('call agregar_nota_examen_c('.$cuadro.', '.$nota.');');
	}

	/*
		metodo que obtiene los puntos de evaluacion de bloque y de zona de
		un determinado curso en un bloque en especicfico del nivel
		pre-primario, primario y básico
	*/
	public function getExamenPuntos($asignarea, $fecha, $ciclo)
	{
		$this->db->select('c.id_cuadros, c.evaluacion_bloque, p.puntos_acreditacion');
		$this->db->from('CUADROS c');
		$this->db->join('PUNTOS p', 'c.id_cuadros = p.id_cuadros', 'inner');
		$this->db->join('BLOQUE b', 'c.id_bloque = b.id_bloque', 'inner');
		$this->db->join('FECHA_DISPONIBLE fd', 'b.id_bloque = fd.id_bloque', 'inner');
		$this->db->where('c.id_asignacion_area', $asignarea);
		$this->db->where('c.ciclo_academico', $ciclo);
		$this->db->where('fd.fecha_inicio <=', $fecha);
		$this->db->where('fd.fecha_final >=', $fecha);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo que obtiene los puntos de evaluacion de bloque y de zona de
		un determinado curso en un bloque en especicfico del nivel
		básico por madurez
	*/
	public function getExamenPuntosM($asignarea, $fecha, $ciclo)
	{
		$this->db->select('c.id_cuadros_madurez as id_cuadros, c.evaluacion_bloque, p.puntos_acreditacion');
		$this->db->from('CUADROS_MADUREZ c');
		$this->db->join('PUNTOS_MADUREZ p', 'c.id_cuadros_madurez = p.id_cuadros_madurez', 'inner');
		$this->db->join('BLOQUE_MADUREZ b', 'c.id_bloque_madurez = b.id_bloque_madurez', 'inner');
		$this->db->join('FECHA_DISPONIBLE_MADUREZ fd', 'b.id_bloque_madurez = fd.id_bloque_madurez', 'inner');
		$this->db->where('c.id_asignacion_area', $asignarea);
		$this->db->where('c.ciclo_academico', $ciclo);
		$this->db->where('fd.fecha_inicio_madurez <=', $fecha);
		$this->db->where('fd.fecha_final_madurez >=', $fecha);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo que obtiene los puntos de evaluacion de bloque y de zona de
		un determinado curso en un bloque en especifico del nivel
		diversificado
	*/
	public function getExamenPuntosC($asignarea, $fecha, $ciclo)
	{
		$this->db->select('cc.id_cuadros_carreras as id_cuadros, cc.evaluacion_bloque, pc.puntos_acreditacion');
		$this->db->from('CUADROS_CARRERAS cc');
		$this->db->join('PUNTOS_CARRERA pc', 'cc.id_cuadros_carreras = pc.id_cuadros_carreras', 'inner');
		$this->db->join('BLOQUE b', 'cc.id_bloque = b.id_bloque', 'inner');
		$this->db->join('FECHA_DISPONIBLE fd', 'b.id_bloque = fd.id_bloque', 'inner');
		$this->db->where('cc.id_asignacion_areac', $asignarea);
		$this->db->where('cc.ciclo_academico', $ciclo);
		$this->db->where('fd.fecha_inicio <=', $fecha);
		$this->db->where('fd.fecha_final >=', $fecha);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo que agrega la nota total del bloque de un estudiante de nivel
		pre-primario, primario y básico
	*/
	public function total_bloque($cuadro, $nota)
	{
		$this->db->query('call total_bloque('.$cuadro.', '.$nota.');');
	}

	/*
		metodo que agrega la nota total del bloque de un estudiante de nivel
		 básico por madurez
	*/
	public function total_bloqueM($cuadro, $nota)
	{
		$this->db->query('call total_bloqueM('.$cuadro.', '.$nota.');');
	}

	/*
		metodo que agrega la nota total del bloque de un estudiante de nivel
		diversificado
	*/
	public function total_bloque_c($cuadro, $nota)
	{
		$this->db->query('call total_bloque_c('.$cuadro.', '.$nota.');');
	}

	/*
		metodo que obtiene los datos para generar un cuadro
		de un bloque actual de los nivel pre-primario, primario y básico
	*/
	public function datos_cuadros($asignarea, $fecha, $ciclo)
	{
		$this->db->select('e.nombre_estudiante, e.apellidos_estudiante, p.puntos_acreditacion, c.evaluacion_bloque, c.total_bloque, ab.nombre_acreditacion, g.nombre_grado, n.nombre_nivel, a.nombre_area, nombre_bloque');
		$this->db->from('CUADROS c');
		$this->db->join('PUNTOS p', 'c.id_cuadros = p.id_cuadros', 'inner');
		$this->db->join('ESTUDIANTE e', 'c.id_estudiante = e.id_estudiante', 'inner');
		$this->db->join('BLOQUE b', 'c.id_bloque = b.id_bloque', 'inner');
		$this->db->join('FECHA_DISPONIBLE fd', 'b.id_bloque = fd.id_bloque', 'inner');
		$this->db->join('ASIGNACION_AREA aa', 'c.id_asignacion_area = aa.id_asignacion_area', 'inner');
		$this->db->join('AREAS a', 'aa.id_area = a.id_area', 'inner');
		$this->db->join('ACREDITACIONES_BLOQUE ab', 'p.id_acreditacion = ab.id_acreditacion', 'inner');
		$this->db->join('NIVEL n', 'e.id_nivel = n.id_nivel', 'inner');
		$this->db->join('GRADO g', 'e.id_grado = g.id_grado', 'inner');
		$this->db->where('c.id_asignacion_area', $asignarea);
		$this->db->where('c.ciclo_academico', $ciclo);
		$this->db->where('fd.fecha_inicio <=', $fecha);
		$this->db->where('fd.fecha_final >=', $fecha);
		//$this->db->order_by('e.apellidos_estudiante', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo que obtiene los datos para generar un cuadro
		de un bloque actual del nivel básico madurez
	*/
	public function datos_cuadrosM($asignarea, $fecha, $ciclo)
	{
		$this->db->select('e.nombre_estudiante, e.apellidos_estudiante, p.puntos_acreditacion, c.evaluacion_bloque, c.total_bloque, ab.nombre_acreditacion, g.nombre_grado, n.nombre_nivel, a.nombre_area, b.nombre_bloque_madurez as nombre_bloque');
		$this->db->from('CUADROS_MADUREZ c');
		$this->db->join('PUNTOS_MADUREZ p', 'c.id_cuadros_madurez = p.id_cuadros_madurez', 'inner');
		$this->db->join('ESTUDIANTE e', 'c.id_estudiante = e.id_estudiante', 'inner');
		$this->db->join('BLOQUE_MADUREZ b', 'c.id_bloque_madurez = b.id_bloque_madurez', 'inner');
		$this->db->join('FECHA_DISPONIBLE_MADUREZ fd', 'b.id_bloque_madurez = fd.id_bloque_madurez', 'inner');
		$this->db->join('ASIGNACION_AREA aa', 'c.id_asignacion_area = aa.id_asignacion_area', 'inner');
		$this->db->join('AREAS a', 'aa.id_area = a.id_area', 'inner');
		$this->db->join('ACREDITACIONES_BLOQUE ab', 'p.id_acreditacion = ab.id_acreditacion', 'inner');
		$this->db->join('NIVEL n', 'e.id_nivel = n.id_nivel', 'inner');
		$this->db->join('GRADO g', 'e.id_grado = g.id_grado', 'inner');
		$this->db->where('c.id_asignacion_area', $asignarea);
		$this->db->where('c.ciclo_academico', $ciclo);
		$this->db->where('fd.fecha_inicio_madurez <=', $fecha);
		$this->db->where('fd.fecha_final_madurez >=', $fecha);
		//$this->db->order_by('e.apellidos_estudiante', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo que obtiene los datos para generar un cuadro
		de un bloque actual del nivel diversificado
	*/
	public function datos_cuadrosC($asignarea, $fecha, $ciclo)
	{
		$this->db->select('e.nombre_estudiante, e.apellidos_estudiante, pc.puntos_acreditacion, cc.evaluacion_bloque, cc.total_bloque, ab.nombre_acreditacion, g.nombre_grado, n.nombre_nivel, c.nombre_carrera, b.nombre_bloque, a.nombre_area');
		$this->db->from('CUADROS_CARRERAS cc');
		$this->db->join('ESTUDIANTE_CARRERA ec', 'cc.id_estudiante_carrera = ec.id_estudiante_carrera', 'inner');
		$this->db->join('ESTUDIANTE e', 'ec.id_estudiante = e.id_estudiante', 'inner');
		$this->db->join('BLOQUE b', 'cc.id_bloque = b.id_bloque', 'inner');
		$this->db->join('FECHA_DISPONIBLE fd', 'b.id_bloque = fd.id_bloque', 'inner');
		$this->db->join('PUNTOS_CARRERA pc', 'cc.id_cuadros_carreras = pc.id_cuadros_carreras', 'inner');
		$this->db->join('ACREDITACIONES_BLOQUE ab', 'pc.id_acreditacion = ab.id_acreditacion', 'inner');
		$this->db->join('ASIGNACION_AREA_CARRERA aac', 'cc.id_asignacion_areac = aac.id_asignacion_areac', 'inner');
		$this->db->join('AREAS a', 'aac.id_area = a.id_area', 'inner');
		$this->db->join('NIVEL n', 'e.id_nivel = n.id_nivel', 'inner');
		$this->db->join('GRADO g', 'e.id_grado = g.id_grado', 'inner');
		$this->db->join('CARRERA c', 'ec.id_carrera = c.id_carrera', 'inner');
		$this->db->where('cc.id_asignacion_areac', $asignarea);
		$this->db->where('cc.ciclo_academico', $ciclo);
		$this->db->where('fd.fecha_inicio <=', $fecha);
		$this->db->where('fd.fecha_final >=', $fecha);
		//$this->db->order_by('e.apellidos_estudiante', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo que se encarga de obtener las notas de los cinco bloques
		de todos los estudiantes de una determinada area en el
		ciclo academico actual del nivel pre-primario, primario y básico
	*/
	public function cuadro_anual($asignarea, $ciclo)
	{
		$this->db->select('e.apellidos_estudiante, e.nombre_estudiante, c.total_bloque, a.nombre_area, b.nombre_bloque, n.nombre_nivel, g.nombre_grado');
		$this->db->from('CUADROS c');
		$this->db->join('BLOQUE b', 'c.id_bloque = b.id_bloque', 'inner');
		$this->db->join('ESTUDIANTE e', 'c.id_estudiante = e.id_estudiante', 'inner');
		$this->db->join('ASIGNACION_AREA aa', 'c.id_asignacion_area = aa.id_asignacion_area', 'inner');
		$this->db->join('AREAS a', 'aa.id_area = a.id_area', 'inner');
		$this->db->join('NIVEL n', 'e.id_nivel = n.id_nivel', 'inner');
		$this->db->join('GRADO g', 'e.id_grado = g.id_grado', 'inner');
		$this->db->where('c.ciclo_academico', $ciclo);
		$this->db->where('c.id_asignacion_area', $asignarea);
		$this->db->group_by('e.apellidos_estudiante');//hayq que quitar esta linea despues
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo que se encarga de obtener las notas de los cinco bloques
		de todos los estudiantes de una determinada area en el
		ciclo academico actual del nivel diversificado
	*/
	public function cuadro_anualC($asignarea, $ciclo)
	{
		$this->db->select('e.apellidos_estudiante, e.nombre_estudiante, cc.total_bloque, a.nombre_area, b.nombre_bloque, n.nombre_nivel, c.nombre_carrera, g.nombre_grado');
		$this->db->from('CUADROS_CARRERAS cc');
		$this->db->join('ESTUDIANTE_CARRERA ec', 'cc.id_estudiante_carrera = ec.id_estudiante_carrera', 'inner');
		$this->db->join('ESTUDIANTE e', 'ec.id_estudiante = e.id_estudiante', 'inner');
		$this->db->join('BLOQUE b', 'cc.id_bloque = b.id_bloque', 'inner');
		$this->db->join('NIVEL n', 'e.id_nivel = n.id_nivel', 'inner');
		$this->db->join('GRADO g', 'e.id_grado = g.id_grado', 'inner');
		$this->db->join('CARRERA c', 'ec.id_carrera = c.id_carrera', 'inner');
		$this->db->join('ASIGNACION_AREA_CARRERA aac', 'cc.id_asignacion_areac = aac.id_asignacion_areac', 'inner');
		$this->db->join('AREAS a', 'aac.id_area = a.id_area', 'inner');
		$this->db->where('cc.ciclo_academico', $ciclo);
		$this->db->where('cc.id_asignacion_areac', $asignarea);
		$this->db->group_by('e.apellidos_estudiante');//hay que quitar esta linea despues
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo para obtener los datos nombres, apellidos de estudiante, los puntos de los cuadros
		de un bloque en especifico, del ciclo academico para ser editado
	*/
	public function getNotasCuadros($area, $nivel, $grado, $ciclo, $bloque)
	{
		$this->db->select('e.apellidos_estudiante, e.nombre_estudiante, c.id_cuadros, c.total_bloque, c.evaluacion_bloque, c.habitos_orden, c.punt_asist');
		$this->db->from('ASIGNACION_AREA aa');
		$this->db->join('CUADROS c', 'aa.id_asignacion_area = c.id_asignacion_area', 'inner');
		$this->db->join('ESTUDIANTE e', 'c.id_estudiante = e.id_estudiante', 'inner');
		$this->db->where('aa.id_asignacion_area', $area);
		$this->db->where('e.id_nivel', $nivel);
		$this->db->where('e.id_grado', $grado);
		$this->db->where('c.ciclo_academico', $ciclo);
		$this->db->where('c.id_bloque', $bloque);
		$query = $this->db->get();
		return $query->result_array();
	}//fin del metodo

	/*
		metodo para obtener los datos nombres, apellidos de estudiante, los puntos de los cuadros
		de un bloque en especifico, del ciclo academico para ser editado del nivel diversificado
	*/
	public function getNotasCuadrosC($area, $carrera, $bloque, $ciclo, $grado)
	{
		$this->db->select('cc.id_cuadros_carreras as id_cuadros, cc.evaluacion_bloque, cc.total_bloque, e.nombre_estudiante, e.apellidos_estudiante, e.id_nivel, e.id_grado, cc.habitos_orden, cc.punt_asist');
		$this->db->from('CUADROS_CARRERAS cc');
		$this->db->join('ESTUDIANTE_CARRERA ec', 'cc.id_estudiante_carrera = ec.id_estudiante_carrera', 'inner');
		$this->db->join('ESTUDIANTE e', 'ec.id_estudiante = e.id_estudiante', 'inner');
		$this->db->join('CARRERA c', 'ec.id_carrera = c.id_carrera', 'inner');
		$this->db->join('GRADO_CARRERA gc', 'c.id_carrera = gc.id_carrera', 'inner');
		$this->db->where('cc.id_asignacion_areac', $area);
		$this->db->where('cc.id_bloque', $bloque);
		$this->db->where('ec.id_carrera', $carrera);
		$this->db->where('cc.ciclo_academico', $ciclo);
		$this->db->where('gc.id_grado', $grado);
		$this->db->order_by('e.apellidos_estudiante', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getNotasCuadrosM($area, $grado, $bloque)
	{
		$this->db->select('cm.id_cuadros_madurez as id_cuadros, cm.total_bloque, cm.evaluacion_bloque, cm.habitos_orden, cm.punt_asist, e.id_nivel, e.apellidos_estudiante, e.nombre_estudiante');
		$this->db->from('CUADROS_MADUREZ cm');
		$this->db->join('ESTUDIANTE e', 'cm.id_estudiante = e.id_estudiante', 'inner');
		$this->db->where('cm.id_asignacion_area', $area);
		$this->db->where('e.id_grado', $grado);
		$this->db->where('cm.id_bloque_madurez', $bloque);
		$query = $this->db->get();
		return $query->result_array();
	}
	/*
	SELECT cm.id_cuadros_madurez as id_cuadros, cm.total_bloque, cm.evaluacion_bloque, cm.habitos_orden, cm.punt_asist, e.id_nivel
FROM CUADROS_MADUREZ cm INNER JOIN ESTUDIANTE e
ON cm.id_estudiante = e.id_estudiante
WHERE cm.id_asignacion_area = 133 AND e.id_grado = 3 AND cm.id_bloque_madurez = 1
	*/
	/*
		SELECT cc.id_cuadros_carreras, e.nombre_estudiante, e.apellidos_estudiante, e.id_nivel, e.id_grado, cc.habitos_orden, cc.habitos_orden
		FROM CUADROS_CARRERAS cc INNER JOIN ESTUDIANTE_CARRERA ec
		on cc.id_estudiante_carrera = ec.id_estudiante_carrera INNER JOIN ESTUDIANTE e
		ON ec.id_estudiante = e.id_estudiante INNER JOIN CARRERA c
		on ec.id_carrera = c.id_carrera INNER JOIN GRADO_CARRERA gc
		on c.id_carrera = gc.id_carrera
		WHERE cc.id_asignacion_areac = 69 AND cc.id_bloque = 2 AND ec.id_carrera = 6 AND cc.ciclo_academico = '2016-00-00'
	*/

	/*
	Metodo para actulizar la evaluacion del estudiantes de un determinado bloque
	*/
	public function actualizar_evaluacion($cuadro, $nota)
	{
		$this->db->query('call actualizar_evaluacion('.$cuadro.', '.$nota.');');
	}//fin del metodo


	//metodo que obtiene la nomina de los estudiantes de acuerdo a una asignacion de area
	public function getEstudiantesArea($ciclo, $asignacion)
	{
		$this->db->select('c.id_asignacion_area, e.id_estudiante, e.apellidos_estudiante, e.nombre_estudiante, g.nombre_grado, n.nombre_nivel, a.nombre_area');
		$this->db->from('ESTUDIANTE e');
		$this->db->join('CUADROS c', 'e.id_estudiante = c.id_estudiante', 'inner');
		$this->db->join('GRADO g', 'e.id_grado = g.id_grado', 'inner');
		$this->db->join('NIVEL n', 'e.id_nivel = n.id_nivel', 'inner');
		$this->db->join('ASIGNACION_AREA aa', 'c.id_asignacion_area = aa.id_asignacion_area', 'inner');
		$this->db->join('AREAS a', 'aa.id_area = a.id_area', 'inner');
		$this->db->where('c.id_asignacion_area', $asignacion);
		$this->db->where('c.ciclo_academico', $ciclo);
		$this->db->group_by('e.apellidos_estudiante');
		$this->db->order_by('e.apellidos_estudiante', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	//metodo que obtien la nomina de los estudiantes de acuerdo a una signacion de area del nivel diversificado
	public function getEstudiantesAreaD($ciclo, $asignacion)
	{
		$this->db->select('cc.id_asignacion_areac as id_asignacion_area, e.id_estudiante, e.apellidos_estudiante, e.nombre_estudiante, g.nombre_grado, n.nombre_nivel, a.nombre_area, c.nombre_carrera');
		$this->db->from('ESTUDIANTE e');
		$this->db->join('ESTUDIANTE_CARRERA ec', 'e.id_estudiante = ec.id_estudiante', 'inner');
		$this->db->join('CUADROS_CARRERAS cc', 'cc.id_estudiante_carrera = ec.id_estudiante_carrera', 'inner');
		$this->db->join('GRADO g', 'e.id_grado = g.id_grado', 'inner');
		$this->db->join('NIVEL n', 'e.id_nivel = n.id_nivel', 'inner');
		$this->db->join('ASIGNACION_AREA_CARRERA aa', 'cc.id_asignacion_areac = aa.id_asignacion_areac', 'inner');
		$this->db->join('AREAS a', 'aa.id_area = a.id_area', 'inner');
		$this->db->join('CARRERA c', 'ec.id_carrera = c.id_carrera', 'inner');
		$this->db->where('cc.id_asignacion_areac', $asignacion);
		$this->db->where('cc.ciclo_academico', $ciclo);
		$this->db->group_by('e.apellidos_estudiante');
		$this->db->order_by('e.apellidos_estudiante', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

//metodo que obtiene la nomina de los estudiantes de acuerdo a una signacion de area del nivel básico por madurez
public function getEstudiantesAreaM($ciclo, $asignacion)
{
	$this->db->select('e.id_estudiante, c.id_asignacion_area, e.apellidos_estudiante, e.nombre_estudiante, g.nombre_grado, n.nombre_nivel, a.nombre_area');
	$this->db->from('ESTUDIANTE e');
	$this->db->join('CUADROS_MADUREZ c', 'e.id_estudiante = c.id_estudiante', 'inner');
	$this->db->join('GRADO g', 'e.id_grado = g.id_grado', 'inner');
	$this->db->join('NIVEL n', 'e.id_nivel = n.id_nivel', 'inner');
	$this->db->join('ASIGNACION_AREA aa', 'c.id_asignacion_area = aa.id_asignacion_area', 'inner');
	$this->db->join('AREAS a', 'aa.id_area = a.id_area', 'inner');
	$this->db->where('c.id_asignacion_area', $asignacion);
	$this->db->where('c.ciclo_academico', $ciclo);
	$this->db->group_by('e.apellidos_estudiante');
	$this->db->order_by('e.apellidos_estudiante', 'ASC');
	$query = $this->db->get();
	return $query->result();
}
/*
select e.apellidos_estudiante, e.nombre_estudiante, g.nombre_grado, n.nombre_nivel, a.nombre_area
from ESTUDIANTE e inner join CUADROS_MADUREZ c
on e.id_estudiante = c.id_estudiante inner join GRADO g
on e.id_grado = g.id_grado inner join NIVEL n
on e.id_nivel = n.id_nivel inner join ASIGNACION_AREA aa
on c.id_asignacion_area = aa.id_asignacion_area inner join AREAS a
on aa.id_area = a.id_area
where c.id_asignacion_area = 135 and c.ciclo_academico = '2016-00-00'
group by e.apellidos_estudiante
order by e.apellidos_estudiante asc
*/

	//metodo para buscar el punteo total de un estudiante en un determinado bloque y una determinada área
	public function getTotalBloque($asignacion, $idEstudiante, $bloque)
	{
		$this->db->select('c.total_bloque');
		$this->db->from('CUADROS c');
		$this->db->where('c.id_asignacion_area', $asignacion);
		$this->db->where('c.id_estudiante', $idEstudiante);
		$this->db->where('c.id_bloque', $bloque);
		$query = $this->db->get();
		return $query->result();
	}

	//metodo para buscar el punteo total de un estudiante en un determinado bloque y determinada área del nivel diversificado
	public function getTotalBloqueD($asignacion, $idEstudiante, $bloque)
	{
		$this->db->select('cc.total_bloque');
		$this->db->from('CUADROS_CARRERAS cc');
		$this->db->join('ESTUDIANTE_CARRERA ec', 'cc.id_estudiante_carrera = ec.id_estudiante_carrera', 'inner');
		$this->db->where('cc.id_asignacion_areac', $asignacion);
		$this->db->where('ec.id_estudiante', $idEstudiante);
		$this->db->where('cc.id_bloque', $bloque);
		$query = $this->db->get();
		return $query->result();
	}

	//metodo para buscar el punteo total de un estudiante en un determinado bloque y determinada área del nivel básico madurez
	public function getTotalBloqueM($asignacion, $idEstudiante, $bloque)
	{
		$this->db->select('c.total_bloque');
		$this->db->from('CUADROS_MADUREZ c');
		$this->db->where('c.id_asignacion_area', $asignacion);
		$this->db->where('c.id_estudiante', $idEstudiante);
		$this->db->where('c.id_bloque_madurez', $bloque);
		$query = $this->db->get();
		return $query->result();
	}

	//metodo para actualizar las notas de un cuadro
	public function actualizar_cuadro($cuadro, $total, $habitos, $puntualidad, $evaluacion)
	{
		$this->db->query('UPDATE CUADROS SET total_bloque = '.$total.', habitos_orden = "'.$habitos.'", punt_asist = "'.$puntualidad.'", evaluacion_bloque = '.$evaluacion.' where id_cuadros = '.$cuadro);
	}

	//metodo para actualizar los datos de un cuadro del nivel diversificado
	public function actualizar_cuadroC($cuadro, $total, $habitos, $puntualidad, $evaluacion)
	{
		$this->db->query('UPDATE CUADROS_CARRERAS SET total_bloque ='.$total.', habitos_orden = "'.$habitos.'", punt_asist = "'.$puntualidad.'", evaluacion_bloque = '.$evaluacion.' where id_cuadros_carreras = '.$cuadro);
	}

	//metodo para actualizar los datos de un cuadro del nivel básico madurez
	public function actualizar_cuadroM($cuadro, $total, $habitos, $puntualidad, $evaluacion)
	{
		$this->db->query('UPDATE CUADROS_MADUREZ SET total_bloque ='.$total.', habitos_orden = "'.$habitos.'", punt_asist = "'.$puntualidad.'", evaluacion_bloque = '.$evaluacion.' where id_cuadros_madurez = '.$cuadro);
	}

}

/* End of file Cuadros_model.php */
/* Location: ./application/models/Cuadros_model.php */
