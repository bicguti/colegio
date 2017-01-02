<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estudiante_model extends CI_Model {
	//Medodo para agregar un nuevo estudiante de nivel preprimaria, primaria o basico.
	public function setEstudiante($genero, $estado, $codigo, $nombres, $apellidos, $nacimiento, $edad, $nivel, $grado, $cui)
	{
		$query = $this->db->query('CALL nuevo_estudiante('.$genero.', '.$estado.', "'.$codigo.'", "'.$nombres.'", "'.$apellidos.'", "'.$nacimiento.'", '.$edad.', '.$nivel.', '.$grado.', "'.$cui.'");');
		$aux = $query->row();
		$dato = $aux->msg;
		$query->next_result();
		return $dato;
	}

	public function setEstudiantec($genero, $estado, $codigo, $nombres, $apellidos, $nacimiento, $edad, $nivel, $grado, $cui)//Metodo para agregar un nuevo estudiante de nivel diversificado
	{
		$query = $this->db->query('call nuevo_estudiantec('.$genero.', '.$estado.', "'.$codigo.'", "'.$nombres.'", "'.$apellidos.'", "'.$nacimiento.'", '.$edad.', '.$nivel.', '.$grado.', "'.$cui.'");');
		$aux = $query->row();
		$dato = $aux->id;
		$query->next_result();
		return $dato;
	}

	public function getEstudiantesPB()//obtiene el id de estudiante, id del grado y id del nivel de los estudiantes de nivel preprimario, primario, básico
	{
		$query = $this->db->query('select id_estudiante, id_nivel, id_grado from ESTUDIANTE where id_nivel != 4 and id_nivel != 5');
		return $query->result_array();
	}

	public function getEstudiantesD()//obtien el id de estudiante y id grado de los estudiantes del nivel diversificado
	{
		//$query = $this->db->query('select id_estudiante, id_grado from ESTUDIANTE where id_nivel = 4');
		$this->db->select('e.id_estudiante, e.id_grado');
		$this->db->from('ESTUDIANTE e');
		$this->db->where('e.id_nivel', 4);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		Obtiene la nomina de estudiantes de un grado donde un docente es guía
		del nivel pre-primaria, primaria y básico
	*/
	public function getNominaEstudiantes($nivel, $grado, $ciclo, $fecha)
	{
		$this->db->select('c.id_estudiante, e.apellidos_estudiante, e.nombre_estudiante, b.nombre_bloque');
		$this->db->from('ESTUDIANTE e');
		$this->db->join('CUADROS c', 'e.id_estudiante = c.id_estudiante', 'inner');
		$this->db->join('FECHA_DISPONIBLE fd', 'c.id_bloque = fd.id_bloque', 'inner');
		$this->db->join('BLOQUE b', 'c.id_bloque = b.id_bloque', 'inner');
		$this->db->where('e.id_nivel', $nivel);
		$this->db->where('e.id_grado', $grado);
		$this->db->where('c.ciclo_academico', $ciclo);
		$this->db->where('fd.fecha_inicio <=', $fecha);
		$this->db->where('fd.fecha_final >=', $fecha);
		$this->db->group_by('c.id_estudiante');
		$this->db->order_by('e.apellidos_estudiante', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		Obtiene la nomina de estudiantes de un grado donde un docente es guía
		del nivel básico por madurez
	*/
	public function getNominaEstudiantesM($nivel, $grado, $ciclo, $fecha)
	{
		$this->db->select('c.id_estudiante, e.apellidos_estudiante, e.nombre_estudiante, b.nombre_bloque_madurez as nombre_bloque');
		$this->db->from('ESTUDIANTE e');
		$this->db->join('CUADROS_MADUREZ c', 'e.id_estudiante = c.id_estudiante', 'inner');
		$this->db->join('FECHA_DISPONIBLE_MADUREZ fd', 'c.id_bloque_madurez = fd.id_bloque_madurez', 'inner');
		$this->db->join('BLOQUE_MADUREZ b', 'c.id_bloque_madurez = b.id_bloque_madurez', 'inner');
		$this->db->where('e.id_nivel', $nivel);
		$this->db->where('e.id_grado', $grado);
		$this->db->where('c.ciclo_academico', $ciclo);
		$this->db->where('fd.fecha_inicio_madurez <=', $fecha);
		$this->db->where('fd.fecha_final_madurez >=', $fecha);
		$this->db->group_by('c.id_estudiante');
		$this->db->order_by('e.apellidos_estudiante', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		Obtiene la nomina de estudiantes de un grado donde un docente es guía
		del nivel diversificado
	*/
	public function getNominaEstudiantesC($grado, $carrera, $ciclo, $fecha)
	{
		$this->db->select('e.id_estudiante, e.apellidos_estudiante, e.nombre_estudiante, b.nombre_bloque');
		$this->db->from('CUADROS_CARRERAS cc');
		$this->db->join('ESTUDIANTE_CARRERA ec', 'cc.id_estudiante_carrera = ec.id_estudiante_carrera', 'inner');
		$this->db->join('ESTUDIANTE e', 'ec.id_estudiante = e.id_estudiante', 'inner');
		$this->db->join('CARRERA c', 'ec.id_carrera = c.id_carrera', 'inner');
		$this->db->join('FECHA_DISPONIBLE fd', 'cc.id_bloque = fd.id_bloque', 'inner');
		$this->db->join('BLOQUE b', 'cc.id_bloque = b.id_bloque', 'inner');
		$this->db->where('e.id_grado', $grado);
		$this->db->where('ec.id_carrera', $carrera);
		$this->db->where('cc.ciclo_academico', $ciclo);
		$this->db->where('fd.fecha_inicio <=', $fecha);
		$this->db->where('fd.fecha_final >=', $fecha);
		$this->db->group_by('e.id_estudiante');
		$this->db->order_by('e.apellidos_estudiante', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		obtiene los datos de puntualidad y habitos de orden de un estudiante
		del nivel pre-primario, primario y básico
	*/
	public function buscar_punt_habitos($estudiante, $ciclo, $fecha)
	{
		$this->db->select('c.id_cuadros, c.punt_asist, c.habitos_orden');
		$this->db->from('CUADROS c');
		$this->db->join('FECHA_DISPONIBLE fd', 'c.id_bloque = fd.id_bloque', 'inner');
		$this->db->where('c.id_estudiante', $estudiante);
		$this->db->where('c.ciclo_academico', $ciclo);
		$this->db->where('fd.fecha_inicio <=', $fecha);
		$this->db->where('fd.fecha_final >=', $fecha);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		obtiene los datos de puntualidad y habitos de orden de un estudiante
		del nivel básico madurez
	*/
	public function buscar_punt_habitosM($estudiante, $ciclo, $fecha)
	{
		$this->db->select('c.id_cuadros_madurez as id_cuadros, c.punt_asist, c.habitos_orden');
		$this->db->from('CUADROS_MADUREZ c');
		$this->db->join('FECHA_DISPONIBLE_MADUREZ fd', 'c.id_bloque_madurez = fd.id_bloque_madurez', 'inner');
		$this->db->where('c.id_estudiante', $estudiante);
		$this->db->where('c.ciclo_academico', $ciclo);
		$this->db->where('fd.fecha_inicio_madurez <=', $fecha);
		$this->db->where('fd.fecha_final_madurez >=', $fecha);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		obtiene los datos de puntualidad y habitos de orden de un estudiante
		del nivel diversificado
	*/
	public function buscar_punt_habitosC($estudiante, $ciclo, $fecha)
	{
		$this->db->select('cc.id_cuadros_carreras as id_cuadros, cc.punt_asist, cc.habitos_orden');
		$this->db->from('CUADROS_CARRERAS cc');
		$this->db->join('ESTUDIANTE_CARRERA ec', 'cc.id_estudiante_carrera = ec.id_estudiante_carrera', 'inner');
		$this->db->join('FECHA_DISPONIBLE fd', 'cc.id_bloque = fd.id_bloque', 'inner');
		$this->db->where('ec.id_estudiante', $estudiante);
		$this->db->where('cc.ciclo_academico', $ciclo);
		$this->db->where('fd.fecha_inicio <=', $fecha);
		$this->db->where('fd.fecha_final >=', $fecha);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo para buscar a todos los estudiantes de un grado y nivel de
		pre-primaria, primaria y básico
	*/
	public function buscar_estudiantes($nivel, $grado)
	{
		$this->db->select('e.id_estudiante, e.apellidos_estudiante, e.nombre_estudiante');
		$this->db->from('ESTUDIANTE e');
		$this->db->where('e.id_nivel', $nivel);
		$this->db->where('e.id_grado', $grado);
		$this->db->where('e.id_est_estud', 1);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo para buscar los puntos de un bloque para un estudiante
		de nivel pre-primaria, primaria y básico
	*/
	public function buscar_puntuacion($estudiante, $bloque, $ciclo)
	{
		$this->db->select('a.nombre_area, c.total_bloque, c.habitos_orden, c.punt_asist');
		$this->db->from('CUADROS c');
		$this->db->join('ASIGNACION_AREA aa', 'c.id_asignacion_area = aa.id_asignacion_area', 'inner');
		$this->db->join('AREAS a', 'aa.id_area = a.id_area', 'inner');
		$this->db->where('c.id_estudiante', $estudiante);
	//	$this->db->where('c.id_bloque', $bloque);
		$this->db->where('c.ciclo_academico', $ciclo);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo para buscar los puntos de un bloque para un estudiante
		de nivel básico madurez
	*/
	public function buscar_puntuacionM($estudiante, $bloque, $ciclo)
	{
		$this->db->select('a.nombre_area, c.total_bloque, c.habitos_orden, c.punt_asist');
		$this->db->from('CUADROS_MADUREZ c');
		$this->db->join('ASIGNACION_AREA aa', 'c.id_asignacion_area = aa.id_asignacion_area', 'inner');
		$this->db->join('AREAS a', 'aa.id_area = a.id_area', 'inner');
		$this->db->where('c.id_estudiante', $estudiante);
	//	$this->db->where('c.id_bloque', $bloque);
		$this->db->where('c.ciclo_academico', $ciclo);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo que obtiene a todos los estudiantes que pertenecen a un grado
		del nivel pre-primario, primario y básico, deacuerdo a los parametros
		de busqueda que se le envien
	*/
	public function getNominaEstudiantesG($nivel, $grado, $ciclo)
	{
		$this->db->select('e.apellidos_estudiante, e.nombre_estudiante');
		$this->db->from('ESTUDIANTE e');
		$this->db->join('CUADROS c', 'e.id_estudiante = c.id_estudiante', 'inner');
		$this->db->where('e.id_nivel', $nivel);
		$this->db->where('e.id_grado', $grado);
		$this->db->where('c.ciclo_academico', $ciclo);
		$this->db->group_by('e.id_estudiante');
		$this->db->order_by('e.apellidos_estudiante', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo que obtiene a todos los estudiantes que pertenecen a un grado
		del nivel básico por madurez
	*/
	public function getNominaEstudiantesGM($nivel, $grado, $ciclo)
	{
		$this->db->select('e.apellidos_estudiante, e.nombre_estudiante');
		$this->db->from('ESTUDIANTE e');
		$this->db->join('CUADROS_MADUREZ c', 'e.id_estudiante = c.id_estudiante', 'inner');
		$this->db->where('e.id_nivel', $nivel);
		$this->db->where('e.id_grado', $grado);
		$this->db->where('c.ciclo_academico', $ciclo);
		$this->db->group_by('e.id_estudiante');
		$this->db->order_by('e.apellidos_estudiante', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo que obtiene a todos los estudiantes que pertenecen a un grado
		del nivel diversificado, deacuerdo a los parametros
		de busqueda que se le envien
	*/
	public function getNominaEstudiantesGC($nivel, $carrera, $grado, $ciclo)
	{
		$this->db->select('e.apellidos_estudiante, e.nombre_estudiante, e.id_estudiante');
		$this->db->from('ESTUDIANTE e');
		$this->db->join('ESTUDIANTE_CARRERA ec', 'e.id_estudiante = ec.id_estudiante', 'inner');
		$this->db->join('CUADROS_CARRERAS cc', 'ec.id_estudiante_carrera = cc.id_estudiante_carrera', 'inner');
		$this->db->where('e.id_grado', $grado);
		$this->db->where('ec.id_carrera', $carrera);
		$this->db->where('cc.ciclo_academico', $ciclo);
		$this->db->group_by('e.id_estudiante');
		$this->db->order_by('e.apellidos_estudiante', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo que busca a un estudiante por su id y obtiene los nombres del mismo
 	*/
	public function findEstudiante($estudianteId)
	{
		$this->db->select('e.apellidos_estudiante, e.nombre_estudiante, e.codigo_personal_estudiante, g.nombre_grado, c.nombre_carrera');
		$this->db->from('ESTUDIANTE e');
		$this->db->join('GRADO g', 'e.id_grado = g.id_grado', 'inner');
		$this->db->join('ESTUDIANTE_CARRERA ec', 'e.id_estudiante = ec.id_estudiante', 'inner');
		$this->db->join('CARRERA c', 'ec.id_carrera = c.id_carrera', 'inner');
		$this->db->where('e.id_estudiante', $estudianteId);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
	 metodo para buscar a un estudiante del nivel básico por su id y obtine los nombres del mismo
	*/
	public function findEstudianteBP($estudianteId)
	{
		$this->db->select('e.apellidos_estudiante, e.nombre_estudiante, e.codigo_personal_estudiante, g.nombre_grado, n.nombre_nivel');
		$this->db->from('ESTUDIANTE e');
		$this->db->join('GRADO g', 'e.id_grado = g.id_grado', 'inner');
		$this->db->join('NIVEL n', 'e.id_nivel = n.id_nivel', 'inner');
		$this->db->where('e.id_estudiante', $estudianteId);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
	 metodo para buscar los nomina de los estudiante del nivel básico de un grado en especifico (id, nombres, apellidos)	*/
	public function findEstudiantesBasico($nivel, $grado, $ciclo)
	{
		$this->db->select('distinct(c.id_estudiante), e.apellidos_estudiante, e.nombre_estudiante, e.codigo_personal_estudiante');
		$this->db->from('ESTUDIANTE e');
		$this->db->join('CUADROS c', 'e.id_estudiante = c.id_estudiante', 'inner');
		$this->db->where('e.id_nivel', $nivel);
		$this->db->where('e.id_grado', $grado);
		$this->db->where('c.ciclo_academico', $ciclo);
		$this->db->order_by('e.apellidos_estudiante', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
	 		metodo para buscar los nomina de los estudiante del nivel básico  madurez de un grado en especifico (id, nombres, apellidos)
	 */
	public function findEstudiantesBasicoM($nivel, $grado, $ciclo)
	{
		$this->db->select('distinct(c.id_estudiante), e.apellidos_estudiante, e.nombre_estudiante, e.codigo_personal_estudiante');
		$this->db->from('ESTUDIANTE e');
		$this->db->join('CUADROS_MADUREZ c', 'e.id_estudiante = c.id_estudiante', 'inner');
		$this->db->where('e.id_nivel', $nivel);
		$this->db->where('e.id_grado', $grado);
		$this->db->where('c.ciclo_academico', $ciclo);
		$this->db->order_by('e.apellidos_estudiante', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo para obtener el id, nombres y apellidos de unestudiante del nivel diversificado del ciclo acadmico actual
	*/
	public function findEstudiantesDiversificado($nivel, $grado, $carrera, $ciclo)
	{
		$this->db->select('distinct(e.id_estudiante), e.apellidos_estudiante, e.nombre_estudiante, e.codigo_personal_estudiante, ec.id_estudiante_carrera');
		$this->db->from('ESTUDIANTE e');
		$this->db->join('ESTUDIANTE_CARRERA ec', 'e.id_estudiante = ec.id_estudiante', 'inner');
		$this->db->join('CUADROS_CARRERAS cc', 'ec.id_estudiante_carrera = cc.id_estudiante_carrera', 'inner');
		$this->db->join('CARRERA c', 'ec.id_carrera = c.id_carrera', 'inner');
		$this->db->where('e.id_nivel', $nivel);
		$this->db->where('cc.ciclo_academico', $ciclo);
		$this->db->where('c.id_carrera', $carrera);
		$this->db->where('e.id_grado', $grado);
		$this->db->order_by('e.apellidos_estudiante', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		metodo para buscar los puntos de los cinco bloques de todas las areas de un estudiante del nivel diversificado
	*/
	public function buscar_puntuacionC($idEstudianteCarrera, $ciclo)
	{
		$this->db->select('a.nombre_area, cc.total_bloque, cc.habitos_orden, cc.punt_asist');
		$this->db->from('CUADROS_CARRERAS cc');
		$this->db->join('ASIGNACION_AREA_CARRERA aac', 'cc.id_asignacion_areac = aac.id_asignacion_areac', 'inner');
		$this->db->join('AREAS a', 'aac.id_area = a.id_area', 'inner');
		$this->db->join('ESTUDIANTE_CARRERA ec', 'cc.id_estudiante_carrera = ec.id_estudiante_carrera', 'inner');
		$this->db->where('ec.id_estudiante_carrera', $idEstudianteCarrera);
		$this->db->where('cc.ciclo_academico', $ciclo);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getEstudiantesBM()//obtiene el id de estudiante, id del grado y id del nivel de los estudiantes de nivel básico por madurez
	{
		$query = $this->db->query('select id_estudiante, id_nivel, id_grado from ESTUDIANTE where id_nivel = 5');
		return $query->result_array();
	}

	public function findEstudianteId($id)
	{
		$this->db->select('e.id_estudiante, e.nombre_estudiante, e.apellidos_estudiante, e.codigo_personal_estudiante, e.id_genero, e.cui_estudiante, e.fecha_nac_estudiante');
		$this->db->from('ESTUDIANTE e');
		$this->db->where('e.id_estudiante', $id);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*
		actualizar los datos de un estudiante
	*/
	public function updateEstudiante($id, $nombre, $apellidos, $nacimiento, $genero, $codigo, $cui)
	{
		$query = $this->db->query('call actualizar_estudiante('.$id.', "'.$nombre.'", "'.$apellidos.'", "'.$nacimiento.'", '.$genero.', "'.$codigo.'", "'.$cui.'")');
		return $query->row();
	}


}

/* End of file Estudiante_model.php */
/* Location: ./application/models/Estudiante_model.php */
